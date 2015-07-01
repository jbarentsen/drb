<?php
namespace NcpFacility\V1\Rest\Facility;

use Dws\Exception\ServiceException;
use NcpFacility\Model\Facility;
use NcpFacility\Service\FacilityService;
use ZF\Rest\AbstractResourceListener;

class FacilityResource extends AbstractResourceListener
{
    /**
     * @var FacilityService
     */
    private $facilityService;

    /**
     * Constructor
     *
     * @param FacilityService $facilityService
     */
    public function __construct(FacilityService $facilityService)
    {
        $this->facilityService = $facilityService;
    }

    /**
     * Create a facility
     *
     * @param  array|\Traversable|\stdClass $data
     * @return Facility
     * @throws ServiceException
     */
    public function create($data)
    {
        return $this->facilityService->persist($this->facilityService->create($data));
    }

    /**
     * Fetch a facility
     *
     * @param  integer $id
     * @return Facility
     * @throws ServiceException
     */
    public function fetch($id)
    {
        $facility = $this->facilityService->find($id);
        return $facility;
    }

    /**
     * Fetch all or a subset of facilities
     *
     * @param array $params
     * @return FacilityCollection
     */
    public function fetchAll($params = array())
    {
        return new FacilityCollection($this->facilityService->findAllPaged());
    }

    /**
     * Delete a facility
     *
     * @param  mixed $id
     * @return bool
     */
    public function delete($id)
    {

        if (!$this->facilityService->delete($id)) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * Update a facility
     *
     * @param  integer $id
     * @param  array|\Traversable|\stdClass $data
     * @return Facility
     * @throws ServiceException
     */
    public function update($id, $data)
    {
        $data->id = $id;
        return $this->facilityService->persist($this->facilityService->populate($data));
    }
}
