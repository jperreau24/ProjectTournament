<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(6);?>">Boutique</a></li>
    <li><a href="<?php echo backoUrl(6, array("act" => "liste"));?>">Liste</a></li>
    <li><a href="<?php echo backoUrl(6, array('act' =>'listeCategories'))?>">Catégorie</a></li>
    <?php if($obj_page->data('editercat')) : ?>
    <li class="active"><a href="javascript:void(0)">Editer catégorie</a></li>
    <?php else : ?>
    <li class="active"><a href="javascript:void(0)">Ajouter catégorie</a></li>
    <?php endif; ?>
</ul>

<?php if($obj_page->data('editercat')) : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Editer une catégorie :</h3>
    </div>
</div>
<?php else : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Ajouter une catégorie :</h3>
    </div>
</div>
<?php endif; ?>

<form action="<?php if($obj_page->data('editercat')) : echo backoUrl(6, array('act'=>'updateCategorie'));
                    else : echo backoUrl(6, array('act'=>'insertCategorie')); endif;?>" method="post" class="form-horizontal form-box">
    <div class=" form-box form-box-content">
        <div class="control-group">
            <label class="control-label">Identifiant</label>
            <div class="controls">      
                <input id="" name="id" class="uneditable-input" disabled="" type="text" value="<?php if($obj_page->data('editercat')) : echo $obj_page->data('categorie')->getId();
                                                                                                     else : echo $obj_page->data('next_id'); endif;?>">        
            </div>
            <input id="" name="id" type="hidden" value='<?php if($obj_page->data('editercat')) : echo $obj_page->data('categorie')->getId(); 
                                                              else : echo $obj_page->data('next_id'); endif;?>'>                                                
        </div>
   
        <div class="control-group">
            <label class="control-label">Nom</label>
            <div class="controls">      
                <input id="" name="nom" type="text" value="<?php if($obj_page->data('editercat')) : echo $obj_page->data('categorie')->getNom(); else : endif;?>" required="required">      
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">      
                <textarea id="" name="description" type="text" cols="25" rows="5"><?php if($obj_page->data('editercat')) : echo $obj_page->data('categorie')->getDescription(); endif;?></textarea>    
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Groupe</label>
            <div class="controls">      
                <select name="groupe">
                    <?php foreach($obj_page->data('tab_groupe') as $key=>$row) : ?>
                    <option value="<?php echo $row->getGroupe(); ?>" <?php if($obj_page->data('editercat')) : if($row->getGroupe()==$obj_page->data('categorie')->getGroupe()){ echo "selected='selected'"; } endif;?> >
                        <?php echo $row->getGroupe(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Ordre catégorie</label>
            <div class="controls">      
                <input id="" name="ordrecat" type="text" value="<?php if($obj_page->data('editercat')) : echo $obj_page->data('categorie')->getOrdreCat();endif;?>" />    
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Picto</label>
            <div class="controls">      
                <input id="" name="picto" type="text" value="<?php if($obj_page->data('editercat')) : echo $obj_page->data('categorie')->getPicto();endif;?>" />    
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">
                <div class="input-switch switch-small"  data-on="success" data-off="danger">
                <input type="checkbox" name="valide" <?php if($obj_page->data('editercat')) : if($obj_page->data('categorie')->getValide() == 1) { echo 'checked="checked"'; } endif;?>/>
                </div>
            </div>
        </div>     
     </div>
    <input type="submit" value='<?php if($obj_page->data('editercat')) : echo "Mettre à jour"; else : echo "Ajouter"; endif; ?>' class="btn btn-success" style="margin-left:40%"/>
</form>
