<?php

class User{
    private $pdo;

    public function __construct(){
        $this->pdo=Database::instance();
    }

    public function userData($user_id){
        return $this->get("users",["*"],array("user_id"=>$user_id));

    }
    public function userEmailById($user_id){
        return $this->get("users",["email"],array("user_id"=>$user_id));

    }
    public function create($tableName, $fields=array()){
        $columns= implode(', ',array_keys($fields));
        $values=':'.implode(', :',array_keys($fields));
        $sql="INSERT INTO {$tableName} ({$columns}) VALUES ({$values})";
        if($stmt=$this->pdo->prepare($sql)){
            foreach($fields as $key =>$values){
                $stmt->bindValue(":".$key,$values);
            }
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }
    }

    public function get($tableName,$columnName=array(),$fields=array()){
        $targetColumns=implode(', ',array_values($columnName));
        if(empty($fields)){
            $sql="SELECT {$targetColumns} FROM `{$tableName}`";
            if($stmt=$this->pdo->prepare($sql)){
                foreach($fields as $key =>$values){
                    $stmt ->bindValue(":".$key,$values);
                }
                $stmt->execute();
                return $stmt->fetchALL(PDO::FETCH_OBJ);
            }
        }else{
            $columns="";
            $i=1;
            foreach($fields as $name =>$value){
                $columns .="{$name}=:{$name}";
                if($i <count($fields)){
                    $columns .=" AND ";
                }
                $i++;
            }
            $sql="SELECT {$targetColumns} FROM `{$tableName}` WHERE {$columns}";
            if($stmt=$this->pdo->prepare($sql)){
                foreach($fields as $key =>$values){
                    $stmt ->bindValue(":".$key,$values);
                }
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }

    public function delete($tableName,$fields=array()){
        $sql="DELETE FROM `{$tableName}` ";
        $where=" WHERE ";
        foreach($fields as $name => $value){
            $sql.=" {$where} `{$name}`=:{$name} ";
            $where = " AND ";
        }
        if($stmt=$this->pdo->prepare($sql)){
            foreach($fields as $key =>$values){
                $stmt ->bindValue(":".$key,$values);
            }
            $stmt->execute();
        }


    }    
    public function is_log_in(){
        return (isset($_SESSION['isVerify']) ? true : false);
    }

    public function update($tableName,$user_id,$fields=array()){
        $columns="";
        $i=1;
        foreach($fields as $name =>$value){
            $columns .="`{$name}`=:{$name}";
            if($i <count($fields)){
                $columns .=" , ";
            }
            $i++;
        }
        $sql="UPDATE `{$tableName}` SET {$columns} WHERE `user_id`={$user_id}";
        if($stmt=$this->pdo->prepare($sql)){
            foreach($fields as $key =>$values){
                $stmt ->bindValue(":".$key,$values);
            }
            $stmt->execute();




        }
    }
    public function updateCategory($tableName,$user_id,$fields=array()){
        $columns="";
        $i=1;
        foreach($fields as $name =>$value){
            $columns .="`{$name}`=:{$name}";
            if($i <count($fields)){
                $columns .=" , ";
            }
            $i++;
        }
        $sql="UPDATE `{$tableName}` SET {$columns} WHERE `id`={$user_id}";
        if($stmt=$this->pdo->prepare($sql)){
            foreach($fields as $key =>$values){
                $stmt ->bindValue(":".$key,$values);
            }
            $stmt->execute();




        }
    }

}
?>