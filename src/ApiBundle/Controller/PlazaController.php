<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Plaza;

class PlazaController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("plazas")
     */
    public function getPlazasAction() {
        $repository = $this->getDoctrine()->getRepository(Plaza::class);
        $plazas = $repository->findAll();
        return $this->handleView($this->view($plazas, JsonResponse::HTTP_OK));
    }
}
