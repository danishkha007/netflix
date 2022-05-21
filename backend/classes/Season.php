<?php
class Season{
    private $season_num,$videos;
    public function __construct($season_num,$videos)
    {
        $this->season_num=$season_num;
        $this->videos=$videos;
    }

    public function getSeasonNumber(){
        return $this->season_num;
    }
    public function getVideos(){
        return $this->videos;
    }
}