<?php

class VideoPreviewProvider{

    private $pdo,$user;

    public function __construct()
    {
        $this->pdo=Database::instance();    
        $this->user=new User;    
    }

    public function createVideoPreview($entity="",$userId)
    {
        if($entity==null){
            $entity=$this->getRandomEntity();
        }

        $entityData=$entity->entityData();
        $Id=$entityData['Id'];
        $name=$entityData['name'];
        $thumbnail=$entityData['thumbnail'];
        $preview=$entityData['preview'];

        $userEmailData=$this->user->userEmailById($userId);
        $email=$userEmailData['email'];

        $videoProvider=new VideoProvider();
        $videoId=$videoProvider->getEntityVideoForUser($Id,$email);

        $video=new Video($videoId);
        $seasonEpisode=$video->displaySeasonAndEpisode();
        $subTitle=$video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

        $videoIsInProgress=$video->videoIsInProgress($videoId,$email);
        $playButtonText=$videoIsInProgress ?  "Play"  : "Continue Watching" ;
        return "<div class='previewContainer'>
                    <img src=' ".url_for($thumbnail)."' class='previewImage' hidden/>
                    <video autoplay muted class='previewVideo' onended='previewVideoEnded()'>
                        <source src='".url_for($preview)."' />
                    </video>
                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            $subTitle
                            <div class='btns'>
                                <button onclick='watchVideo($videoId)'><i class='fas fa-play'></i> $playButtonText</button>
                                <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>
                        </div>
                    </div>
                </div>";


    }

    private function getRandomEntity(){
        $entity=EntityProvider::getEntities($this->pdo,null,1);
        return $entity[0];
    }

    public function createHomeEntityPreviewSquare($entityData){
        $id=$entityData['Id'];
        $name=$entityData['name'];
        $thumbnail=$entityData['thumbnail'];
        $preview=$entityData['preview'];

        return '<li class="nm-content-horizontal-row-item">
                    <a href="'.url_for('entity/'.u(h($id))).'" class="nm-collections-title nm-collections-link">
                        <div class="nm-collections-title-img">
                            <img src="'.url_for($thumbnail).'" alt="'.$name.'" title="'.$name.'"/ >
                        </div>
                        <span class="nm-collections-title-name">'.$name.'</span>
                    </a>
                </li>
                ';
    }
}