<!DOCTYPE html>
<html>
    <head>
        <title>MyTunes!</title>
        <script src="list_songs.js"></script>
        <link rel="stylesheet" href="style.css" />
        <meta charset="UTF-8">
                            
    </head>
    <body>
        <?php include 'albums.php'; ?>
        <div id="all">
            <div id="header">
                <h1>MyTunes!</h1>
                <p id="slogan">Stop listening to music. Start to live the music.</p>
            </div><!--header-->
            <div id="content">
                <div id="albums">
                    <?php  list_albums($my_albums)?>
                </div><!--albums-->
                <div id="selected_album">
                    <p id="quote">“And those who were seen dancing were thought <br>to be insane by those who could not hear the music.” </p>
                    <p id="quote_author"> ― Friedrich Nietzsche</p>
                </div><!--selected album-->
            </content><!--div-->
            <div id="footer">
                <p>October 2014</p>
                <p>Created as a homework for Webprogramming and Interaction design</p>
                <p>Author: katrinP - <a href="http://katrin.me">www.katrin.me</a><p/>
            </div><!--footer-->
        </div><!--all-->    
    </body>
</html>
