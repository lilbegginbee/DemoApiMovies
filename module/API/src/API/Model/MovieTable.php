<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 2:48 PM
 */

namespace API\Model;

use Zend\Db\Adapter\Adapter;

class MovieTable extends CoreTable
{
    protected $table ='movie';

    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new Movie());
    }

    /**
     * Конкретный фильм
     * @param $idMovie int
     * @return Movie
     */
    public function get($idMovie)
    {
        $where = array(
            'id_movie' => $idMovie
        );
        $rowset = $this->select($where);
        $row = $rowset->current();
        return $row;
    }

    /**
     * Список фильмов
     * @param $movies array
     * @return Movie[]
     */
    public function getList($movies)
    {
        $where = array(
            'id_movie IN (' . implode(',', $movies) . ')'
        );
        $rowset = $this->select($where);

        return $rowset;
    }

}

