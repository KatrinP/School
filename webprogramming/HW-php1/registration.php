    <html>
        <head>
            <title>K&amp;T publishing</title>
            <meta charset="utf-8">
            <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <link href="style.css" rel="stylesheet" type="text/css">
        </head>
        <body> <div id="all">
            <div id="header">
                <h1> K&amp;T publishing </h1>
                <p id="slogan"> your way to fairytale world </p>
            </div> <!--header-->
            <div id="content">
<?php
    
include 'Magazine.class.php';
include 'Subscription.class.php';
$permittedperiod = [6, 12, 18, 24];
   
if (!isset($_POST['submit'])) {
    echo '
            <div id ="promo">
                <p>Are you <strong>too tired</strong> to tell to children your own bedtime stories? Don\'t worry! We have a lot of original stories and fairytales for your e-book.</p>
                <p> There are 10 stories in each online magazine. Order 3 different magazines and <strong>get story for every day in the month</strong> - and discount of 15 %!</p><br/>
                <p id="calltoaction"> Fill in your personal details and select the best stories for you and your children:<p>
            </div> <!--promo-->
            <div id="orderForm">
                <form action="#" name="subscribeform" method="POST" id="">
                    <input type="text" placeholder="First name" name="firstname" class="texfield">
                    <input type="text" placeholder="Last name" name="lastname" class="texfield">
                    <input type="text" placeholder="E-mail" name="email" class="texfield">
                    <span class="radiobuttons"> <input type="radio" name="gender" value="female" > Female </span>
                    <span class="radiobuttons"> <input type="radio" name="gender" value="male" class="radiobuttons"> Male </span>
					<br>
					
					';
	Subscription::listMagazines($ktmagazines);
	echo '				
					<br>
					<div id="lengthOfSub">Subscription period: 
		    		<select name="period" id="selectperiod">';
		    		    foreach ($permittedperiod as $numbermonths) {
		    		        echo '<option value="' . $numbermonths . '"> ' . $numbermonths . ' months</option>';
		    		    }
   echo '                </select>
					</div>
					<input type="submit" name="submit" value="Buy" class="btn btn-success btn-lg">
                </form>
            </div> <!--orderForm-->
            ';
}

else {
    $errormissing = '<ul class="errormissing">';
    if (!empty($_POST["firstname"])) {
        $firstname = htmlspecialchars($_POST["firstname"]);
        $filled[0] = true;
    }
    else {
        $filled[0] = false;
        $errormissing .= "<li>Please fill in your first name.</li>";
    }
    if (!empty($_POST["lastname"])) {
        $lastname = htmlspecialchars($_POST["lastname"]);
        $filled[1] = true;
    }
    else {
        $filled[1] = false;
        $errormissing .= "<li>Please fill in your last name.</li>";
    }
    if (!empty($_POST["email"])) {
        if (preg_match("/^[\w\.]+@\w+\...+$/", $_POST["email"])) {
            $email = htmlspecialchars($_POST["email"]);
            $filled[2] = true;
        }
        else {
            $filled[2] = false;
            $email = htmlspecialchars($_POST["email"]);
            $errormissing .= "<li>Please fill in a correct email.</li>";
        }  
    }      
    else {
        $filled[2] = false;
        $errormissing .= "<li>Please fill in your email.</li>";
        $email = "";
    }
    if (!empty($_POST["gender"])) {
        $gender = $_POST["gender"];
        $filled[3] = true;
    }
    else {
        $filled[3] = false;
        $errormissing .=  "<li>Please fill in your gender.</li>"; 
    }
    if (!empty($_POST["period"])) {
        if (in_array($_POST["period"], $permittedperiod)) {
            $period = $_POST["period"];
            $filled[4] = true;
        }
        else {
            $filled[4] = false;
            $errormissing .=  "<li>Please don't hack the subscription period.</li>";
            $period = 0;
        }
    }
    else {
        $filled[4] = false;
        $errormissing .=  "<li>Please fill in subscription period.</li>";
        $period = 0;
    }
    $numberOrdered = 0;    
    if (!empty($_POST["mytitle"])) {
        $filled[5] = true;
        foreach ($_POST["mytitle"] as $magazineid) {
            foreach ($ktmagazines as $magazine) {
                if ($magazine->id == $magazineid) {
                    $magazine->ordered = true;
                    $numberOrdered++;
                }
            }
        }
    }
    else {
        $filled[5] = false;
        $errormissing .=  "<li>Please choose at least one magazine.</li>";
    }
    $errormissing .=  "</ul>";
	if ($filled[0] 
		&& $filled[1] 
		&& $filled[2] 
		&& $filled[3] 
		&& $filled[4] 
		&& $filled[5] 
		) {
		echo '	
		<div id="response">
			<p> We confirm your order! </p>
			<h2> Sumary: </h2>
			<p> <strong>First name: </strong>' . $firstname . ' </p>
			<p> <strong>Last name: </strong>' . $lastname . '</p>
			<p> <strong>E-mail: </strong>' . $email . ' </p>
			<p> <strong>Subscription period: </strong>' . $period . ' months (expires: ';
			$mydate = strtotime(date("Y-m-d"));
			$expires = strtotime("+".$period." months", $mydate);
			
			echo date("Y-m-d", $expires);
			echo '</p>
			<p> <strong>Magazine(s): </strong>';
		$suma = 0;	
	    if (is_array($_POST["mytitle"])) {
	        echo '<ul class="list-unstyled">';
		    foreach ($_POST["mytitle"] as $magazineid) {
		        foreach ($ktmagazines as $magazine) {
		            if ($magazine->id == $magazineid) {
		                echo '<li>'.$magazine->title . " (" . $magazine->price. " CZK) " . "</li>";
		                $suma += $magazine->price;
		                Subscription::subscribe($magazine->id, $email);
		           }
		                        
		        }   
		    }
		    echo '</ul>';
		    $suma = $suma * $period;
		    switch (true) {
		        case $numberOrdered == 2:
		            $suma *= 0.95;
		            break;
		        case $numberOrdered == 3:
		            $suma *= 0.90;
		            break;
		        case $numberOrdered > 3:
		            $suma *= 0.85;      
		            break;  
		        default:
		            $suma *= 1;
		            break;    
		    }
	    }
	    
	    echo '</p>			
                <p id="totalprice"><span style="font-size: 16px;"> <strong>Total price: ' . $suma . ' CZK  </strong> </span><br />';
        switch (true) {
		            case $numberOrdered == 2:
		                echo '(discount 5 %!)';
		                break;
		            case $numberOrdered == 3:
		                echo '(discount 10 %!)';
		                break;
		            case $numberOrdered > 3:
		                echo '(discount 15 %!)';     
		                break;  
		            default:
		                echo '(no discount...)';
		                break;    
		}
        echo' </p>
                <p id="claim"> Enjoy your time with your children! </p>    	
                <p id="smartadd">Actually, this is just a homework. If you realy want to have some e-book with fairy tales, you can buy it here: <a href="https://www.boobook.cz/kategorie/pro-deti-a-mladez">BOObook.cz</a> (in czech).</p>	   
		    </div> <!--response-->';
        
	    }
    else {
        echo '<div id ="promo">
                <p>Are you <strong>too tired</strong> to tell to children your own bedtime stories? Don\'t worry! We have a lot of original stories and fairytales for your e-book.</p>
                <p> There are 10 stories in each online magazine. Order 3 different magazines and <strong>get story for every day in the month</strong> - and discount of 15 %!</p><br/>
                <p id="calltoaction"> Fill in your name and select the best stories for you and your children:<p>
            </div>
            <div id="missing">
                <p>Ooops! It seems there\'s something wrong with your form: </p>';
        echo $errormissing . '
            </div>
            
            <div id="orderForm">
                <form action="#" name="subscribeform" method="POST">
                    <input type="text" placeholder="First name" name="firstname" class="texfield';
                        if (!$filled[0]) {echo ' hightlight';}
                        echo '"';
                        if ($filled[0]) {echo 'value="' . $firstname . '"';}
                        echo '>                   
                    <input type="text" placeholder="Last name" name="lastname" class="texfield';
                        if (!$filled[1]) {echo ' hightlight';}
                        echo '"';
                        if ($filled[1]) {echo 'value="' . $lastname . '"';}
                        echo '>
                    
                    <input type="text" placeholder="E-mail" name="email" class="texfield';
                        if (!$filled[2]) {echo ' hightlight';}
                            echo '" value="'. $email . '">';
                        if ($filled[3]) {
                            echo '<span class="radiobuttons"> <input type="radio" name="gender" value="female"';
                                if ($gender == "female") {echo ' checked';}
                            echo '> Female</span>
                            <span class="radiobuttons"> <input type="radio" name="gender" value="male"';
                            if ($gender == "male") {echo ' checked';}
                            echo '> Male</span>
					        <br>';
                        } 
                    else {
                        echo '    
                        <span class="radiobuttons"> <input type="radio" name="gender" value="female" class="hightlight"> Female</span>
                        <span class="radiobuttons"> <input type="radio" name="gender" value="male" class="hightlight"> Male</span>
					    <br>';
					}
                    if ($filled[4]) {
                        Subscription::listMagazines($ktmagazines);
                        echo '<br />';
                    }
                    else {
                        Subscription::listMagazines($ktmagazines);
					    echo '<br>';
                    }
					echo '<span id="lengthOfSub">Subscription period: </span>
					<select name="period" id="selectperiod">
		    		    ';
		    		    foreach ($permittedperiod as $numbermonths) {
		    		        echo '<option value="' . $numbermonths .'"';
		    		        if ($period == $numbermonths) {echo ' selected';}
		    		        echo '>' . $numbermonths . 'months</option>';
		    		    }
                    echo '</select>
					<br>
					<input type="submit" name="submit" value="Buy" class="btn btn-success btn-lg">
                </form>
            </div> <!--orderForm-->';
         
    }
}
?>
        </div> <!--content-->
            <div id="footer">
                <p>October 2014</p>
                <p>Created as a homework for Webprogramming and Interaction design</p>
                <p>Author: katrinP - <a href="http://katrin.me">www.katrin.me</a><p/>
            </div> <!--footer-->
           <div> <!--all--> 
        </body>
    </html>
