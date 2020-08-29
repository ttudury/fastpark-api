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
class Estacionamiento {

    const TIPO_CONCESIONADO = 'concesionado';
    const TIPO_PRIVADO = 'privado';
    const TIPO_MOTOCICLETAS = 'motocicletas';
    
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
     * @ORM\Column(type="string",nullable=true)
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $nombre;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(
     *     choices = {"concesionado", "privado", "motocicletas"},
     *     message = "Choose a valid type of instrument: 'concesionado', 'privado' or 'motocicletas'."
     * )
     * @Assert\NotBlank
     * @Expose
     */
    protected $tipo;
    
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
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Expose
     */
    protected $precio;
    
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
    
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }
    
    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }
    
    public function getLatitud() {
        return $this->latitud;
    }

    public function setLatitud($latitud) {
        $this->latitud = $latitud;
        return $this;
    }
    
    public function getLongitud() {
        return $this->longitud;
    }

    public function setLongitud($longitud) {
        $this->longitud = $longitud;
        return $this;
    }
    
    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
        return $this;
    }
}
