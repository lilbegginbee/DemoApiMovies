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
use Hashids\Hashids;

class TicketController extends ParentController
{
    public function indexAction()
    {
        return new JsonModel();
    }

    public function buyAction()
    {
        $tickets = $this->params()->fromRoute('tickets');
        $tickets = preg_split('|,|',$tickets);
        // проверка свободности билетов

        $salt = $this->getServiceLocator()->get('config')['api']['hashids_salt'];
        $hashids = new Hashids($salt);
        $idSession = 1;
        $hash = '';
        // может я не понял, но в качестве аргумента - только набор аргументов. Массив нельзя, строку нельзя,
        // наследоваться тоже нельзя так как Hashids::_encode() private.
        eval( '$hash = $hashids->encrypt('.$idSession.', ' . implode(',',$tickets) . ');' );

        // завершение покупки

        return new JsonModel(array('hash' => $hash));
    }
}
