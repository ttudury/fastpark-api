<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \AppBundle\Entity\EstacionamientoViaPublica;

class LimpiarRegistrosCommand extends ContainerAwareCommand {


    protected function configure() {
        $this->setName('limpiar:coordenadas')
                ->setDescription('Elimina las coordenadas que se encuentran fuera del rango establecido');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $estacionamientos = $em->getRepository("AppBundle:EstacionamientoViaPublica")->findAll();
        $estacionamientosCerrados = $em->getRepository("AppBundle:Estacionamiento")->findAll();

        foreach ($estacionamientos as $estacionamiento){
            $latitudes = $this->extraerCoordenadas("lat", $estacionamiento->getCodigo());
            $longitudes = $this->extraerCoordenadas("lng", $estacionamiento->getCodigo());
            if (!$this->coordenadasEnRango($latitudes, $longitudes)){
                $em->remove($estacionamiento);
                echo("coordenada eliminada *|*| latitudes-> " . implode("|",$latitudes) . " longitudes-> " .  implode("|",$longitudes) . "\n");
            }else{
                echo("coordenada aprobada *|*| latitudes-> " . implode("|",$latitudes) . " longitudes-> " .  implode("|",$longitudes) . "\n");
            }
        }
        $em->flush();

        foreach ($estacionamientosCerrados as $estacionamientoCerrado){
            $latitudes = array($estacionamientoCerrado->getLatitud()*(-1));
            $longitudes = array($estacionamientoCerrado->getLongitud()*(-1));
            if (!$this->coordenadasEnRango($latitudes, $longitudes)){
                $em->remove($estacionamientoCerrado);
                echo("coordenada eliminada *|*| latitudes-> " . implode("|",$latitudes) . " longitudes-> " .  implode("|",$longitudes) . "\n");
            }else{
                echo("coordenada aprobada *|*| latitudes-> " . implode("|",$latitudes) . " longitudes-> " .  implode("|",$longitudes) . "\n");
            }
        }
        $em->flush();
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

    private function coordenadasEnRango($latitudes, $longitudes){
        $minLat = 34.588498;
        $maxLat = 34.622888;
        $minLong = 58.359090;
        $maxLong = 58.394941;


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
