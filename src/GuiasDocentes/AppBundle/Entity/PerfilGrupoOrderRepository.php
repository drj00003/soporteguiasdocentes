<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PerfilGrupoOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PerfilGrupoOrderRepository extends EntityRepository
{
    public function getDistinctGroupsByPerfilOrdered($perfil){
        // $em = $this->getDoctrine()->getManager();
        // $query = $em->createQuery(
        //     "SELECT IDENTITY (po.grupoid)
        //     FROM GuiasDocentesAppBundle:PerfilGrupoOrder po
        //     WHERE po.perfilnombre = '$perfil'
        //     ORDER BY po.orden ASC"
        // );
        // $res=$query->getResult();
        // return $res;
        return $this->getEntityManager()
            ->createQuery(
                "SELECT IDENTITY (po.grupoid)
                FROM GuiasDocentesAppBundle:PerfilGrupoOrder po
                WHERE po.perfilnombre = '$perfil'
                ORDER BY po.orden ASC"
            )
            ->getResult();
    } 
    
    // public function getAllGroupsByProfile(){
    //     $query = $this->c
    // }
    
    public function getAllGroupOrderedByOrden(){
        return $this->createQueryBuilder('a')
        // ->groupBy('a.perfilnombre')
        ->addOrderBy('a.orden', 'ASC')
        ->getQuery()
        ->getResult();
    }
    
    // public function findAllOrderedByName()
    // {
    //     return $this->getEntityManager()
    //                 ->createQuery('SELECT u FROM Acme\HelloBundle\Entity\User u
    //                                 ORDER BY u.name ASC')
    //                 ->getResult();
    // }
}
