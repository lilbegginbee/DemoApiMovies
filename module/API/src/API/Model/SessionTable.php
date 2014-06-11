<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class SessionTable extends CoreTable
{
    protected $table ='session';

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new Session());
    }

    /**
     * Киносеанс
     * @param $idSession int
     * @return Session
     */
    public function get($idSession)
    {
        $where = array(
            'id_session' => $idSession
        );
        $rowset = $this->select($where);
        return $rowset->current();
    }

    /**
     * Все актуальные сеансы для данного кинотеатра и зала.
     * @param $idCinema integer
     * @param $idHall integer
     * @param $date String День, когда нужно посмотреть сеансы
     * @return Session[]
     */
    public function getSessions($idCinema, $idHall = null, $date = null)
    {
        $today = date('Y:m:d H:i:s');
        if (!is_null($date)) {
            $today = $date;
        }

        $where = array(
            'id_cinema' => $idCinema,
            'start_date > ?' => $today,
            'start_date <= ?' => date('Y:m:d H:i:s', strtotime('+1 day'))
        );

        if (!is_null($idHall)) {
            $where['id_hall'] = $idHall;
        }


        $rowset = $this->select(function (Select $select) use ($where) {
                        $select->where($where);
                        $select->order('start_date ASC');
                    });

        return $rowset;
    }

}
