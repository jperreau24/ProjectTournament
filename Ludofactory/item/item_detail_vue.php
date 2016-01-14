<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(3); ?>">Items</a></li>
    <li><a href="<?php echo backoUrl(3, array('act' => 'liste', 'item_ajout_recent' => '')) ?>">Liste</a></li>
    <?php if($obj_page->data('verif_id')) : ?>
    <li class="active"><a href="javascript:void(0)">Edition</a></li>
    <?php else : ?>
    <li class="active"><a href="javascript:void(0)">Ajout</a></li>
    <?php endif;?>
</ul>
<div class="row-fluid">
    <div class="span12">
        <?php if($obj_page->data('verif_id')) : ?>
        <h3 class="page-header page-header-top">Edition de l'item <?php echo $obj_page->data('item')->getId() ?></h3>
        <?php else :?>
        <h3 class="page-header page-header-top">Ajouter un item :</h3>
        <?php endif; ?>
        
    </div>
</div>

<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-success"><?php echo $flashdata ?></p>
<?php endif; ?>


<form action="<?php if($obj_page->data('verif_id')){echo backoUrl(3, array('act'=>'update', 'edit' => true));}else {echo backoUrl(3, array('act'=>'insert'));} ?>" method="post" class="form-horizontal form-box">
    <div class=" form-box form-box-content">
       
        <div class="control-group">
            <label class="control-label">Identifiant</label>
            <div class="controls">      
                <input id="" name="id" class="uneditable-input" disabled="" type="text" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item')->getId();}else{echo $obj_page->data('max_id'); } ?>">
                <?php if($obj_page->data('verif_id')) : ?> 
                <input id="" name="id" type="hidden" value="<?php echo $obj_page->data('item')->getId() ?>">
                 <?php endif;?>
            </div>
        </div>
   

         
        <div class="control-group">
            <label class="control-label">Nom</label>
            <div class="controls">
                <input id="" name="nom" type="text" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item')->getNom();} ?>" required="required">
            </div>
        </div>
         
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <input id="" name="description" type="text" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item')->getDescription();} ?>">
            </div>
        </div>
         
        <div class="control-group">
            <label class="control-label">Valeur</label>
            <div class="controls">
                <div class="input-prepend">
                    <input id="" name="valeur" type="text" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item')->getValeur();} ?>">
                </div>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="selon l'effet (ex : si 10 pour un item énergie = +10 d'énergie)"></i>
            </div>
        </div>
         
        <div class="control-group">
            <label class="control-label">Valeur bis</label>
            <div class="controls">
            <div class="input-prepend">
                <input id="" type="text" name="valeurBis" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item')->getValeurBis();} ?>">
            </div>
            <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="idem que valeur mais pour un second effet"></i>
            </div>
        </div>
         
        <div class="control-group">
            <label class="control-label">Réputation</label>
            <div class="controls">
                <div class="input-prepend">
                    <input id="" name="reputation" type="text" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item')->getReputation();} ?>">
                </div>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="gain de réputation éventuel à l'obtention"></i>
            </div>
        </div>
              
        <div class="control-group">
            <label class="control-label">Image</label>
            <div class="controls">
                <div class="input-prepend">
                    <input id="" name="image" type="text" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item')->getImgDot();} ?>">
                </div>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="penser au 2e fichier nommé de la même manière mais avec en préfixe _1st_, img.../lots/"></i>
            </div>
             
        </div>
         
        <div class="control-group">
            <label class="control-label">Disponible par défaut</label>
            <div class="controls">
                <div class="input-switch switch-small"  data-on="success" data-off="danger">
                <input type="checkbox" name="defaut" <?php if($obj_page->data('verif_id')){if($obj_page->data('item')->getParDefaut() == 1) { echo 'checked="checked"'; }} ?>/>
                </div>
            </div>
        </div>
         
        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">
                <div class="input-switch switch-small"  data-on="success" data-off="danger">
                <input type="checkbox" name="valide" <?php if($obj_page->data('verif_id')){if($obj_page->data('item')->getValide() == 1) { echo 'checked="checked"'; }} ?>/>
                </div>
            </div>
        </div>

         
    
    
    <div class="control-group">
            <label class="control-label">Type</label>
            <div class="controls">
                <select id="type" name="type" class="select_type_item">
                    <?php foreach($obj_page->data('type_item') as $key=>$row) : ?>                  
                        <option value="<?php echo $key; ?>" <?php if($obj_page->data('verif_id')){if($obj_page->data('item')->getType() == $key){echo 'selected="selected"';}} ?>><?php echo $key." - ".$row; 
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
        </div>       
         
         <!--Section lot-->
        <div class="form-box form-box-content affiche_type_lot" style="display:none">
            <div class="control-group">
                <label class="control-label">Prix</label>
                <div class="controls">              
                    <input type="text" class="item_lot" name="prix" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item_lot')->getPrix();} ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Lot Valide</label>
                <div class="controls">         
                    <div class="div_valide_lot" value="<?php if($obj_page->data('verif_id')){if($obj_page->data('item_lot')->getValideLot() == 1) { echo 'on'; } else {echo 'off';}} else{echo 'off';} ?>">
                        <div class="input-switch switch-small"  data-on="success" data-off="danger">
                            <input type="checkbox" id="valide_lot" name="valide_lot" <?php if($obj_page->data('verif_id')){if($obj_page->data('item_lot')->getValideLot() == 1) { echo 'checked="checked"'; }} ?>/>             
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
         
        <!--Section flotte-->
        <div class=" form-box form-box-content affiche_type_flotte" style="display:none">
            <div class="control-group">
                <label class="control-label">Image flotte</label>
                <div class="controls">              
                    <input type="text" class="item_flotte" name="imageFlotte" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item_flotte')->getImage();} ?>"/>
                    <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="img.../items/flotte/"></i>
                </div>

            </div>
            
            <div class="control-group">
                <label class="control-label">Image bis flotte</label>
                <div class="controls">
                    <div class="input-prepend">
                        <input type="text" class="item_flotte" name="imageBisFlotte" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item_flotte')->getImageBis();} ?>"/>
                    </div>
                    <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="Item en 2 morceaux (inutilisé) "></i>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Image vignette flotte</label>
                <div class="controls">      
                    <div class="input-prepend">
                        <input type="text" class="item_flotte" name="imageVignetteFlotte" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item_flotte')->getImageVignette();} ?>"/>
                    </div>
                    <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="image dans la sélection d'item de l'éditeur (inutilisé)"></i>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Item flotte catégorie</label>
                <div class="controls">              
                    <select id="flottecat" name="flotteCat">
                        <?php foreach($obj_page->data('tab_flotte_cat') as $row) :?>   
                           <option value="<?php echo $row->getId(); ?>" <?php if($obj_page->data('verif_id')){if($obj_page->data('item_flotte')->getIdCategorie()==$row->getId()){ ?> selected="selected" <?php }} ?>>
                               <?php echo $row->getId()." - ".$row->getNom(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Item flotte valide</label>
                <div class="controls">          
                    <div class="div_valide_flotte" value="<?php if($obj_page->data('verif_id')){if($obj_page->data('item_flotte')->getValideFlotte() == 1) { echo 'on'; } else {echo 'off';}}else{echo 'off';} ?>">
                        <div class="input-switch switch-small"  data-on="success" data-off="danger">
                            <input type="checkbox" id="valide_flotte" name="valide_flotte" <?php if($obj_page->data('verif_id')){if($obj_page->data('item_flotte')->getValideFlotte() == 1) { echo 'checked="checked"'; }} ?>/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Section bateau-->
        <div class=" form-box form-box-content affiche_type_bateau" style="display:none">
            <div class="control-group">
                <label class="control-label">Image bateau</label>
                <div class="controls">              
                    <input type="text" class="item_bateau" name="imageBateau" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item_bateau')->getImage();} ?>"/>
                     <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="swf, img.../editeur/image/ "></i>
                </div>
                
            </div>
            
            <div class="control-group">
                <label class="control-label">Image bis bateau</label>
                <div class="controls">              
                   <div class="input-prepend">
                    <input type="text" class="item_bateau" name="imageBisBateau" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item_bateau')->getImageBis();} ?>"/>
                    </div>
                    <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="Item en 2 morceaux (swf, utile pour la 2e image des barrières du bateau img.../editeur/image/)"></i>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Image vignette bateau</label>
                <div class="controls">              
                    <div class="input-prepend">
                        <input type="text" class="item_bateau" name="imageVignetteBateau" value="<?php if($obj_page->data('verif_id')){echo $obj_page->data('item_bateau')->getImageVignette();} ?>"/>
                    </div>
                    <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="image dans la sélection d'item de l'éditeur (vignette pour l’éditeur, img.../items/boutique/)"></i>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Item bateau catégorie</label>
                <div class="controls">
                    <select id="bateaucat" name="bateauCat">
                        <?php foreach($obj_page->data('tab_bateau_cat') as $row) :?>   
                           <option value="<?php echo $row->getId(); ?>" <?php if($obj_page->data('verif_id')){if($obj_page->data('item_bateau')->getIdCategorie()==$row->getId()){ ?> selected="selected" <?php }} ?>>
                               <?php echo $row->getId()." - ".$row->getNom(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Item bateau valide</label>
                <div class="controls">   
                    <div class="div_valide_bateau" value="<?php if($obj_page->data('verif_id')){if($obj_page->data('item_bateau')->getValideBateau() == 1) { echo 'on'; } else {echo 'off';}}else{echo 'off';} ?>">
                        <div class="input-switch switch-small"  data-on="success" data-off="danger">
                            <input type="checkbox" id="valide_bateau" name="valide_bateau" <?php if($obj_page->data('verif_id')){if($obj_page->data('item_bateau')->getValideBateau() == 1) { echo 'checked="checked"'; }} ?>/>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
       <?php if($obj_page->data('verif_id')) :?>
        <input type="submit" class="btn btn-success" style="margin-left:45%;margin-top:1%" value="Mettre à jour"/>
        <?php else : ?>
        <input type="submit" class="btn btn-success" style="margin-left:45%;margin-top:1%" value="Ajouter"/>
        <?php endif; ?>
</form>
    




    
    <!--<input type="hidden" name="id" value="<?php //echo $obj_page->data('item')->getId() ?>" />
    <p><label>Identifiant</label>
        <?php //echo $obj_page->data('item')->getId() ?></p>
    <p><label>Nom</label>
        <input type="text" name="nom" value="<?php //echo $obj_page->data('item')->getNom() ?>" /></p>
    <p><label>Description</label>
        <input type="text" name="description" value="<?php //echo $obj_page->data('item')->getDescription() ?>" /></p>
    <p><label>Valeur</label>
        <input type="text" name="valeur" value="<?php //echo $obj_page->data('item')->getValeur() ?>" /></p>
    
        <!-- VALEUR BIS 
    <p><label>Valeur bis</label>
        <input type="text" name="valeurBis" value="<?php //echo $obj_page->data('item')->getValeurBis() ?>" /></p>
    <p><label>Reputation</label>
        <input type="text" name="reputation" value="<?php //echo $obj_page->data('item')->getReputation() ?>" /></p>
   
        <!-- TYPE 
    <p><label>Type</label>
        <td><input type="text" name="type" value="<?php //echo $obj_page->data('item')->getType() ?>" /></p>
    <p><label>Par défaut</label>
        <input type="checkbox" name="defaut" <?php //if($obj_page->data('item')->getParDefaut() == 1) { echo 'checked="checked"'; } ?>/></p>
    <p><label>Valide</label>
        <input type="checkbox" name="valide" <?php //if($obj_page->data('item')->getValide() == 1) { echo 'checked="checked"'; } ?>/></p>
    <p><input type="submit" value="Mettre à jour" /></p>
</form>

<p><a href="<?php //echo backoUrl(3, array('act'=>'liste')); ?>">Retour</a></p>-->



