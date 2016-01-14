<ul>
    <?php foreach($obj_page->data('messages') as $row) :?>
    <li class="chat-msg-right" data-id="<?php echo $row['secl']->getId(); ?>" style="<?php if($row['secl']->getValide()=='0') : ?>;min-height:0;padding:0px 0px 0px 10px<?php endif; ?>">
        
       
        <span class="label label-success chat-msg-time">
            <em><?php echo $row['secl']->getDate(); ?></em>
            by
            <em><?php echo $row['membre']->getPrenom(); ?></em>
        </span>
        <span class="questvalide" data-id="<?php echo $row['secl']->getId(); ?>" value="<?php echo $row['secl']->getValide(); ?>" >
            <div class="input-switch switch-mini" data-on="success" data-off="danger">
                    <input type="checkbox" name="valide_message" <?php if($row['secl']->getValide()=='1') { ?>checked <?php } ?>/>
                </div>
        </span>
        
        <img <?php if($row['secl']->getValide()=='0') :?> style="display:none"<?php endif; ?> alt="avatar" src="<?php echo Config::get('url_site_img') ?>commun/vignette_ami_neutre.jpg">
        
        <span class="questsujet" style=" font-weight:bold;">
            <?php foreach($obj_page->data('sujet') as $key=>$value) : 
            if($key==$row['secl']->getSujet()-1) 
            {
                echo $value;
            }
            endforeach; ?>
        </span> 
        <div style="clear:both"></div>
        <p <?php if($row['secl']->getValide()=='0') :?> style="display:none"<?php endif; ?>><?php echo $row['secl']->getQuestion() ?></p>
    </li>
    
    <?php if($row['secl']->getReponse()!=null) :?>
    <li class="chat-msg-left" >
        <span class="label label-inverse chat-msg-time">
            <em><?php echo $row['secl']->getDateReponse() ?></em>
            by
            <em>Tooki Island</em>
        </span>
        <img alt="avatar" src="<?php echo Config::get('url_site_img') ?>commun/logo_135.png">
        <p><?php echo nl2br($row['secl']->getReponse()); ?></p>
    </li>
    <?php endif;endforeach; ?>
</ul>
<script> 
    $(document).ready(function(){
        $('.questvalide .input-switch').bootstrapSwitch(); 
        
        $(".chat-msg-right").click(function(){
            
            if($(this).attr("id")=="selected" || $(this).children(".questvalide").attr("value")==0)     //désélectionne une question
            {
                $(this).css({"background-color": "#db4a39", "color": "#fff"});
                $(this).attr("id", "");
            }
            else
            {
                $(".send_reponse").text("Envoyer");                             
                $(".chat-msg-right").attr("id", "");                            //désélectionne toutes les questions
                $(".chat-msg-right").css({"background-color": "#db4a39", "color": "#fff"});    
                $(this).css({"background-color": "#fcf8e3", "color": "red"});
                $(this).attr("id", "selected");                                 //sélectionne la question choisie
                $("#chat-message").focus();                                     //focus le textarea
            }
        });
        
        $(".questvalide label").click(function() {
  
            var id = $(this).parents(".questvalide").data("id");
            var valide_message = $(this).parents(".questvalide").attr("value");
            var valide_message_t;
            if (valide_message=="0")    //remplace l'ancienne valeur par la nouvelle       
            {
                valide_message="1";
                valide_message_t="on";
                $(this).parents(".questvalide").attr('value', valide_message);

                $(this).parents("li").children("img").show();                       //modifie l'apparence du li
                $(this).parents("li").children("p").show();
                $(this).parents("li").css({"min-height": "55px","padding": "10px 55px 20px 10px"});
            }
            else if (valide_message=="1")
            {
                valide_message="0";
                valide_message_t="off";
                $(this).parents(".questvalide").attr('value', valide_message);

                $(this).parents("li").children("img").hide();                       //modifie l'apparence du li
                $(this).parents("li").children("p").hide();
                $(this).parents("li").css({"min-height": "0","padding": "0px 0px 0px 10px"});
            }
             //update du champs	
            var paramAjax = {
                type: "GET",
                url: "index.php?b=8&act=update_valide&id="+id+"&valide_message="+valide_message_t
                };
                callAjax(paramAjax);  
        });
        
        $( '.chat-messages' ).scrollTop( 9999 );                                //place la scrollbar tout en bas de la conversation
    });
</script>