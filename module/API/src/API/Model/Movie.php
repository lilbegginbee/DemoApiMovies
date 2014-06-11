<?php
/**
 *
 * User: timur
 * Date: 6/9/14
 * Time: 4:09 PM
 */
namespace API\Model;

class Movie
{
    public $id_movie;
    public $title;
    public $year;

    public function exchangeArray($data)
    {
        $this->id_movie = (isset($data['id_movie'])) ? $data['id_movie'] : null;
        $this->title    = (isset($data['title'])) ? $data['title'] : null;
        $this->year     = (isset($data['year'])) ? $data['year'] : null;
    }
}