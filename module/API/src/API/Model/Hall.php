<?php
/**
 *
 * User: timur
 * Date: 6/9/14
 * Time: 4:09 PM
 */
namespace API\Model;

class Hall
{
    public $id_hall;
    public $id_cinema;
    public $title;
    public $seats;

    public function exchangeArray($data)
    {
        $this->id_hall = (isset($data['id_hall'])) ? $data['id_hall'] : null;
        $this->id_cinema    = (isset($data['id_cinema'])) ? $data['id_cinema'] : null;
        $this->title     = (isset($data['title'])) ? $data['title'] : null;
        $this->seats     = (isset($data['seats'])) ? $data['seats'] : null;
    }
}