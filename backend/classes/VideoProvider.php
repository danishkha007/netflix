<?php

class VideoProvider{

    private $pdo;

    public function __construct()
    {
        $this->pdo=Database::instance();    
    }

    public function getUpNext($currentVideo){
        $videoData=$currentVideo->videoData();
        $entityId=$videoData['entityId'];
        $season=$videoData['season'];
        $videoId=$videoData['videoId'];
        $episodeNumber=$videoData['episode'];

        $stmt=$this->pdo->prepare("SELECT * FROM videos WHERE entityId=:entityId AND videoId!=:videoId
            AND ((season=:season AND episode > :episode) OR season > :season) ORDER BY season,episode ASC LIMIT 1");
        $stmt->bindValue(":entityId",$entityId);
        $stmt->bindValue(":season",$season);
        $stmt->bindValue(":videoId",$videoId);
        $stmt->bindValue(":episode",$episodeNumber);

        $stmt->execute();

        if ($stmt->rowCount()==0) {
            $stmt=$this->pdo->prepare("SELECT * FROM videos WHERE season <= 1 AND episode <= 1 AND videoId !=:videoId ORDER BY views DESC LIMIT 1");
            $stmt->bindValue(":videoId",$videoId);
            $stmt->execute();
        }
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return new Video($row);
    }
    public function getEntityVideoForUser($entityId,$email){

        $stmt=$this->pdo->prepare("SELECT videoProgress.videoId FROM videoProgress INNER JOIN videos ON videoProgress.videoId=videos.videoId WHERE(videos.entityId=:entityId AND videoProgress.email=:email) ORDER BY videoProgress.dateUpdated ASC LIMIT 1");
        $stmt->bindValue(":entityId",$entityId);
        $stmt->bindValue(":email",$email);


        $stmt->execute();

        if ($stmt->rowCount()==0) {
            $stmt=$this->pdo->prepare("SELECT videoId FROM videos WHERE entityId=:entityId ORDER BY season,episode ASC LIMIT 1");
            $stmt->bindValue(":entityId",$entityId);
            $stmt->execute();
        }
        return $stmt->fetchColumn();
    }

    
}