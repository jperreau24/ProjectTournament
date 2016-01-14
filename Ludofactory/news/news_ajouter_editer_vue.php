<script src="//cdn.ckeditor.com/4.4.1/standard/ckeditor.js"></script>           <!--Pour les textarea-->
<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(10);?>">News</a></li>
    <?php if($obj_page->data('editer')) : ?>
    <li class="active"><a href="javascript:void(0)">Edition</a></li>
    <?php else : ?>
    <li class="active"><a href="javascript:void(0)">Ajouter</a></li>
    <?php endif; ?>
</ul>

<?php if($obj_page->data('editer')) : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Edition d'une news :</h3>
    </div>
</div>
<?php else : ?>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Ajouter une news</h3>
    </div>
</div>
<?php endif; ?>

<form action="<?php if($obj_page->data('editer')) : echo backoUrl(10, array('act'=>'update')); else : echo backoUrl(10, array('act'=>'insert')); endif; ?>" method="post" class="form-horizontal form-box" id="form_insert_news">
    <div class=" form-box form-box-content">
        <?php if($obj_page->data('editer')) : ?>
        <div class="control-group">
            <label class="control-label">Id</label>
            <div class="controls">      
                <input id="" name="id" class="uneditable-input" disabled="" type="text" value="<?php echo $obj_page->data('news')[0]->getId();?>">     
                <input id="" name="id" type="hidden" value="<?php echo $obj_page->data('news')[0]->getId();?>">     
            </div>
            
        </div>
        <?php endif; ?>
        
        <div class="control-group">
            <label class="control-label">Intitulé</label>
            <div class="controls">      
                <input id="" name="intitule" type="text" value="<?php if($obj_page->data('editer')) : echo $obj_page->data('news')[0]->getIntitule();endif;?>">      
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Date d'affichage</label>
            <div class="controls">
                <div class="input-append">       
                    <input id="date_fin" name="date_a" type="text" class="input-append input-datepicker" data-date-format="yyyy-mm-dd" data-date="" value="<?php if($obj_page->data('editer')) : echo $obj_page->data('date_a');endif;?>">
                    <span class="add-on">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
                 <select type="text" name="heure_a" minlength="2" style="margin-left:1%;width:7%" >
                    <?php for($num_heure=0; $num_heure<=23;$num_heure++): ?>
                        <option value="<?php echo ($num_heure < 10)? '0'.$num_heure: $num_heure; ?>" <?php if($obj_page->data('editer')) :if ($obj_page->data('heure_a')== $num_heure) {echo 'selected="selected"';} endif;?>>
                            <?php echo ($num_heure < 10)? '0'.$num_heure: $num_heure; ?>
                        </option>
                    <?php endfor; ?>
                 </select>&nbsp;:&nbsp;
                 <select type="text" name="minute_a" minlength="2" style="width:7%">
                    <?php for($num_minute=0; $num_minute<=59;$num_minute++): ?>
                        <option value="<?php echo ($num_minute < 10)? '0'.$num_minute: $num_minute; ?>" <?php if($obj_page->data('editer')) :if ($obj_page->data('minute_a')== $num_minute) {echo 'selected="selected"';} endif;?>>
                            <?php echo ($num_minute < 10)? '0'.$num_minute: $num_minute; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div> 
        </div>
                 
        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">
                <div class="input-switch switch-small"  data-on="success" data-off="danger">
                    <input type="checkbox" name="valide_news" <?php if($obj_page->data('editer')) : if($obj_page->data('news')[0]->getValide()=='1') { ?>checked <?php } endif;?>/>
                </div>
            </div>
        </div>     
        
        <div class="control-group">
            <label class="control-label">Langue</label>
            <div class="controls">      
                <select class="select_langue" name="langue">
                    <option id="news0"></option>
                    <?php foreach($obj_page->data('langue') as $row) : ?>
                    <option id="<?php echo $row ?>" ><?php echo $row ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="button" class="add_news btn btn-success" value="+" data-toggle="tooltip" data-original-title="Ajouter une news">
            </div>
        </div>
        
        
        <div class="control-group news" style="display:none">
            <label class="control-label"></label>
            <div class="controls">
                <input type="button" class="remove_news btn btn-danger" value="-">&nbsp;
            </div>         
            <div class="controls">            
                <label class="control-label">Titre</label>
                <div class="controls">
                    <input id="titre" name="titre" type="text" value="">
                </div><br><br>
                <label class="control-label"><a class='btn btn-primary switch' data-toggle="tooltip" data-original-title="Textarea/Richtext"><i class='icon-refresh'></i></a> Corps</label>
                <div class="controls text_area_edit">
                    <textarea id="corps" name="corps" type="text" rows="8" style="width:100%" ></textarea>
                </div>
            </div>      
        </div>
        
        <div id="add_champ">
            <?php if($obj_page->data('editer')) : ?>
            <?php foreach($obj_page->data('news') as $key=>$row) : if($obj_page->data('news')[$key]->getLangue()!=null) : ?>
            <div class="news<?php echo $row->getLangue(); ?> control-group newsedit">
                <label class="control-label"><?php echo $row->getLangue(); ?></label>
                <div class="controls">
                    <input data-id="<?php echo $row->getLangue(); ?>" type="button" class="remove_news btn btn-danger" value="-">&nbsp;
                </div>
                <div class="controls">  
                    <label class="control-label">Titre</label>
                    <div class="controls">
                        <input id="titre" name="titre<?php echo $row->getLangue(); ?>" type="text" value="<?php echo $row->getTitre(); ?>">
                    </div><br><br>
                    <label class="control-label"><a class='btn btn-primary switch' data-id="<?php echo $row->getLangue(); ?>" data-toggle="tooltip" data-original-title="Textarea/Richtext"><i class='icon-refresh'></i></a> Corps</label>
                    <div class="controls text_area_edit<?php echo $row->getLangue(); ?>">            
                        <textarea id="corps<?php echo $row->getLangue(); ?>" name="corps<?php echo $row->getLangue(); ?>" type="text" rows="8" style="width:100%" ><?php echo $row->getCorps(); ?></textarea>              
                    </div>
                </div>      
            </div>
            <?php endif;endforeach;endif; ?>
        </div>
         
    </div>
    <input type='submit' class='btn btn-success' style='display:block;margin:auto;' value='<?php if($obj_page->data('editer')) : echo "Mettre à jour"; else : echo "Ajouter"; endif; ?>'/>
</form>

<div id="fb-root"></div>

<script>
    $(document).ready(function(){  
        
  
        $(".newsedit").each(function(){                                         //supprime les options liées aux news déja existantes (mode edition seulement)
            var idClass = $(this).attr("class");
            if(idClass !=null)
            {
                var value=idClass.substring(4,6);
                $(".select_langue").find($("#"+value)).css("display", "none");
                var isFound = $("#corps"+value).val().search(/fb-root/i);
                if(isFound=="-1")
                {
                    createCkeditor(value);
                }
            }
        });
        
        $(".switch").click(function(){
            var value = $(this).data("id");
            
            var id = 'corps'+value; 
           
            
            if($(".text_area_edit"+value).children().first().css("display") == "none")
            {
                CKEDITOR.instances[id].destroy();                               //destruction du ckeditor pour remettre le textarea normal
            }
            else
            {
                createCkeditor(value);                                          //
            }            

        });
        
        $(".add_news").click(function(){           //rajoute une ligne de classement tout en incrémentant les noms des input
            if($("#news0").is(':selected'))
            {
                alert("Choisir une langue");
                                                
            }
            else
            {
                var c = $(".news").clone(true);
                                 
                var value = $(".select_langue option:selected").val();
                $(c).css("display", "inline");
                $(c).removeClass("news").addClass("news"+value);
                $(".select_langue option:selected").css("display", "none");     //enlève la langue choisie du select
                $("#news0").prop("selected", true);                             //met le select sur rien
                
                $(c).children("label").text(value);
                $(c).children().last().children().last().prev().children().attr("data-id", value);
                $(c).children().children().children("input").attr("name", "titre"+value);       //change le nom des champs
                $(c).children().last().children().last().attr("class", "controls text_area_edit"+value);
                $(c).children().children().children("textarea").attr("name", "corps"+value);
                $(c).children().children().children("textarea").attr("id", "corps"+value);      //change l'id pour ckeditor
                $(c).children().children("input").attr("data-id", value);
                
                $("#add_champ").append(c);                                      //on place la nouvelle sur la page
                
                createCkeditor(value);
            }
        });
        
        $(".remove_news").click(function(){                                     //supprime une ligne de classement
            if(confirm("Voulez-vous supprimer cette news ?"))
            {
                var remove_lang_news = $(this).attr("data-id");
                
                $(".news"+remove_lang_news).remove();
                $("#"+remove_lang_news).css("display","block");
            }
        });
        
        function createCkeditor(elt)                                            //remplace la textarea basique par une textarea editor
        {                                                                      
           CKEDITOR.replace( 'corps'+elt,  {                               
                toolbar :                                                       //configuration de la toolbar des textarea
                [
                    { name: 'document', items : [ 'Source' ] },
                    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                    { name: 'clipboard', items : [ 'Undo','Redo' ] },                      
                    { name: 'insert', items : [ 'Image' ] },                                                                                                      
                    { name: 'styles', items : [ 'Format','Font','FontSize' ] },
                    { name: 'colors', items : [ 'TextColor','BGColor' ] },
                    { name: 'paragraph', items : [ 'BulletedList'] },
                    { name: 'links', items : [ 'Link','Unlink'] },
                    { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
                ],
                enterMode : CKEDITOR.ENTER_BR,
                customConfig: ''
            });
        }
    });
</script>