<?php

namespace ZfSimpleMigrations\Migrations;

use Dws\Exception\Service\InvalidInputException;
use Dws\Exception\Service\ModelNotFoundException;
use Exception;
use NcpOrganisation\Model\Association;
use NcpOrganisation\Model\Federation;
use NcpOrganisation\Model\Organisation;
use NcpOrganisation\Model\Organisation\OrganisationAddress;
use NcpOrganisation\Model\StateOrganisation;
use NcpOrganisation\Service\AssociationService;
use NcpOrganisation\Service\ClubService;
use NcpOrganisation\Service\FederationService;
use NcpOrganisation\Service\Organisation\OrganisationAddressService;
use NcpOrganisation\Service\StateOrganisationService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use ZfSimpleMigrations\Library\AbstractMigration;
use Zend\Db\Metadata\MetadataInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Version20150520000000 extends AbstractMigration implements ServiceLocatorAwareInterface
{
    public static $description = "Import organisations";

    /** @var array $allowedKeys */
    private $allowedKeys = ['external_id', 'name', 'abbreviation', 'address', 'state', 'city', 'postcode',
                            'state_affiliated_with','region_affiliated_with','zone_affiliated_with','assoc_affiliated_with'];

    /** @var  Federation */
    private $federation;

    /** @var  ClubService */
    private $clubService;

    /** @var  StateOrganisationService */
    private $stateOrganisationService;

    /** @var  AssociationService */
    private $associationService;

    /** @var  OrganisationAddressService */
    private $organisationAddressService;

    /** @var  FederationService */
    private $federationService;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    public function up(MetadataInterface $schema)
    {
        try {
            $this->_up($schema);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            die;
        }

       // die("Let's not exit yet and abuse this thing\n");
    }

    /**
     * @param MetadataInterface $schema
     */
    public function down(MetadataInterface $schema)
    {
        // Currently unsupported
    }

    /**
     * @param MetadataInterface $schema
     * @throws Exception
     * @throws InvalidInputException
     * @throws \Dws\Exception\ServiceException
     */
    private function _up(MetadataInterface $schema)
    {
        echo "Create Federation \n";

        $federationService = $this->getFederationService();

        $federationData = [
            'name' => 'Tennis Australia'
        ];

        $this->federation = $federationService->create($federationData);
        $this->federation = $federationService->persist($this->federation);

        echo "Import organisations \n";

        $path = 'data/import/organisations.csv';
        $keys = false;
        $counter = 0;
        $mapping = [];
        if (file_exists($path)) {
            if (($handle = fopen($path, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                    $counter++;
                    // Use first row for key names
                    if ($keys === false) {
                        $values = array_values($data);
                        $mapping = array_flip($values);
                        $keys = array_intersect($values, $this->allowedKeys);
                        continue;
                    }
                    $organisationType = strtolower($data[3]);
                    $input = [];
                    foreach($keys as $index => $value) {
                        $input[$value] = $data[$mapping[$keys[$index]]];
                    }

                    if ($organisationType === 'club') {
                        $this->addClub($input);
                    } else if ($organisationType === 'state') {
                        $this->addStateOrganisation($input);
                    } else if (in_array($organisationType, ['region', 'association', 'council', 'national'])) {
                        $this->addAssociation($input);
                    } else {
                        throw new Exception(sprintf('Unknown organisation type: %s', $organisationType));
                    }
                    if ($counter > 350) {
                        // should be enough for now and keeps wercker controllable
                        break;
                    }

                }
                fclose($handle);
            }
        }
    }

    /**
     * @param array $input
     * @throws \Dws\Exception\Service\InvalidInputException
     */
    private function addClub($input) {
        $input['associations'] = [];
        if (!empty($input['state_affiliated_with'])) {
            $input['state_organisation'] = $this->getStateOrganisation($input['state_affiliated_with']);
        }
        if (!empty($input['region_affiliated_with'])) {
            $input['associations'] = array_merge($input['associations'], $this->getAssociations($input['region_affiliated_with']));
        }
        if (!empty($input['zone_affiliated_with'])) {
            $input['associations'] = array_merge($input['associations'], $this->getAssociations($input['zone_affiliated_with']));
        }
        if (!empty($input['assoc_affiliated_with'])) {
            $input['associations'] = array_merge($input['associations'], $this->getAssociations($input['assoc_affiliated_with']));
        }

        /** @var ClubService $clubService */
        $clubService = $this->getClubService();

        /** @var OrganisationAddressService $organisationAddressService */
        $organisationAddressService = $this->getOrganisationAddressService();

        try {
            /** @var OrganisationAddress $address */
            $address = $organisationAddressService->create($input);

            $input['addresses'] = [
                $address
            ];
        } catch(InvalidInputException $e) {
            // Invalid address, but we still want to add the organisation
        }

        try {
            $club = $clubService->findOneByExternalId($input['external_id']);
            $input['id'] = $club->getId();
            $club = $clubService->populate($input);
        } catch(ModelNotFoundException $e) {
            $club = $clubService->create(
                $input
            );
        }

        $clubService->persist($club);
    }

    /**
     * @param array $input
     * @throws InvalidInputException
     */
    private function addAssociation($input) {
        $associationService = $this->getAssociationService();
        if (!empty($input['state_affiliated_with'])) {
            $input['state_organisation'] = $this->getStateOrganisation($input['state_affiliated_with']);
        }

        try {
            $association = $associationService->findOneByExternalId($input['external_id']);
        } catch(ModelNotFoundException $e) {
            $association = $associationService->create(
                $input
            );
        }

        $associationService->persist($association);

        if (!empty($input['assoc_affiliated_with'])) {
            /** @var Association[] $parentAssociations */
            $parentAssociations = $this->getAssociations($input['assoc_affiliated_with']);
            if (count($parentAssociations)) {
                foreach ($parentAssociations as $parentAssociation) {
                    $parentAssociation->addChildAssociation($association);
                    $associationService->persist($parentAssociation);
                }
            }
        }
    }

    /**
     * @param array $input
     * @throws \Dws\Exception\Service\InvalidInputException
     */
    private function addStateOrganisation($input) {
        $stateOrganisationService = $this->getStateOrganisationService();

        try {
            $input['federation'] = $this->federation;
            $stateOrganisation = $stateOrganisationService->findOneByExternalId($input['external_id']);
        } catch(ModelNotFoundException $e) {
            $stateOrganisation = $stateOrganisationService->create(
                $input
            );
        }

        $stateOrganisationService->persist($stateOrganisation);
    }

    /**
     * @param string $input
     * @return StateOrganisation|null
     */
    private function getStateOrganisation($input) {
        $stateOrganisationService = $this->getStateOrganisationService();
        $targets = explode(',', $input);
        foreach ($targets as $target) {
            preg_match('~\(([0-9]+)\)~', $target, $matches);
            if (isset($matches[1])) {
                $externalId = intval($matches[1]);
                try {
                    $stateOrganisation = $stateOrganisationService->findOneByExternalId($externalId);
                } catch(ModelNotFoundException $e) {
                    $stateOrganisation = $stateOrganisationService->create(
                        [
                            'federation' => $this->federation,
                            'external_id' => $externalId,
                            'name' => trim(substr($target, 0, strpos($target, '(') - 1)),
                        ]);
                }
                // We only support a single state
                return $stateOrganisation;
            }
        }
        return null;
    }

    /**
     * @param string $input
     * @return Association[]
     */
    private function getAssociations($input) {
        $associations = [];
        $associationService = $this->getAssociationService();
        $targets = explode(',', $input);
        foreach ($targets as $target) {
            preg_match('~\(([0-9]+)\)~', $target, $matches);
            if (isset($matches[1])) {
                $externalId = intval($matches[1]);
                try {
                    $associations[] = $associationService->findOneByExternalId($externalId);
                } catch(ModelNotFoundException $e) {
                    $associations[] = $associationService->create(
                        [
                            'external_id' => $externalId,
                            'name' => trim(substr($target, 0, strpos($target, '(') - 1)),
                        ]);
                }
            }
        }
        return $associations;
    }

    /**
     * @return ClubService
     */
    private function getClubService() {
        if (!$this->clubService) {
            $this->clubService = $this->getServiceLocator()->get('NcpOrganisation\Service\Club');
        }
        return $this->clubService;
    }

    /**
     * @return StateOrganisationService
     */
    private function getStateOrganisationService() {
        if (!$this->stateOrganisationService) {
            $this->stateOrganisationService = $this->getServiceLocator()->get('NcpOrganisation\Service\StateOrganisation');
        }
        return $this->stateOrganisationService;
    }

    /**
     * @return AssociationService
     */
    private function getAssociationService() {
        if (!$this->associationService) {
            $this->associationService = $this->getServiceLocator()->get('NcpOrganisation\Service\Association');
        }
        return $this->associationService;
    }

    /**
     * @return OrganisationAddressService
     */
    private function getOrganisationAddressService() {
        if (!$this->organisationAddressService) {
            $this->organisationAddressService = $this->getServiceLocator()->get('NcpOrganisation\Service\Organisation\OrganisationAddress');
        }
        return $this->organisationAddressService;
    }

    /**
     * @return FederationService
     */
    private function getFederationService() {
        if (!$this->federationService) {
            $this->federationService = $this->getServiceLocator()->get('NcpOrganisation\Service\Federation');
        }
        return $this->federationService;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AbstractMigration
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
