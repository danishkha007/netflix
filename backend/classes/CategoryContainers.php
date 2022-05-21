<?php

class CategoryContainers{

    private $pdo;
    private $user;

    public function __construct(){
        $this->pdo=Database::instance();
        $this->user=new User;
    }

    public function categoryData(){
        $categoriesData=$this->user->get('categories',["*"]);
        foreach($categoriesData as $cat){
            ?>
            <tr>
                <td><?= $cat->id; ?></td>
                <td><?= $cat->name; ?></td>
                <td><button type="submit" value="<?= $cat->id; ?>" class="btn btn-success" name="btnedit">Edit</button></td>
                <td><button type="submit" value="<?= $cat->id; ?>" class="btn btn-danger" name="btndelete">Delete</button></td>

            </tr>
            <?php
        }
    }

    public function getAllCategories(){
        $categoriesData=$this->user->get("categories",["*"]);
        $html="<div class='previewCategories'>";
        foreach($categoriesData as $catData){
            $html .= $this->getHomeCategoryHtml($catData,null,true,true);
        }
        return $html ."</div>";
    }

    public function getHomeCategoryHtml($data,$title,$isTvShow,$isMovie){
        if(is_object($data)){
            $categoryId=$data->id;
        }else{
            $categoryId=$data['id'];
        }
        
        $title=$title==null ? $data->name : $title;
        if($isTvShow && $isMovie){
            $entitiesData=EntityProvider::getEntities($this->pdo,$categoryId,4);
        }
        
        if(sizeof($entitiesData)==0){
            return;
        }
        $entitiesContent="";
        $previewProvider= new VideoPreviewProvider();
        foreach($entitiesData as $entity){
            $entityData=$entity->entityData();
            $entitiesContent .=$previewProvider->createHomeEntityPreviewSquare($entityData);
        }
        return '<section class="nm-collections-row">
                    <h3 class="nm-collections-row-name">
                        <a href="'.url_for('category/'.u(h($categoryId))).'">'.$title.'</a>
                    </h3>
                    <div class="nm-content-horizontal-row">
                        <ul class="nm-content-horizontal-row-item-container">'.$entitiesContent.'</ul>
                    </div>
        
                </section>';


    }
}