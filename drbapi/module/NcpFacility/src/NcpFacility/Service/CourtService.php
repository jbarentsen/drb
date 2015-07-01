<?php

namespace NcpFacility\Service;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Dws\Exception\RepositoryException;
use Dws\Exception\Service\InvalidArgumentException;
use Dws\Exception\Service\InvalidInputException;
use Dws\Exception\Service\ModelNotFoundException;
use Dws\Exception\Service\UnauthorizedException;
use Dws\Exception\ServiceException;
use NcpBase\Hydrator\Model\BaseHydrator;
use NcpFacility\Hydrator\Model\CourtHydrator;
use NcpFacility\InputFilter\Court\CourtCreateInputFilter;
use NcpFacility\InputFilter\Court\CourtPopulateInputFilter;
use NcpFacility\Model\Court;
use NcpFacility\Model\Facility;
use NcpFacility\Repository\CourtRepository;
use NcpPermission\Service\Permission\ResourcePermissionService;
use stdClass;
use Traversable;
use Zend\Stdlib\ArrayUtils;

class CourtService
{
    /**
     * @var CourtRepository
     */
    private $courtRepository;

    /**
     * @var ResourcePermissionService
     */
    private $resourcePermissionService;

    /**
     * @var FacilityService
     */
    private $facilityService;

    /**
     * @var CourtHydrator
     */
    private $courtHydrator;

    /**
     * @var BaseHydrator
     */
    private $baseHydrator;

    /**
     * @var CourtCreateInputFilter
     */
    private $createInputFilter;

    /**
     * @var CourtPopulateInputFilter
     */
    private $populateInputFilter;

    /**
     * @param CourtRepository|CourtRepository $courtRepository
     * @param FacilityService $facilityService
     * @param ResourcePermissionService $resourcePermissionService
     * @param BaseHydrator $baseHydrator
     */
    public function __construct(
        CourtRepository $courtRepository,
        FacilityService $facilityService,
        ResourcePermissionService $resourcePermissionService,
        BaseHydrator $baseHydrator
    ) {
        $this->courtRepository = $courtRepository;
        $this->resourcePermissionService = $resourcePermissionService;
        $this->baseHydrator = $baseHydrator;
        $this->facilityService = $facilityService;
    }

    /**
     * Find court by id
     *
     * @param $id
     * @return Court
     * @throws ModelNotFoundException
     * @throws UnauthorizedException
     */
    public function find($id)
    {
        /** @var Court $court */
        $court = $this->courtRepository->find($id);
        if ($court === null) {
            throw new ModelNotFoundException(
                sprintf('Court with identifier %d not found', $id)
            );
        }

        if (!$this->resourcePermissionService->isAllowedToCourt($court, 'read')) {
            throw new UnauthorizedException(
                sprintf('Not authorized to read court with identifier %d', $court->getId())
            );
        }

        return $court;
    }

    /**
     * @return DoctrinePaginator
     */
    public function findAllPaged()
    {
        // TODO: validate $criteria

        // TODO: add ACL verification

        return $this->courtRepository->findAllPaged();
    }

    /**
     * @param array|Traversable|stdClass $data
     * @return Court
     * @throws InvalidArgumentException
     * @throws ServiceException
     */
    public function create($data)
    {
        /** @var CourtCreateInputFilter $inputFilter */
        $inputFilter = $this->getCreateInputFilter($data);
        if (!$inputFilter->isValid()) {
            throw new InvalidInputException(
                'Unable to create court because of invalid input',
                0,
                null,
                $inputFilter->getMessages()
            );
        }

        return $this->courtHydrator->hydrate($inputFilter->getValues(), new Court());
    }

    /**
     * @param array|Traversable|stdClass|null $data
     * @return CourtCreateInputFilter
     */
    private function getCreateInputFilter($data = [])
    {
        if (!$this->createInputFilter) {
            $this->createInputFilter = new CourtCreateInputFilter($this->facilityService);
        }
        return $this->createInputFilter->setData($data);
    }

    /**
     * @param array|Traversable|stdClass $data
     * @return Court
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
                'Unable to update court because of invalid input',
                0,
                null,
                $inputFilter->getMessages()
            );
        }

        /** @var Court $court */
        $court = $this->baseHydrator->hydrate($inputFilter->getValues(), $this->courtRepository->find($inputFilter->getValue('id')));

        if (!$this->resourcePermissionService->isAllowedToCourt($court, 'update')) {
            throw new UnauthorizedException(
                sprintf('Not authorized to update court with identifier %d', $court->getId())
            );
        }

        return $court;
    }

    /**
     * @param array|Traversable|stdClass|null $data
     * @return CourtPopulateInputFilter
     */
    private function getPopulateInputFilter($data = [])
    {
        if (!$this->populateInputFilter) {
            $this->populateInputFilter = new CourtPopulateInputFilter(
                $this->facilityService
            );
        }
        return $this->populateInputFilter->setData($data);
    }

    /**
     * @param Court $court
     * @throws ServiceException
     * @return Court
     */
    public function persist(Court $court)
    {
        try {
            return $this->courtRepository->persist($court);
        } catch (RepositoryException $e) {
            throw new ServiceException('Failed to persist court', 0, $e);
        }
    }
}
