<html>
    <head>
        <title>Pexeso!</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link href="style.css" rel="stylesheet" type="text/css">

        <script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>


    </head>
    <body>
        <div id="all">
            <div id="header">
                <h1>Pexeso time!</h1>
                <p id="slogan">
                    Do you wanna play with me?
                </p>
            </div><!--header-->
            <div id="content">
                <div id="rules">
                    <p>Find the same pairs of images!</p>
                </div> <!--rules-->
                
                <div id="gameboard">
                </div><!--gameboard-->
                
                <div id="box">    
                    <div id="score">
                        <div id="bestscore"> </div><!--bestscore-->
                        <div id="yourscore"> </div><!--yourscore-->
                        <div id="time"> </div><!--time-->
                    </div><!--score-->
                    <div id="startbuttondiv">
                        <button id ="startbutton" class="btn btn-warning" onClick="startgame();">Start game!</button>
                    </div><!--startbutton-->
                </div> <!--box-->    
                

            </div><!--content-->
            <div id="footer">
                <p>November 2014</p>
                <p>Created as a homework for Webprogramming and Interaction design</p>
                <p>Author: katrinP - <a href="http://katrin.me">www.katrin.me</a><p/>
            </div><!--footer-->

        </div>
             <script language="JavaScript" type="text/javascript" src="prepare_game.js"></script>
    </body>
</html>
