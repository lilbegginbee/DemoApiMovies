<?php
/**
 * Родительский класс для всех моделей.
 * User: timur
 * Date: 6/10/14
 * Time: 12:55 PM
 */

namespace API\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\ResultSet;

class CoreTable extends AbstractTableGateway {

    /**
     * @var Zend\Db\Adapter\Adapter
     */
    protected $adapter;

    public function __construct($adapter, $prototype)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype($prototype);
        $this->initialize();
    }
}
