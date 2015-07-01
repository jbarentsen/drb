<?php

namespace NcpFacility\Model\Facility;

use Doctrine\ORM\Mapping as ORM;
use NcpBase\Model\Address;

/**
 * FacilityAddress
 *
 * @ORM\Entity(repositoryClass="NcpFacility\Repository\FacilityRepository")
 */
class FacilityAddress extends Address
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->type = self::TYPE_WORK; // is the only valid type
    }
}
