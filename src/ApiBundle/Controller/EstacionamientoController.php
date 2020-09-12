<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Estacionamiento;
use AppBundle\Entity\TipoEstacionamiento;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @Rest\Get("/estacionamientos/{codigoTipoEstacionamiento}")
     */
    public function getEstacionamientosPorTipoAction($codigoTipoEstacionamiento) {
        $tipoRepository = $this->getDoctrine()->getRepository(TipoEstacionamiento::class);
        $tipoEstacionamiento = $tipoRepository->findOneBy(array('codigo'=>$codigoTipoEstacionamiento));
        if (!$tipoEstacionamiento) throw new HttpException(404, "tipo de estacionamiento no encontrado para el codigo especificado: '" . $codigoTipoEstacionamiento."'");
        $estacionamientoRepository = $this->getDoctrine()->getRepository(Estacionamiento::class);
        $estacionamientos = $estacionamientoRepository->findBy(array('tipoEstacionamiento' => $tipoEstacionamiento));
        return $this->handleView($this->view($estacionamientos, JsonResponse::HTTP_OK));
    }
}
