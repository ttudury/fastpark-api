<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Expose;
use Gedmo\Mapping\Annotation as GEDMO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @Serializer\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks
 * @GEDMO\SoftDeleteable(fieldName="deletedAt")
 */
class Plaza {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    
    protected $id;
    
    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $codigo;
    
    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(
     *     type="boolean",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $disponible;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $latitud;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $longitud;
    
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    
    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    protected $deletedAt;
    
    function getId() {
        return $this->id;
    }
    public function getCodigo() {
        return $this->codigo;
    }

    public function setdni($codigo) {
        $this->codigo = $codigo;
        return $this;
    }
    
    public function getDisponible() {
        return $this->disponible;
    }

    public function setDisponible($disponible) {
        $this->disponible = $disponible;
        return $this;
    }
    
    public function getLatitud() {
        return $this->latitud;
    }

    public function setLatitud($latitud) {
        $this->dni = $latitud;
        return $this;
    }
    
    public function getLongitud() {
        return $this->longitud;
    }

    public function setLongitud($longitud) {
        $this->dni = $longitud;
        return $this;
    }
}
