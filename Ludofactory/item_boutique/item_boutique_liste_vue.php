<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li ><a href="<?php echo backoUrl(6) ?>">Boutique</a></li>
    <li class="active"><a href="javascript:void(0)">Liste</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Liste des items de la boutique</h3>
    </div>
</div>

<form action="<?php echo backoUrl(6, array('act'=>'ajouter')); ?>" method="post" style="float:left;">
    <input type="submit" class="btn btn-success" value="Ajouter un nouvel item boutique" />
</form>

<form action="<?php echo backoUrl(6, array('act'=>'listeCategories')); ?>" method="post" style="float:left;margin-left:1%">
    <input type="submit" class="btn btn-success" value="Liste catégories boutique" />
</form>

<form action="<?php echo backoUrl(6, array('act'=>'ajouterCategorie')); ?>" method="post" style="float:left;margin-left:1%">
    <input type="submit" class="btn btn-success" value="Ajouter une nouvelle catégorie" />
</form>
<div style="clear:both"></div>


<input class='btn btn-info search' value='recherche avancée' type='button'><br>
<?php if(!is_null($flashdata = getFlashData('message'))): ?>
<p class="flash_message alert alert-info" style="margin-top:1%;margin-bottom: 0%;"><?php echo $flashdata ?></p>
    <?php endif; ?><br>

<form class="form-horizontal form-box form_itemb_search" action="<?php echo backoUrl(6, array("act" => "liste")); ?>" method="post" style="display:none">
    <h4 class="form-box-header">Rechercher un item de la boutique par :</h4>
    <div class="form-box-content">

        <!-- Id Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id</label>
            <div class="controls">
                <input type="text" name="itemb_id" id="example-input-inline" class="input-large" placeholder="Id">
            </div>
        </div>
        
        <!-- Name Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Nom</label>
            <div class="controls">
                <input type="text" name="itemb_name" id="example-input-inline" class="input-large" placeholder="Nom">
            </div>
        </div>
        
        <!-- Type Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Catégorie</label>
            <div class="controls">
                 <select name="itemb_categorie" class="input-large">
                     <option value="0">Tout</option>
                    <?php foreach($obj_page->data('categories') as $row) : ?>                  
                        <option value="<?php echo $row->getId(); ?>"><?php echo $row->getId()." - ".$row->getNom();  ?></option>  
                    <?php endforeach; ?>                    
                </select>
            </div>
        </div>
        
        <div class="form-actions">
            <input type="submit" class="btn btn-success btn_item_recherche" value="Rechercher">
        </div>
    </div>
</form>

<div>
    <table class="table table-striped table-bordered table-hover" id="tab_bouc">
        <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Nom</th>
            <th>Type</th>
            <th>Catégorie</th>
            <th data-toggle="tooltip" data-original-title="img.../items/boutique/">Image</th>
            <th>Cout or</th>
            <th>Cout Rubis</th>
            <th data-toggle="tooltip" data-original-title="niveau d'xp mini pour acheter l'article">Niveau mini</th>
            <th data-toggle="tooltip" data-original-title="réputation mini pour acheter l'article">Reputation mini</th>
            <th data-toggle="tooltip" data-original-title="id de l'item qu'il faut posséder avant de pouvoir obtenir celui ci">Dependance</th>
            <th>Etoile</th>
            <th data-toggle="tooltip" data-original-title="lien entre des items. Quand on en obtient 1 les autres sont acquis aussi">Lien</th>
            <th>Valide</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($obj_page->data('items') as $item_boutique) : ?>
        <tr id='<?php echo $item_boutique->getId() ?>'>
            <td><a class="btn btn-mini btn-success btn-edit-mb" data-toggle="tooltip" data-original-title="Modifier" href="<?php echo backoUrl(6, array('act'=>'detail', 'id'=>$item_boutique->getId())) ?>">
                    <i class="icon-pencil"></i></td>
            <td><a href="<?php echo backoUrl(3,array('act'=>'detail', 'id'=>$item_boutique->getId()))?>" target="_blank"><?php echo $item_boutique->getId() ?></a></td>
            <td><?php echo $item_boutique->getNom() ?></td>
            <td data-toggle="tooltip" data-original-title="<?php   if($item_boutique->getType() == 0){echo "autre";}
                        else if ($item_boutique->getType() == 1) {echo "énergie";}
                        else if ($item_boutique->getType() == 2) {echo "énergie max";}
                        else if ($item_boutique->getType() == 3) {echo "pièces d'or max";}
                        else if ($item_boutique->getType() == 4) {echo "pièce d'or";}
                        else if ($item_boutique->getType() == 5) {echo "niveau equipage bateau";}
                        else if ($item_boutique->getType() == 6) {echo "expérience";}
                        else if ($item_boutique->getType() == 7) {echo "flotte";}
                        else if ($item_boutique->getType() == 8) {echo "lot";}
                        else if ($item_boutique->getType() == 9) {echo "générique flotte";}
                        else if ($item_boutique->getType() == 10){echo "cabine arrière du bateau";}
                        else if ($item_boutique->getType() == 11){echo "coque du bateau";}
                        else if ($item_boutique->getType() == 12){echo "voile centrale du bateau";}
                        else if ($item_boutique->getType() == 13){echo "canon du bateau";}
                        else if ($item_boutique->getType() == 14){echo "proue du bateau";}
                        else if ($item_boutique->getType() == 15){echo "ancre du bateau";}
                        else if ($item_boutique->getType() == 16){echo "ornement du bateau";}
                        else if ($item_boutique->getType() == 17){echo "rambarde du bateau";}
                        else if ($item_boutique->getType() == 18){echo "cabine avant du bateauu";}
                        else if ($item_boutique->getType() == 19){echo "escalier du bateau";}
                        else if ($item_boutique->getType() == 20){echo "pavillon du bateau";}
                        else if ($item_boutique->getType() == 21){echo "vigie du bateau";}
                        else if ($item_boutique->getType() == 22){echo "voile arrière du bateau";}
                        else if ($item_boutique->getType() == 23){echo "voile avant du bateau";}
                        else if ($item_boutique->getType() == 24){echo "item qui ne fait qu'ajouter de la réputation";}
                        ?>">
                <?php echo $item_boutique->getType() ?>
            </td>
            <td data-toggle="tooltip" data-original-title="<?php foreach($obj_page->data('categories') as $row): 
                if($row->getId()==$item_boutique->getIdCategorieBoutique()) : echo $row->getNom();
                endif;endforeach;?>">
                <?php echo $item_boutique->getIdCategorieBoutique() ?>
            </td>
            <td><?php echo $item_boutique->getImage() ?></td>
            <td><?php echo $item_boutique->getCoutPieces() ?></td>
            <td><?php echo $item_boutique->getCoutRubis() ?></td>
            <td><?php echo $item_boutique->getNiveauMin() ?></td>
            <td><?php echo $item_boutique->getReputationMin() ?></td>
            <td><?php echo $item_boutique->getDependance() ?></td>
            <td><?php echo $item_boutique->getEtoile() ?></td>
            <td><?php echo $item_boutique->getIdLiaison() ?></td>
            <td class="valide_item_boutique" data-id="<?php echo $item_boutique->getId(); ?>" value="<?php echo $item_boutique->getValideArticle(); ?>">                    
                <div class="input-switch item_<?php echo $item_boutique->getId(); ?> switch-mini "  data-on="success" data-off="danger" style="margin-left: 20%">
                    <input type="checkbox" <?php if ($item_boutique->getValideArticle() == '1') { ?>checked <?php } ?>>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
            </tbody>
    </table>
</div>

<script>
$(document).ready(function(){
        $(".search").click(function(){
            $(".form_itemb_search").slideToggle();
        });
        
        var rowCount = $('#tab_bouc tr').length;    //détermine si on utilise datatable ou non selon le nombre de lignes retournées
        if(rowCount<2)                                 //pour éviter une temps de chargement trop long
        {
            $(".form_itemb_search").fadeIn();           // affichage du formulaire de recherche si aucun résultat
        }
        else if(rowCount<=100)                             
        {
            
            $('#tab_bouc').dataTable({"iDisplayLength": 50,"aaSorting": [[ 0, "desc" ]]});
        }
       
        $(".valide_item_boutique label").click(function() {              //Dans la liste des items boutique, on update le champs "valide" selon le bouton on/off

        //récupère les valeurs pour l'update
        var id_item=$(this).parents(".valide_item_boutique").data('id');
        var valide_item=$(this).parents(".valide_item_boutique").attr('value');
        var valide_item_c;          //valeur à mettre à jour
        if (valide_item=="0")       //remplace l'ancienne valeur par la nouvelle       
        {
            valide_item="1";
            valide_item_c ="on";
            $(this).parents(".valide_item_boutique").attr('value', valide_item); 
        }
        else if (valide_item=="1")
        {
            valide_item="0";
            valide_item_c="off";
            $(this).parents(".valide_item_boutique").attr('value', valide_item);
        }
         //update du champs
       $.ajax({
            type: "GET",
            url: "index.php?b=6&act=updateValideListe&id="+id_item+"&valideArticle="+valide_item_c
        });
			
    });

    });
</script>