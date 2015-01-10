<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'mission_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => __DIR__ . '/../src/PlaygroundMission/Entity'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'PlaygroundMission\Entity' => 'mission_entity'
                )
            )
        )
    ),
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'mission_mission', 'roles' => array('guest', 'user')),
    
                // Admin area
                array('controller' => 'mission_admin_mission', 'roles' => array('admin')),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(),
        'template_path_stack' => array(
            __DIR__ . '/../view/admin',
            __DIR__ . '/../view/frontend'
        )
    ),

    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
                'text_domain' => 'playgroundgame'
            )
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'mission_mission' => 'PlaygroundMission\Controller\Frontend\MissionController',
            'mission_admin_mission' => 'PlaygroundMission\Controller\Admin\MissionController',
        )
    ),

    'router' => array(
        'routes' => array(
            'frontend' => array(
                'child_routes' => array(
                    'mission' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'mission[/:id]',
                            'defaults' => array(
                                'controller' => 'mission_mission',
                                'action' => 'home'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'index' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/index',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'index'
                                    )
                                )
                            ),
                            'play' => array(
                                'type' => 'Segment', 
                                'options' => array(
                                    'route' => '/jouer[/:x][/:y]',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'play'
                                    )
                                )
                            ),
                            'result' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/resultat',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'result'
                                    )
                                )
                            ),
                            'register' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/register',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'register'
                                    )
                                )
                            ),
                            'fbshare' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/fbshare',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'fbshare'
                                    )
                                )
                            ),
                            'fbrequest' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/fbrequest',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'fbrequest'
                                    )
                                )
                            ),
                            'tweet' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/tweet',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'tweet'
                                    )
                                )
                            ),
                            'google' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/google',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'google'
                                    )
                                )
                            ),
                            'bounce' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/essayez-aussi',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'bounce'
                                    )
                                )
                            ),
                            'terms' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/reglement',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'terms'
                                    )
                                )
                            ),
                            'conditions' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/mentions-legales',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'conditions'
                                    )
                                )
                            ),
                            'fangate' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/fangate',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'fangate'
                                    )
                                )
                            ),
                            'prizes' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/lots',
                                    'defaults' => array(
                                        'controller' => 'mission_mission',
                                        'action' => 'prizes'
                                    )
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'prize' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/:prize',
                                            'defaults' => array(
                                                'controller' => 'mission_mission',
                                                'action' => 'prize'
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    ),
                )
            ),

            'admin' => array(
                'child_routes' => array(
                    'playgroundgame' => array(
                        'child_routes' => array(
                            'create-mission' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/create-mission/:missionId',
                                    'defaults' => array(
                                        'controller' => 'mission_admin_mission',
                                        'action' => 'createMission',
                                        'missionId' => 0
                                    )
                                )
                            ),
                            'edit-mission' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit-mission/:gameId',
                                    'defaults' => array(
                                        'controller' => 'mission_admin_mission',
                                        'action' => 'editMission',
                                        'gameId' => 0
                                    )
                                )
                            ),
                        )
                    )
                )
            )
        )
    ),

    'navigation' => array(
       
        'admin' => array(
            'playgroundgame' => array(
                'pages' => array(
                    'create-mission' => array(
                        'label' => 'Add new mission',
                        'route' => 'admin/playgroundgame/create-mission',
                        'resource' => 'game',
                        'privilege' => 'add'
                    ),
                    'mission_list' => array(
                        'label' => 'Mission Management',
                        'route' => 'admin/playgroundgame/list',
                        'resource' => 'game',
                        'privilege' => 'list'
                    )
                )
            )
        )
    )
);