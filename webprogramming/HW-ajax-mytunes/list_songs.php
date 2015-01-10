<?php
    include 'albums.php';
    foreach ($my_albums as $album) {
        if ($album->id == (int)$_GET["id"]) {
            echo
             '<div id="alb_picture">
                <img src="/webprogramming/ajax/HW7-ajax/' . $album->picture . '" class="cover_photo" />
             </div> <!--alb-picture-->
                    <div id="alb_info">
                        <h2 id="album_title">' . $album->title .'</h2>
                        <table id="songs_table">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Length</th>
                           </tr> 
                           ';
            foreach ($album->songs as $song) {
                echo '
                           <tr>
                                <td>' . $song->number . '</td>
                                <td>' . $song->title  . '</td>
                                <td>' . floor(($song->length)/60) . ':' . str_pad(($song->length) % 60,  2, '0', STR_PAD_LEFT) . '</td>
                           </tr>
                               ';
                $total_length += $song->length; 
            }
            echo '
                            <tr>
                                <td colspan=2 id="total_length">Total length: </td>
                                <td id="total_length_number"> '. floor(($total_length)/60) . ':' . str_pad(($total_length) % 60,  2, '0', STR_PAD_LEFT) . '</td>
                            </tr>       
                        </table>
                    </div><!--alb_info-->
            ';
        }
    }

?>
