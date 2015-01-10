<?php
class Album {
    var $title;
    var $picture;
    var $artist;
    var $id;
    var $songs;
    
    function album($title, $picture, $artist, $id, $songs) {
        $this->title = $title;
        $this->picture = $picture;
        $this->artist = $artist;
        $this->id = $id;
        $this->songs = $songs;
    }
}

class Song {
    var $title;
    var $number;
    var $length;
    
    function song($title, $number, $length) {
        $this->title = $title;
        $this->number = $number;
        $this->length = $length;
    }
}

$corrida_songs = [
    new song("Intro", 1, 32),
    new song("Corrida", 2, 199),
    new song("Burlaci", 3, 310),
    new song("Kostlivci", 4, 167),
    new song("Úsměv pana Lloyda", 5, 171),
    new song("Malá dáma", 6, 254),
    new song("Raci v práci s.r.o.", 7, 167),
    new song("Virtuóz", 8, 152),
    new song("Buldozerem", 9, 205),
    new song("Joy", 10, 100),
    new song("Cesta do Kadaně", 11, 189),
    new song("Kůže líná od Kolína", 12, 173),
    new song("Kdoví jestli", 13, 262),
];

$racek_songs = [
    new song("Teplota vody", 1, 45),
    new song("Dobrý mrav(enci)", 2, 169),
    new song("Pánubohudooken", 3, 276),
    new song("Okoloběhu", 4, 56),
    new song("Sibyla", 5, 224),
    new song("Soběc", 6, 243),
    new song("Dno za dnem", 7, 230),
    new song("Textovka v hudbě", 8, 35),
    new song("PodléHnutí", 9, 159),
    new song("Trigorin", 10, 258),
    new song("Nina", 11, 280),
    new song("Arkadina", 12, 190),
    new song("Treplev", 13, 163),
    new song("LedaCo", 14, 119),
    new song("Děkujeme za pozornost", 15, 14),
];

$nasim_klientum_songs = [
    new song("Našim klientům", 1, 240),
    new song("Gastrosexuál", 2, 214),
    new song("Padák", 3, 208),
    new song("Smutná písnička", 4, 181),
    new song("Hledáme zpěváka", 5, 249),
    new song("Voda v prášku", 6, 280),
    new song("Nápady", 7, 161),
    new song("Ježci", 8, 239),
    new song("O básnících", 9, 160),
    new song("Dobrý den, pane Kohák", 10, 179),
    new song("Bublina", 11, 194),
    new song("Chudej", 12, 222),
    new song("Bombaj", 13, 267),
    new song("Toubkal", 14, 269),
    new song("Svaz českých bohémů", 15, 156),
];

$my_albums = [
  new album("Corrida", "covers/corrida.jpg", "Kabát", 0, $corrida_songs),
  new album("Racek", "covers/racek.jpg", "Tomáš Klus", 1, $racek_songs),
  new album("Našim klientům", "covers/nasim_klientum.jpg", "Wohnout", 2, $nasim_klientum_songs), 
];

function list_albums($my_albums) {
    ?><table> 
        <tr>
            <th>Artist</th>
            <th>Album</th>
        </tr>    
        <?php 
        foreach ($my_albums as $album) {
            echo '<tr onClick="list_songs(' . $album->id . ')" class="click_row">'; 
            echo '<td>' . $album->artist . '</td>';
            echo '<td>' . $album->title . '</td>';
            echo '</tr>';  
        }
        ?>
        
    </table><?php
    
}

?>
