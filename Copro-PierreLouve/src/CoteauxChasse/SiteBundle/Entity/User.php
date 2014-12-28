<?php

namespace CoteauxChasse\SiteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="CoteauxChasse\ActusBundle\Entity\Actu", mappedBy="auteur")
     **/
    private $actus;
    
    public function __construct() {
    	$this->actus = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    

    

    /**
     * Add actus
     *
     * @param \CoteauxChasse\ActusBundle\Entity\Actu $actus
     * @return User
     */
    public function addActus(\CoteauxChasse\ActusBundle\Entity\Actu $actus)
    {
        $this->actus[] = $actus;

        return $this;
    }

    /**
     * Remove actus
     *
     * @param \CoteauxChasse\ActusBundle\Entity\Actu $actus
     */
    public function removeActus(\CoteauxChasse\ActusBundle\Entity\Actu $actus)
    {
        $this->actus->removeElement($actus);
    }

    /**
     * Get actus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActus()
    {
        return $this->actus;
    }
}
