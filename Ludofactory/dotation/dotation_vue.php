<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li class="active"><a href="javascript:void(0)">Dotation</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Gestion des dotations</h3>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <h4>Liste des dotations</h4>
    </div>
</div>

<form action='<?php echo backoUrl(12,array('act'=>'liste_critere')); ?>' method='POST' style="float:left">
    <input type='submit' name='domc' class='btn btn-success' value='Voir les critères'/>
</form>

<form action='<?php echo backoUrl(12,array('act'=>'liste_modele')); ?>' method='POST' style="float:left;margin-left:1%">
    <input type='submit' name='domc' class='btn btn-success' value='Voir les modèles'/>
</form>

<div style="clear: both"></div>
<input class='btn btn-info recherche_av' value='recherche avancée' type='button'><br>
<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-error" style="margin-top:1%;margin-bottom: 0%;"><?php echo $flashdata ?></p>
<?php endif; ?> 
<form class="form-horizontal form-box form_dota_search" action="<?php echo backoUrl(12); ?>" method="post" style='display:none'>
    <h4 class="form-box-header">Rechercher une dotation par :</h4>
    <div class="form-box-content">

        <!-- Id Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id</label>
            <div class="controls">
                <input type="text" name="dota_id" id="example-input-inline" class="input-large">
            </div>
        </div>
        
        <!-- Name Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id de Tournois</label>
            <div class="controls">
                <input type="text" name="dota_id_tournois" id="example-input-inline" class="input-large">
            </div>
        </div>
        
        <!-- Type Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id d'item</label>
            <div class="controls">
                <input type="text" name="dota_id_item" id="example-input-inline" class="input-large">
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
                <input type="submit" name="dota_all" id="example-input-inline" class="btn btn-primary" value='Afficher tout'>
                <input type="submit" name="dota_tosc" id="example-input-inline" class="btn btn-primary" value='Tournois solo'>
                <input type="submit" name="dota_toec" id="example-input-inline" class="btn btn-primary" value='Tournois équipe'>
            </div>
        </div>
        
        
        <div class="form-actions">
            <input type="submit" class="btn btn-success btn_dota_recherche" value="Rechercher">
        </div>
    </div>
</form>



<div  class="wait" style="margin-left:45%"><span class="loader-11"></span> Chargement...</div>
<table id='tab_liste_dota' class="table table-striped table-bordered table-hover" style="display:none">
    <thead>
        <tr>
            <th>Id</th>
            <th data-toggle="tooltip" data-original-title="nom de l'item (id)">Gain Principal</th>
            <th>Tournoi</th>
            <th data-toggle="tooltip" data-original-title="1 : T. des Capitaines - 2 : T. des Maîtres - 3 : T. des Seigneurs">Type de tournoi</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($obj_page->data('tab_dota') as $row) :?>        
        <tr>
            <td><?php echo $row['dota']->getId() ?></td>
            <td><?php echo $row['item']->getNom()." (<a href='".backoUrl(3,array('act'=>'detail', 'id'=>$row['item']->getId()))."' target='_blank'><b>".$row['item']->getId()."</b></a>)"; ?>
            <p class="conteneur_classement" style="float:right"><button type="button" class="btn btn-small btn-info expand-classement-dota" data-id="<?php echo $row['dota']->getId() ?>"><i class="icon-info-sign"></i></button></p>   
            </td>      
            <td><?php if(isset($row['tournoisolo']) && $row['tournoisolo']->getId()!=null)
                            { echo "Solo n°<a href='".backoUrl(25,array('act'=>'tournois_details', 'id_tournois'=>$row['tournoisolo']->getId(), 'type'=>'solo'))."' target='_blank'>".$row['tournoisolo']->getId()." </a>";} 
                      else if($row['tournoiequipe']->getId()!=null)
                            { echo "Equipe n°<a href='".backoUrl(25,array('act'=>'tournois_details', 'id_tournois'=>$row['tournoiequipe']->getId(), 'type'=>'equipe'))."' target='_blank'>".$row['tournoiequipe']->getId()." </a>"; } ?></td>
            <td><?php if(isset($row['tournoisolo']) && $row['tournoisolo']->getId()!=null)
                            { echo $row['tournoisolo']->getType();}
                      else if($row['tournoiequipe']->getId()!=null)
                            { echo $row['tournoiequipe']->getType(); } ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<script>
    $(window).load(function(){
       $(".wait").hide();
       $("#tab_liste_dota").fadeIn();
    });
</script>

                           
                      