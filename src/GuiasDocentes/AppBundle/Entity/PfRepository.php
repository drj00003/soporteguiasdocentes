<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PfRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PfRepository extends EntityRepository
{
    /* funcion que devuelve un array de pf para un grupo dado por su idetificador en orden creciente a su peso*/
    public function getCollectionPFByGroupOrdered($idGrupo){
        // $p=$this->findBy(array('grupoid' => '1'), array('orden' => 'ASC'));
        // var_dump($p[0]->getPregunta());die;
        return $this->findBy(array('grupoid' => $idGrupo), array('orden' => 'ASC'));
    }
    
    // public function findAllOrderedByName()
    // {
    //     return $this->getEntityManager()
    //                 ->createQuery('SELECT u FROM Acme\HelloBundle\Entity\User u
    //                                 ORDER BY u.name ASC')
    //                 ->getResult();
    // }
}