<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * GrupoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GrupoRepository extends EntityRepository
{
    public function getGrupoById($id){
        $grupo=$this->find($id);
        return $grupo;
    }
        
    // public function findAllOrderedByName()
    // {
    //     return $this->getEntityManager()
    //                 ->createQuery('SELECT u FROM Acme\HelloBundle\Entity\User u
    //                                 ORDER BY u.name ASC')
    //                 ->getResult();
    // }
}