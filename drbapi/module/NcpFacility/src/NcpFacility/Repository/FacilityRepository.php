<?php

namespace NcpFacility\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Join;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Dws\Exception\Repository\InvalidArgumentException;
use DwsBase\Repository\AbstractRepository;
use Exception;
use NcpFacility\Model\Facility;
use NcpOrganisation\Model\Organisation;

class FacilityRepository extends AbstractRepository
{
    /**
     * @var string Model name
     */
    protected $modelClassName = 'NcpFacility\Model\Facility';

    /**
     * @param Facility $facility
     * @return Facility
     * @throws InvalidArgumentException
     */
    public function persist(Facility $facility)
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($facility);
            $entityManager->flush();
            return $facility;
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('Failed to persist facility with identifier %d', $facility->getId()),
                0,
                $e
            );
        }
    }

    /**
     * @param Facility $facility
     * @throws InvalidArgumentException
     */
    public function remove(Facility $facility)
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->remove($facility);
            $entityManager->flush();
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('Failed to remove facility with identifier %d', $facility->getId()),
                0,
                $e
            );
        }
    }

    /**
     * @param Organisation $organisation
     * @return Facility[]
     */
    public function findByOrganisationPaged(Organisation $organisation) {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('f')
            ->from($this->getClassName(), 'f')
            ->join('NcpOrganisation\Model\Organisation\OrganisationFacility', 'fo', Join::WITH, 'f.id = fo.facility')
            ->where('fo.organisation = :organisation')
            ->setParameter('organisation', $organisation)
            ->orderBy('f.name');
        return $this->getPaginator($qb->getQuery());

    }
}
