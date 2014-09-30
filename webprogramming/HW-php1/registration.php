    <html>
        <head>
            <title>K&amp;T publishing</title>
            <meta charset="utf-8">
            <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <link href="style.css" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div id="header">
                <h1> K&amp;T publishing </h1>
                <p id="slogan"> your way to fairytale world </p>
            </div> <!--header-->
 <?php
    
    include 'Magazine.class.php';
    include 'Subscription.class.php';

	if (!(isset($_POST['submit']))) {
	?>

            <div id="orderForm">
                <form action="#" name="subscribeform" method="POST">
                    <input type="text" placeholder="First name" name="firstname">
                    <input type="text" placeholder="Last name" name="lastname">
                    <input type="text" placeholder="E-mail" name="email"></input>
                    <input type="radio" name="gender" value="female">Female
                    <input type="radio" name="gender" value="male">Male
					<br>
					
					<?php Subscription::listMagazines($ktmagazines);?>
					
					<br>
					<span id="lengthOfSub">Subscription period: </span>
		    		<select name="period">
						<option value="6">6 months</option>
                        <option value="12">12 months</option>
                        <option value="18">18 months</option>
                        <option value="24">24 months</option>
                    </select>
					<br>
					<input type="submit" name="submit" value="Buy">
                </form>
            </div> <!--orderForm-->
            <?php
}

else {
    if (!empty($_POST["firstname"])) {
        $firstname = $_POST["firstname"];
        $filled[0] = true;}
    else {$filled[0] = false;}
    if (!empty($_POST["lastname"])) {
        $lastname = $_POST["lastname"];
        $filled[1] = true;}
    else {$filled[1] = false;}
    if ((!empty($_POST["email"])) and preg_match("/^\w+@\w+\...+$/", $_POST["email"])) {
        $email = $_POST["email"];
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
			<p> We confirm your order! </p> <br />
			<h2> Sumary: </h2>
			<p> <strong>First name: </strong><?php echo $firstname ?> </p>
			<p> <strong>Last name: </strong><?php echo $lastname ?> </p>
			<p> <strong>E-mail: </strong><?php echo $email ?> </p>
			<p> <strong>Gender: </strong><?php echo $gender  ?> </p>
			<p> <strong>Subscription period: </strong><?php echo $period ?> months (expires: <?php 
			$mydate = strtotime(date("Y-m-d"));
			$expires = strtotime("+".$period." months", $mydate);
			
			echo date("Y-m-d", $expires);?>)</p>
			<p> <strong>Magazine(s): </strong><?php
		$suma = 0;	
	    if (is_array($_POST["mytitle"])) {
	        echo '<ul  id="maglist">';
		    foreach ($_POST["mytitle"] as $magazineid) {
		        foreach ($ktmagazines as $magazine) {
		            if ($magazine->id == $magazineid) {
		                echo '<li>'.$magazine->title . "</li>";
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
            <p id="totalprice"><span style="font-size: 16px;"> <strong>Total price:<?php echo $suma?> CZK  </strong> </span><br /><?php
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
		    </div> <!--response-->
        <?php
	    }
    else {?>
            <p id="missing">Ops! It seems you forgot to fill in some field in the form... </p>
            <div id="orderForm">
                <form action="#" name="subscribeform" method="POST">
                    <input type="text" placeholder="First name" name="firstname" <?php if ($filled[0] == true) {echo 'value="' . $firstname . '"';} else {echo 'class="hightlight"';}?>>


                    <input type="text" placeholder="Last name" name="lastname" <?php if ($filled[1] == true) {echo 'value="' . $lastname . '"';} else {echo 'class="hightlight"';}?>>
                    <input type="text" placeholder="E-mail" name="email" <?php if ($filled[2] == true) {echo 'value="' . $email . '"';} else {echo 'class="hightlight"';}?>>
                    <?php if ($filled[3] == true) {echo '
                    <input type="radio" name="gender" value="female"';
                    if ($gender == "female") {echo ' checked';}
                    echo '>Female
                    <input type="radio" name="gender" value="male"';
                    if ($gender == "male") {echo ' checked';}
                    echo '>Male
					<br>';}
                    else {echo '
                    <input type="radio" name="gender" value="female" class="hightlight">Female
                    <input type="radio" name="gender" value="male" class="hightlight">Male
					<br>';}
                    if ($filled[4] == true) {
                        Subscription::listMagazines($ktmagazines);
                        ?><br /><?php
                    }
                    else {
                        Subscription::listMagazines($ktmagazines); ?>
					    <br>
                    <?php } ?>
					<span id="lengthOfSub">Subscription period: </span>
		    		<select name="period">
						<option value="6"<?php if ($period == 6) {echo ' selected';}?>>6 months</option>
                        <option value="12"<?php if ($period == 12) {echo ' selected';}?>>12 months</option>
                        <option value="18"<?php if ($period == 18) {echo ' selected';}?>>18 months</option>
                        <option value="24"<?php if ($period == 24) {echo ' selected';}?>>24 months</option>
                    </select>
					<br>
					<input type="submit" name="submit" value="Buy">
					<!--<button type="submit" name="buy" value="buy" id="buybutton">Buy</button>-->
                </form>
            </div> <!--orderForm-->
         <?php
    }
}
?>
<div id="footer">
            </div> <!--footer-->
        </body>
    </html>
