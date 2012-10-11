<?php
    echo '<div class="outils" id="calques">';
      echo '<div class="menu">';
      echo 'Actions Calques Effets';
      echo '</div>';
        // selon le nombre de calques en cours...
        $nb_calques = 3;
        
        echo '<table id="liste_calques">';
        for ($i=0; $i <= $nb_calques; $i++){
          $nom_calque = ($i == 0) ? 'Fond' : 'Calque&nbsp;' . $i;            
          
          echo '<tr class="calque">';
            echo '<td class="icone">';
            echo '</td>';
            echo '<td class="nom">' . $nom_calque . '</td>';
            echo '<td class="actions">'. '0 X i' . '</td>';
          echo '</tr>';
        }
        
        echo '</table>';
    echo '</div>';