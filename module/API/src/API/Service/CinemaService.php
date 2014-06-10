<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 4:03 PM
 */

namespace API\Service;

use API\Model\CinemaTable;

class CinemaService
{
    /**
     * @var CinemaTable
     */
    protected $cinemaTable;

    /**
     * @param $cinemaTable CinemaTable
     */
    public function __construct($cinemaTable)
    {
        $this->cinemaTable = $cinemaTable;
    }

    public function getSheduler($cinema, $hall = null)
    {
        $oCinema = $this->cinemaTable->getCinemaBySysname($cinema);
        var_dump($oCinema);

        return true;
    }
}