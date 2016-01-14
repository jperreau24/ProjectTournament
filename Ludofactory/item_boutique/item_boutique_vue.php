<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li class="active"><a href="javascript:void(0)">Boutique</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Gérer les items de la boutique</h3>
    </div>
</div>

<form action="<?php echo backoUrl(6, array('act'=>'ajouter')); ?>" method="post" style="float:left;">
    <input type="submit" class="btn btn-success" value="Ajouter un nouvel item boutique" />
</form>

<form action="<?php echo backoUrl(6, array('act'=>'listeCategories')); ?>" method="post" style="float:left;margin-left:1%">
    <input type="submit" class="btn btn-success" value="Liste catégories boutique" />
</form>

<form action="<?php echo backoUrl(6, array('act'=>'ajouterCategorie')); ?>" method="post" style="float:left;margin-left:1%">
    <input type="submit" class="btn btn-success" value="Ajouter une nouvelle catégorie" />
</form>
<div style="clear:both"></div>

<form class="form-horizontal form-box form_itemb_search" action="<?php echo backoUrl(6, array("act" => "liste")); ?>" method="post">
    <h4 class="form-box-header">Rechercher un item de la boutique par :</h4>
    <div class="form-box-content">

        <!-- Id Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id</label>
            <div class="controls">
                <input type="text" name="itemb_id" id="example-input-inline" class="input-large" placeholder="Id">
            </div>
        </div>
        
        <!-- Name Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Nom</label>
            <div class="controls">
                <input type="text" name="itemb_name" id="example-input-inline" class="input-large" placeholder="Nom">
            </div>
        </div>
        
        <!-- Type Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Catégorie</label>
            <div class="controls">
                 <select name="itemb_categorie" class="input-large">
                     <option value="0">Tout</option>
                    <?php foreach($obj_page->data('categories') as $row) : ?>                  
                        <option value="<?php echo $row->getId(); ?>"><?php echo $row->getId()." - ".$row->getNom();  ?></option>  
                    <?php endforeach; ?>                    
                </select>
            </div>
        </div>
        
        <div class="form-actions">
            <input type="submit" class="btn btn-success btn_item_recherche" value="Rechercher">
        </div>
    </div>
</form>
