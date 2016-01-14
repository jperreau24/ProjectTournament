<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(3); ?>">Items</a></li>
    <li class="active"><a href="javascript:void(0)">Liste</a></li>
</ul>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Liste des items</h3>
    </div>
</div>

<div id="detail-modal" class="modal hide" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4>Récupération des informations</h4>
    </div>
    <div class="modal-body">
        <p></p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>

<form action="<?php echo backoUrl(3, array('act'=>'detail')); ?>" method="post">
    <input type="submit" class="btn btn-success" value="Ajouter un nouvel item" />
</form>

<input class='btn btn-info testb' value='recherche avancée' type='button'><br>
<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-info" style="margin-top:1%;margin-bottom: 0%;"><?php echo $flashdata ?></p>
<?php endif; ?> 

<div class="wait" style="margin-left:45%"><span class="loader-11"></span> Chargement...</div>


<form class="form-horizontal form-box form_item_search" action="<?php echo backoUrl(3,array('act'=>'liste')); ?>" method="post" style='display: none'>
    <h4 class="form-box-header">Rechercher un item par :</h4>
    <div class="form-box-content">

        <!-- Id Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id</label>
            <div class="controls">
                <input type="text" name="item_id" id="example-input-inline" class="input-xlarge item_id" placeholder="Id">
            </div>
        </div>
        
        <!-- Name Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Nom</label>
            <div class="controls">
                <input type="text" name="item_nom" id="example-input-inline" class="input-xlarge item_nom" placeholder="Nom">
            </div>
        </div>
        
        <!-- Type Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Type</label>
            <div class="controls">
                 <select name="item_type" class="input-xlarge item_type">
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
                <input type="checkbox" classe="item_ajout_recent" name="item_ajout_recent" style='margin-right: 8%'>Nombre d'items :<input type="text" name="item_nb" maxlength="2" value="30" class="input-mini item_nb" style='margin-left: 1%'>
            </div>
        </div>
        
        
        <div class="form-actions">
            <input type="submit" class="btn btn-success btn_item_recherche" value="Rechercher">
        </div>
    </div>
</form>



<!-- Affichage des objets concernés -->
<div>
    <table id="liste_item_c" class="table table-striped table-bordered table-hover" style="display:none">
        <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Nom</th>
            <th>Description</th>
            <th data-toggle="tooltip" data-original-title="selon l'effet (ex : si 10 pour un item énergie = +10 d'énergie)">Valeur</th>
            <th data-toggle="tooltip" data-original-title="idem que valeur mais pour un second effet!">Valeur bis</th>
            <th data-toggle="tooltip" data-original-title="gain de réputation éventuel à l'obtention">Réputation</th>
            <th>Image</th>
            <th>Type</th>
            <th>Par défaut</th>            
            <th>Valide</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($obj_page->data('items') as $item) { ?>
            <tr id=<?php echo $item->getId() ?>>
                <td><a class="btn btn-mini btn-success btn-edit-mb" style="float:right" data-toggle="tooltip" data-original-title="Modifier" href="<?php echo backoUrl(3, array('act'=>'detail', 'id'=>$item->getId())) ?>">
                    <i class="icon-pencil"></i></td>
                <td><?php echo $item->getId() ?></td>
                <td><?php echo $item->getNom() ?></a></td>
                <td><?php echo $item->getDescription() ?></td>
                <td><?php echo $item->getValeur() ?></td>
                <td><?php echo $item->getValeurBis() ?></td>
                <td><?php echo $item->getReputation() ?></td>
                <td><?php echo $item->getImgDot() ?></td>
                <td<?php foreach($type_item_c as $key =>$row): if($key==$item->getType()): if($item->getType()>=7 && $item->getType()<=24):?> data-toggle="tooltip" data-original-title="
                <?php   if ($key == 7) {echo "fanion flotte";}
                        else if ($key == 8) {echo "lot";}
                        else if ($key == 9) {echo "générique flotte";}
                        else if ($key == 10){echo "cabine arrière du bateau";}
                        else if ($key == 11){echo "coque du bateau";}
                        else if ($key == 12){echo "voile centrale du bateau";}
                        else if ($key == 13){echo "canon du bateau";}
                        else if ($key == 14){echo "proue du bateau";}
                        else if ($key == 15){echo "ancre du bateau";}
                        else if ($key == 16){echo "ornement du bateau";}
                        else if ($key == 17){echo "rambarde du bateau";}
                        else if ($key == 18){echo "cabine avant du bateauu";}
                        else if ($key == 19){echo "escalier du bateau";}
                        else if ($key == 20){echo "pavillon du bateau";}
                        else if ($key == 21){echo "vigie du bateau";}
                        else if ($key == 22){echo "voile arrière du bateau";}
                        else if ($key == 23){echo "voile avant du bateau";}
                        else if ($key == 24){echo "item qui ne fait qu'ajouter de la réputation";}
                        ?>"
                    <?php endif;endif;endforeach; ?>><?php echo $item->getType();  ?>
                <?php if($item->getType()>=7 && $item->getType()<=23):?>
                <div class="type-details btn-group"  style="float:right">
                    <a href="#detail-modal" data-id="<?php echo $item->getId(); ?>" data-type="<?php echo $item->getType(); ?>" data-toggle="modal" title="" class="btn btn-mini btn-info" data-original-title="Détails"><i class="icon-info-sign"></i></a>
                </div>
                <?php endif; ?>    
                </td>
                <td class="par_defaut_item" data-id="<?php echo $item->getId(); ?>" value="<?php echo $item->getParDefaut(); ?>"> 
                <div class="input-switch item_<?php echo $item->getId(); ?> switch-mini "  data-on="success" data-off="danger" style="margin-left: 20%">
                   <input type="checkbox" <?php if ($item->getParDefaut() == '1') { ?>checked <?php } ?>>
                </div>
                </td>
                <td class="valide_item" data-id="<?php echo $item->getId(); ?>" value="<?php echo $item->getValide(); ?>">                    
                    <div class="input-switch item_<?php echo $item->getId(); ?> switch-mini "  data-on="success" data-off="danger" style="margin-left: 20%">
                            <input type="checkbox" <?php if ($item->getValide() == '1') { ?>checked <?php } ?>>
                    </div>
                </td> 
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



<script>
$(window).load(function(){
       $(".wait").hide();
       $("#liste_item_c").fadeIn();
    });
</script>
