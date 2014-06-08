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
                        'controller' => 'Ticket'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'buy' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'buy/:tickets',
                            'constraints' => array(
                                'tickets' => '[0-9,]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Ticket',
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
                        'controller' => 'Cinema'
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
                                'controller' => 'Cinema',
                                'action'     => 'sheduler',
                            ),
                        ),
                    ),
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
            'API\Controller\Index' => 'API\Controller\IndexController',
            'Cinema' => 'API\Controller\CinemaController',
            'Ticket' => 'API\Controller\TicketController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);

