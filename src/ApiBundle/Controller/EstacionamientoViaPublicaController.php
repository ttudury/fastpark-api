<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\EstacionamientoViaPublica;
use AppBundle\Entity\Normativa;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EstacionamientoViaPublicaController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("viapublica")
     */
    public function getRestriccionesViaPublicaAction() {
        $repository = $this->getDoctrine()->getRepository(EstacionamientoViaPublica::class);
        $restriccionesViaPublica = $repository->findAll();
        return $this->handleView($this->view($restriccionesViaPublica, JsonResponse::HTTP_OK));
    }

    /**
     * @Rest\Get("/viapublica/{codigoNormativa}")
     */
    public function getRestriccionesPorNormativaAction($codigoNormativa) {
        $normativaRepository = $this->getDoctrine()->getRepository(Normativa::class);
        $normativa = $normativaRepository->findOneBy(array('codigo'=>$codigoNormativa));
        if (!$normativa) throw new HttpException(404, "Normativa no encontrada para el codigo especificado: '" . $codigoNormativa."'");
        $estacionamientoViaPublicaRepository = $this->getDoctrine()->getRepository(EstacionamientoViaPublica::class);
        $restriccionesViaPublica = $estacionamientoViaPublicaRepository->findBy(array('normativa' => $normativa));
        return $this->handleView($this->view($restriccionesViaPublica, JsonResponse::HTTP_OK));
    }
}
