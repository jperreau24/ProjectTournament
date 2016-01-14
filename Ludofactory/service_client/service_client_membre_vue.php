<?php foreach($obj_page->data('joueurs') as $row) : ?>
        <li id="user_message" class="user" <?php if ($row['secl']->getDateReponse() == null) : ?>data-value="non_traites" style="background-color:#f2dede;cursor: pointer"<?php else : ?> data-value="traites" style="background-color:#dff0d8;cursor: pointer;" <?php endif; ?>>

        <a id="<?php echo $row['secl']->getIdMembre() ?>" class="select_memb" title="" data-placement="left" style="min-height:0%;word-wrap: break-word;">
            <span class="chat-name" style="color:#666666; width:85%;margin:0"><?php echo $row['membre']->getPrenom() . " " . $row['membre']->getNom() ?>
                <span style="color:green;margin-left:4px;"><?php echo $row['secl']->getIdMembre() ?></span>
            </span> 
            <button class="btn btn-mini btn-info show_user" data-id="<?php echo $row['secl']->getIdMembre() ?>" data-toggle="tooltip" data-original-title="Voir profil" style="float:right">
                <i class="icon-user"></i>
            </button>
            <br>
            <span style="color:grey;font-size:12px"><?php echo $row['membre']->getEmail() ?> </span>
        </a>

    </li>
<?php endforeach; ?>

<script>
    $(".select_memb").click(function(){                                         //appel la vue de la conversation du membre que l'utilisateur a sélectionné
       var value = $(this).attr("id");
       $(".chat-messages").children().remove();
       $(".chat-messages").html('<span class="loader-11"></span> Chargement...');
       $(".chat-messages").load('/?b=8&act=detail_message&id='+value);
       $(".send_reponse").data("id", value);

       $(".user").each(function(){                                         //enléve le bandeau
          $(this).children().first().css({"border-left": "", "font-style":""});
          $(this).children().first().children().first().css({"color":"grey"});
       });

       $("#"+value).css({"border-left":"5px solid orange"});               //ajoute le bandeau du membre sélectionné
       $("#"+value).children().first().css({"color":"black","font-weight":"bold"});
   });   
   
   $(".show_user").click(function(){                                           //affichage du profil d'un membre dans un onglet
        var id=$(this).data('id');
        var url="index.php?b=2&act=fiche&id="+id;
        window.open(url, '_blank');
    });
</script>