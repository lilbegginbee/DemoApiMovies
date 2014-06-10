<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 4:03 PM
 */

namespace API\Service;
use API\Model\MovieTable;
use Zend\Debug\Debug;
use API\Model\CinemaTable;
use API\Model\SessionTable;

class CinemaService
{
    /**
     * @var CinemaTable
     */
    protected $cinemaTable;

    /**
     * @var SessionTable
     */
    protected $sessionTable;

    /**
     * @var MovieTable
     */
    protected $movieTable;

    /**
     * @param $cinemaTable CinemaTable
     */
    public function __construct(CinemaTable $cinemaTable, SessionTable $sessionTable, MovieTable $movieTable)
    {
        $this->cinemaTable = $cinemaTable;
        $this->sessionTable = $sessionTable;
        $this->movieTable = $movieTable;
    }

    /**
     * Все кинотеатры
     * @return array
     */
    public function getAll()
    {
        $list = $this->cinemaTable->fetchAll();
        $result = array();
        foreach ($list as $cinema) {
            $result[] = $cinema;
        }
        return $result;
    }

    /**
     * Расписание конкретного кинотеатра.
     * Можно уточнить кинозал.
     * @param $cinema
     * @param null $hall
     * @return bool
     */
    public function getSheduler($cinema, $hall = null)
    {
        $oCinema = $this->cinemaTable->getCinemaBySysname($cinema);
        $oSessions = $this->sessionTable->getSessions($oCinema->id_cinema,$hall);
        /**
         * Так как очень нравится механизм прототипов в tableGateway,
         * то вместо одного sql запроса, будем оперировать объектами.
         */
        $movies = array();
        $sessions = array();
        foreach ($oSessions as $session) {
            $sessions[] = $session;
            $movies[$session->id_movie] = $session->id_movie;
        }
        $res = $this->movieTable->getList($movies);
        $movies = array();
        foreach ($res as $movie) {
            $movies[$movie->id_movie] = $movie;
        }

        return array(
                'sessions'  => $sessions,
                'movies'    => $movies
            );
    }
}