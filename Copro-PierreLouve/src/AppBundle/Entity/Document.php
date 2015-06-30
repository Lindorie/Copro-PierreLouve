<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="gerer", type="string", length=255)
     */
    private $gerer;

    /**
     * @var string
     *
     * @ORM\Column(name="voir", type="string", length=255)
     */
    private $voir;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=5)
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="docs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set titre
     *
     * @param string $titre
     * @return Document
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set gerer
     *
     * @param string $gerer
     * @return Document
     */
    public function setGerer($gerer)
    {
        $this->gerer = $gerer;

        return $this;
    }

    /**
     * Get gerer
     *
     * @return string
     */
    public function getGerer()
    {

        return $this->gerer;
    }

    /**
     * Set voir
     *
     * @param string $voir
     * @return Document
     */
    public function setVoir($voir)
    {
        $this->voir = $voir;

        return $this;
    }

    /**
     * Get voir
     *
     * @return string
     */
    public function getVoir()
    {
        return $this->voir;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Document
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

    public function upload($directory)
    {
    	// la propriété « file » peut être vide si le champ n'est pas requis
    	if (null === $this->file) {
    		return;
    	}
		if ($this->extension === null) {
			$this->retrieveSetExtension();
		}
    	$this->file->move($directory, $this->id.".".$this->extension);

    }
	public function getFileName() {
		$fichier = $this->id.".".$this->extension;
		return $fichier;
	}

	public function retrieveSetExtension() {
		$this->extension = pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION);
	}



    /**
     * Set extension
     *
     * @param string $extension
     * @return Document
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
     * Set date
     *
     * @param \DateTime $date
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Document
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
