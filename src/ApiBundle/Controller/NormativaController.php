<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Normativa;

class NormativaController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("normativas")
     */
    public function getNormativasAction() {
        $repository = $this->getDoctrine()->getRepository(Normativa::class);
        $plazas = $repository->findAll();
        return $this->handleView($this->view($plazas, JsonResponse::HTTP_OK));
    }
}