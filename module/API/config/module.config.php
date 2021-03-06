<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'ticket' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/ticket/',
                    'defaults' => array(
                        'controller' => 'TicketController'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'buy' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'buy/:session/:seats',
                            'constraints' => array(
                                'session' => '[0-9]{1,10}',
                                'seats' => '[,0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'TicketController',
                                'action'     => 'buy',
                            ),
                        ),
                    ),
                ),
            ),
            'cinema' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api/cinema/',
                    'defaults' => array(
                        'controller' => 'CinemaController',
                        'action'    =>  'list'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'sheduler' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => ':cinema/sheduler/[:hall]',
                            'constraints' => array(
                                'cinema'  => '[-a-zA-Z0-9_]+',
                                'hall' => '[0-9]{1,2}',
                            ),
                            'defaults' => array(
                                'action'     => 'sheduler',
                            ),
                        ),
                    ),
                    'session' => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => 'seats/:session',
                            'constraints' => array(
                                'session' => '[0-9]{1,10}',
                            ),
                            'defaults' => array(
                                'action'     => 'session',
                            ),
                        )
                    )
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => array(
           /* 'CinemaService' => 'API\Service\CinemaService' */
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'API\Controller\Index' => 'API\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);

