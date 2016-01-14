<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(12);?>">Dotation</a></li>
    <li class="active"><a href="javascript:void(0)">Modèle</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Gestion des modèles de dotations</h3>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <h4>Liste des modèles de dotation</h4>
    </div>
</div>

<form action='<?php echo backoUrl(12,array('act'=>'ajouter_modele')); ?>' method='POST' style="float:left">
    <input type='submit' name='add_domo' class='btn btn-success' value='Ajouter un modèle'/>
</form>
<form action='<?php echo backoUrl(12,array('act'=>'liste_critere')); ?>' method='POST' style="float:left;margin-left:1%">
    <input type='submit' name='domc' class='btn btn-success' value='Voir les critères'/>
</form>

<div style="clear:both"></div>

<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-info"><?php echo $flashdata ?></p>
<?php endif; ?>

<table id='tab_liste_domo' class="table table-striped table-bordered table-hover" >
    <thead>
        <tr>
            <th style="width:5%"></th>
            <th style="text-align:center; width:7%">Id</th>
            <th style="text-align:center" data-toggle="tooltip" data-original-title="nom de l'item (id)">Gain Principal</th>
        </tr>
       
    </thead>
    
    <tbody>
        <?php foreach($tab_domo as $row) : ?>
        <tr id="<?php echo $row['domo']->getId() ?>">
            <td><a class="btn btn-mini btn-success btn-edit-mb" data-toggle="tooltip" data-original-title="Modifier" href="index.php?b=12&act=editer_modele&id=<?php echo $row['domo']->getId() ?>">
                <i class="icon-pencil"></i></a></td>
            <td><?php echo $row['domo']->getId() ?></td>
            <td><?php echo $row['domc']->getNom()." (<a href='".backoUrl(12,array('act'=>'editer_critere', 'id'=>$row['domc']->getId()))."' target='_blank'><b>".$row['domc']->getId()."</b></a>)" ?>
                <p class="conteneur_classement" style="float:right">
                    <button type="button" class="btn btn-small btn-info expand-classement-domo" data-id="<?php echo $row['domo']->getId() ?>">
                        <i class="icon-info-sign"></i>
                    </button>
                </p>   
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
