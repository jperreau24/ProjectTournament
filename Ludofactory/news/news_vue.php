<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li class="active"><a href="javascript:void(0)">News</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Gestion des News</h3>
    </div>
</div>

<form action="<?php echo backoUrl(10, array('act'=>'ajouter')) ?>" method="post">
    <input type="submit" class="btn btn-success" value="Ajouter une news"/>
</form>

<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-info" style="margin-top:1%;margin-bottom: 0%;"><?php echo $flashdata ?></p>
    <?php endif; ?><br>

<table id="tab_news" class="table table-striped table-bordered table-hover">
    <thead>
    <th></th>
    <th>Id</th>
    <th>Intitule</th>
    <th>Date</th>
    <?php foreach($obj_page->data('langue') as $row) :?>
    <th><?php echo $row ?></th>
    <?php endforeach; ?>
    <th>Valide</th>
    </thead>
    <tbody>
        <?php foreach($obj_page->data('news') as $row) :?>
        <tr id="<?php echo $row['id'] ?>">
            <td style="width:1%"><a class="btn btn-mini btn-success btn-edit-mb" data-original-title="Modifier" href="<?php echo backoUrl(10, array('act'=>'detail', 'id'=>$row['id'])) ?>">
                <i class="icon-pencil"></i></td>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['intitule']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <?php foreach($obj_page->data('langue') as $value) :?>
             <td style="text-align: center"><?php if(isset($row[$value])) : ?><i class="icon-ok" style="color:green" data-toggle="popover" data-html="true" data-width="80%" data-original-title="<?php echo $row[$value]['titre']; ?>" data-content='<?php if(preg_match("/'/",$row[$value]['corps'])) : echo str_replace("'","\"",$row[$value]['corps']); else : echo $row[$value]['corps']; endif; ?>' data-placement="top" title=""></i>
            <?php endif;?></td>
            <?php endforeach; ?>  
            <td class="valide_news" data-id="<?php echo $row['id']; ?>" value="<?php echo $row['valide']; ?>">                    
                <div class="input-switch news_<?php echo $row['id']; ?> switch-mini "  data-on="success" data-off="danger" style="margin-left: 20%">
                    <input type="checkbox" <?php if ($row['valide'] == '1') { ?>checked <?php } ?>>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>

<script>
    $(document).ready(function(){
       
        $("#tab_news").dataTable({"aaSorting": [[ 1, "desc" ]]});
        
        $(".valide_news label").click(function() {              //Dans la liste des newss boutique, on update le champs "valide" selon le bouton on/off

        //récupère les valeurs pour l'update
        var id_news=$(this).parents(".valide_news").data('id');
        var valide_news=$(this).parents(".valide_news").attr('value');
        var valide_news_c;          //valeur à mettre à jour
        if (valide_news=="0")       //remplace l'ancienne valeur par la nouvelle       
        {
            valide_news="1";
            valide_news_c ="on";
            $(this).parents(".valide_news").attr('value', valide_news); 
        }
        else if (valide_news=="1")
        {
            valide_news="0";
            valide_news_c="off";
            $(this).parents(".valide_news").attr('value', valide_news);
        }
         //update du champs
       $.ajax({
            type: "GET",
            url: "index.php?b=10&act=updateValideListe&id="+id_news+"&valideNews="+valide_news_c
        });
			
    });
        
    });
</script>
