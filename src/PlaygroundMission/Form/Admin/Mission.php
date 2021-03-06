<?php

namespace PlaygroundMission\Form\Admin;

use Zend\Form\Form;
use PlaygroundCore\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Element;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\ServiceManager;
use PlaygroundGame\Form\Admin\Game;

class Mission extends Game
{
    public function __construct($name = null, ServiceManager $sm, Translator $translator)
    {
        $this->setServiceManager($sm);
        $entityManager = $sm->get('doctrine.entitymanager.orm_default');

        // having to fix a Doctrine-module bug :( https://github.com/doctrine/DoctrineModule/issues/180
        $hydrator = new DoctrineHydrator($entityManager, 'PlaygroundMission\Entity\Mission');
        $hydrator->addStrategy('partner', new \PlaygroundCore\Stdlib\Hydrator\Strategy\ObjectStrategy());
        $this->setHydrator($hydrator);
        
        /*$this->setValidationGroup(array(
            'MissionGame' => array(
                'game'
            )
        ));*/

        parent::__construct($name, $sm, $translator);

        $gameMissionFieldset = new MissionGameFieldset(null,$sm,$translator);
        $this->add(array(
            'type'    => 'Zend\Form\Element\Collection',
            'name'    => 'missionGames',
            'options' => array(
                'id'    => 'missionGames',
                'label' => $translator->translate('List of games', 'playgroundgame'),
                'count' => 0,
                'should_create_template' => true,
                'allow_add' => true,
                'allow_remove' => true,
                'target_element' => $gameMissionFieldset
            )
        ));
    }
}
