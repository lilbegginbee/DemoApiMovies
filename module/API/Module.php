<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace API;

use API\Controller\TicketController;
use API\Model\TicketTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

use API\Controller\CinemaController;
use API\Service\CinemaService;
use API\Service\TicketService;
use API\Model\CinemaTable;
use API\Model\SessionTable;
use API\Model\MovieTable;
use API\Model\HallTable;
use API\Model\SessionSeatTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /*$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onRenderError'), 0);*/
    }

    public function onDispatchError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function onRenderError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function getJsonModelError($e)
    {
        $error = $e->getError();
        if (!$error) {
            return;
        }

        $response = $e->getResponse();
        $exception = $e->getParam('exception');
        $exceptionJson = array();
        if ($exception) {
            $exceptionJson = array(
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'stacktrace' => $exception->getTraceAsString()
            );
        }

        $errorJson = array(
            'message'   => 'An error occurred during execution; please try again later.',
            'error'     => $error,
            'exception' => $exceptionJson,
        );
        if ($error == 'error-router-no-match') {
            $errorJson['message'] = 'Resource not found.';
        }

        $model = new JsonModel(array('errors' => array($errorJson)));

        $e->setResult($model);

        return $model;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CinemaService' => function($sm){
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $cinemaTable      = new CinemaTable($dbAdapter);
                        $sessionTable     = new SessionTable($dbAdapter);
                        $movieTable       = new MovieTable($dbAdapter);
                        $hallTable        = new HallTable($dbAdapter);
                        $sessionSeatTable = new SessionSeatTable($dbAdapter);
                        return new CinemaService(
                                        $cinemaTable,
                                        $sessionTable,
                                        $movieTable,
                                        $hallTable,
                                        $sessionSeatTable);
                    },
                'TicketService' => function($sm){
                         $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                         $sessionSeatTable  = new SessionSeatTable($dbAdapter);
                         $ticketTable       = new TicketTable($dbAdapter);
                         return new TicketService(
                                         $ticketTable,
                                         $sessionSeatTable);

                    }
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'CinemaController' => function ($sm) {
                        $locator = $sm->getServiceLocator();
                        $cinemaService = $locator->get('CinemaService');
                        $controller = new CinemaController($cinemaService);
                        return $controller;
                    },
                'TicketController' => function ($sm) {
                        $locator = $sm->getServiceLocator();
                        $ticketService = $locator->get('TicketService');
                        $controller = new TicketController($ticketService);
                        return $controller;
                    }
            ),
        );
    }
}
