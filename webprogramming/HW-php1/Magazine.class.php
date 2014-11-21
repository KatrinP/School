<?php
class magazine {
    var $id;
    var $price;
    var $title;
    var $picture;
    var $ordered;
    function magazine($id, $price, $title, $picture) {
        $this->id = $id;
        $this->price = $price;
        $this->title = $title; 
        $this->picture = $picture;
        $this->ordered = false;
    }
}
$ktmagazines = array(new magazine("story1", 99, "Fantasy time", "http://fc03.deviantart.net/fs71/f/2013/321/c/9/cryy_by_igneous_dragon-d6unpns.png"), 
                new magazine("story2", 59, "Crazy bedtime stories", "http://fc05.deviantart.net/fs70/f/2012/349/8/5/retarded_princess_peach_by_kiki_themonkey-d5o490x.jpg"), 
                new magazine("story3", 77, "Fairytales for naughty children", "https://openclipart.org/image/300px/svg_to_png/5394/johnny_automatic_loving_children.png"), 
                new magazine("story4", 89, "Horrors for bedtime", "https://openclipart.org/image/300px/svg_to_png/181494/batnight.png"), 
                new magazine("story5", 49, "Papa's stories", "http://fc03.deviantart.net/fs70/i/2010/156/6/3/Birthday_Unicorns_by_kilocopter.jpg")
                );
?>
 
 
