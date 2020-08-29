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
class EstacionamientoViaPublica {
    
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
     * @ORM\Column(type="string")
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $descripcion;

    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity=Normativa::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $normativa;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $latitudOrigen;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $longitudOrigen;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $latitudDestino;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $longitudDestino;
    
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

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
        return $this;
    }
    
    public function getLatitudOrigen() {
        return $this->latitudOrigen;
    }

    public function setLatitudOrigen($latitudOrigen) {
        $this->latitudOrigen = $latitudOrigen;
        return $this;
    }
    
    public function getLongitudOrigen() {
        return $this->longitudOrigen;
    }

    public function setLongitudOrigen($longitudOrigen) {
        $this->longitudOrigen = $longitudOrigen;
        return $this;
    }
    
    public function getLatitudDestino() {
        return $this->latitudDestino;
    }

    public function setLatitudDestino($latitudDestino) {
        $this->latitudDestino = $latitudDestino;
        return $this;
    }
    
    public function getLongitudDestino() {
        return $this->longitudDestino;
    }

    public function setLongitudDestino($longitudDestino) {
        $this->longitudDestino = $longitudDestino;
        return $this;
    }
}
