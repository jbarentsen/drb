<?php

namespace NcpFacility\Service;

use Doctrine\Common\Collections\Collection;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Dws\Exception\RepositoryException;
use Dws\Exception\Service\InvalidArgumentException;
use Dws\Exception\Service\InvalidInputException;
use Dws\Exception\Service\ModelNotFoundException;
use Dws\Exception\Service\UnauthorizedException;
use Dws\Exception\ServiceException;
use NcpOrganisation\Model\Organisation;
use NcpFacility\Hydrator\Model\FacilityHydrator;
use NcpFacility\InputFilter\Facility\FacilityCreateInputFilter;
use NcpFacility\InputFilter\Facility\FacilityPopulateInputFilter;
use NcpFacility\Model\Facility;
use NcpFacility\Repository\FacilityRepository;
use NcpOrganisation\Service\ClubService;
use NcpOrganisation\Service\OrganisationService;
use NcpPermission\Service\Permission\ResourcePermissionService;
use stdClass;
use Traversable;
use Zend\Stdlib\ArrayUtils;

class FacilityService
{
    /**
     * @var FacilityRepository
     */
    private $facilityRepository;

    /**
     * @var ClubService
     */
    private $clubService;

    /**
     * @var ResourcePermissionService
     */
    private $resourcePermissionService;

    /**
     * @var FacilityHydrator
     */
    private $facilityHydrator;

    /**
     * @var FacilityCreateInputFilter
     */
    private $createInputFilter;

    /**
     * @var FacilityPopulateInputFilter
     */
    private $populateInputFilter;

    /**
     * @param FacilityRepository $facilityRepository
     * @param ResourcePermissionService $resourcePermissionService
     * @param FacilityHydrator $facilityHydrator
     * @param OrganisationService $organisationService
     */
    public function __construct(
        FacilityRepository $facilityRepository,
        ResourcePermissionService $resourcePermissionService,
        FacilityHydrator $facilityHydrator,
        OrganisationService $organisationService
    ) {
        $this->facilityRepository = $facilityRepository;
        $this->resourcePermissionService = $resourcePermissionService;
        $this->facilityHydrator = $facilityHydrator;
        $this->organisationService = $organisationService;
    }

    /**
     * Find facility by id
     *
     * @param $id
     * @return Facility
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function find($id)
    {
        /** @var Facility $facility */
        $facility = $this->facilityRepository->find($id);
        if ($facility === null) {
            throw new ModelNotFoundException(
                sprintf('Facility with identifier %d not found', $id)
            );
        }

        if (!$this->resourcePermissionService->isAllowedToFacility($facility, 'read')) {
            throw new UnauthorizedException(
                sprintf('Not authorized to read facility with identifier %d', $facility->getId())
            );
        }
        return $facility;
    }

    /**
     * @return DoctrinePaginator
     */
    public function findAllPaged()
    {
        return $this->facilityRepository->findAllPaged();
    }

    /**
     * @param array|Traversable|stdClass $data
     * @return Facility
     * @throws InvalidArgumentException
     * @throws ServiceException
     */
    public function create($data)
    {
        /** @var FacilityCreateInputFilter $inputFilter */
        $inputFilter = $this->getCreateInputFilter($data);
        if (!$inputFilter->isValid()) {
            throw new InvalidInputException(
                'Unable to create facility because of invalid input',
                0,
                null,
                $inputFilter->getMessages()
            );
        }

        return $this->facilityHydrator->hydrate($inputFilter->getValues(), new Facility());
    }

    /**
     * @param array|Traversable|stdClass|null $data
     * @return FacilityCreateInputFilter
     */
    private function getCreateInputFilter($data = [])
    {
        if (!$this->createInputFilter) {
            $this->createInputFilter = new FacilityCreateInputFilter(
                $this->clubService
            );
        }
        return $this->createInputFilter->setData($data);
    }

    /**
     * @param array|Traversable|stdClass $data
     * @return Facility
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     * @throws ServiceException
     */
    public function populate($data)
    {
        /** @var  $inputFilter */
        $inputFilter = $this->getPopulateInputFilter($data);

        if (!$inputFilter->isValid()) {
            throw new InvalidInputException(
                'Unable to update facility because of invalid input',
                0,
                null,
                $inputFilter->getMessages()
            );
        }

        /** @var Facility $facility */
        $facility = $this->facilityHydrator->hydrate($inputFilter->getValues(), $this->facilityRepository->find($inputFilter->getValue('id')));

        if (!$this->resourcePermissionService->isAllowedToFacility($facility, 'update')) {
            throw new UnauthorizedException(
                sprintf('Not authorized to update facility with identifier %d', $facility->getId())
            );
        }

        return $facility;
    }

    /**
     * @param array|Traversable|stdClass|null $data
     * @return FacilityPopulateInputFilter
     */
    private function getPopulateInputFilter($data = [])
    {
        if (!$this->populateInputFilter) {
            $this->populateInputFilter = new FacilityPopulateInputFilter(
                $this->facilityRepository,
                $this->clubService
            );
        }
        return $this->populateInputFilter->setData($data);
    }

    /**
     * @param Organisation $organisation
     * @return Facility[]|Collection
     * @throws UnauthorizedException
     */
    public function findByOrganisationPaged(Organisation $organisation)
    {
        if (!$this->resourcePermissionService->isAllowedToOrganisation($organisation, 'read')) {
            throw new UnauthorizedException(
                sprintf('Not authorized to read organisation with identifier %d', $organisation->getId())
            );
        }
        return $this->facilityRepository->findByOrganisationPaged($organisation);
    }

    /**
     * @param Facility $facility
     * @throws ServiceException
     * @return Facility
     */
    public function persist(Facility $facility)
    {
        try {
            return $this->facilityRepository->persist($facility);
        } catch (RepositoryException $e) {
            throw new ServiceException('Failed to persist facility', 0, $e);
        }
    }

    /**
     * @param integer $id
     * @return bool
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     * @throws ServiceException
     */
    public function delete($id)
    {
        $facility = $this->find($id);

        if (!$this->resourcePermissionService->isAllowedToFacility($facility, 'delete')) {
            throw new UnauthorizedException(
                sprintf('Not authorized to delete facility with identifier %d', $facility->getId())
            );
        }

        try {
            $this->facilityRepository->remove($facility);
            return true;
        } catch (RepositoryException $e) {
            throw new ServiceException(
                sprintf('Failed to delete facility with identifier %d', $facility->getId()),
                0,
                $e
            );
        }
    }
}
