<?php
/**
 *
 * User: timur
 * Date: 6/9/14
 * Time: 4:09 PM
 */
namespace API\Model;

class SessionSeat
{
    public $id_session;
    public $seat;
    public $id_ticket;

    public function exchangeArray($data)
    {
        $this->id_session    = (isset($data['id_session'])) ? $data['id_session'] : null;
        $this->seat     = (isset($data['seat'])) ? $data['seat'] : null;
        $this->id_ticket        = (isset($data['id_ticket'])) ? $data['id_ticket'] : null;
    }
}