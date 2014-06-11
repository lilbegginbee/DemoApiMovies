<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;

class TicketTable extends CoreTable
{
    /**
     * Действующий билет, по умолчанию
     */
    const TICKET_STATUS_ACTIVE = 'active';
    /**
     * Возврат
     */
    const TICKET_STATUS_REJECT = 'reject';

    protected $table ='ticket';

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new Ticket());
    }


}

