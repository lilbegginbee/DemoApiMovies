<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;

class HallTable extends CoreTable
{
    protected $table ='hall';

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new Hall());
    }

    /**
     * Информация о кинозале
     * @param $idCinema int
     * @param $idHall int
     * @return Hall
     */
    public function get($idCinema, $idHall)
    {
        $where = array(
            'id_cinema' => $idCinema,
            'id_hall'   => $idHall
        );
        $rowset = $this->select($where);
        $row = $rowset->current();
        return $row;
    }
}

