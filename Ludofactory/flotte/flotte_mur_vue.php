<table id="mur-datatable" data-id="<?php echo $obj_page->data('id_flotte') ?>" class="table table-striped table-bordered table-hover">
        <thead>
                <tr>
                    <th>Id membre</th>
                    <th>Date</th>
                    <th>Message</th>
                    <th>Valide</th>
                </tr>
        </thead>
        <tbody>
            <?php foreach($obj_page->data('mur') as $row) : ?>           
            <tr>
                <td><a href="<?php echo backoUrl(2,array('act'=>'fiche', 'id'=>$row['obj_mur']->getIdMembre()))?>" target='_blank'><?php echo $row['obj_mur']->getIdMembre();?></a></td>
                <td><?php echo $row['obj_mur']->getDate();?></td>
                <td><?php echo $row['obj_mur']->getMessage();?></td>
                <td class="valide_message" data-id="<?php echo $row['obj_mur']->getId(); ?>"  data-date="<?php echo $row['obj_mur']->getDate(); ?>" value="<?php echo $row['obj_mur']->getValide(); ?>">      
                    <div class="input-switch message_mur switch-mini"  data-on="success" data-off="danger" style="margin-left: 20%">
                        <input type="checkbox" <?php if ($row['obj_mur']->getValide() == '1') { ?>checked<?php } ?>>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
<p>&nbsp;</p>

<script>
    $('#mur-datatable').dataTable({"bPaginate": false,"aaSorting": [[ 1, "desc" ]],'iDisplayLength': 25,"aoColumnDefs": [{"bSortable": false, "aTargets": [0]}]});
    $('.message_mur').bootstrapSwitch();
    $(".valide_message label").click(function() {              //Dans la liste des messages, on update le champs "valide" selon le bouton on/off

        //récupère les valeurs pour l'update
        var id_message=$(this).parents(".valide_message").data('id');
        var valide_message=$(this).parents(".valide_message").attr('value');
        var valide_message_c;          //valeur à mettre à jour
        var date_message=$(this).parents(".valide_message").data('date');
        
        if (valide_message=="0")       //remplace l'ancienne valeur par la nouvelle       
        {
            valide_message="1";
            valide_message_c ="on";
            $(this).parents(".valide_message").attr('value', valide_message); 
        }
        else if (valide_message=="1")
        {
            valide_message="0";
            valide_message_c="off";
            $(this).parents(".valide_message").attr('value', valide_message);
        }
         //update du champs
        var paramAjax = {
                type: "POST",
                url: "index.php?b=29&act=updateValideMessageMur",
                data:"id="+id_message+"&valide="+valide_message_c+"&date="+date_message
            };
            callAjax(paramAjax);
			
    });
    
</script>