<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Estacionamiento;

class EstacionamientoController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("estacionamientos")
     */
    public function getEstacionamientosAction() {
        $repository = $this->getDoctrine()->getRepository(Estacionamiento::class);
        $plazas = $repository->findAll();
        return $this->handleView($this->view($plazas, JsonResponse::HTTP_OK));
    }

    /**
     * @Rest\Get("/estacionamientos/{tipoEstacionamiento}")
     */
    public function getEstacionamientoPorTipoAction($tipoEstacionamiento) {
        $repository = $this->getDoctrine()->getRepository(Estacionamiento::class);
        $plazas = $repository->findBy(array('tipo' => $tipoEstacionamiento));
        return $this->handleView($this->view($plazas, JsonResponse::HTTP_OK));
    }
}
