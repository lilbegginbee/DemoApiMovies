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

    /**
     * Покупка одного или нескольких билетов на сеанс
     * @return JsonModel
     */
    public function buyAction()
    {
        $session = $this->params()->fromRoute('session');
        $seats = $this->params()->fromRoute('seats');
        $seats = preg_split('|,|',$seats);
        $seatsValid = array();
        $removeEmptyCallback = function($item) {
            $number = trim((int)$item);
            return $number?true:false;
        };
        $seatsValid = array_filter($seats, $removeEmptyCallback );
        if (!count($seatsValid)) {
            throw new \Exception('Отсутствуют номера мест.');
        }

        // проверка свободности билетов


        $salt = $this->getServiceLocator()->get('config')['api']['hashids_salt'];
        $hashids = new Hashids($salt);
        $idSession = 1;
        $hash = '';
        // может я не понял, но в качестве аргумента - только набор аргументов. Массив нельзя, строку нельзя,
        // наследоваться тоже нельзя так как Hashids::_encode() private.
        eval( '$hash = $hashids->encrypt('.$idSession.', ' . implode(',',$seatsValid) . ');' );

        // завершение покупки

        return new JsonModel(array('hash' => $hash));
    }
}
