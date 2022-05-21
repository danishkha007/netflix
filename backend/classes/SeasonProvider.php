<?php
class SeasonProvider{
    private $pdo;
    public function __construct()
    {
        $this->pdo=Database::instance();
    }

    public function createSeason($entity){
        $seasons=$entity->getSeasons();
        if(sizeof($seasons)==0){
            return;
        }

        $htmlContainer="";
        foreach($seasons as $season){
            $seasonNumber=$season->getSeasonNumber();
            $videosContainer="";
            foreach($season->getVideos() as $video){
                $videosContainer .=$this->createVideoContainer($video);
            }

            $htmlContainer .="<div class='season'>
                                <h3>Season $seasonNumber</h3>
                                <section class='videos'>
                                    $videosContainer
                                </section>
                              </div>";
        }
        return $htmlContainer;
    }

    private function createVideoContainer($video){
        $videoData=$video->videoData();
        $videoId=$videoData['videoId'];
        $name=$videoData['title'];
        $description=$videoData['description'];
        $episodeNumber=$videoData['episode'];
        $posterImage=$video->getPosterImage();
        return '<a href="'.url_for('watch/'.h(u($videoId))).'">
                    <div class="episodeContainer">
                        <div class="contents">
                            <img src="'.url_for($posterImage).'" title="'.$name.'" alt="'.$name.'"/>
                            <div class="videoInfo">
                                <h4>'.$episodeNumber.'.'.$name.'</h4>
                                <span>'.$description.'</span>
                            </div>
                        </div>
                    </div>
        </a>';
    }
}

