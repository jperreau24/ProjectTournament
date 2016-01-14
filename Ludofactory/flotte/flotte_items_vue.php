<?php if(sizeof($obj_page->data('items'))==0) : echo "Aucun Item"; 
    else :  ?>
<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-info" style="margin-top:1%;margin-bottom: 0%;"><?php echo $flashdata ?></p>
<?php endif; ?> 
<table class="table table-striped table-bordered table-hover" id="tab_item_flotte" data-id="<?php echo $obj_page->data('flotte')->getId(); ?>">
        <thead>
        <tr>
            <th style="display:none"></th>
            <th>Id</th>
            <th>Nom</th>
        </tr>
        </thead>
        <tbody >

            <?php foreach($obj_page->data('items') as $row) :?>
            <?php foreach($row as $value) :?>
            <tr id="<?php echo $value->getId() ?>">
                <td style="display: none"><?php echo $value->getId();?></td>
                <td><a href="<?php echo backoUrl(3,array('act'=>'detail', 'id'=>$value->getId()))?>" target='_blank'><?php echo $value->getId();?></a></td>
                <td><?php echo $value->getNom();?></td>
            </tr>
            <?php endforeach;endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
 <input type="button" class="btn btn-success" id="ajout_item_flotte" style="margin:auto;display:block" value="Ajouter un item" />


<script>
    $("#tab_item_flotte").dataTable({"aaSorting": [[ 0, "desc" ]]});    
    
    $("#ajout_item_flotte").click(function(){
        var id_item = parseInt(prompt("l'id de l'item à ajouter :"));
        var id_flotte = $("#tab_item_flotte").data("id");
       
        if(id_item != "" && id_item !=null && !isNaN(id_item))
        {     
            var paramAjax = {
            type: 'POST',
            url: 'index.php?b=29&act=ajout_item_flotte',
            data: 'id='+id_flotte+'&id_item='+id_item,
                success: function(retour) {
                    $("#item_flotte").load('/?b=29&act=liste_items_flotte&id='+id_flotte, 
                    function() {
                        $(this).fadeIn(5000);           // rafraichissement de la vue
                    });
                }
            };
            callAjax(paramAjax);
        }
        else if(id_item !=null)
        {
            alert("Aucun item n'a été choisi");
        }
                    
    });
</script>