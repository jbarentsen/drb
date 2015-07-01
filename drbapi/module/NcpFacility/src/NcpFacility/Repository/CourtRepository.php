<?php

namespace NcpFacility\Repository;

use Doctrine\Common\Collections\Collection;
use Dws\Exception\Repository\InvalidArgumentException;
use DwsBase\Repository\AbstractRepository;
use Exception;
use NcpFacility\Model\Court;
use NcpFacility\Model\Facility;

class CourtRepository extends AbstractRepository
{
    /**
     * @var string Model name
     */
    protected $modelClassName = 'NcpFacility\Model\Court';

    /**
     * Find all courts by facility
     *
     * @param Facility $facility
     * @return Collection|Court[]
     */
    public function findByFacility(Facility $facility)
    {
        return $this->findBy([
            'facility' => $facility
        ]);
    }

    /**
     * @param Court $court
     * @return Court
     * @throws InvalidArgumentException
     */
    public function persist(Court $court)
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($court);
            $entityManager->flush();
            return $court;
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('Failed to persist court with identifier %d', $court->getId()),
                0,
                $e
            );
        }
    }

    /**
     * @param Court $court
     * @throws InvalidArgumentException
     */
    public function remove(Court $court)
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->remove($court);
            $entityManager->flush();
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('Failed to remove court with identifier %d', $court->getId()),
                0,
                $e
            );
        }
    }
}
