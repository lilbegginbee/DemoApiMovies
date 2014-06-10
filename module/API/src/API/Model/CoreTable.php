<?php
/**
 * Родительский класс для всех моделей.
 * User: timur
 * Date: 6/10/14
 * Time: 12:55 PM
 */

namespace API\Model;

use Zend\Db\TableGateway\AbstractTableGateway;

class CoreTable extends AbstractTableGateway {

    /**
     * @var Zend\Db\Adapter\Adapter
     */
    protected $dbAdapter;

    public function __construct($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
}
