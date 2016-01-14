<div id="classement<?php echo $obj_page->data('id') ?>">
    <button id="hide_classement-<?php echo $obj_page->data('id') ?>" class="btn btn-small btn-info" style='float:right;margin-top: -1%' data-value="<?php echo $obj_page->data('id') ?>"><i class="icon-info-sign"></i></button>   
    <br>
     <div id="hide_table-<?php echo $obj_page->data('id') ?>">
        <?php if ($obj_page->data('modele')) : ?>
       
            <table class="table table-bordered table-hover" id="tab_dotation_modele-<?php echo $obj_page->data('id') ?>">
                <thead>
                    <tr>
                        <th style="text-align:center;width:2%"></th>
                        <th style="text-align:center;width:5%">Classement</th>
                        <th style="text-align:center">Gain Principal</th>
                        <th style="text-align:center">Gain Secondaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($obj_page->data('tab_classement') as $row) : ?>
                        <tr id="row<?php echo $obj_page->data('id') . $row['domo']->getClassement() ?>" class="row_domo<?php echo $obj_page->data('id') ?>" data-value="<?php echo $row['domo']->getClassement() ?>">
                            <td>
                                <button id="delRow<?php echo $row['domo']->getClassement() ?>" value="<?php echo $row['domo']->getClassement() ?>" class="btn btn-mini btn-danger delRow<?php echo $obj_page->data('id') ?>"><i class="icon-remove"></i></button>
                            </td>
                            <th><?php
                                if ($row['domo']->getClassement() == 1) :
                                    echo $row['domo']->getClassement() . "er";
                                else :
                                    echo $row['domo']->getClassement() . "e";
                                endif;
                                ?> 
                            </th>
                            <td class='editable-td' data-id="<?php echo $obj_page->data('id') ?>" data-value="<?php echo $row['domo']->getClassement() ?>" data-type="principal">
                                <?php if($row['domc']->getId()!=null){ echo $row['domc']->getNom() . " (<b style='color:green'>" . $row['domc']->getId() . "</b>)";} ?></td>
                            <td class='editableGS-td' data-id="<?php echo $obj_page->data('id') ?>" data-value="<?php echo $row['domo']->getClassement() ?>" data-type="secondaire"><?php echo $row['domo']->getIdgain2() ?></td>
                        </tr>
                <?php endforeach; ?>
                </tbody> 
            </table>
         <br>
            <button id="addRow<?php echo $obj_page->data('id') ?>" class="btn btn-success addRow"><i class="icon-plus"> Ajouter une ligne</i></button>

        <?php else : ?>
                <table class="table table-bordered table-hover" id='tab_dotation_class-<?php echo $obj_page->data('id') ?>'>
                    <thead>
                        <tr>
                            <th style="text-align:center">Classement</th>
                            <th style="text-align:center">Gain Principal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($obj_page->data('tab_classement') as $row) : ?>
                            <tr>
                                <th><?php
                                    if ($row['dota']->getClassement() == 1) :
                                        echo $row['dota']->getClassement() . "er";
                                    else :
                                        echo $row['dota']->getClassement() . "e";
                                    endif; ?>
                                </th>
                                <td><?php echo $row['item']->getNom() . " (<b style='color:green'>" . $row['item']->getId() . "</b>)"; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>                                            
            </table>
            <?php endif; ?>   
    </div>
</div>


<script>
      $("#hide_classement-<?php echo $obj_page->data('id') ?>").click(function() {  //show ou hide le classement
            var value=$(this).data('value');
           // alert('ok');
            
            $("#hide_table-"+value).slideToggle();
        });
        
        $("#addRow<?php echo $obj_page->data('id') ?>").click(function() {            // ajoute une ligne de classement

            var value_classement = prompt("La position max du classement :", $(".row_domo<?php echo $obj_page->data('id') ?>:last").data('value') + 1);     // demande à l'utilisateur le classement
            if (value_classement != null)
            {
                if ($("#row<?php echo $obj_page->data('id') ?>" + value_classement).length)    // vérifie que la nouvelle ligne souhaitée n'existe pas déja
                {
                    alert("La ligne de classement "+ value_classement +" que vous souhaitez ajouter existe déja");

                }
                else
                {
                    // créer la nouvelle ligne de classement
                    $.ajax({
                        type: "GET",
                        url: "index.php?b=12&act=insert_modele_classement&id=<?php echo $obj_page->data('id') ?>&classement=" + value_classement,
                        success:
                            function(retour) {
                                $('#classement<?php echo $obj_page->data('id') ?>').load('index.php?b=12&act=classement_modele&id=<?php echo $obj_page->data('id') ?>', 
                                    function() {
                                        $(this).fadeIn(5000); // rafraichissement de la vue
                                    });
                            }
                    });

                }
            }

        });


        $(".delRow<?php echo $obj_page->data('id') ?>").click(function() {
            var value_classement = $(this).attr('value');
            var id_domo = <?php echo $obj_page->data('id') ?>;

            if (confirm('Supprimer cette ligne ?') == true)    // demande de confirmation à l'utilisateur avant de supprimer la ligne
            {
                //delete du champ
                $.ajax({
                    type: "GET",
                    url: "index.php?b=12&act=delete_modele&id=" + id_domo + "&classement=" + value_classement,
                    success:
                        function(retour) {
                            $('#classement<?php echo $obj_page->data('id') ?>').load('index.php?b=12&act=classement_modele&id=<?php echo $obj_page->data('id') ?>',
                                function() {
                                    $(this).fadeIn(5000);  // rafraichissement de la vue
                                }); 
                            }
                });
            }
        });

        //édition de la table modele
        $(function() {
            var DomoTable = $('#tab_dotation_modele-<?php echo $obj_page->data('id') ?>');
            var reqHandle = function(value, settings) {
                
                //Update du champ séléctionné
                if ($(this).data('type') == "principal")
                {
                    $.post("/?b=12&act=update_modele", {id: $(this).data('id'), classement: $(this).data('value'), idgain: value});
                    $('#classement<?php echo $obj_page->data('id') ?>').load('index.php?b=12&act=classement_modele&id=<?php echo $obj_page->data('id') ?>',
                            function() {
                                $(this).fadeIn(5000);  // rafraichissement de la vue
                            });
                    return ''; //valeur affichée avant le rechargement de la vue
                }
                else if ($(this).data('type') == "secondaire")
                {
                    $.post("/?b=12&act=update_modele", {id: $(this).data('id'), classement: $(this).data('value'), idgain2: value});
                    $('#classement<?php echo $obj_page->data('id') ?>').load('index.php?b=12&act=classement_modele&id=<?php echo $obj_page->data('id') ?>',
                            function() {
                                $(this).fadeIn(5000);  // rafraichissement de la vue
                            });
                    return ''; //valeur affichée avant le rechargement de la vue
                }


            };

            var initEditable = function(rowID) {                                // pour éditer le champ gain principal

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
                    loadurl: '/?b=12&act=domo_tabGain_json',                        //récupère les données pour le select
                    type: 'select',
                    cssclass: 'remove-margin',
                    submit: 'Modifier',
                    cancel: 'Annuler'
                });
            };

            var initEditableGainSec = function(rowID) {                         // pour éditer le champ gain secondaire

                var elements;

                if (!rowID)
                    elements = $('td.editableGS-td', editableTable.fnGetNodes());
                else
                    elements = $('td.editableGS-td', editableTable.fnGetNodes(rowID));

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
                    loadurl: '/?b=12&act=domo_tabGainSec_json',                 //récupère les données pour le select
                    type: 'select',
                    cssclass: 'remove-margin',
                    submit: 'Modifier',
                    cancel: 'Annuler'
                });
            };

            var editableTable = DomoTable.dataTable({
                "bPaginate": false,
                "bInfo": false,
                "bScrollCollapse": false,
                "aaSorting": [[0, 'desc']],
                "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]
                    }]
            });
            
            initEditable();
            initEditableGainSec();
            
            $(".row-fluid").hide();

        });
</script>