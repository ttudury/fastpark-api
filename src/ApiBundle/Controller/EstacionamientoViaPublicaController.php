<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\EstacionamientoViaPublica;
use AppBundle\Entity\Normativa;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EstacionamientoViaPublicaController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("viapublica")
     */
    public function getRestriccionesViaPublicaAction() {
        $repository = $this->getDoctrine()->getRepository(EstacionamientoViaPublica::class);
        $restriccionesViaPublica = $repository->findAll();
        return $this->handleView($this->view($restriccionesViaPublica, JsonResponse::HTTP_OK, array('Access-Control-Allow-Origin'=>'*')));
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
        return $this->handleView($this->view($restriccionesViaPublica, JsonResponse::HTTP_OK, array('Access-Control-Allow-Origin'=>'*')));
    }

    /**
     * @Rest\Post("/viapublica/{codigoNormativa}")
     */
    public function getRestriccionesPorTipoCoordenadasAction($codigoNormativa, HttpFoundationRequest $request) {
        $body_request = json_decode($request->getContent());
        $normativaRepository = $this->getDoctrine()->getRepository(Normativa::class);
        $normativa = $normativaRepository->findOneBy(array('codigo'=>$codigoNormativa));
        if (!$normativa) throw new HttpException(404, "Normativa no encontrada para el codigo especificado: '" . $codigoNormativa."'");
        $estacionamientoViaPublicaRepository = $this->getDoctrine()->getRepository(EstacionamientoViaPublica::class);
        $restriccionesViaPublica = $estacionamientoViaPublicaRepository->findBy(array('normativa' => $normativa));

        foreach ($restriccionesViaPublica as $key => $restriccion){
            $latitudes = $this->extraerCoordenadas("lat", $restriccion->getCodigo());
            $longitudes = $this->extraerCoordenadas("lng", $restriccion->getCodigo());
            if (!$this->coordenadasEnRango($latitudes, $longitudes, $body_request->latitud, $body_request->longitud)){
                unset($restriccionesViaPublica[$key]);
            }
        }

        return $this->handleView($this->view($restriccionesViaPublica, JsonResponse::HTTP_OK, array(
            'Access-Control-Allow-Origin'=>'*', 
            'Access-Control-Allow-Methods'=>'GET, POST, PATCH, PUT, DELETE, OPTIONS', 
            'Access-Control-Allow-Headers'=>'Content-Type, Origin, Cache-Control, X-Requested-With  '
        )));
    }

    private function extraerCoordenadas($aguja, $multiString){
        $html = $multiString;
        $needle = $aguja;
        $lastPos = 0;
        $positions = array();

        while (($lastPos = strpos($html, $needle, $lastPos))!== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($needle);
        }

        $coordenadaLength = 10;
        $coordenadas = array();
        foreach ($positions as $position){
            $coordenadas[] = substr($multiString, $position+6, $coordenadaLength);
        }
        return $coordenadas;

    }

    private function coordenadasEnRango($latitudes, $longitudes, $latitudReferencia, $longitudReferencia){
        $minLat = $latitudReferencia*(-1)-0.01;
        $maxLat = $latitudReferencia*(-1)+0.01;
        $minLong = $longitudReferencia*(-1)-0.01;
        $maxLong = $longitudReferencia*(-1)+0.01;


        foreach ($latitudes as $latitud){
            if ($latitud > $maxLat || $latitud < $minLat ){
                return false;
            }
        }

        foreach ($longitudes as $longitud){
            if ($longitud > $maxLong || $longitud < $minLong ){
                return false;
            }
        }

        return true;
    }


}
