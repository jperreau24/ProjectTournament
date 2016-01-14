<!-- Navigation info -->
<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(25, array('act' => 'listing_en_cours')) ?>">Tournois</a></li>
    <li class="active"><a href="javascript:void(0)">Détails</a></li>
</ul>
<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Tournoi <?php echo $http_request['type'] . " n°" . $http_request['id_tournois']; ?></h3>
    </div>
</div>


<form action="index.php?b=25&act=update_tournois&id_tournoi=<?php echo $obj_page->data('tournois')->getId(); ?>&type_tournoi=<?php echo $http_request['type']; ?>" method="post" class="form-horizontal form-box">
    <div class=" form-box form-box-content">
        <div class="control-group">
            <label class="control-label">Identifiant</label>
            <div class="controls">      
                <input id="" class="uneditable-input" disabled="" type="text" value="<?php echo $obj_page->data('tournois')->getId(); ?>">
            </div>
        </div>

         <div class="control-group">
            <label class="control-label">Dotation</label>
            <div class="controls">
                <input id="" class="uneditable-input" disabled="" type="text" value="<?php echo $obj_page->data('tournois')->getIdDotation(); ?>">
            </div>
        </div>
        
         <div class="control-group">
            <label class="control-label">Dotation Modèle</label>
            <div class="controls">
                <select id="domo" name="domo" type="text" >
                    <?php foreach($tab_dotation_modele as $value){?>
                    <option value="<?php echo $value['domo']->getId(); ?>" <?php if ($obj_page->data('tournois')->getIdDotationModele() == $value['domo']->getId()) {echo 'selected="selected"';}?>>
                    <?php echo $value['domo']->getId()." - ".$value['domc']->getDescription(); ?></option>
                    <?php } ?>
                </select>    
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Réputation minimum</label>
            <div class="controls">
                <input id="reputation_min" name="reputation_min" type="text" value="<?php echo $obj_page->data('tournois')->getReputationMin(); ?>" required="required">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Coût en énergie</label>
            <div class="controls">
                <input id="cout_energie" name="cout_energie" type="text" value="<?php echo $obj_page->data('tournois')->getCoutEnergie(); ?>" required="required">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Date de début</label>
            <div class="controls">
                <input id="date_debut" name="date_debut" class="uneditable-input" type="text" disabled="" value="<?php echo $obj_page->data('tournois')->getDebut(); ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Date de fin</label>
            <div class="controls">
                <div class="input-append">       
                    <input id="date_fin" name="date_fin_tournoi" type="text" value="<?php echo $obj_page->data('date_fin_tournoi'); ?>" class="input-append input-datepicker" data-date-format="yyyy-mm-dd" data-date="" required>
                    <span class="add-on">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
                 <select type="text" name="heure_tournoi" minlength="2" style="width:7%" >
                             <?php for($num_heure=0; $num_heure<=23;$num_heure++): ?>
                                 <option value="<?php echo ($num_heure < 10)? '0'.$num_heure: $num_heure; ?>" <?php if ($obj_page->data('heure_tournoi')== $num_heure) {echo 'selected="selected"';}?>><?php echo ($num_heure < 10)? '0'.$num_heure: $num_heure; ?></option>
                                 <?php endfor; ?>
                         </select>:
                        <select type="text" name="minute_tournoi" minlength="2" style="width:7%">
                             <?php for($num_minute=0; $num_minute<=59;$num_minute++): ?>
                                 <option value="<?php echo ($num_minute < 10)? '0'.$num_minute: $num_minute; ?>" <?php if ($obj_page->data('minute_tournoi')== $num_minute) {echo 'selected="selected"';}?>><?php echo ($num_minute < 10)? '0'.$num_minute: $num_minute; ?></option>
                                 <?php endfor; ?>
                         </select>:
                         <select type="text" name="seconde_tournoi" minlength="2" style="width:7%">
                                 <option value="00" <?php if ($obj_page->data('seconde_tournoi')== "00") {echo 'selected="selected"';}?>>00</option>
                                  <option value="59" <?php if ($obj_page->data('seconde_tournoi')== "59") {echo 'selected="selected"';}?>>59</option>
                        </select>
            </div> 
        </div>
  

        <div class="control-group">
            <label class="control-label">Type</label>
            <div class="controls">
                <div class="input-prepend">
                    <select id="type" name="type">
                        <?php for ($num_type = 1; $num_type <= 3; $num_type++):       
                        switch($num_type)
                        {
                            case '1':
                                $strNomTournoi = 'T. des Capitaines';
                            break;
                            case '2':
                                $strNomTournoi = 'T. des Maîtres';
                            break;
                            case '3':
                                $strNomTournoi = 'T. des Seigneurs';                                
                            break;
                            default:
                                $strNomTournoi = 'Tournoi Spécial';
                            break;
                        }?>
                            <option value="<?php echo $num_type ?>" <?php if ($obj_page->data('tournois')->getType() == $num_type) {echo 'selected="selected"';} ?>><?php echo $num_type.". ".$strNomTournoi; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Duree</label>
            <div class="controls">
                <div class="input-prepend">
                    <input id="duree" name="duree" type="text" value="<?php echo $obj_page->data('tournois')->getDuree(); ?>" required>                   
                </div>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="Unité en jours !"></i>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">
                <div class="input-prepend">
                    <div class="input-switch switch-small"  data-on="success" data-off="danger">
			<input name="valide_tournois" data-id="<?php $obj_page->data('tournois')->getValide(); ?>" type="checkbox" <?php if($obj_page->data('tournois')->getValide()=='1') { ?>checked <?php }?>>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <input type="submit" class="btn btn-success" style="margin-left:45%" value="Mettre à jour"/>
</form>
