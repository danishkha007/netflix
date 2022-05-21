<?php

class EntityContainers{
    private $pdo;

    private $user;

    public function __construct(){
        $this->pdo=Database::instance();
        $this->user=new User;
    }

    public function entityData(){
        $entitiesData=$this->user->get('entities',["*"]);
        foreach($entitiesData as $entity){
            ?>
            <tr>
                <td><?= $entity->Id; ?></td>
                <td><?= $entity->name; ?></td>
                <td><img src="<?= url_for($entity->thumbnail); ?>" class="img-rounded" style="color:#fff;" data-toggle="tooltip" title="<?= $entity->name; ?>" title="<?= $entity->name; ?>" width="100px" ></td>
                <td><video src="<?= url_for($entity->preview); ?>" class="img-rounded" style="color:#ffffff;background:#000000; " data-toggle="tooltip" title="<?= $entity->name; ?>" poster="<?= url_for($entity->thumbnail); ?>" width="250px" height="200px"controls></td>
                <td><?= $entity->categoryId; ?></td>
                <td><a href="<?= url_for(h('viewentity/'.u($entity->Id))); ?>" class="btn btn-success" role="button" ><span class="glyphicon glyphicon-eye-open" style="color:#fff;" data-toggle="tooltip" title="View Entity"></span></a></td>
                <td><a href="<?= url_for(h('editentity/'.u($entity->Id))); ?>" class="btn btn-info" role="button" ><span class="glyphicon glyphicon-edit" style="color:#fff;" data-toggle="tooltip" title="Edit Entity"></span></a></td>
                <td><a href="<?= url_for(h('deleteentity/'.u($entity->Id))); ?>" class="btn btn-danger" role="button" ><span class="glyphicon glyphicon-trash" style="color:#fff;" data-toggle="tooltip" title="Delete Entity"></span></a></td>

            </tr>
            <?php
        }
    }


}