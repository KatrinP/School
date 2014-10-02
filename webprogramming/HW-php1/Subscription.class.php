<?php 
class Subscription {
    public static $subscribers;
    public static function listMagazines($magazines) {
        foreach ($magazines as $magazine) {
					    ?>
					    <div class="magazine" id="<?php echo $magazine->id; ?>">
						<img src="<?php echo $magazine->picture; ?>" class="picture" />
					    <p class="magazinename"><?php echo $magazine->title; ?></p>
					    <p class="price"><?php echo $magazine->price; ?> CZK</p>
						<input type="checkbox" name="mytitle[]" value="<?php echo $magazine->id;?>" <?php if ($magazine->ordered == true) {echo ' checked';}?>>
					    </div><?php
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
						    
