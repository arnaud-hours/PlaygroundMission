<?php

namespace PlaygroundMission\Mapper;

use Doctrine\ORM\EntityManager;
use PlaygroundMission\Options\ModuleOptions;

class MissionGame
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $er;

    /**
     * @var \PlaygroundMission\Options\ModuleOptions
     */
    protected $options;


    /**
    * __construct
    * @param EntityManager $em
    * @param ModuleOptions $options
    *
    */
    public function __construct(EntityManager $em, ModuleOptions $options)
    {
        $this->em      = $em;
        $this->options = $options;
    }

    /**
    * findById : recupere l'entite en fonction de son id
    * @param int $id id de la missionGame
    *
    * @return PlaygroundMission\Entity\MissionGame $missionGame
    */
    public function findById($id)
    {
        return $this->getEntityRepository()->find($id);
    }

    /**
    * findOneBy : recupere l'entite en fonction de filtres
    * @param array $filters tableau de filtres
    *
    * @return PlaygroundMission\Entity\MissionGame $missionGame
    */
    public function findOneBy($filters)
    {
         return $this->getEntityRepository()->findOneBy($filters);
    }

    /**
    * findBy : recupere des entites en fonction de filtre
    *
    * @return collection $missionGames collection de PlaygroundMission\Entity\MissionGame
    */
    public function findBy($filter, $order = null, $limit = null, $offset = null)
    {
        return $this->getEntityRepository()->findBy($filter, $order, $limit, $offset);
    }

    /**
    * insert : insert en base une entité missionGame
    * @param PlaygroundMission\Entity\MissionGame $entity missionGame
    *
    * @return PlaygroundMission\Entity\MissionGame $missionGame
    */
    public function insert($entity)
    {
        return $this->persist($entity);
    }

    /**
    * insert : met a jour en base une entité missionGame
    * @param PlaygroundMission\Entity\MissionGame $entity missionGame
    *
    * @return PlaygroundMission\Entity\MissionGame $missionGame
    */
    public function update($entity)
    {
        return $this->persist($entity);
    }

    /**
    * insert : met a jour en base une entité missionGame et persiste en base
    * @param PlaygroundMission\Entity\MissionGame $entity missionGame
    *
    * @return PlaygroundMission\Entity\MissionGame $missionGame
    */
    public function persist($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
    * findAll : recupere toutes les entites 
    *
    * @return collection $missionGames collection de PlaygroundMission\Entity\MissionGame
    */
    public function findAll()
    {
        return $this->getEntityRepository()->findAll();
    }

     /**
    * remove : supprimer une entite missionGame
    * @param PlaygroundMission\Entity\MissionGame $entity missionGame
    *
    */
    public function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
    * refresh : supprimer une entite missionGame
    * @param PlaygroundMission\Entity\MissionGame $entity missionGame
    *
    */
    public function refresh($entity)
    {
        $this->em->refresh($entity);
    }

    /**
    * getEntityRepository : recupere l'entite missionGame
    *
    * @return \Doctrine\ORM\EntityRepository $missionGame
    */
    public function getEntityRepository()
    {
        if (null === $this->er) {
            $this->er = $this->em->getRepository('PlaygroundMission\Entity\MissionGame');
        }

        return $this->er;
    }

    public function getNextGame($mission, $currentPosition)
    {
        if (!is_object($mission)) {
            return false;
        }

        if (!is_integer($currentPosition)) {
            return false;
        }


        $select = "SELECT mg.id";
        $from = "FROM PlaygroundMission\Entity\MissionGame mg";
        $where = "WHERE mg.mission = :mission";
        $where .= " AND mg.position > :currentPosition";
        $order = "ORDER BY mg.position ASC";

        $query = $select.' '.$from.' '.$where.' '.$order;

        $query = $this->em->createQuery($query);


        $query->setParameter('mission', (int) $mission->getId());
        $query->setParameter('currentPosition', (int) $currentPosition);
        $query->setMaxResults(1);

        $nextGame =  $query->getResult();
        
        if(empty($nextGame)) {
            return false;
        }

        return $this->findById($nextGame[0]['id']);
    }
}
