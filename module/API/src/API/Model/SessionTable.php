<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;

class SessionTable extends CoreTable
{
    protected $table ='session';

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new Session());
    }

    /**
     * Все актуальные сеансы для данного кинотеатра и зала.
     * @param $idCinema integer
     * @param $idHall integer
     * @return Session[]
     */
    public function getSessions($idCinema,$idHall = null)
    {
        $where = array(
            'id_cinema' => $idCinema,
            'start_date > ?' => date('Y:m:d H:i:s')
        );
        if (!is_null($idHall)) {
            $where['id_hall'] = $idHall;
        }
        $rowset = $this->select($where);

        return $rowset;
    }

}
