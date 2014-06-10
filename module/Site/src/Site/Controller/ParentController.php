<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ParentController extends AbstractActionController
{
    protected $pageTitle;

    protected function setTitle($title)
    {
        $rootTitle = $this->getServiceLocator()->get('config')['site']['title'];
        $this->pageTitle = $title . ' | ' . $rootTitle;
    }

    public function getTitle()
    {
        return $this->pageTitle;
    }
}
