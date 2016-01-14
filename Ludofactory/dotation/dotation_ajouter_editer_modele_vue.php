<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(12);?>">Dotation</a></li>
    <li><a href="<?php echo backoUrl(12, array('act' => 'liste_modele'));?>">Modèle</a></li>
    <?php if($obj_page->data('editer')) : ?>
    <li class="active"><a href="javascript:void(0)">Editer</a></li>
    <?php else : ?>
    <li class="active"><a href="javascript:void(0)">Ajouter</a></li>
    <?php endif; ?>
</ul>
<?php if($obj_page->data('editer')) : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Editer un modèle :</h3>
    </div>
</div>
<?php else : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Ajouter un modèle :</h3>
    </div>
</div>
<?php endif; ?>
<form action="<?php if($obj_page->data('editer')) {echo backoUrl(12, array('act' =>'edit_modele'));}
                    else {echo backoUrl(12, array('act' =>'insert_modele'));}?>"
    method="post" class="form-horizontal form-box">
    <div class=" form-box form-box-content">
       
        <div class="control-group">
            <label class="control-label">Identifiant</label>
            <div class="controls">      
                <input id="" name="id" class="uneditable-input" disabled="" type="text" value="<?php if($obj_page->data('editer')){echo $obj_page->data('id');} 
                                                                                                     else {echo $obj_page->data('max_id');} ?>" >               
            </div>
                <input id="" name="id" type="hidden" value="<?php if($obj_page->data('editer')){echo $obj_page->data('id');} 
                                                                  else {echo $obj_page->data('max_id');} ?>" >
        </div>
        
        
        <?php if($obj_page->data('editer')) :
            foreach($obj_page->data('tab_domo') as $key=>$value) : ?>
        <div class="control-group classement" id="classement" name="class-<?php echo $key ?>">
            <label class="control-label">Classement</label>
            <div class="controls">      
                <input id="ln-class" name="classement-<?php echo $key ?>" type="text" class="input-small" value="<?php echo $value->getClassement()?>" required="required">
                <?php if($key==0) :?><i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='Position max'></i><?php endif; ?>
                <br><br>
                <select id="gain" name="idgain-<?php echo $key ?>">
                    <?php foreach($obj_page->data('tab_domc') as $row) :?>
                    <option <?php if($row->getId()==$value->getIdGain()): ?> selected='selected' <?php endif; ?>><?php echo $row->getId()." - ".$row->getDescription() ?></option>                 
                    <?php endforeach; ?>
                </select>        
                <?php if($key==0) :?><i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='Gain principal'></i> <?php endif; ?>

                <br><br>
                <select id="gainsec" name="idgainsec-<?php echo $key ?>">
                    <option value="0">Aucun</option>
                    <?php foreach($obj_page->data('tab_item') as $row) :?>
                    <option <?php if($row->getId()==$value->getIdGain2()): ?> selected='selected' <?php endif; ?>><?php echo $row->getId()." - ".$row->getNom() ?></option>                 
                    <?php endforeach; ?>
                </select>   
                <?php if($key==0) :?><i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='Gain secondaire'></i><?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <div class="control-group classement" id="classement" name="class-0">
            <label class="control-label">Classement</label>
            <div class="controls">      
                <input id="ln-class" name="classement-0" type="text" class="input-small" value="" required="required">
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='Position max'></i>
                <br><br>
                <select id="gain" name="idgain-0">
                    <?php foreach($obj_page->data('tab_domc') as $row) :?>
                    <option ><?php echo $row->getId()." - ".$row->getDescription() ?></option>                 
                    <?php endforeach; ?>
                </select>        
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='Gain principal'></i>

                <br><br>
                <select id="gainsec" name="idgainsec-0">
                    <option>Aucun</option>
                    <?php foreach($obj_page->data('tab_item') as $row) :?>
                    <option ><?php echo $row->getId()." - ".$row->getNom() ?></option>                 
                    <?php endforeach; ?>
                </select>   
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='Gain secondaire'></i>
            </div>
        </div>
        
        <?php endif;?>
        <div id="add_champ"></div>
        <input type="button" class="add_classement btn btn-success" value="+" data-toggle="tooltip" data-original-title="Ajouter une ligne de classement">
        <input type="button" class="remove_classement btn btn-danger" value="-" data-toggle="tooltip" data-original-title="Supprimer une ligne de classement">
    </div>
    <?php if($obj_page->data('editer')) : ?>
    <input type='submit' class='btn btn-success' style='margin-left:40%' value='Mettre à jour'/>
    <?php else : ?>
    <input type='submit' class='btn btn-success' style='margin-left:40%' value='Ajouter'/>
    <?php endif;?>
</form>