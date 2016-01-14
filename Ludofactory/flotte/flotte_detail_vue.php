<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li><a href="<?php echo backoUrl(29);?>">Flotte</a></li>
    <li><a href="<?php echo backoUrl(29, array("act" => "liste"));?>">Liste</a></li>
    <li class="active"><a href="javascript:void(0)">Edition</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Edition de la flotte :</h3>
    </div>
</div>

<fieldset>
    <legend>Actions diverses</legend>
<div class="navbar" >
    <div class="navbar-inner remove-radius remove-box-shadow">
        <div class="container" >
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul id="nav-opt-users" class="nav">
                    <li><a href="javascript:void(0)" onclick="flotteClasseactiv($(this));flotteAfficherSection($(this),'actualites',<?php echo $obj_page->data('flotte')->getId() ?>)">Actualités</a></li>
                    <li><a href="javascript:void(0)" onclick="flotteClasseactiv($(this));flotteAfficherSection($(this),'mur',<?php echo $obj_page->data('flotte')->getId() ?>)">Mur</a></li>
                </ul>
                <ul class="nav pull-right">
                    <li>
                        <button style="margin:5px;display:none;" id="btn-hide-section" type="button" class="btn btn-success">Masquer la section</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
    <div id="actualites"></div>
    <div id="mur"></div>
</fieldset>

<form action="<?php echo backoUrl(29, array('act'=>'update')) ?>" method="post" class="form-horizontal form-box" id="form_flotte_update">
    
    <div class=" form-box form-box-content">
        <div class="control-group">
            <label class="control-label">Identifiant</label>
            <div class="controls">      
                <input type="text" value="<?php echo $obj_page->data('flotte')->getId(); ?>" disabled='disabled' />
                <input type="hidden" id="id" name="id" value="<?php echo $obj_page->data('flotte')->getId(); ?>" />
            </div>
        </div> 
        
        <div class="control-group">
            <label class="control-label">Nom</label>
            <div class="controls">      
                <input type="text" id="nom" name="nom" value="<?php echo $obj_page->data('flotte')->getNom(); ?>" />
            </div>
        </div>  
        
        <div class="control-group">
            <label class="control-label">id amiral</label>
            <div class="controls">      
                <input type="text" id="id_amiral" name="id_amiral" value="<?php echo $obj_page->data('flotte')->getAmiral(); ?>" disabled='disabled' />
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="id membre de l'amiral (créateur) de le flotte"></i>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Total Réputation</label>
            <div class="controls">      
                <input type="text" id="total_reputation" name="total_reputation" value="<?php echo $obj_page->data('flotte')->getTotalReputation(); ?>" disabled='disabled' />
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="Somme des réputations des bateaux des membre de la flotte"></i>
            </div>       
        </div> 
        
        <div class="control-group">
            <label class="control-label">Fanion</label>
            <div class="controls">      
                <img src="<?php echo Config::get('url_site_img')."commun/items/flotte/fanions/".$obj_page->data('fanion')->getImage();?>"/>
            </div>
        </div> 
        
        <div class="control-group">
            <label class="control-label">Devise</label>
            <div class="controls">   
                <select name="devise">
                    <?php foreach($obj_page->data('devise') as $row) : ?>
                    <option value="<?php echo $row->getId() ?>" <?php if($row->getId()==$obj_page->data('flotte')->getDevise()) : echo "selected='selected'"; endif; ?>><?php echo $row->getId()." - ".$row->getDevise() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div> 
        
        <div class="control-group">
            <label class="control-label">Trésor</label>
            <div class="controls">      
                <input type="number" id="tresor" name="tresor" value="<?php echo $obj_page->data('flotte')->getTresor(); ?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Date création</label>
            <div class="controls">      
                <input type="text" id="date_creation" name="date_creation" value="<?php echo $obj_page->data('flotte')->getDateCreation(); ?>" disabled='disabled' />
            </div>
        </div>
            
        <div class="control-group" id="liste_item_flotte" style="display:none">
            <label class="control-label"><input type="button" class='btn btn-info' id="masque_item_flotte" value="Masquer les items" /></label>
            <div class="controls">      
                <div id="item_flotte">
                </div>
            </div>
        </div>
        
        <div class="control-group" id="affiche_item">
            <label class="control-label"><input type="button" class='btn btn-info' id="affiche_item_flotte" value="Afficher les items" /></label>
            <div class="controls">       
            </div>
        </div>
       
        <div class="control-group">
            <label class="control-label">Langue</label>
            <div class="controls">   
                <select id="langue" name="langue">
                    <?php foreach($obj_page->data('langue') as $row) : ?>
                    <option value="<?php echo $row; ?>" <?php if($obj_page->data('flotte')->getLangues()==$row){echo "selected='selected'";} ?>><?php echo $row; ?></option>
                    <?php endforeach; ?>
                </select>
                <i class="glyphicon-circle_question_mark help_question" data-toggle="tooltip" data-original-title="Langues représentés par la flotte "></i>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Autorisation d'invitation</label>
            <div class="controls">    
                <div class="input-switch switch-small"  data-on="success" data-off="danger">
                    <input type="checkbox" name="invitation" <?php if($obj_page->data('flotte')->getAutorisationInvitationAmi() == 1) { echo 'checked="checked"'; } ?>/>
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Liste des membres</label>
            <div class="controls"><?php if(sizeof($obj_page->data('membres'))==0) : echo "Aucun Membre"; 
                        else :  ?>
                    <table class="table table-striped table-bordered table-hover" style='width: 50%'>
                        <tr>
                            <th>Id</th>
                            <th>Pseudo</th>
                            <th>Réputation</th>
                            <th>Amiral</th>
                        </tr>
                            <?php foreach($obj_page->data('membres') as $row) : ?>
                                <tr>
                                     <td><a href="<?php echo backoUrl(2,array('act'=>'fiche', 'id'=>$row->getId()))?>" target='_blank'><?php echo $row->getId();?></a></td>
                                    <td><?php echo $row->getPseudo()?></td>
                                    <td><?php foreach($obj_page->data('reputation') as $value) : if($row->getId()==$value->getIdMembre()){echo $value->getReputation();} endforeach; ?></td>
                                    <td class="amiral" style="text-align: center"><?php if($row->getId()!=$obj_page->data('flotte')->getAmiral()) : ?><button type="button" class="btn btn-success btn-mini choix_amiral" data-id="<?php echo $row->getId(); ?>" data-toggle="tooltip" data-original-title="Mettre au poste d'amiral"><i class="glyphicon-crown"></i></button>
                                        <?php else : ?><i class="glyphicon-crown" data-toggle="tooltip" data-original-title="Amiral actuel"></i><?php endif; ?></td>
                                </tr> 
                            <?php endforeach;endif; ?>
                    </table>
                <input type="hidden" id="amiral" name="amiral">
                </div>
        </div>

        <div class="control-group">
            <label class="control-label">Valide</label>
            <div class="controls">
                <div class="input-switch switch-small"  data-on="success" data-off="danger">
                    <input type="checkbox" name="valide" <?php if($obj_page->data('flotte')->getValide() == 1) { echo 'checked="checked"'; } ?>/>
                </div>
            </div>
        </div>     
        <input type="submit" value="Mettre à jour" class="btn btn-success" style="margin:auto;display:block"/>
    </div>
</form>
