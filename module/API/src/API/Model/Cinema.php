<?php
/**
 *
 * User: timur
 * Date: 6/9/14
 * Time: 4:09 PM
 */
namespace API\Model;

class Cinema
{
    public $id_cinema;
    public $sysname;
    public $title;

    public function exchangeArray($data)
    {
        $this->id_cinema    = (isset($data['id_cinema'])) ? $data['id_cinema'] : null;
        $this->sysname      = (isset($data['sysname'])) ? $data['sysname'] : null;
        $this->title        = (isset($data['title'])) ? $data['title'] : null;
    }
}