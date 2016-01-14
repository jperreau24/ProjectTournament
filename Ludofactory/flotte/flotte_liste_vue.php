<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li ><a href="<?php echo backoUrl(29) ?>">Flotte</a></li>
    <li class="active"><a href="javascript:void(0)">Liste</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Liste des flottes</h3>
    </div>
</div>

<input class='btn btn-info search' value='recherche avancée' type='button'><br>
<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-info" style="margin-top:1%;margin-bottom: 0%;"><?php echo $flashdata ?></p>
    <?php endif; ?><br>

<form class="form-horizontal form-box form_flotte_search" action="<?php echo backoUrl(29, array("act" => "liste")); ?>" method="post" style="display:none">
    <h4 class="form-box-header">Rechercher une flotte par :</h4>
    <div class="form-box-content">

        <!-- Id Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id</label>
            <div class="controls">
                <input type="text" name="flotte_id" id="example-input-inline" class="input-large" placeholder="Id">
            </div>
        </div>
        
        <!-- Name Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Nom</label>
            <div class="controls">
                <input type="text" name="flotte_name" id="example-input-inline" class="input-large" placeholder="Nom">
            </div>
        </div>
        
        <!-- Type Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id membre</label>
            <div class="controls">
                  <input type="text" name="flotte_idmemb" id="example-input-inline" class="input-large" placeholder="Id membre">
            </div>
        </div>
        
        <div class="form-actions">
            <input type="submit" class="btn btn-success btn_flotte_recherche" value="Rechercher">
        </div>
    </div>
</form>

<div>
    <table class="table table-striped table-bordered table-hover" id="tab_flotte">
        <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Nom</th>
            <th data-toggle="tooltip" data-original-title="Id membre de l'amiral (créateur) de le flotte">Id amiral</th>
            <th data-toggle="tooltip" data-original-title="Somme des réputations des bateaux des membre de la flotte">Total réputation</th>
            <th>Trésor</th>
            <th>Date création</th>
            <th>valide</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($obj_page->data('flottes') as $row) : ?>
        <tr id='<?php echo $row->getId() ?>'>
            <td><a class="btn btn-mini btn-success btn-edit-mb" data-toggle="tooltip" data-original-title="Modifier" href="<?php echo backoUrl(29, array('act'=>'detail', 'id'=>$row->getId())) ?>">
                    <i class="icon-pencil"></i></td>
            <td><?php echo $row->getId() ?></td>
            <td><?php echo $row->getNom() ?></td>
            <td><a href="<?php echo backoUrl(2,array('act'=>'fiche', 'id'=>$row->getAmiral()))?>" target='_blank'><?php echo $row->getAmiral();?></a></td>
            <td><?php echo $row->getTotalReputation() ?></td>
            <td><?php echo $row->getTresor() ?></td>
            <td><?php echo $row->getDateCreation() ?></td>
            <td class="valide_flotte" data-id="<?php echo $row->getId(); ?>" value="<?php echo $row->getValide(); ?>" data-tresor="<?php echo $row->getTresor() ?>">                    
                <div class="input-switch flotte_<?php echo $row->getId(); ?> switch-mini "  data-on="success" data-off="danger" style="margin-left: 20%">
                    <input type="checkbox" <?php if ($row->getValide() == '1') { ?>checked <?php } ?>>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
            </tbody>
    </table>
</div>