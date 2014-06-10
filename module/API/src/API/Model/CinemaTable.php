<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class CinemaTable extends AbstractTableGateway
{
    protected $table ='cinema';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Cinema());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getCinemaBySysname($sysname)
    {
        $rowset = $this->select(array(
            'sysname' => $sysname,
        ));

        $row = $rowset->current();

        if (!$row) {
            throw new Exception("Could not find row $sysname");
        }

        return $row;
    }
}
