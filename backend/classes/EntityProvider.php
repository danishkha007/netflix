<?php
class EntityProvider{

    public static function getEntities($pdo,$entityId,$limit){
        $sql="SELECT * FROM entities ";

        if($entityId !=null){
            $sql.="WHERE categoryId=:categoryId ";
        }

        $sql.="ORDER BY RAND() LIMIT :limit";
        $stmt=$pdo->prepare($sql);
        if($entityId!=null){
            $stmt->bindValue(":categoryId",$entityId,PDO::PARAM_INT);
        }
        
        $stmt->bindValue(":limit",$limit,PDO::PARAM_INT);
        $stmt->execute();

        $resultData=array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $resultData[]=new Entity($row);
        }
        return $resultData;

    }

}