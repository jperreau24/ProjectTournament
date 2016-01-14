<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li class="active"><a href="javascript:void(0)">items</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Gérer les items</h3>
    </div>
</div>

<form action="<?php echo backoUrl(3, array('act'=>'detail')); ?>" method="post">
    <input type="submit" class="btn btn-success" value="Ajouter un nouvel item" />
</form>


<form class="form-horizontal form-box" action="<?php echo backoUrl(3,array('act'=>'liste')); ?>" method="post">
    <h4 class="form-box-header">Rechercher un item par :</h4>
    <div class="form-box-content">

        <!-- Id Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id</label>
            <div class="controls">
                <input type="text" name="item_id" id="example-input-inline" class="input-xlarge" placeholder="Id">
            </div>
        </div>
        
        <!-- Name Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Nom</label>
            <div class="controls">
                <input type="text" name="item_nom" id="example-input-inline" class="input-xlarge" placeholder="Nom">
            </div>
        </div>
        
        <!-- Type Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Type</label>
            <div class="controls">
                 <select name="item_type" class="input-xlarge">
                     <option value="aucun">Tout</option>
                    <?php foreach($obj_page->data('type_item') as $key=>$row) : ?>                  
                        <option value="<?php echo $key; ?>"><?php echo $key." - ".$row; 
                        if ($key == 0){echo " (générique non flotte)";}
                        else if ($key == 7){echo " (fanion flotte)";}
                        else if ($key == 9){echo " (générique flotte)";}
                        else if ($key == 10){echo " (cabine arrière du bateau)";}
                        else if ($key == 11){echo " (coque du bateau)";}
                        else if ($key == 12){echo " (voile centrale du bateau)";}
                        else if ($key == 13){echo " (canon du bateau)";}
                        else if ($key == 14){echo " (proue du bateau)";}
                        else if ($key == 15){echo " (ancre du bateau)";}
                        else if ($key == 16){echo " (ornement du bateau)";}
                        else if ($key == 17){echo " (rambarde du bateau)";}
                        else if ($key == 18){echo " (cabine avant du bateauu)";}
                        else if ($key == 19){echo " (escalier du bateau)";}
                        else if ($key == 20){echo " (pavillon du bateau)";}
                        else if ($key == 21){echo " (vigie du bateau)";}
                        else if ($key == 22){echo " (voile arrière du bateau)";}
                        else if ($key == 23){echo " (voile avant du bateau)";}
                        else if ($key == 24){echo " (item qui ne fait qu'ajouter de la réputation)";}
                        else { echo " ";}
                        ?>
                        </option>                   
                    <?php endforeach; ?>                    
                </select>
            </div>
        </div>
        
        <!-- recent addition  Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Ajout récent</label>
            <div class="controls">
                <input type="checkbox" name="item_ajout_recent" style='margin-right: 8%'>Nombre d'items :<input type="text" name="item_nb" maxlength="2" value="30" class="input-mini" style='margin-left: 1%'>
            </div>
        </div>
        
        
        <div class="form-actions">
            <input type="submit" class="btn btn-success btn_item_recherche" value="Rechercher">
        </div>
    </div>
</form>