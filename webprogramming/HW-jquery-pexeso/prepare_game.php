<?php
    $size_of_game = 4;

    for ($i = 0; $i < $size_of_game; $i++) {
        
        for ($j = 0; $j < $size_of_game; $j++) {
            $number = $j+$size_of_game*$i;
            echo '<div class="wholecard" id="'. $number .'" onclick="turn_card('. $number .');">
                    <div class="back"></div>
                    <div class="front hiden"></div>
                  </div>';
        }
        
        echo '<br />';
    }
?>    
