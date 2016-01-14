
<h4 class="sub-header">Tournois <?php echo $obj_page->data('type'); ?> terminés <small> listing des derniers tournois </small></h4>
<!-- Datatables inscrits -->
<table id="tab_tournois_historique_<?php echo $obj_page->data('type'); ?>" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="span1">Tournois</th>
            <th>Début</th>
            <th>fin</th>
            <th>Dotation</th>
            <th>Type de tournoi</th>
            <th>Participants</th>
            <th>Chiffre d'affaire</th>
            <th>Payeurs</th>
            <th>Payeurs uniques</th>
            <th>Valide</th>
        </tr>
    </thead>
    <tbody id="">
        <?php foreach($obj_page->data('historique') as $idTournois => $row):

        ?>
        <tr>
            <td ><?php echo $row['tournoi']->getId(); ?></td>
            <td><?php echo $row['tournoi']->getDebut(); ?></td>
            <td><?php echo $row['tournoi']->getFin(); ?></td>
            <td>
                <?php echo $row['dotation'][1]->getNom(); ?>
                <i class="zoom-dodation icon-zoom-in" data-toggle="popover" data-html="true" data-content="<ul><li>2ème : <?php echo $row['dotation'][2]->getNom(); ?></li><li>3ème : <?php echo $row['dotation'][3]->getNom(); ?></li><li>4-7ème : <?php echo $row['dotation'][7]->getNom(); ?></li><li>8-15ème : <?php echo $row['dotation'][15]->getNom(); ?></li></ul>" data-placement="right" title="" data-original-title="1er prix <strong><?php echo $row['dotation'][1]->getNom(); ?></strong>"></i>
            </td>
            <td><?php echo $row['tournoi']->getType(); ?></td>
            <td>
                <?php echo $row['nb_participants']; ?>
                <div class="classement-details btn-group">
                    <a href="#classement-modal" data-type="<?php echo $obj_page->data('type'); ?>" data-tournoi="<?php echo $row['tournoi']->getId(); ?>" data-toggle="modal" title="" class="btn btn-mini btn-info" data-original-title="Détails"><i class="icon-info-sign"></i></a>
                </div>
            </td>
            <td><?php echo $row['ca']['revenues']; ?></td>
            <td><?php echo $row['ca']['nb']; ?></td>
            <td><?php echo $row['ca']['nbUnique']; ?></td>
            <td class="valide_t_<?php echo $obj_page->data('type'); ?>" data-id="<?php echo $row['tournoi']->getId(); ?>" data-type="<?php echo $obj_page->data('type'); ?>" value="<?php echo $row['tournoi']->getValide(); ?>"> 
             <div class="input-switch t_<?php echo $obj_page->data('type'); ?> switch-small "  data-on="success" data-off="danger">
                <input type="checkbox" <?php if ($row['tournoi']->getValide() == '1') { ?>checked <?php } ?>>
            </div>	
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$( document ).ready(function() {
    $(".conteneur_historique_<?php echo $obj_page->data('type') ?>").removeClass('well'); 
    $('i.icon-zoom-in').popover();
    
    $('.valide_t_<?php echo $obj_page->data('type'); ?> .input-switch').bootstrapSwitch();
    
    
    $(".valide_t_<?php echo $obj_page->data('type'); ?> label").click(function() {
	
        //récupère les valeurs pour l'update
        var id_tournoi=$(this).parents(".valide_t_<?php echo $obj_page->data('type'); ?>").data('id');
        var type_tournoi=$(this).parents(".valide_t_<?php echo $obj_page->data('type'); ?>").data('type'); 
        var valide_tournoi=$(this).parents(".valide_t_<?php echo $obj_page->data('type'); ?>").attr('value');
        
        if (valide_tournoi=="0")    //remplace l'ancienne valeur par la nouvelle       
        {
            valide_tournoi="1";
            $(this).parents(".valide_t_<?php echo $obj_page->data('type'); ?>").attr('value', valide_tournoi); 
        }
        else if (valide_tournoi=="1")
        {
            valide_tournoi="0";
            $(this).parents(".valide_t_<?php echo $obj_page->data('type'); ?>").attr('value', valide_tournoi);
        }
         
         //update du champs
       $.ajax({
            type: "GET",
            url: "index.php?b=25&act=update_tournois&id_tournoi="+id_tournoi+"&valide_tournois="+valide_tournoi+"&type_tournoi="+type_tournoi
        });
			
    });
    
});
</script>