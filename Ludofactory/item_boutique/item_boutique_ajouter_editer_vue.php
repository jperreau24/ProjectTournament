<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(6);?>">Boutique</a></li>
    <li><a href="<?php echo backoUrl(6, array("act" => "liste"));?>">Liste</a></li>
    <?php if($obj_page->data('editer')) : ?>
    <li class="active"><a href="javascript:void(0)">Edition</a></li>
    <?php else : ?>
    <li class="active"><a href="javascript:void(0)">Ajouter</a></li>
    <?php endif; ?>
</ul>

<?php if($obj_page->data('editer')) : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Edition de l'item boutique :</h3>
    </div>
</div>
<?php else : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Ajouter un nouvel item boutique</h3>
    </div>
</div>
<?php endif; ?>

<form action="<?php if($obj_page->data('editer')) : echo backoUrl(6, array('act'=>'update'));
                    else : echo backoUrl(6, array('act'=>'insert')); endif; ?>" method="post" class="form-horizontal form-box" id="form_insert_itemb">
    
    <div class=" form-box form-box-content">
        <div class="control-group">
            <label class="control-label">Identifiant</label>
            <div class="controls">   
                <?php if($obj_page->data('editer')) : ?>
                <input id="" name="id" class="uneditable-input" disabled="" type="text" value="<?php echo $obj_page->data('item')->getId();?>">    
                <?php else : ?>
                <select name="id">
                    <?php foreach ($obj_page->data('unlinked_items') as $unlinkedItem) { ?>
                    <option value="<?php echo $unlinkedItem->getId() ?>"><?php echo $unlinkedItem->getId()." - ".$unlinkedItem->getNom() ?></option>
                    <?php } ?>
                </select>
                <?php endif; ?>
            </div>
            <?php if($obj_page->data('editer')) : ?>
            <input id="" name="id" type="hidden" value='<?php echo $obj_page->data('item')->getId() ?>'>
            <?php endif; ?>
        </div>
   
        <?php if($obj_page->data('editer')) : ?>
        <div class="control-group">
            <label class="control-label">Nom</label>
            <div class="controls">      
                <input id="" name="nom" class="uneditable-input" disabled="" type="text" value="<?php echo $obj_page->data('item')->getNom();?>">      
            </div>
            <input id="" name="id" type="hidden" value='<?php echo $obj_page->data('item')->getId() ?>'>
        </div>
        <?php endif; ?>
        
        <div class="control-group">
            <label class="control-label">Catégorie</label>
            <div class="controls">      
                <select name="idCategorie">
                    <?php foreach ($obj_page->data('categories') as $categorie) : ?>
                    <option value="<?php echo $categorie->getId() ?>" <?php if($obj_page->data('editer')) : if($categorie->getId()==$obj_page->data('item')->getIdCategorieBoutique()){echo "selected='selected'";} endif;?>>
                        <?php echo $categorie->getNom()." (".$categorie->getGroupe().")"; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
         <div class="control-group">
            <label class="control-label">Image</label>
            <div class="controls">      
                <input type="text" name="image" value="<?php if($obj_page->data('editer')) :echo $obj_page->data('item')->getImage();endif;?>" required="required"/>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title='img.../items/boutique/'></i>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Coût pièces d'or</label>
            <div class="controls">      
                <input type="number" id="coutPieces" name="coutPieces" value="<?php if($obj_page->data('editer')) : echo $obj_page->data('item')->getCoutPieces();endif;?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Coût rubis</label>
            <div class="controls">      
                <input type="number" id="coutRubis" name="coutRubis" value="<?php if($obj_page->data('editer')) : echo $obj_page->data('item')->getCoutRubis();endif;?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Niveau minimum</label>
            <div class="controls">      
                <input type="number" name="niveauMini" value="<?php if($obj_page->data('editer')) : echo $obj_page->data('item')->getNiveauMin();endif;?>"/>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="niveau d'xp mini pour acheter l'article"></i>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Réputation minimum</label>
            <div class="controls">      
                <input type="number" name="reputationMini" value="<?php if($obj_page->data('editer')) :echo $obj_page->data('item')->getReputationMin();endif;?>"/>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="réputation mini pour acheter l'article"></i>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Item dépendant</label>
            <div class="controls">      
                <select name="dependance">
                    <option value="0">---</option>
                    <?php foreach ($obj_page->data('items') as $item) { ?>
                    <option value="<?php echo $item->getId() ?>" <?php if($obj_page->data('editer')) :if($item->getId()==$obj_page->data('item')->getDependance()){echo "selected='selected'";} endif;?>>
                        <?php echo $item->getId().' - '.$item->getNom() ?></option>
                    <?php } ?>
                </select>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="id de l'item qu'il faut posséder avant de pouvoir obtenir celui ci"></i>
            </div>
        </div>  
        
        <div class="control-group">
            <label class="control-label">Etoiles</label>
            <div class="controls">      
                <select name="etoiles">
                    
                    <option value="0" <?php if($obj_page->data('editer')) :if($obj_page->data('item')->getEtoile()=="0"){echo "selected='selected'";}endif;?>>0</option>
                    <option value="1" <?php if($obj_page->data('editer')) :if($obj_page->data('item')->getEtoile()=="1"){echo "selected='selected'";}endif;?>>1</option>
                    <option value="2" <?php if($obj_page->data('editer')) :if($obj_page->data('item')->getEtoile()=="2"){echo "selected='selected'";}endif;?>>2</option>
                    <option value="3" <?php if($obj_page->data('editer')) :if($obj_page->data('item')->getEtoile()=="3"){echo "selected='selected'";}endif;?>>3</option>
                    <option value="4" <?php if($obj_page->data('editer')) :if($obj_page->data('item')->getEtoile()=="4"){echo "selected='selected'";}endif;?>>4</option>
                </select>
            </div>
        </div>
           
        <div class="control-group">
            <label class="control-label">Liaison</label>
            <div class="controls">      
                <select name="id_liaison" id="select_liaison">
                    <option value="0">---</option>
                    <?php foreach($obj_page->data('tab_liaison') as $row) : ?>
                    <option class="optLiaison" id="<?php echo $row->getId(); ?>" value="<?php echo $row->getId(); ?>" <?php if($obj_page->data('editer')) :if($row->getId()==$obj_page->data('item')->getIdLiaison()){echo "selected='selected'";}endif; ?>>
                        <?php echo $row->getId()." - ".$row->getNomLiaison(); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="lien entre des items. Quand on en obtient 1 les autres sont acquis aussi"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" class="add_liaison btn btn-success" value="+" data-toggle="tooltip" data-original-title="Ajouter une nouvelle liaison">
            </div>
        </div> 
        
        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">
                <div class="input-switch switch-small"  data-on="success" data-off="danger">
                    <input type="checkbox" name="valideArticle" <?php if($obj_page->data('editer')) :if($obj_page->data('item')->getValideArticle() == 1) { echo 'checked="checked"'; }endif; ?>/>
                </div>
            </div>
        </div>     
        <input type="submit" value="<?php if($obj_page->data('editer')) :echo 'Mettre à jour'; else : echo 'Ajouter'; endif;?>" class="btn btn-success" style="margin-left: 40%"/>
    </div>
</form>


<script>
    $(document).ready(function(){
        $("#form_insert_itemb").submit(function( event ) {
            if($("#coutPieces").val()<1 && $("#coutRubis").val()<1)
            {
                alert( "Les champs coût en pièces et/ou coût en rubis ne doivent pas être vide" );
                event.preventDefault();               
            }
        });
        
        $(".add_liaison").click(function(){ 
            var value = prompt("Le nom de la nouvelle liaison :");
            if(value!=null)
            {
                //insert du champs
            $.ajax({
                 type: "GET",
                 url: "index.php?b=6&act=insertLiaison&nom_liaison="+value
             });
                var id = parseInt($(".optLiaison:last").val(),10)+1; 
                d=document.createElement('option');
                $(d).addClass("optLiaison");
                $(d).attr("id", id);
                $(d).text(id+' - '+value);
                $(d).appendTo($("#select_liaison"));
            }
        });
    });
</script>
