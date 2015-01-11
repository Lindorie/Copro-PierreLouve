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
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text")
     */
    private $adresse;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mail1", type="string", length=255)
     */
    private $mail1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mail2", type="string", length=255)
     */
    private $mail2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telephone1", type="string", length=255)
     */
    private $telephone1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telephone2", type="string", length=255)
     */
    private $telephone2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="millieme", type="string", length=255)
     */
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
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set mail1
     *
     * @param string $mail1
     * @return User
     */
    public function setMail1($mail1)
    {
        $this->mail1 = $mail1;

        return $this;
    }

    /**
     * Get mail1
     *
     * @return string 
     */
    public function getMail1()
    {
        return $this->mail1;
    }

    /**
     * Set mail2
     *
     * @param string $mail2
     * @return User
     */
    public function setMail2($mail2)
    {
        $this->mail2 = $mail2;

        return $this;
    }

    /**
     * Get mail2
     *
     * @return string 
     */
    public function getMail2()
    {
        return $this->mail2;
    }

    /**
     * Set telephone1
     *
     * @param string $telephone1
     * @return User
     */
    public function setTelephone1($telephone1)
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    /**
     * Get telephone1
     *
     * @return string 
     */
    public function getTelephone1()
    {
        return $this->telephone1;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     * @return User
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * Get telephone2
     *
     * @return string 
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * Set millieme
     *
     * @param string $millieme
     * @return User
     */
    public function setMillieme($millieme)
    {
        $this->millieme = $millieme;

        return $this;
    }

    /**
     * Get millieme
     *
     * @return string 
     */
    public function getMillieme()
    {
        return $this->millieme;
    }
}
