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

	if (!(isset($_POST['submit']))) {
	?> 
            <div id ="promo">
                <p>Are you <strong>too tired</strong> to tell to children your own bedtime stories? Don't worry! We have a lot of original stories and fairytales for your e-book.</p>
                <p> There are 10 stories in each online magazine. Order 3 different magazines and <strong>get story for every day in month</strong> - and discount of 15 %!</p><br/>
                <p id="calltoaction"> Fill in your personal details and select the best stories for you and your children:<p>
            </div>
            <div id="orderForm">
                <form action="#" name="subscribeform" method="POST" id="">
                    <input type="text" placeholder="First name" name="firstname" class="texfield">
                    <input type="text" placeholder="Last name" name="lastname" class="texfield">
                    <input type="text" placeholder="E-mail" name="email" class="texfield">
                    <span class="radiobuttons"> <input type="radio" name="gender" value="female" >Female </span>
                    <span class="radiobuttons"> <input type="radio" name="gender" value="male" class="radiobuttons">Male </span>
					<br>
					
					<?php Subscription::listMagazines($ktmagazines);?>
					
					<br>
					<div id="lengthOfSub">Subscription period: 
		    		<select name="period" id="selectperiod">
						<option value="6">6 months</option>
                        <option value="12">12 months</option>
                        <option value="18">18 months</option>
                        <option value="24">24 months</option>
                    </select>
					</div>
					<input type="submit" name="submit" value="Buy" class="btn btn-success btn-lg">
                </form>
            </div> <!--orderForm-->
            <?php
}

else {
    if (!empty($_POST["firstname"])) {
        $firstname = htmlspecialchars($_POST["firstname"]);
        $filled[0] = true;}
    else {$filled[0] = false;}
    if (!empty($_POST["lastname"])) {
        $lastname = htmlspecialchars($_POST["lastname"]);
        $filled[1] = true;}
    else {$filled[1] = false;}
    if ((!empty($_POST["email"])) and preg_match("/^[\w\.]+@\w+\...+$/", $_POST["email"])) {
        $email = htmlspecialchars($_POST["email"]);
        $filled[2] = true;}
    else {$filled[2] = false;}
    if (!empty($_POST["gender"])) {
        $gender = $_POST["gender"];
        $filled[3] = true;}
    else {$filled[3] = false;}
    if (!empty($_POST["period"])) {
        $period = $_POST["period"];
        $filled[4] = true;}
    else {$filled[4] = false;}
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
    else {$filled[5] = false;}
    
	if ($filled[0] == true
		&& $filled[1] == true
		&& $filled[2] == true
		&& $filled[3] == true
		&& $filled[4] == true
		&& $filled[5] == true
		) {
		?>	
		<div id="response">
			<p> We confirm your order! </p>
			<h2> Sumary: </h2>
			<p> <strong>First name: </strong><?php echo $firstname ?> </p>
			<p> <strong>Last name: </strong><?php echo $lastname ?> </p>
			<p> <strong>E-mail: </strong><?php echo $email ?> </p>
			<p> <strong>Subscription period: </strong><?php echo $period ?> months (expires: <?php 
			$mydate = strtotime(date("Y-m-d"));
			$expires = strtotime("+".$period." months", $mydate);
			
			echo date("Y-m-d", $expires);?>)</p>
			<p> <strong>Magazine(s): </strong><?php
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
	    
	    ?></p>			
            <p id="totalprice"><span style="font-size: 16px;"> <strong>Total price: <?php echo $suma?> CZK  </strong> </span><br /><?php
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
		            echo '(no discount... order more magazines and get discount!)';
		            break;    
		    }?>
                </p>
            <p id="claim"> Enjoy your time with your children! </p>    		   
		    </div> <!--response-->
        <?php
	    }
    else {?>
            <div id ="promo">
                <p>Are you <strong>too tired</strong> to tell to children your own bedtime stories? Don't worry! We have a lot of original stories and fairytales for your e-book.</p>
                <p> There are 10 stories in each online magazine. Order 3 different magazines and <strong>get story for every day in month</strong> - and discount of 15 %!</p><br/>
                <p id="calltoaction"> Fill in your name and select the best stories for you and your children:<p>
            </div>
            <p id="missing">Ooops! It seems you forgot to fill in some field in the form... </p>
            <div id="orderForm">
                <form action="#" name="subscribeform" method="POST">
                    <input type="text" placeholder="First name" name="firstname" class="texfield<?php if ($filled[0] == true) {echo '" value="' . $firstname . '"';} else {echo ' hightlight"';}?>>


                    <input type="text" placeholder="Last name" name="lastname" class="texfield<?php if ($filled[1] == true) {echo '" value="' . $lastname . '"';} else {echo ' hightlight"';}?>>
                    <input type="text" placeholder="E-mail" name="email" class="texfield<?php if ($filled[2] == true) {echo '" value="' . $email . '"';} else {echo ' hightlight"';}?>>
                    <?php if ($filled[3] == true) {?>
                    <span class="radiobuttons"> <input type="radio" name="gender" value="female"<?php if ($gender == "female") {echo ' checked';}?>>Female</span>
                    <span class="radiobuttons"> <input type="radio" name="gender" value="male"<?php if ($gender == "male") {echo ' checked';}?>>Male</span>
					<br>
                    <?php } 
                    else {?>
                    <span class="radiobuttons"> <input type="radio" name="gender" value="female" class="hightlight">Female</span>
                    <span class="radiobuttons"> <input type="radio" name="gender" value="male" class="hightlight">Male</span>
					<br><?php
					}
                    if ($filled[4] == true) {
                        Subscription::listMagazines($ktmagazines);
                        ?><br /><?php
                    }
                    else {
                        Subscription::listMagazines($ktmagazines); ?>
					    <br>
                    <?php } ?>
					<span id="lengthOfSub">Subscription period: </span>
		    		<select name="period" id="selectperiod">
						<option value="6"<?php if ($period == 6) {echo ' selected';}?>>6 months</option>
                        <option value="12"<?php if ($period == 12) {echo ' selected';}?>>12 months</option>
                        <option value="18"<?php if ($period == 18) {echo ' selected';}?>>18 months</option>
                        <option value="24"<?php if ($period == 24) {echo ' selected';}?>>24 months</option>
                    </select>
					<br>
					<input type="submit" name="submit" value="Buy" class="btn btn-success btn-lg">
                </form>
            </div> <!--orderForm-->
         <?php
    }
}
?>
        </div> <!--content-->
            <div id="footer">
                <p>October 2014</p>
                <p>Created as a homework for Webprogramming and Interaction design</p>
                <p>Author: katrinP - <a href="http://www.katrin.me">www.katrin.me</a><p/>
            </div> <!--footer-->
           <div> <!--all--> 
        </body>
    </html>
