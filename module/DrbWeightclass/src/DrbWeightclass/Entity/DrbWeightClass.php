<?php

namespace DrbWeightclass\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DrbWeightClass
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DrbWeightclass\Entity\DrbWeightClassRepository")
 */
class DrbWeightClass
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

	
}
