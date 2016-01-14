<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(12);?>">Dotation</a></li>
    <li class="active"><a href="javascript:void(0)">Critère</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Gestion des critères de modèle de dotations</h3>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <h4>Liste des critères de modèle de dotation</h4>
    </div>
</div>
<form action='<?php echo backoUrl(12,array('act'=>'ajouter_critere')); ?>' method='POST' style="float:left">
    <input type='submit' name='add_domc' class='btn btn-success' value='Ajouter un critère'/>
</form>
<form action='<?php echo backoUrl(12,array('act'=>'liste_modele')); ?>' method='POST' style="float:left;margin-left:1%">
    <input type='submit' name='domc' class='btn btn-success' value='Voir les modèles'/>
</form>

<div style="clear: both"></div>

<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-info"><?php echo $flashdata ?></p>
<?php endif; ?>

<table id='tab_liste_domc' class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Description</th>
            <th data-toggle="tooltip" data-original-title="1 : items prédéfinis en choisira 1 seul en random, 2 : critères de sélection de pièces de bateau">type</th>
            <th data-toggle="tooltip" data-original-title='exemple : {"type":10,"min":301,"max":400} OU 1845'>data</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($obj_page->data('tab_domc') as $row) :?>
        <tr id="<?php echo $row->getId() ?>">
            <td><a class="btn btn-mini btn-success btn-edit-mb" data-toggle="tooltip" data-original-title="Modifier" href="index.php?b=12&act=editer_critere&id=<?php echo $row->getId() ?>">
                    <i class="icon-pencil"></i></a></td>
            <td><?php echo $row->getId() ?></td>
            <td class='editable-td' data-id='<?php echo $row->getId(); ?>' data-description='<?php echo $row->getDescription(); ?>' data-type='<?php echo $row->getType(); ?>' data-data='<?php echo $row->getData(); ?>'><?php echo $row->getDescription() ?></td>
            <td class='editable-td' data-id='<?php echo $row->getId(); ?>' data-description='<?php echo $row->getDescription(); ?>' data-type='<?php echo $row->getType(); ?>' data-data='<?php echo $row->getData(); ?>'><?php echo $row->getType() ?></td>
            <td class='editable-td' data-id='<?php echo $row->getId(); ?>' data-description='<?php echo $row->getDescription(); ?>' data-type='<?php echo $row->getType(); ?>' data-data='<?php echo $row->getData(); ?>'><?php if(is_array($row->getData())) :?>
                {<?php foreach($row->getData() as $key=>$value) : echo '"'.$key.'":'.$value; if($key!="max"){echo ",";} endforeach; ?>}<?php else : echo $row->getData();  endif; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
$(document).ready(function(){
        
        
        $(function() {
            var DomcTable = $("#tab_liste_domc");
            var reqHandle = function(value, settings) {
                console.log(settings);
                var aPos = editableTable.fnGetPosition(this);  
                if(aPos[1]=="2")
                {
                    $(".editable-td").data('description', value); 
                    //update du champ sélectionné
                    $.post("/?b=12&act=update_critere", {id: $(this).data('id'),description: $(this).data('description')});
                }
                else if
                (aPos[1]=="3")
                {
                    $(".editable-td").data('type', value);
                    //update du champ sélectionné
                    $.post("/?b=12&act=update_critere", {id: $(this).data('id'),type: $(this).data('type')});
                }
                else if
                (aPos[2]=="4")
                {
                    $(".editable-td").data('data', value);
                    //update du champ sélectionné
                    $.post("/?b=12&act=update_critere", {id: $(this).data('id'),data: $(this).data('data')});
                }
            
                 return value; //valeur affichée avant le rechargement de la page
                
            };
        
          var initEditable = function(rowID) {                                

                var elements;

                if (!rowID)
                    elements = $('td.editable-td', editableTable.fnGetNodes());
                else
                    elements = $('td.editable-td', editableTable.fnGetNodes(rowID));
                elements.editable(reqHandle, {
                    "callback": function(sValue, y) {

                        var aPos = editableTable.fnGetPosition(this);           //trouve quelle cellule a été changée
                        editableTable.fnUpdate(sValue, aPos[0], aPos[1]);


                    },
                    "submitdata": function(value, settings) {
                        return {
                            "row_id": this.parentNode.getAttribute('id'),
                            "column": editableTable.fnGetPosition(this)[2]
                        };
                    },
                    //loadurl: '/?b=12&act=domo_tabGain_json', //récupère les données pour le select
                   
                    cssclass: 'remove-margin',
                    submit: 'Modifier',
                    cancel: 'Annuler'
                });
            };

            var editableTable = DomcTable.dataTable({"aaSorting": [[ 1, "desc" ]]});

            initEditable();
        });


    });
</script>