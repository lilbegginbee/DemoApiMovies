<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;

class SessionSeatTable extends CoreTable
{
    protected $table ='session_seat';

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new SessionSeat());
    }

    /**
     * Занятые места на сеанс
     * @param $id_session
     * @return array
     */
    public function getSeats($id_session)
    {
        $where = array(
            'id_session = ?',  $id_session
        );
        $rowset = $this->select($where);

        return $rowset;
    }
}

