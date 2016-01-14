<table id="" class="table table-striped">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center"><?php echo ($obj_page->data('type') == 'solo') ? 'Membre' : 'Flotte'; ?></th>
            <th class="text-center">Score</th>
            <?php 
                if(($obj_page->data('type') == 'solo')) {
                echo '<th class="text-center">Stock Rubis</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($obj_page->data('classement') as $idm => $data): ?>
            <tr>
                <td><?php echo $data['position']; ?></td>
                <td class="text-center">
                    <?php if(($obj_page->data('type') == 'solo')) {
                        echo '<a href="index.php?b=2&act=fiche&id='.$data['membre']->getId().'" target="_blank">'.$data['membre']->getPseudo().' <em class="em-name">('.$data['membre']->getNom().' '.$data['membre']->getPrenom().')</em></a>';
                    }else{
                        echo $data['flotte']->getNom();
                    }?>

                </td>
                <td class="text-center"><?php echo $data['total']; ?></td>
                
                    <?php 
                        if(($obj_page->data('type') == 'solo')) {
                            echo '<td class="text-center">'.$data['membre']->getRubis().'</td>';
                        }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>