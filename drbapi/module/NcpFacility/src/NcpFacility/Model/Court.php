<?php

namespace NcpFacility\Model;

use Doctrine\ORM\Mapping as ORM;
use Dws\Model\Traits\TimestampableTrait;

/**
 * Court
 *
 * @ORM\Entity(repositoryClass="NcpFacility\Repository\CourtRepository")
 */
class Court
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
     * @var Facility
     *
     * @ORM\ManyToOne(targetEntity="Facility", inversedBy="courts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facility;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Facility
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * @param Facility|null $facility
     * @return Court
     */
    public function setFacility(Facility $facility)
    {
        $this->facility = $facility;
        if (!$facility->hasCourt($this)) {
            $facility->addCourt($this);
        }

        return $this;
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
