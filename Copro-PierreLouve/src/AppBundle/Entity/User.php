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
    
    /**
    * nom
    */
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
    * prenom
    */
    public function getPrenom()
    {
        return $this->prenom;
    }
    
    /**
    * adresse
    */
    public function getAdresse()
    {
        return $this->adresse;
    }
    
    /**
    * millieme
    */
    public function getMillieme()
    {
        return $this->millieme;
    }
    
    /**
    * mail-1
    */
    public function getMail1()
    {
        return $this->mail1;
    }
    
    public function setMail1()
    {
    	$this->mail1 = $mail1;
    	return $this;
    }
    
    /**
    * mail-2
    */
    public function getMail2()
    {
        return $this->mail2;
    }
    
    public function setMail2()
    {
    	$this->mail2 = $mail2;
    	return $this;
    }
    
    /**
    * telephone-1
    */
    public function getTelephone1()
    {
        return $this->telephone1;
    }
    
    public function settelephone1()
    {
    	$this->telephone1 = $telephone1;
    	return $this;
    }
    
    /**
    * telephone-2
    */
    public function getTelephone2()
    {
        return $this->telephone2;
    }
    
    public function settelephone2()
    {
    	$this->telephone2 = $telephone2;
    	return $this;
    }
}
