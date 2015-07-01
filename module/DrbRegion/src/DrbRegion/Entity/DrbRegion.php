<?php

namespace DrbRegion\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DrbRegion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DrbRegion\Entity\DrbRegionRepository")
 */
class DrbRegion
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	public $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string")
	 */
	public $name;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="abbreviation", type="string")
	 */
	public $abbreviation;
	
	/**
	 * @var Date
	 *
	 * @ORM\Column(name="created", type="date")
	 */
	public $created;
	
	/**
	 * @var Date
	 *
	 * @ORM\Column(name="modified", type="date")
	 */
	public $modified;

	/**
	 * @var DrbCountry\Entity\DrbCountry
	 *
	 * @ORM\OneToOne(targetEntity="DrbCountry\Entity\DrbCountry", mappedBy="drbRegion")
	 * @ORM\JoinColumn(nullable=true)
	 */
	public $drbCountry;

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

	/**
	 * Gets id
	 * 
	 * @return integer
	 */
	public function getId() 
	{
		return $this->id;
	}
	
	/**
	 * Gets name
	 * 
	 * @return string
	 */
	public function getName() 
	{
		return $this->name;
	}
	
	/**
	 * Sets name
	 * 
	 * @param string $name
	 * 
	 * @return $this
	 */
	public function setName(string $name) 
	{
		$this->name = $name;
	
		return $this;
	}
	
	/**
	 * Gets abbreviation
	 * 
	 * @return string
	 */
	public function getAbbreviation() 
	{
		return $this->abbreviation;
	}
	
	/**
	 * Sets abbreviation
	 * 
	 * @param string $abbreviation
	 * 
	 * @return $this
	 */
	public function setAbbreviation(string $abbreviation) 
	{
		$this->abbreviation = $abbreviation;
	
		return $this;
	}
	
	/**
	 * Gets created
	 * 
	 * @return Date
	 */
	public function getCreated() 
	{
		return $this->created;
	}
	
	/**
	 * Sets created
	 * 
	 * @param Date $created
	 * 
	 * @return $this
	 */
	public function setCreated(Date $created) 
	{
		$this->created = $created;
	
		return $this;
	}
	
	/**
	 * Gets modified
	 * 
	 * @return Date
	 */
	public function getModified() 
	{
		return $this->modified;
	}
	
	/**
	 * Sets modified
	 * 
	 * @param Date $modified
	 * 
	 * @return $this
	 */
	public function setModified(Date $modified) 
	{
		$this->modified = $modified;
	
		return $this;
	}

	/**
	 * Gets drbCountry
	 * 
	 * @return DrbCountry\Entity\DrbCountry
	 */
	public function getDrbCountry() 
	{
		return $this->drbCountry;
	}
	
	/**
	 * Sets drbCountry
	 * 
	 * @param DrbCountry\Entity\DrbCountry $drbCountry
	 * 
	 * @return $this
	 */
	public function setDrbCountry(DrbCountry\Entity\DrbCountry $drbCountry) 
	{
		if($this->getDrbCountry() !== $drbCountry)
		{
			$this->drbCountry = $drbCountry;
			$drbCountry->setDrbRegion($this);
		}
	
		return $this;
	}
}
