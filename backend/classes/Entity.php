<?php
class Entity{
    private $pdo,$entityData,$user;

    public function __construct($data)
    {
        $this->pdo=Database::instance();
        $this->user=new User();
        if(is_array($data)){
            $this->entityData=$data;
        }else{
            $this->entityData=$this->user->get("entities",["*"],["Id"=>$data]);
        }
    }

    public function entityData()
    {
        return $this->entityData;
    }

    public function getSeasons(){
        $entityData=$this->entityData();
        $Id=$entityData['Id'];
        $stmt=$this->pdo->prepare("SELECT * FROM videos WHERE entityId=:Id AND isMovie=0 ORDER BY season,episode ASC");
        $stmt->bindValue(":Id",$Id,PDO::PARAM_INT);
        $stmt->execute();
        $seasons=[];
        $videos=[];
        $currentSeason=null;
        while($data=$stmt->fetch(PDO::FETCH_ASSOC)){
            if($currentSeason !=null && $currentSeason != $data['season']){
                $seasons=new Season($currentSeason,$videos);
                $videos=[];
            }
            $currentSeason=$data['season'];
            $videos[]=new Video($data);

        }
        if(sizeof($videos) != 0){
            $seasons[]=new Season($currentSeason,$videos);
        }

        return $seasons;
    }
}