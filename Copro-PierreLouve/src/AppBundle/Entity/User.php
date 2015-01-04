<?php

namespace AppBundle\Entity;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Actu", mappedBy="auteur")
     **/
    private $actus;
    private $nom;
    private $prenom;
    private $adresse;
    private $mail1;
    private $mail2;
    private $telephone1;
    private $telephone2;
    private $millieme;

    public function __construct()
    {
        parent::__construct();
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
     * @param \AppBundle\Entity\Actu $actus
     * @return User
     */
    public function addActus(\AppBundle\Entity\Actu $actus)
    {
        $this->actus[] = $actus;

        return $this;
    }

    /**
     * Remove actus
     *
     * @param \AppBundle\Entity\Actu $actus
     */
    public function removeActus(\AppBundle\Entity\Actu $actus)
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
