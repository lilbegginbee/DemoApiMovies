<?php
/**
 * User: timur
 * Date: 6/8/14
 * Time: 4:03 PM
 */

namespace API\Service;
use API\Model\HallTable;
use API\Model\MovieTable;
use API\Model\SessionSeatTable;
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
     * @var HallTable
     */
    protected $hallTable;

    /**
     * @var SessionSeatTable
     */
    protected $sessionSeatTable;

    /**
     * @param $cinemaTable CinemaTable
     */
    public function __construct(
                        CinemaTable $cinemaTable,
                        SessionTable $sessionTable,
                        MovieTable $movieTable,
                        HallTable $hallTable,
                        SessionSeatTable $sessionSeatTable)
    {
        $this->cinemaTable = $cinemaTable;
        $this->sessionTable = $sessionTable;
        $this->movieTable = $movieTable;
        $this->hallTable = $hallTable;
        $this->sessionSeatTable = $sessionSeatTable;
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
        $movies = array();
        $sessions = array();

        $oCinema = $this->cinemaTable->getCinemaBySysname($cinema);
        $oSessions = $this->sessionTable->getSessions($oCinema->id_cinema,$hall);

        if($oSessions->count()) {
            /**
             * Так как очень нравится механизм прототипов в tableGateway,
             * то вместо одного sql запроса, будем оперировать объектами.
             */

            foreach ($oSessions as $session) {
                $sessions[] = $session;
                $movies[$session->id_movie] = $session->id_movie;
            }
            $res = $this->movieTable->getList($movies);
            $movies = array();
            foreach ($res as $movie) {
                $movies[$movie->id_movie] = $movie;
            }
        }

        return array(
                'sessions'  => $sessions,
                'movies'    => $movies
            );
    }

    /**
     * Информация о сеансе, о свободных/занятых местах.
     * @param $idSession
     * @return array
     */
    public function getSession($idSession)
    {
        $oSession = $this->sessionTable->get($idSession);
        if (!$oSession) {
            throw new \Exception('Сеанса не существует');
        }
        // Узнаём сколько всего мест в зале.
        // Упрощаем, что в кинотеатре места от 1 до n
        $oHall = $this->hallTable->get($oSession->id_cinema, $oSession->id_hall);

        // Отдельно выясняем какие места уже заняты
        $occupied = $this->sessionSeatTable->getSeats($idSession);

        return array(
            'seats' => $oHall->seats,
            'occupied' => $occupied
        );
    }
}