<html>
    <head>
        <meta charset="UTF-8">
        <title>Challenge Tournament</title> 
        <link href="../css/default.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="stylesheet" type="text/css" href="../css/tournoi.css">
        <script src="../js/jquery-1.11.2.min.js"></script>
    </head>
    <body>
        <?php
        include('../Classe/Rencontre.php'); 
        include('../Classe/Concurrent.php'); 
        include('../Classe/Tournoi.php');
        session_start(); 
        $id_tournoi = $_GET['id_tournoi'];
        $tournoi= $_SESSION['tournoi'];
        $tab_rencontre=$_SESSION['tab_rencontre'];
        $tab_concurrent=$_SESSION['tab_concurrent'];
        if(isset($_SESSION['tab_groupe']) && isset($_SESSION['nb_equipe']))
        {
            $tab_groupe = $_SESSION['tab_groupe'];
            $nb_equipe = $_SESSION['nb_equipe'];
            $tab_classement = $_SESSION['tab_classement'];
        }
        if(isset($_SESSION['vue']))
        {
            $vue="OFF";
        }
        else
        {
            $vue="ON";
        }
        if(isset($_SESSION['id_fantome'])){$id_fantome=$_SESSION['id_fantome'];}
        else{$id_fantome="";}
        $TBA = "--" ; // équipe non communiqué  
        ?>
        <div id="header-wrapper">
          <?php  if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
            <div class="login">
                <form action="../logout.php" method="post">
                    <input type="Submit" value="Déconnexion" name="submit">
                </form>
            </div>   
                <?php else : ?>               
            <div class="login">
                <form action="../checkLogin.php" method="post">
                    <label for="pseudo">Login : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="pseudo" class="textbox" id="pseudo" style="width: 50%;margin-top: -1%"/><br /><br />
                    <label for="mdp">Password : </label><input type="password" name="mdp" class="textbox" id="mdp" style="width: 50%;margin-top: -1%"/><br />
                    <input type="Submit" value="Connexion" name="submit">
                </form>
                <?php if(isset($_SESSION['logged'])):?>
                    <div id="wrongLogin">Login ou mot de passe incorrect</div>
                <?php unset($_SESSION['logged']);endif;?>  
            </div>
            <?php endif;?>
            <div id="header" class="container">
                <div id="logo" style="">                   
                    <h1><a href="#">Challenge Tournament</a></h1>
                </div>
                <div id="menu">
                    <ul>
                        <li><a href="../index.php" title="Accueil">Accueil</a></li>
                        <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) :?>
                        <li><a href="../mes_tournois/mes_tournois.php" title="Accueil">Mes tournois</a></li>
                        <li><a href="../crea_tournoi/crea_tournoi.php" title="Creer Tournoi">Créer un tournoi</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="corps" style='height:110%;'>
            <h1 style='text-align:center'><?php echo $tournoi['nom_tournoi']; ?></h1>
            <?php if($tournoi['type_tournoi']=="championnat") : ?>
            <div id='phase_groupe' class='myBoutonTournoi' style='width:49.8%;float:left;'>Phase de groupe</div>
            <?php endif; ?>
            <div id='phase_bracket' class='myBoutonTournoi' style='<?php if($tournoi['type_tournoi']=="championnat") : echo "width:49.8%"; else : echo "width:99.6%"; endif; ?> ;float:left'>Bracket</div>
            <div class='clear'></div>
            
            <div id='block_groupe' <?php if($tournoi['type_tournoi']!="championnat" || $vue=="OFF") : ?>hidden<?php endif; ?>>
                <div class="groupe">
                    <?php for($i=1 ;$i<=8;$i++) : 
                        foreach($tab_rencontre as $value_groupe) : 
                        if(preg_match("#G".$i."#", "".$value_groupe->getPlaceRencontre()."")) : 
                        ?>
                        <div class="affichage_groupe">
                            <h2>Groupe <?php echo $i; ?></h2>
                            <table class="tableau_groupe gpr" cellspacing="0" 
                                   onclick="location.href='<?php echo "tournoi.php?act=plan_groupe&id_tournoi=".$id_tournoi."&gpr=".$i?>'">
                                <tr>
                                    <th class="bordure_th">Concurrent</th>
                                    <th class="bordure_th">Points</th>
                                </tr>
                                <?php if($nb_equipe == 6 || $nb_equipe == 12 || $nb_equipe == 24):$nb_concurrent_by_groupe =3;                              
                                      elseif($nb_equipe == 8 || $nb_equipe == 16 || $nb_equipe == 32):$nb_concurrent_by_groupe =4;
                                      elseif($nb_equipe == 4):$nb_concurrent_by_groupe = 2;
                                      endif; 
                                for($x=0;$x<$nb_concurrent_by_groupe;$x++) :?>
                                <?php if($tab_groupe[$i][$x]!="~~free win~~"):  ?>
                                <tr>     
                                    <td class="bordure_td"><?php echo $tab_groupe[$i][$x]; ?></td>
                                    <td class="bordure_td"><?php foreach($tab_concurrent as $note) :
                                        if($note->getNomConcurrent()==$tab_groupe[$i][$x]): 
                                            echo $tab_classement[$note->getIdConcurrent()]['point']; break;
                                       endif;endforeach; ?></td>
                                </tr>
                                <?php endif;endfor;?>
                            </table>
                        </div>
                    <?php if($i==4) : ?><div class="clear"></div><?php endif;?>
                    <?php break;endif;endforeach;endfor; ?>    
                    
                </div>
            </div>
            
            
            <div id='block_bracket' <?php if($vue=="ON") : ?>hidden<?php endif; ?>>
                <div class='bracket'>
                 <?php foreach($tab_rencontre as $phase) :
                     if(preg_match("#H#", "".$phase->getPlaceRencontre()."")) : ?>
                 
                <div class='huit_final'>
                    <div class="phase"><h3>huit-final</h3></div>
                    <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#H#", "".$value->getPlaceRencontre()."")) :?>
                    <div class="huit_game" 
                    <?php if($id_fantome != $value->getIdConcurrentA() && $id_fantome != $value->getIdConcurrentB()) :   ?>   
                        onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre()."&vue=true"; ?>';"
                        <?php endif; ?>>
                        <div class='box_game'>
                            <div class='box_game_A'>
                                <div class='team_1'>
                                    <?php foreach($tab_concurrent as $value_concurrent) : 
                                             if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                                echo "&nbsp;".$value_concurrent->getNomConcurrent();
                                            elseif($value->getIdConcurrentA() == null):
                                                    echo "&nbsp;".$TBA;
                                                break;
                                            endif; 
                                        endforeach; ?></div>
                                <div class='score_1'><?php if($value->getScoreA() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreA(); endif; ?></div><div class="clear"></div>
                            </div>
                            <div class='team_2'>
                                <?php foreach($tab_concurrent as $value_concurrent) : 
                                         if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                            echo "&nbsp;".$value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentB() == null):
                                                echo "&nbsp;".$TBA;
                                            break;
                                        endif; 
                                    endforeach; ?></div>
                            <div class='score_2'><?php if($value->getScoreB() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                    
                </div>
                 <?php break;endif;endforeach; ?>
                    
                    <!-- quart de final !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
                    <?php foreach($tab_rencontre as $phase) :
                     if(preg_match("#Q#", "".$phase->getPlaceRencontre()."")) : ?>
                 <div class='quart_final'>
                    <div class="phase"><h3>Quart-final</h3></div>
                    <div style='margin-top:35px;'></div>
                     <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#Q#", "".$value->getPlaceRencontre()."")) :?>
                    
                    <div class="quart_game"
                         <?php if($id_fantome != $value->getIdConcurrentA() && $id_fantome != $value->getIdConcurrentB()) :   ?>   
                         onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre()."&vue=true"; ?>';"
                         <?php endif; ?>>
                        <div class='box_game'>
                            <div class='box_game_A'>
                                <div class='team_1'><?php foreach($tab_concurrent as $value_concurrent) : 
                                            if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                                echo "&nbsp;".$value_concurrent->getNomConcurrent();
                                            elseif($value->getIdConcurrentA() == null):
                                                    echo "&nbsp;".$TBA;
                                                break;
                                            endif; 
                                        endforeach; ?></div>
                                <div class='score_1'><?php if($value->getScoreA() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreA(); endif; ?></div><div class="clear"></div>
                            </div>
                                <div class='team_2'><?php foreach($tab_concurrent as $value_concurrent) : 
                                            if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                                echo "&nbsp;".$value_concurrent->getNomConcurrent();
                                            elseif($value->getIdConcurrentB() == null):
                                                    echo "&nbsp;".$TBA;
                                                break;
                                            endif;
                                        endforeach; ?></div>
                                <div class="score_2"><?php if($value->getScoreB() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                 </div>
                 <?php break;endif;endforeach; ?>
                    
                 <!--Demi final !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
                 <?php foreach($tab_rencontre as $phase) :
                     if(preg_match("#D#", "".$phase->getPlaceRencontre()."")) : ?>
                <div class='demi_final'>
                    <div class="phase"><h3>Demi-final</h3></div>
                    <div style='margin-top:103px;'></div>
                    <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#D#", "".$value->getPlaceRencontre()."")) :?>
                    <div class="demi_game"
                         <?php if($id_fantome != $value->getIdConcurrentA() && $id_fantome != $value->getIdConcurrentB()) :   ?>
                         onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre()."&vue=true"; ?>';"
                         <?php endif; ?>>
                        <div class='box_game'>
                            <div class='box_game_A'>
                                <div class='team_1'><?php foreach($tab_concurrent as $value_concurrent) : 
                                            if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                                echo $value_concurrent->getNomConcurrent();
                                            elseif($value->getIdConcurrentA() == null):
                                                    echo "&nbsp;".$TBA;
                                                break;
                                            endif; 
                                        endforeach; ?>
                                </div>
                                <div class='score_1'><?php if($value->getScoreA() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreA(); endif; ?></div><div class="clear"></div>
                            </div>
                            <div class='team_2'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentB() == null):
                                                echo "&nbsp;".$TBA;
                                            break;
                                        endif;
                                    endforeach; ?>
                            </div><div class="score_2"><?php if($value->getScoreB() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                </div>
                 <?php break;endif;endforeach; ?>
                 
                 <!--final !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
                 <div class='final'>
                    <div class="phase"><h3>Final</h3></div>
                    <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#F#", "".$value->getPlaceRencontre()."")) :?>
                    <div class="final_game" onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre()."&vue=true"; ?>';">
                        <div class='box_game'>
                            <div class='box_game_A'>
                                <div class='team_1'><?php foreach($tab_concurrent as $value_concurrent) : 
                                            if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                                echo "&nbsp;".$value_concurrent->getNomConcurrent();
                                            elseif($value->getIdConcurrentA() == null):
                                                    echo "&nbsp;".$TBA;
                                                break;
                                            endif; 
                                        endforeach; ?>
                                </div>
                                <div class='score_1'><?php if($value->getScoreA() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreA(); endif; ?></div><div class="clear"></div>
                            </div>
                            <div class='team_2'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                            echo "&nbsp;".$value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentB() == null):
                                                echo "&nbsp;".$TBA;
                                            break;
                                        endif;
                                    endforeach; ?>
                            </div><div class="score_2"><?php if($value->getScoreB() == null) : echo "&nbsp;0"; else : echo "&nbsp;".$value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                </div> 
                 
                 <!--vainqueur !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
                 <?php if($tournoi['vainqueur_tournoi']!="") : ?>
                 <div class="vainqueur"><h1 style='text-align:center'>Vainqueur <?php echo $tournoi['vainqueur_tournoi']; ?></h1><img  src="../Images/coupe.png"></div>
                 <?php endif; ?>
            </div>   
        </div>
        <script>
        $(document).ready(function() 
        {
            $("#phase_groupe").click(function(){ 
                $(this).css("border", "1px solid orange");
                $("#phase_bracket").css("border", "");
                $("#block_bracket").hide(); 
                $("#block_groupe").show();
            });
            
            $("#phase_bracket").click(function(){ 
                $(this).css("border", "1px solid orange");
                $("#phase_groupe").css("border", "");
                $("#block_groupe").hide();        
                $("#block_bracket").show(); 
            });
        });

        </script>
</body>
</html>
