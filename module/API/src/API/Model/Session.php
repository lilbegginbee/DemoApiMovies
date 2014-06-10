<?php
/**
 *
 * User: timur
 * Date: 6/9/14
 * Time: 4:09 PM
 */
namespace API\Model;

class Session
{
    public $id_session;
    public $id_movie;
    public $id_cinema;
    public $id_hall;
    public $start_date;
    public $status;

    public function exchangeArray($data)
    {
        $this->id_session    = (isset($data['id_session'])) ? $data['id_session'] : null;
        $this->id_movie      = (isset($data['id_movie'])) ? $data['id_movie'] : null;
        $this->id_cinema        = (isset($data['id_cinema'])) ? $data['id_cinema'] : null;
        $this->id_hall        = (isset($data['id_hall'])) ? $data['id_hall'] : null;
        $this->start_date        = (isset($data['start_date'])) ? $data['start_date'] : null;
        $this->status        = (isset($data['status'])) ? $data['status'] : null;
    }
}