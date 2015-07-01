<?php

namespace NcpFacility\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Dws\Model\Traits\TimestampableTrait;
use NcpFacility\Model\Facility\FacilityAddress;
use NcpOrganisation\Model\Organisation;

/**
 * Facility
 *
 * @ORM\Entity(repositoryClass="NcpFacility\Repository\FacilityRepository")
 */
class Facility
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180, nullable=false)
     */
    private $name;

    /**
     * @var FacilityAddress
     *
     * @ORM\OneToOne(targetEntity="NcpFacility\Model\Facility\FacilityAddress",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @var Court[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Court", mappedBy="facility",cascade={"persist"})
     */
    private $courts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return FacilityAddress
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param FacilityAddress $address
     * @return Facility
     */
    public function setAddress(FacilityAddress $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param Court $court
     * @return bool
     */
    public function hasCourt(Court $court)
    {
        return $this->courts->contains($court);
    }

    /**
     * @param Court $court
     * @return Facility
     */
    public function addCourt(Court $court)
    {
        if (!$this->hasCourt($court)) {
            $this->courts->add($court);
            $court->setFacility($this);
        }

        return $this;
    }

    /**
     * @param Court $court
     */
    public function removeCourt(Court $court)
    {
        if ($this->hasCourt($court)) {
            $this->courts->removeElement($court);
            $court->setFacility(null);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
