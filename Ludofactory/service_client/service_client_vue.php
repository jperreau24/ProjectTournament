<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="icon-home"></i></a></li>
    <li class="active"><a href="javascript:void(0)">Questions joueurs</a></li>
</ul>

<div class="row-fluid">
    <div class="span12">
        <h3 class="page-header page-header-top">Questions joueurs</h3>
    </div>
</div>


<div class="chat" >
    <div class="chat-people" style="background-color:#cccccc;font-weight:''">
        <ul>
            <li class="active">
                <a style="margin-top:4%;min-height:30px;">
                    <label style="display:inline;font-weight:bold"><input type="radio" class="radio_question" id="radio_question1" name="radio_question" value="non_traites" checked style='margin-left:7%'/> Non traités</label>
                    <label style="display:inline;font-weight:bold"><input type="radio" class="radio_question" id="radio_question3" name="radio_question" value="tout" style='margin-left:5%' /> Tout voir</label>
                </a>
            </li>
            <span id="liste_membre"></span>
        </ul>
    </div>
    <div class="chat-messages"></div>
</div>
<div class="chat-input" style="background-color: #cccccc">
        <form id="form-chat" class="remove-margin" action="<?php echo backoUrl(8) ?>">
                <textarea id="chat-message" class="remove-box-shadow" type="text" style="float:left;height: 38px;resize: vertical;" placeholder="Sélectionner une question et écrire votre réponse..." name="chat-message" onkeyup="javascript: ScHauteurTextarea(this.id)" ></textarea>
                <button type='button' class="btn btn-success send_reponse" data-id="" style="width: 250px;margin-right:8px;height: 38px; float:right">Envoyer</button>
        </form>
</div>


