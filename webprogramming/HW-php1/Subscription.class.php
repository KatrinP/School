<?php 
class Subscription {
    public static $subscribers;
    public static function listMagazines($magazines) {
        foreach ($magazines as $magazine) {
	            echo '
					    <div class="magazine" id="' . $magazine->id .'">
						<img src="' . $magazine->picture . '" class="picture" />
					    <p class="magazinename">' . $magazine->title . '</p>
					    <p class="price">' . $magazine->price . ' CZK</p>
						<input type="checkbox" name="mytitle[]" value="' . $magazine->id . '"';
						     if ($magazine->ordered == true) {echo ' checked';}
		        echo    '>
					    </div>';
		}
    }
    public static function subscribe($magazine_id, $email) {
        if (!isset(self::$subscribers[$magazine_id])) {
            self::$subscribers[$magazine_id] = array();
        }
        array_push(self::$subscribers[$magazine_id], $email);
    }
}
?> 
						    
