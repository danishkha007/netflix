<?php
class Video{
    private $pdo,$videoData,$user,$entity;

    public function __construct($data)
    {
        $this->pdo=Database::instance();
        $this->user=new User();
        if(is_array($data)){
            $this->videoData=$data;
        }else{
            $this->videoData=$this->user->get("videos",["*"],["videoId"=>$data]);
        }
        $this->entity= new Entity($this->videoData["entityId"]);
    }

    public function videoData()
    {
        return $this->videoData;
    }

    public function getPosterImage()
    {
        $entityData=$this->entity->entityData();
        return $entityData['thumbnail'];
    }

    public function videoViewsCounter(){
        $videoData=$this->videoData();
        $stmt=$this->pdo->prepare("UPDATE videos SET views=views+1 WHERE videoId=:id");
        $stmt->bindValue(":id",$videoData['videoId'],PDO::PARAM_INT);
        $stmt->execute();
    }

    public function displaySeasonAndEpisode(){
        if($this->isMovie()){
            return;
        }
        $videoData=$this->videoData();
        $season=$videoData['season'];
        $episode=$videoData['episode'];
        return "Season $season, Episode $episode";

    }

    public function isMovie(){
        return $this->videoData['isMovie']==1;
    }
    private function wasWatchBy($videoId,$email){
        return $this->user->get("videoProgress",["*"],["videoId"=>$videoId,"email"=>$email]);
    }
    public function videoIsInProgress($videoId,$email){
         $videoProgressData=$this->user->get("videoProgress",["*"],["videoId"=>$videoId,"email"=>$email,"finished"=>0]);
         if(!empty($videoProgressData)){
             return $videoProgressData;
         }
    }

    public function updateVideoDuration($videoId,$email,$progress){
        if(!empty($this->wasWatchBy($videoId,$email))){
            $stmt=$this->pdo->prepare("UPDATE videoProgress SET progress=:progress,dateUpdated=Now() WHERE videoId=:id AND email=:email");
            $stmt->bindParam(":id",$videoId,PDO::PARAM_INT);
            $stmt->bindParam(":progress",$progress,PDO::PARAM_INT);
            $stmt->bindParam(":email",$email,PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    public function watchVideoCompleted($videoId,$email){
        $videoProgressRecord=$this->user->get("videoProgress",["*"],["videoId"=>$videoId,"email"=>$email]);
        if(!empty($this->wasWatchBy($videoId,$email))){
            $stmt=$this->pdo->prepare("UPDATE videoProgress SET finished=1,progress=0 WHERE videoId=:id AND email=:email");
            $stmt->bindParam(":id",$videoId,PDO::PARAM_INT);
            $stmt->bindParam(":email",$email,PDO::PARAM_STR);
            $stmt->execute();
        }
    }


    
    public function getProgress($videoId,$email){
        if(!empty($this->wasWatchBy($videoId,$email))){
            $videoData=$this->user->get("videoProgress",["progress"],["videoId"=>$videoId,"email"=>$email]);
            return $videoData['progress'];
            // $stmt=$this->pdo->prepare("SELECT progress FROM videoProgress WHERE videoId=:id AND email=:email");
            // $stmt->bindParam(":id",$videoId,PDO::PARAM_INT);
            // $stmt->bindParam(":email",$email,PDO::PARAM_STR);
            // $stmt->execute();

            // return $stmt->fetchColumn();
        }
    }
   

}