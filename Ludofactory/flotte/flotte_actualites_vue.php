<table id="actualites-datatable" data-id="<?php echo $obj_page->data('id_flotte') ?>" class="table table-striped table-bordered table-hover">
        <thead>
                <tr>
                    <th>Id membre</th>
                    <th>Date</th>
                    <th>Détails</th>
                </tr>
        </thead>
        <tbody>
            <?php foreach($obj_page->data('actualites') as $row) : ?>           
            <tr>
                <td><a href="<?php echo backoUrl(2,array('act'=>'fiche', 'id'=>$row["id_capitaine"]))?>" target='_blank'><?php echo $row["id_capitaine"];?></a></td>
                <td><?php echo $row["date"];?></td>
                <td><?php echo $row["texte"];?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
<p>&nbsp;</p>

<script>
    $('#actualites-datatable').dataTable({
        "aaSorting": [[ 1, "desc" ]]
    });
    
</script>