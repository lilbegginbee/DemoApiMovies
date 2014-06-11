<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 4:03 PM
 */

namespace API\Service;

use API\Model\MovieTable;

class MovieService
{
    /**
     * @var MovieTable
     */
    protected $movieTable;

    /**
     * @param $cinemaTable MovieTable
     */
    public function __construct($movieTable)
    {
        $this->movieTable = $movieTable;
    }

    public function getSheduler($idMovie)
    {

        return true;
    }
}