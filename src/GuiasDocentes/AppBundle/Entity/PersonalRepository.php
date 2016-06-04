<?php

namespace GuiasDocentes\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PerfilRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonalRepository extends EntityRepository
{
    public function getAllPersonal(){
        $personales = $this->findAll();
        return $personales;
    }
    // public function getEnunciado(){
    //     return $this->getEntityManager()
    //         ->createQuery(
    //             "SELECT (po.enunciado)
    //             FROM GuiasDocentesAppBundle:TematicaSoporte po
    //             WHERE po.personalEmail = '$this->getEmail()'
    //             ORDER BY po.orden ASC"
    //         )
    //         ->getResult();
    // }
    public function getEnunciado(){
        $this->getEnunciado();
    }
    
    public function getPersonalOrdered(){
        $query = $this->createQueryBuilder('p')
            ->from('GuiasDocentesAppBundle:Personal', 'p')
            ->innerJoin('GuiasDocentesAppBundle:TematicaSoporte', 'ts')
            // ->innerJoin('GuiasDocentesAppBundle:TematicaSoporte', 'ts', 'ON', 'ts.personalEmail = p.email')
            ->where('ts.personalEmail = p.email')                
            ->orderBy("ts.order");
        return $query;
    }
    
    public function getPersonalOrdered3(){
        $query = $this->createQueryBuilder('p')
            ->from('GuiasDocentesAppBundle:Personal', 'p')
            ->innerJoin('p.tematicasSoporte', 'ts')
            // ->innerJoin('GuiasDocentesAppBundle:TematicaSoporte', 'ts', 'ON', 'ts.personalEmail = p.email')
            // ->where('ts.personalEmail = p.email')                
            ->orderBy("ts.order");
        return $query;
    }
    
    // Esta consulta devolverá las columnas, yo lo que necesito es el conjunto de objetos
    // Podría meter un foreach 
    public function getPersonalOrdered2(){
        return $this->getEntityManager()
        ->createQuery(
            "SELECT (p.*)
            FROM GuiasDocentesAppBundle:Personal p
            INNER JOIN GuiasDocentesAppBundle:TematicaSoporte ts
            ON ts.personalEmail = p.email
            ORDER BY ts.order"    
        )
        ->getResult();
    }
    
    
    // public function queryOwnedBy($user) {

    // $query = $this->createQueryBuilder('a')
    //         ->from('MyBundle:Article', 'a')
    //         ->innerJoin('a.owndBy', 'u')
    //         ->where('u.id = :id')                
    //         ->setParameter('id', $user->getId());

    // return $query;
    // }
}