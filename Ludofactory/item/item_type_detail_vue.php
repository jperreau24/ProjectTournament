<form action="<?php echo backoUrl(3, array('act'=>'update', 'edit_type' =>$obj_page->data('item')->getType())) ?>" method="post" class="form-horizontal form-box">
    <div class=" form-box form-box-content">
        <input id="" name="id" type="hidden" value="<?php echo $obj_page->data('item')->getId() ?>">
        <?php if($obj_page->data('item')->getType()==8) :?>
        <div class="control-group">
            <label class="control-label">Prix</label>
            <div class="controls">      
                <input id="" name="prix" type="text" value="<?php echo $obj_page->data('item')->getPrix() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">         
                <div class="div_valide" value="<?php if($obj_page->data('item')->getValideLot() == 1) { echo 'on'; } else {echo 'off';}?>">
                    <div class="input-switch switch-small"  data-on="success" data-off="danger">
                        <input type="checkbox" id="valide_lot" name="valide_lot" <?php if($obj_page->data('item')->getValideLot() == 1) { echo 'checked="checked"'; } ?>/>             
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>    
        <?php if($obj_page->data('item')->getType()==7 || $obj_page->data('item')->getType()==9) :?>
        <div class="control-group">
            <label class="control-label">Image</label>
            <div class="controls">      
                <input id="" name="imageFlotte" type="text" value="<?php echo $obj_page->data('item')->getImage() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Image bis</label>
            <div class="controls">      
                <input id="" name="imageBisFlotte" type="text" value="<?php echo $obj_page->data('item')->getImageBis() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Image vignette</label>
            <div class="controls">      
                <input id="" name="imageVignetteFlotte" type="text" value="<?php echo $obj_page->data('item')->getImageVignette() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Catégorie</label>
            <div class="controls">              
                <select id="flottecat" name="flotteCat">
                <?php foreach($obj_page->data('tab_flotte_cat') as $row) :?>   
                    <option value="<?php echo $row->getId(); ?>" <?php if($obj_page->data('item')->getIdCategorie()==$row->getId()){ ?> selected="selected" <?php } ?>>
                    <?php echo $row->getId()." - ".$row->getNom(); ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">         
                <div class="div_valide" value="<?php if($obj_page->data('item')->getValideFlotte() == 1) { echo 'on'; } else {echo 'off';}?>">
                    <div class="input-switch switch-small"  data-on="success" data-off="danger">
                        <input type="checkbox" id="valide_flotte" name="valide_flotte" <?php if($obj_page->data('item')->getValideFlotte() == 1) { echo 'checked="checked"'; } ?>/>             
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?> 
        
        
        <?php if($obj_page->data('item')->getType()>=10 && $obj_page->data('item')->getType()<=23) :?>
        <div class="control-group">
            <label class="control-label">Image</label>
            <div class="controls">      
                <input id="" name="imageBateau" type="text" value="<?php echo $obj_page->data('item')->getImage() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Image bis</label>
            <div class="controls">      
                <input id="" name="imageBisBateau" type="text" value="<?php echo $obj_page->data('item')->getImageBis() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Image vignette</label>
            <div class="controls">      
                <input id="" name="imageVignetteBateau" type="text" value="<?php echo $obj_page->data('item')->getImageVignette() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Catégorie</label>
            <div class="controls">              
                <select id="bateaucat" name="bateauCat">
                <?php foreach($obj_page->data('tab_bateau_cat') as $row) :?>   
                    <option value="<?php echo $row->getId(); ?>" <?php if($obj_page->data('item')->getIdCategorie()==$row->getId()){ ?> selected="selected" <?php } ?>>
                    <?php echo $row->getId()." - ".$row->getNom(); ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">         
                <div class="div_valide" value="<?php if($obj_page->data('item')->getValideBateau() == 1) { echo 'on'; } else {echo 'off';}?>">
                    <div class="input-switch switch-small"  data-on="success" data-off="danger">
                        <input type="checkbox" id="valide_bateau" name="valide_bateau" <?php if($obj_page->data('item')->getValideBateau() == 1) { echo 'checked="checked"'; } ?>/>             
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>           
    </div>
    <input type="submit" class="btn btn-success" style="margin-left:40%;margin-top:1%" value="Mettre à jour"/>
</form>

<script>
    $(document).ready(function(){
         $('.div_valide .input-switch').bootstrapSwitch();
    });

</script>