<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(12);?>">Dotation</a></li>
    <li><a href="<?php echo backoUrl(12, array('act' => 'liste_critere'));?>">Critère</a></li>
    <?php if($obj_page->data('editer')) : ?>
    <li class="active"><a href="javascript:void(0)">Editer</a></li>
    <?php else : ?>
    <li class="active"><a href="javascript:void(0)">Ajouter</a></li>
    <?php endif; ?>
</ul>
<?php if($obj_page->data('editer')) : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Editer un critère :</h3>
    </div>
</div>
<?php else : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Ajouter un critère :</h3>
    </div>
</div>
<?php endif; ?>

<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-danger"><?php echo $flashdata ?></p>
<?php endif; ?>

<form action="<?php if($obj_page->data('editer')){echo backoUrl(12, array('act' =>'update_critere'));}
                    else {echo backoUrl(12, array('act' =>'insert_critere'));}?>" method="post" class="form-horizontal form-box">
    <div class=" form-box form-box-content">
       
        <div class="control-group">
            <label class="control-label">Identifiant</label>
            <div class="controls">      
                <input id="" name="id" class="uneditable-input" disabled="" type="text" 
                       value="<?php if($obj_page->data('editer')) { echo $obj_page->data('domc')->getId();}
                                    else {echo $obj_page->data('max_id');} ?>" >               
            </div>
            <?php if($obj_page->data('editer')) : ?>
            <input id="" name="id" type="hidden" value='<?php echo $obj_page->data('domc')->getId() ?>'>
            <?php endif; ?>
        </div>
        
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">      
                <input id="" name="description" type="text" value="<?php if($obj_page->data('editer')) { echo $obj_page->data('domc')->getDescription();} ?>" required='required'>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Type</label>
            <div class="controls">      
                <select name='type'>
                    <option <?php if($obj_page->data('editer') && $obj_page->data('domc')->getType()==1) {echo "selected=selected";}?>>1</option>
                    <option <?php if($obj_page->data('editer') && $obj_page->data('domc')->getType()==2) {echo "selected=selected";}?>>2</option>
                </select>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='1 : items prédéfinis en choisira 1 seul en random, 2 : critères de sélection de pièces de bateau'></i>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Data</label>
            <div class="controls">
                <div class='input-prepend'>
                    <input id="data" name="data" type="text" value='<?php if($obj_page->data('editer')) : echo $obj_page->data('domc')->getData(); endif; ?>' required='required'>          
                </div>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='exemple : {"type":10,"min":301,"max":400} OU 1845'></i>
            </div>
        </div>
    </div>
   <input type='submit' class='btn btn-success' style='margin-left:40%' value='<?php if($obj_page->data('editer')) : echo "Mettre à jour"; else : echo "Ajouter"; endif; ?>'/>
</form>
