<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;

class CinemaTable extends CoreTable
{
    protected $table ='cinema';

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new Cinema());
    }

    /**
     * Все кинотеатры
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    /**
     * Конкретный кинотеатр.
     * Для удобства обозрения URLов, id кинотеатра не используется, вместо него более понятный сиснейм.
     * @param $sysname
     * @return Cinema|null
     * @throws Exception
     */
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
