<!-- Navigation info -->
<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li class="active"><a href="">En lignes</a></li>
</ul>
<div class="row-fluid">
    <div class="span12">
        <h1>Tournois Solos</h1>
    </div>
</div>

<div id="classement-modal" class="modal hide" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4>Récupération des informations</h4>
    </div>
    <div class="modal-body">
        <p></p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>


<!-- Datatables inscrits -->
<table id="tab_tournois_solo" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
            <th class="span1">Tournois</th>
            <th>Début</th>
            <th>fin</th>
            <th>Dotation</th>
            <th>Type de tournoi</th>
            <th >Participants</th>
            <th >Chiffre d'affaire</th>
            <th >Payeurs</th>
            <th >Payeurs uniques</th>
		</tr>
	</thead>
	<tbody id="">
            <?php foreach($obj_page->data('tab_tournois_solo') as $idTournois => $row):

            ?>
            <tr data-id="" >
                <td><?php echo $idTournois; ?>
                    <a class="btn btn-mini btn-success btn-edit-mb" style="float:right" data-original-title="Modifier" href="index.php?b=25&act=tournois_details&id_tournois=<?php echo $idTournois; ?>&type=solo">
                    <i class="icon-pencil"></i></a>
                </td>
            <td><?php echo $row['tournoi']->getDebut(); ?></td>
            <td><?php echo $row['tournoi']->getFin(); ?></td>
            <td>
                <?php echo $row['dotation'][1]->getNom(); ?>
                <i class="zoom-dodation icon-zoom-in" data-toggle="popover" data-html="true" data-content="<ul><li>2ème : <?php echo $row['dotation'][2]->getNom(); ?></li><li>3ème : <?php echo $row['dotation'][3]->getNom(); ?></li><li>4-7ème : <?php echo $row['dotation'][7]->getNom(); ?></li><li>8-15ème : <?php echo $row['dotation'][15]->getNom(); ?></li></ul>" data-placement="right" title="" data-original-title="1er prix <strong><?php echo $row['dotation'][1]->getNom(); ?></strong>"></i>
            </td>
            <td><?php echo $row['tournoi']->getType(); ?></td>
            <td>
                <?php echo $row['stats']['nb_participants']; ?>
                <div class="classement-details btn-group">
                    <a href="#classement-modal" data-type="solo" data-tournoi="<?php echo $idTournois; ?>" data-toggle="modal" title="" class="btn btn-mini btn-info" data-original-title="Détails"><i class="icon-info-sign"></i></a>
                </div>
            </td>
            <td><?php echo $row['stats']['ca']['revenues']; ?></td>
            <td><?php echo $row['stats']['ca']['nb']; ?></td>
            <td><?php echo $row['stats']['ca']['nbUnique']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<!-- END Datatables -->

<p class="conteneur_historique_solo well"><button type="button" class="btn btn-small btn-success expand-historique" data-type="solo">Accèder à l'historique des classements solos</button></p>

<!-- END Datatables -->
<div class="row-fluid">
    <div class="span12">
        <h1>Tournois Flottes</h1>
    </div>
</div>
<!-- Datatables inscrits -->
		<table id="tab_tournois_equipe" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
                    <th class="span1">Tournois</th>
                    <th>Début</th>
                    <th>fin</th>
                    <th>Dotation</th>
                    <th>Type de tournoi</th>
                    <th>Equipes</th>
                    <th>Chiffre d'affaire</th>
                    <th>Payeurs</th>
                    <th>Payeurs uniques</th>
				</tr>
			</thead>
			<tbody id="">
				<?php foreach($obj_page->data('tab_tournois_equipe') as $idTournois => $row):

                ?>
				<tr data-id="" >
                    <td><?php echo $idTournois; ?>
                         <a class="btn btn-mini btn-success btn-edit-mb" style="float:right" data-original-title="Modifier" href="index.php?b=25&act=tournois_details&id_tournois=<?php echo $idTournois; ?>&type=equipe">
                        <i class="icon-pencil"></i></a>
                    </td>
                    <td><?php echo $row['tournoi']->getDebut(); ?></td>
                    <td><?php echo $row['tournoi']->getFin(); ?></td>
                    <td>
                        <?php echo $row['dotation'][1]->getNom(); ?>
                        <i class="zoom-dodation icon-zoom-in" data-toggle="popover" data-html="true" data-content="<ul><li>2ème : <?php echo $row['dotation'][2]->getNom(); ?></li><li>3ème : <?php echo $row['dotation'][3]->getNom(); ?></li><li>4-7ème : <?php echo $row['dotation'][7]->getNom(); ?></li><li>8-15ème : <?php echo $row['dotation'][15]->getNom(); ?></li></ul>" data-placement="right" title="" data-original-title="1er prix <strong><?php echo $row['dotation'][1]->getNom(); ?></strong>"></i>
                    </td>
                    <td><?php echo $row['tournoi']->getType(); ?></td>
                    <td>
                        <?php echo $row['stats']['nb_participants']; ?>
                        <div class="classement-details btn-group">
                            <a href="#classement-modal" data-type="equipe" data-tournoi="<?php echo $idTournois; ?>" data-toggle="modal" title="" class="btn btn-mini btn-info" data-original-title="Détails"><i class="icon-info-sign"></i></a>
                        </div>
                    </td>
                    <td><?php echo $row['stats']['ca']['revenues']; ?></td>
                    <td><?php echo $row['stats']['ca']['nb']; ?></td>
                    <td><?php echo $row['stats']['ca']['nbUnique']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<!-- END Datatables -->

<p class="conteneur_historique_equipe well"><button type="button" class="btn btn-small btn-success expand-historique" data-type="equipe">Accèder à l'historique des classements flottes</button></p>

<!-- Javascript code only for this page -->
<script>
$(function () {
   /* $('#tab_tournois_solo').dataTable({
        "aaSorting": [[ 0, "asc" ]]
    });
    $('#tab_tournois_equipe').dataTable({
        "aaSorting": [[ 0, "asc" ]]
    });*/
});
</script>
