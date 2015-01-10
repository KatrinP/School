function pexesoCard(picture, position, id_pair) {
            this.picture = picture;
            this.position = position;
            this.hiden = true;
            this.pair = id_pair;     
}

var size_of_game = 4;
var number_of_turned = 0;
var turned_card = new Array();
var number_of_tries = 0;
var pair;
var card_left = size_of_game*size_of_game/2;
var bestscore = "-";
var time;
var startseconds;
var startminuts;
var var_timer



var list_pictures = new Array(
        "ajax.jpg",
        "go.jpg",
        "java.png",
        "pascal.png",  
        "php.jpg",
        "python.jpg",
        "cplus.jpg",
        "html.jpg",
        "mysql.jpg",
        "perl.jpg",
        "prolog.png",
        "scala.jpg"
);

var play_cards = new Array();

function startgame() {
    $(document).ready(function(){
        $('#startbutton').remove();
        $.get("prepare_game.php").done(function(data) {
            $('#gameboard').append(data); 
        }); 
        $('#yourscore').append('<p>Your score: 0</p>'); 
        
        //display time
        starttime = Date.now();
        $('#time').append('<p>Time: 00:00 </p>');  
        var_timer = setInterval(function(){show_time(starttime)}, 1000);     
    });
    prepare_pexeso_cards(play_cards);
}


function show_time(starttime) {
    var time = Math.floor((Date.now() - starttime) / 1000);
    var minutes = Math.floor(time / 60);
    var seconds = time % 60;
    $('#time').empty();
    $('#time').append('<p>Time: '+ add_zero(minutes, 2) + ':' + add_zero(seconds, 2) + ' </p>'); 
}

function add_zero(x,n) {
    if (x.toString().length < n) {
        x = "0" + x;
    }
    return x;
}

function shuffle(myarray) {
    for(var j, x, i = myarray.length; i; j = Math.floor(Math.random() * i), x = myarray[--i], myarray[i] = myarray[j], myarray[j] = x);
    return myarray;
};

function write_best_score(bestscore) {

    $('#bestscore > p').remove();
    $('#bestscore').append('<p>Best score: ' + bestscore + '</p>');   
}

function write_score(yourscore) {
    $('#yourscore > p').remove();
    $('#yourscore').append('<p>Your score: ' + yourscore + '</p>');   
}

function prepare_pexeso_cards() {
        shuffle(list_pictures);
        var picture_for_game = list_pictures.slice(0, (size_of_game*size_of_game)/2);
        shuffle(picture_for_game);
        
        var positions = new Array(size_of_game*size_of_game);
        for (i = 0; i < size_of_game*size_of_game; i++) { 
            positions[i] = i;
        }
        shuffle(positions);
        
        for (i = 0; i < size_of_game*size_of_game/2; i++) {

            play_cards.push(new pexesoCard(picture_for_game[i], positions[i], i));
            play_cards.push(new pexesoCard(picture_for_game[i], positions[i+size_of_game*size_of_game/2], i));
        }
}

function turn_card(card_number) {
    var found_card = $.grep(play_cards, function(e){ return e.position == card_number; });
    
    switch(number_of_turned){
        case 0:
            if (found_card[0].hiden == true) {
                turning_effect(card_number, found_card[0].picture);
                turned_card[0] = card_number;  //which cards was turned
                pair = found_card[0].pair;
                number_of_turned++;
            }
            break;
        case 1:

            if (turned_card[0] != card_number && found_card[0].hiden == true) {
                turning_effect(card_number, found_card[0].picture); 
                turned_card[1] = card_number;  //which cards was turned
                number_of_turned++; 
                number_of_tries++;
                write_score(number_of_tries);
                if (pair == found_card[0].pair) {
                    var second_card = $.grep(play_cards, function(e){ return e.position == turned_card[0]; });
                    found_card[0].hiden = false;
                    second_card[0].hiden = false;
                    number_of_turned = 0;
                    card_left--;
                    if (card_left == 0) {
                        end_of_game();
                    }
                }                   
            }
            break;
        case 2: 
            if (found_card[0].hiden == true) {
                turning_effect_back(turned_card[0]);
                turning_effect_back(turned_card[1]);
                number_of_turned = 1;
                turning_effect(card_number, found_card[0].picture); 
                turned_card[0] = card_number;  //which cards was turned
                pair = found_card[0].pair;
            }
            break;   
        default:
            break;
        
    }
}

function turning_effect(card_number, picture) {
    $(document).ready(function() {
        $('#'+card_number + '> .back').fadeTo(1000, 0, "linear");
        setTimeout(function(){
               $('#'+card_number + '> .back').addClass('hiden');
               $('#'+card_number + '> .front').append('<img src="pexeso/' + picture + '" class="picture"/>');
               $('#'+card_number + '> .front').removeClass('hiden');
        },300);
        
      
    });
}

function turning_effect_back(card_number) {
    //$('#'+card_number + '> .back').fadeTo(0, 1);
    $('#'+card_number + '> .back').removeAttr("style");
    $('#'+card_number + '> .back').removeClass('hiden');

    $('#'+card_number + '> .front > img' ).remove();
    $('#'+card_number + '> .front').addClass('hiden');
}

function end_of_game() {
    write_score(number_of_tries);   
    if (!isNaN(Number(bestscore))) {
        if (number_of_tries < bestscore) { 
            $.cookie("bestScore", number_of_tries);
            write_best_score(number_of_tries);        
        }
    }
    else {
        $.cookie("bestScore", number_of_tries);
        write_best_score(number_of_tries); 
    }
    $('#startbuttondiv').append('<button  id ="startbutton" class="btn btn-warning" onClick="newgame();">New game!</button>');
    clearInterval(var_timer);
}

function newgame() {
    $(document).ready(function(){
        $('#startbutton').remove();
        $('#gameboard').empty();
        $('#yourscore').empty(); 
        $('#time').empty();           
    });

    number_of_turned = 0;
    turned_card = new Array();
    number_of_tries = 0;
    card_left = size_of_game*size_of_game/2;
    play_cards = new Array();
    startgame();
}


if (document.cookie.indexOf("bestScore") >= 0) { 
    bestscore = $.cookie("bestScore");
} else {
    $.cookie("bestScore", bestscore);
} 
write_best_score(bestscore);

