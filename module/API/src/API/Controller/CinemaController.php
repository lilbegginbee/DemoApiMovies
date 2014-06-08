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
use Hashids\Hashids;

class CinemaController extends ParentController
{
    public function indexAction()
    {
        return new JsonModel();
    }

    public function shedulerAction()
    {
        $cinema = $this->params()->fromRoute('cinema');
        $hall = $this->params()->fromRoute('hall', null);
        return new JsonModel(array('data' => array()));
    }
}
