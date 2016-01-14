<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(6);?>">Boutique</a></li>
    <li><a href="<?php echo backoUrl(6, array("act" => "liste"));?>">Liste</a></li>
    <li class="active"><a href="javascript:void(0)">Catégorie</a></li>
</ul>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Liste des catégories de la boutique</h3>
    </div>
</div>
<form action="<?php echo backoUrl(6, array('act'=>'ajouterCategorie')); ?>" method="post">
    <input type="submit" class="btn btn-success" value="Ajouter une nouvelle catégorie" />
</form>

<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-success"><?php echo $flashdata ?></p>
<?php endif; ?> 

<div>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th></th>
            <th>Id</th>
            <th>Nom</th>
            <th>Groupe</th>
            <th>Ordre</th>
            <th>Ordre catégorie</th>
            <th>Picto</th>
            <th>Valide</th>
        </tr>
        <?php foreach ($obj_page->data('categories') as $categorie) { ?>
        <tr>
            <td><a class="btn btn-mini btn-success btn-edit-mb" data-original-title="Modifier" href="<?php echo backoUrl(6, array('act'=>'detailCategorie', 'id'=>$categorie->getId())) ?>">
                    <i class="icon-pencil"></i></td>
            <td><?php echo $categorie->getId() ?></td>
            <td><?php echo $categorie->getNom() ?></td>
            <td><?php echo $categorie->getGroupe();?></td>
            <td><?php echo $categorie->getOrdre();?></td>
            <td><?php echo $categorie->getOrdreCat();?></td>
            <td><?php echo $categorie->getPicto();?></td>
            <td><?php echo $categorie->getValide() ?></td>
        </tr>
        <?php } ?>
    </table>
</div>