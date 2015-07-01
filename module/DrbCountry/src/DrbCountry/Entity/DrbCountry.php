<?php

namespace DrbCountry\Entity;

use Doctrine\ORM\Mapping as ORM;
use DrbRegion\Entity\DrbRegion;
use Zend\Db\Sql\Ddl\Column\Date;

/**
 * DrbCountry
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DrbCountry\Entity\DrbCountryRepository")
 */
class DrbCountry
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
	 * @ORM\Column(name="lc2", type="string")
	 */
	public $lc2;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="lc3", type="string")
	 */
	public $lc3;
	
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="showInFrontEnd", type="boolean")
	 */
	public $showInFrontEnd;
	
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
	 * @var DrbRegion
	 *
	 * @ORM\OneToOne(targetEntity="DrbRegion\Entity\DrbRegion", mappedBy="drbCountry")
	 * @ORM\JoinColumn(nullable=true)
	 */
	public $drbRegion;

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
	 * @param String $name
	 * 
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}
	
	/**
	 * Gets lc2
	 * 
	 * @return string
	 */
	public function getLc2() 
	{
		return $this->lc2;
	}
	
	/**
	 * Sets lc2
	 * 
	 * @param $lc2
	 * 
	 * @return $this
	 */
	public function setLc2($lc2)
	{
		$this->lc2 = $lc2;
	
		return $this;
	}
	
	/**
	 * Gets lc3
	 * 
	 * @return string
	 */
	public function getLc3() 
	{
		return $this->lc3;
	}
	
	/**
	 * Sets lc3
	 * 
	 * @param String $lc3
	 * 
	 * @return $this
	 */
	public function setLc3($lc3)
	{
		$this->lc3 = $lc3;
	
		return $this;
	}
	
	/**
	 * Gets showInFrontEnd
	 * 
	 * @return boolean
	 */
	public function getShowInFrontEnd() 
	{
		return $this->showInFrontEnd;
	}
	
	/**
	 * Sets showInFrontEnd
	 * 
	 * @param boolean $showInFrontEnd
	 * 
	 * @return $this
	 */
	public function setShowInFrontEnd($showInFrontEnd) 
	{
		$this->showInFrontEnd = $showInFrontEnd;
	
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
	 * Gets drbRegion
	 * 
	 * @return DrbRegion
	 */
	public function getDrbRegion() 
	{
		return $this->drbRegion;
	}
	
	/**
	 * Sets drbRegion
	 * 
	 * @param DrbRegion $drbRegion
	 * 
	 * @return $this
	 */
	public function setDrbRegion(DrbRegion $drbRegion)
	{
		if($this->getDrbRegion() !== $drbRegion)
		{
			$this->drbRegion = $drbRegion;
			$drbRegion->setDrbCountry($this);
		}
	
		return $this;
	}
}
