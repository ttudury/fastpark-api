<?php
// src/AppBundle/Repository/EstacionamientoRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EstacionamientoRepository extends EntityRepository
{
    public function estacionamientosPorCoordenadas($latitud, $longitud, $cod)
    {
        $minlat= $latitud-0.005;
        $maxlat= $latitud+0.005;
        $minlong= $longitud-0.01;
        $maxlong= $longitud+0.01;
        return $this->getEntityManager()
            ->createQuery(
                "SELECT p FROM AppBundle:estacionamiento p JOIN p.tipoEstacionamiento te where te.codigo = '" . $cod . "' and p.latitud between " . $minlat . " and " . $maxlat . " and p.longitud between " . $minlong . " and " . $maxlong . " "
            )
            ->getResult();
    }
}