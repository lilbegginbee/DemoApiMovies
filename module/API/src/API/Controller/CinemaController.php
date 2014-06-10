<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace API\Controller;

use Zend\View\Model\JsonModel;
use Zend\Debug;
use API\Service\CinemaService;

class CinemaController extends ParentController
{
    /**
     * @var CinemaService
     */
    protected $cinemaService;

    /**
     * @param $cinemaService CinemaService
     */
    public function __construct($cinemaService)
    {
        parent::__construct();
        $this->cinemaService = $cinemaService;
    }

    public function indexAction()
    {
        return new JsonModel();
    }

    /**
     * Полный
     * @return JsonModel
     */
    public function listAction()
    {
        $list = $this->cinemaService->getAll();
        return new JsonModel(array('data' => $list));
    }

    public function shedulerAction()
    {
        $cinema = $this->params()->fromRoute('cinema');
        $hall = $this->params()->fromRoute('hall', null);

        $sheduler = $this->cinemaService->getSheduler($cinema, $hall);

        return new JsonModel(array('data' => array($sheduler)));
    }
}
