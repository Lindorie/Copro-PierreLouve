<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Document", mappedBy="user")
     **/
    private $docs;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Retard", mappedBy="user")
     **/
    private $retards;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ConseilSyndical", inversedBy="membres")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $conseil;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text", nullable=true)
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
     * @ORM\Column(name="mail2", type="string", length=255, nullable=true)
     */
    private $mail2;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone1", type="string", length=255, nullable=true)
     */
    private $telephone1;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone2", type="string", length=255, nullable=true)
     */
    private $telephone2;

    /**
     * @var string
     *
     * @ORM\Column(name="milliemes", type="string", length=255, nullable=true)
     */
    private $milliemes;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=5, nullable=true)
     */
    private $extension;


    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
   

    public function __construct()
    {
        parent::__construct();
    	$this->actus = new ArrayCollection();
    }

    public function getNomPrenom() {
        $string = $this->nom.' '.$this->prenom;
        return $string;
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
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getMail1()
    {
        return $this->mail1;
    }

    /**
     * @param string $mail1
     */
    public function setMail1($mail1)
    {
        $this->mail1 = $mail1;
    }

    /**
     * @return string
     */
    public function getMail2()
    {
        return $this->mail2;
    }

    /**
     * @param string $mail2
     */
    public function setMail2($mail2)
    {
        $this->mail2 = $mail2;
    }

    /**
     * @return string
     */
    public function getTelephone1()
    {
        return $this->telephone1;
    }

    /**
     * @param string $telephone1
     */
    public function setTelephone1($telephone1)
    {
        $this->telephone1 = $telephone1;
    }

    /**
     * @return string
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * @param string $telephone2
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;
    }

    /**
     * @return string
     */
    public function getMillieme()
    {
        return $this->millieme;
    }

    /**
     * @param string $millieme
     */
    public function setMillieme($millieme)
    {
        $this->millieme = $millieme;
    }
    
    


    /**
     * Set extension
     *
     * @param string $extension
     * @return User
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return User
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set milliemes
     *
     * @param string $milliemes
     * @return User
     */
    public function setMilliemes($milliemes)
    {
        $this->milliemes = $milliemes;

        return $this;
    }

    /**
     * Get milliemes
     *
     * @return string 
     */
    public function getMilliemes()
    {
        return $this->milliemes;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add docs
     *
     * @param \AppBundle\Entity\Document $docs
     * @return User
     */
    public function addDoc(\AppBundle\Entity\Document $docs)
    {
        $this->docs[] = $docs;

        return $this;
    }

    /**
     * Remove docs
     *
     * @param \AppBundle\Entity\Document $docs
     */
    public function removeDoc(\AppBundle\Entity\Document $docs)
    {
        $this->docs->removeElement($docs);
    }

    /**
     * Get docs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocs()
    {
        return $this->docs;
    }


    /**
     * Add retards
     *
     * @param \AppBundle\Entity\Retard $retards
     * @return User
     */
    public function addRetard(\AppBundle\Entity\Retard $retards)
    {
        $this->retards[] = $retards;

        return $this;
    }

    /**
     * Remove retards
     *
     * @param \AppBundle\Entity\Retard $retards
     */
    public function removeRetard(\AppBundle\Entity\Retard $retards)
    {
        $this->retards->removeElement($retards);
    }

    /**
     * Get retards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRetards()
    {
        return $this->retards;
    }

    /**
     * Set conseil
     *
     * @param \AppBundle\Entity\ConseilSyndical $conseil
     * @return User
     */
    public function setConseil(\AppBundle\Entity\ConseilSyndical $conseil = null)
    {
        $this->conseil = $conseil;

        return $this;
    }

    /**
     * Get conseil
     *
     * @return \AppBundle\Entity\ConseilSyndical 
     */
    public function getConseil()
    {
        return $this->conseil;
    }
}
