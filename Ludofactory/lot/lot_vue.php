    <!-- Navigation info -->
    <ul id="nav-info" class="clearfix">
        <li><a href="index.php"><i class="icon-home"></i></a></li>
        <li class="active"><a href="">Gestion des lots</a></li>
    </ul>
<h3 class="page-header page-header-top">
En attentes
</h3>
<form id="form_valider_lot" style="margin-bottom: 0%" action="<?php echo siteURL(9, array('act'=>'valider_lot'), true) ?>" method="post">
    <table id="tab_lots_non_envoyes" class="table table-striped table-bordered table-hover">
        <thead id="headlot_non_envoyes">
        <tr>
            <th class="span1 text-center" title="" data-toggle="tooltip" data-original-title="Tout cocher!">
            <input id="check1-all" type="checkbox" name="check1-all">
            <th>Nom</th>
            <th>Adresse</th>
            <th>Code Postal</th>
            <th>Ville</th>
            <th>Pays</th>
            <th>item</th>
            <th>Date du gain</th>
            <th>Provenance</th>
        </tr>
       <tbody id="bodylot_non_envoyes">
       <?php foreach($tab_lots as $value) { ?>    
          
        <tr class="<?php echo "tr_".$value['lot']->getId().""; ?>" id="lotgagne_<?php echo $value['lot']->getId(); ?>" >
            <td class="span1 text-center"><input class="ln-check-tab" type="checkbox" name="checkbox[]" value="<?php echo $value['lot']->getId(); ?>"></td>
            <td ><a href="index.php?b=2&act=fiche&id=<?php echo $value['membre']->getId() ?>" target="_blank"><?php echo $tab_titre[$value['membre']->getTitre()].". ".$value['membre']->getNom()." ".$value['membre']->getPrenom(); ?></a>
            <?php if($value['membre']->getEmail()!="") : ?>                    
                <i class="gemicon-small-email" style="float:right" data-content="<?php echo $value['membre']->getEmail(); ?>"  data-placement="right" title="" data-html="true" data-toggle="popover"></i>           
             <?php endif;?>
            </td>
            <td><?php echo $value['membre']->getAdresse(); ?></td>
            <td><?php echo $value['membre']->getCodePostal(); ?></td>
            <td><?php echo $value['membre']->getVille(); ?></td>
            <td><?php echo $value['membre']->getPays(); ?></td>      
            <td class="ln-td-tab" data-id="<?php echo $value['lot']->getId(); ?>"><?php echo $value['item']->getNom(); ?></td>      
            <td><?php echo $value['lot']->getDateGain(); ?></td>
            <td><?php if($value['lot']->getProvenanceNom()=="Tournoi Solo n°"){$type="solo";}
                      else {$type="equipe";}
                echo "".$value['lot']->getProvenanceNom().""
                    . "<a href='".backoUrl(25,array('act'=>'tournois_details', 'id_tournois'=>$value['lot']->getProvenanceNomSupp(), 'type'=>$type))."' target='_blank'>".$value['lot']->getProvenanceNomSupp()."</a>"; ?>
            </td>
        </tr>   

       <?php } ?>

        </tbody>
        </thead>
    </table>
    
    <button type="submit" id="valider_lot" name="valider_lot" style="margin-left:35%;float:left" class="btn btn-primary" onclick="return confirm('Valider les lots ?');">Valider les lots</button>
</form>
<form id="generer_etiquettes" style="margin-bottom: 0%" action="<?php echo siteUrl(9, array('act'=>'generer_etiquettes'), true) ?>" method="post">
    <button type="submit" name="generer_etiquettes" style="margin-left:5%;float:left" class="btn btn-success">Générer les étiquettes</button>
</form>


<h3 style="margin-top:8%" class="page-header">
Envoyés
</h3>
<table id="tab_lots_envoyes" class="table table-striped table-bordered table-hover" >
    <thead>
        <tr>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Code Postal</th>
        <th>Ville</th>
        <th>Pays</th>
        <th>item</th>
        <th>Date du gain</th>
        <th>Provenance</th>
        <th>Date d'envoi</th>
    </tr>
   <tbody>
   <?php foreach($tab_lots_envoyes as $value) { ?>    
    
    <tr>
        <td ><a href="index.php?b=2&act=fiche&id=<?php echo $value['membre']->getId() ?>" target="_blank"><?php echo $tab_titre[$value['membre']->getTitre()].". ".$value['membre']->getNom()." ".$value['membre']->getPrenom(); ?></a>
            <?php if($value['membre']->getEmail()) : ?>                    
               <i class="gemicon-small-email" style="float:right" data-content="<?php echo $value['membre']->getEmail(); ?>"  data-placement="right" title="" data-html="true" data-toggle="popover"></i>           
            <?php endif;?>
        </td>
       <td><?php echo $value['membre']->getAdresse(); ?></td>
       <td><?php echo $value['membre']->getCodePostal(); ?></td>
       <td><?php echo $value['membre']->GetVille(); ?></td>
       <td><?php echo $value['membre']->GetPays(); ?></td>      
       <td><?php echo $value['item']->getNom(); ?></td>      
       <td><?php echo $value['lot']->getDateGain(); ?></td>
       <td><?php if($value['lot']->getProvenanceNom()=="Tournoi Solo n°"){$type="solo";}
                 else {$type="equipe";} 
                echo "".$value['lot']->getProvenanceNom().""
               . "<a href='".backoUrl(25,array('act'=>'tournois_details', 'id_tournois'=>$value['lot']->getProvenanceNomSupp(), 'type'=>$type))."' target='_blank'>".$value['lot']->getProvenanceNomSupp()."</a>"; ?>
       </td>
       <td><?php echo $value['lot']->getDateEnvoi(); ?></td>
    </tr>   
    
   <?php } ?>
  
    </tbody>
    </thead>
</table>
