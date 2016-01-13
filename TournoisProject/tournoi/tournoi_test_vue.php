<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/tournoi.css">
        <meta charset="UTF-8"> 
    </head>
    <body>
        <?php 
        include('../Classe/Rencontre.php'); 
        include('../Classe/Concurrent.php'); 
        session_start();     
        $tournoi= $_SESSION['tournoi'];
        $tab_rencontre=$_SESSION['tab_rencontre'];
        $tab_concurrent=$_SESSION['tab_concurrent'];
        if(isset($_SESSION['id_fantome'])){$id_fantome=$_SESSION['id_fantome'];}
        else{$id_fantome="";}
        $TBA = "--" ; // équipe non communiqué
        $id_tournoi=$_GET['id_tournoi']; 
        
        ?>
             <!--mode horizontal-->
             <div class='bracket'>
                 <?php foreach($tab_rencontre as $phase) :
                     if(preg_match("#H#", "".$phase->getPlaceRencontre()."")) : ?>
                 
                <div class='huit_final'>
                    <div class="phase"><h3>huit-final</h3></div>
                    <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#H#", "".$value->getPlaceRencontre()."")) :?>
                    <div class="huit_game" 
                    <?php if($id_fantome != $value->getIdConcurrentA() && $id_fantome != $value->getIdConcurrentB()) :   ?>   
                        onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre(); ?>';"
                        <?php endif; ?>>
                        <div class='box_game'>
                            <div class='team_1'>
                                <?php foreach($tab_concurrent as $value_concurrent) : 
                                         if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentA() == null):
                                                echo $TBA;
                                            break;
                                        endif; 
                                    endforeach; ?></div>
                            <div class='score_1'><?php if($value->getScoreA() == null) : echo "0"; else : echo $value->getScoreA(); endif; ?></div><div class="clear"></div>
                            <div class='team_2'>
                                <?php foreach($tab_concurrent as $value_concurrent) : 
                                         if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentB() == null):
                                                echo $TBA;
                                            break;
                                        endif; 
                                    endforeach; ?></div>
                            <div class='score_2'><?php if($value->getScoreB() == null) : echo "0"; else : echo $value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                    
                </div>
                 
                 
                 <div class="espace">
                     <?php for($i=0; $i<=3; $i++) : ?>
                     <div class="espace_huit_1"></div>
                     <div class="espace_huit_2"></div>
                     <div class="espace_huit_3"></div>
                     <div class="clear"></div>
                     <?php endfor;?>                
                 </div>
                 <?php break;endif;endforeach; ?>
                                
                 <?php foreach($tab_rencontre as $phase) :
                     if(preg_match("#Q#", "".$phase->getPlaceRencontre()."")) : ?>
                 <div class='quart_final'>
                    <div class="phase"><h3>Quart-final</h3></div>
                     <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#Q#", "".$value->getPlaceRencontre()."")) :?>
                    <div class="quart_game"
                         <?php if($id_fantome != $value->getIdConcurrentA() && $id_fantome != $value->getIdConcurrentB()) :   ?>   
                         onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre(); ?>';"
                         <?php endif; ?>>
                        <div class='box_game'>
                            <div class='team_1'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentA() == null):
                                                echo $TBA;
                                            break;
                                        endif; 
                                    endforeach; ?></div>
                            <div class='score_1'><?php if($value->getScoreA() == null) : echo "0"; else : echo $value->getScoreA(); endif; ?></div><div class="clear"></div>
                            <div class='team_2'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentB() == null):
                                                echo $TBA;
                                            break;
                                        endif;
                                    endforeach; ?></div>
                            <div class="score_2"><?php if($value->getScoreB() == null) : echo "0"; else : echo $value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                 </div>
                 <?php break;endif;endforeach; ?>
             
                 <?php foreach($tab_rencontre as $phase) :
                     if(preg_match("#D#", "".$phase->getPlaceRencontre()."")) : ?>
                <div class='demi_final'>
                    <div class="phase"><h3>Demi-final</h3></div>
                    <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#D#", "".$value->getPlaceRencontre()."")) :?>
                    <div class="demi_game"
                         <?php if($id_fantome != $value->getIdConcurrentA() && $id_fantome != $value->getIdConcurrentB()) :   ?>
                         onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre(); ?>';"
                         <?php endif; ?>>
                        <div class='box_game'>
                            <div class='team_1'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentA() == null):
                                                echo $TBA;
                                            break;
                                        endif; 
                                    endforeach; ?>
                            </div><div class='score_1'><?php if($value->getScoreA() == null) : echo "0"; else : echo $value->getScoreA(); endif; ?></div><div class="clear"></div>
                            <div class='team_2'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentB() == null):
                                                echo $TBA;
                                            break;
                                        endif;
                                    endforeach; ?>
                            </div><div class="score_2"><?php if($value->getScoreB() == null) : echo "0"; else : echo $value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                </div>
                 <?php break;endif;endforeach; ?>
                
                <div class='final'>
                    <div class="phase"><h3>Final</h3></div>
                    <?php foreach($tab_rencontre as $key=>$value) :
                        if(preg_match("#F#", "".$value->getPlaceRencontre()."")) :?>
                    <div class="final_game" onclick="location.href='<?php echo '../feuille_match/feuille_match.php?id_tournoi='.$id_tournoi.'&id_rencontre='.$value->getIdRencontre(); ?>';">
                        <div class='box_game'>
                            <div class='team_1'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentA()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentA() == null):
                                                echo $TBA;
                                            break;
                                        endif; 
                                    endforeach; ?>
                            </div><div class='score_1'><?php if($value->getScoreA() == null) : echo "0"; else : echo $value->getScoreA(); endif; ?></div><div class="clear"></div>
                            <div class='team_2'><?php foreach($tab_concurrent as $value_concurrent) : 
                                        if($value_concurrent->getIdConcurrent() == $value->getIdConcurrentB()) :
                                            echo $value_concurrent->getNomConcurrent();
                                        elseif($value->getIdConcurrentB() == null):
                                                echo $TBA;
                                            break;
                                        endif;
                                    endforeach; ?></div><div class="score_2"><?php if($value->getScoreB() == null) : echo "0"; else : echo $value->getScoreB(); endif; ?></div><div class="clear"></div>  
                        </div>
                    </div>
                    <?php endif;endforeach; ?>
                </div>   
             </div>

        

            
        <!--<form action="../index.php" method="post">
            <input type="submit" value="Retour"> 
        </form>-->
    </body>
</html>

