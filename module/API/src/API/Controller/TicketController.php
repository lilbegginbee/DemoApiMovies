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
use API\Service\TicketService;

class TicketController extends ParentController
{
    /**
     * @var TicketService
     */
    protected $ticketService;

    /**
     * @param $ticketService TicketService
     */
    public function __construct(TicketService $ticketService)
    {
        parent::__construct();
        $this->ticketService = $ticketService;
    }

    /**
     * Покупка одного или нескольких билетов на сеанс
     * @return JsonModel
     */
    public function buyAction()
    {
        $session = $this->params()->fromRoute('session');
        $seats = $this->params()->fromRoute('seats');

        $this->ticketService->config = $this->getServiceLocator()->get('config');

        return new JsonModel( $this->ticketService->buy($session, $seats) );
    }
}
