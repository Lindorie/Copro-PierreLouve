<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
}
