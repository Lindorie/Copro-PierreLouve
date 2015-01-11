<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    private $legende;
    private $path;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
    public function getLegende()
    {
    	return $this->legende;
    }
    
    public function setLegende($legende)
    {
    	$this->legende = $legende;
    	
    	return $this;
    }
    
    public function getPath()
    {
    	return $this->path;
    }
    
    public function setPath($path)
    {
    	$this->path = $path;
    	 
    	return $this;
    }
}
