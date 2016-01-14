<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li class="active"><a href="javascript:void(0)">Flotte</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Gestion des flottes</h3>
    </div>
</div>

<form class="form-horizontal form-box form_itemb_search" action="<?php echo backoUrl(29, array("act" => "liste")); ?>" method="post">
    <h4 class="form-box-header">Rechercher une flotte par :</h4>
    <div class="form-box-content">

        <!-- Id Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id</label>
            <div class="controls">
                <input type="text" name="flotte_id" id="example-input-inline" class="input-large" placeholder="Id">
            </div>
        </div>
        
        <!-- Name Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Nom</label>
            <div class="controls">
                <input type="text" name="flotte_name" id="example-input-inline" class="input-large" placeholder="Nom">
            </div>
        </div>
        
        <!-- Type Content -->
        <div class="control-group">
            <label class="control-label" for="example-input-inline">Id membre</label>
            <div class="controls">
                  <input type="text" name="flotte_idmemb" id="example-input-inline" class="input-large" placeholder="Id membre">
            </div>
        </div>
        
        <div class="form-actions">
            <input type="submit" class="btn btn-success btn_flotte_recherche" value="Rechercher">
        </div>
    </div>
</form>

