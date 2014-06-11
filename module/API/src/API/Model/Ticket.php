<?php
/**
 *
 * User: timur
 * Date: 6/9/14
 * Time: 4:09 PM
 */
namespace API\Model;

class Ticket
{
    public $id_ticket;
    public $code;
    public $id_session;
    public $created;
    public $status;

    public function exchangeArray($data)
    {
        $this->id_ticket = (isset($data['id_ticket'])) ? $data['id_ticket'] : null;
        $this->code    = (isset($data['code'])) ? $data['code'] : null;
        $this->id_session     = (isset($data['id_session '])) ? $data['id_session '] : null;
        $this->created     = (isset($data['created'])) ? $data['created'] : null;
        $this->status     = (isset($data['status'])) ? $data['status'] : null;
    }
}