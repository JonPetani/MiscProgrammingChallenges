<!--
Programmer: Jonathan Petani
Date: 6/29/2021
Purpose: A Form Page for a Business Event. Uses Client and Serverside Checks To Validate Inputs According to Business Rules
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body style='background-color:#c0ded9;'>
<div class='container-fluid'>
<div class='row'>
<img src='Images/header.png' class='img-responsive' title='Company View' alt='Company View'/><!--Header-->
</div>
<div class='row'>
<h1>Contact Details</h1>
<p>Fill Out the Form Below so we have information about you to join the event.</p>
</div>
<div class='row'>
<?php
//function to print error messages related to form inputs
function printError(string $errorCode, string $errorMessage) {
	if(isset($_GET['err']) == true) {
		if(strcmp($errorCode, $_GET['err']) == 0) {
			echo "<div class='alert-danger'>";
			printf("<p>%s</p>", $errorMessage);
			echo "</div>";
		}
	}
}
//field validation according to company requirements using php functions and regex where needed
if(strcmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
	if(strlen($_POST['First']) > 30 or empty($_POST['First']) == true) {
		header('Location: promoform.php?err=First');
		die;
	}
	if(strlen($_POST['Last']) > 30 or empty($_POST['Last']) == true) {
		header('Location: promoform.php?err=Last');
		die;
	}
	if(preg_match('^\d{1,30}$^', $_POST['Phone']) == 0) {
		header('Location: promoform.php?err=Phone');
		die;
	}
	if(preg_match('^.*@.*\..*$^', $_POST['Email']) == 0 or strlen($_POST['Email']) > 50) {
		header('Location: promoform.php?err=Email');
		die;
	}
	//control branch pertaining to the relationship between promo, hear from us, and other input tags
	if(empty($_POST['Promo']) and strcmp($_POST['Reference'], 'Pick') == 0) {
		header('Location: promoform.php?err=Promo');
		die;
	}
	else {
		if(strlen($_POST['Promo']) > 7) {
			header('Location: promoform.php?err=PromoSize');
			die;
		}
		$reference_arr = array('Social', 'Friend', 'Email', 'Other');
		$valid = false;
		foreach($reference_arr as $reference) {
			if(strcmp($reference, $_POST['Reference']) == 0)
				$valid = true;
		}
		if($valid == false and empty($_POST['Promo'])) {
			header('Location: promoform.php?err=Reference');
			die;
		}
		if((strcmp($_POST['Reference'], 'Other') == 0 and empty($_POST['Other'])) or (strcmp($_POST['Reference'], 'Other') != 0 and !empty($_POST['Other']))) {
			header('Location: promoform.php?err=Mismatch');
			die;
		}
		if(strlen($_POST['Other']) > 50) {
			header('Location: promoform.php?err=Other');
			die;
		}
	}
	if(strcmp($_POST['Terms'], 'Accept') != 0) {
		header('Location: promoform.php?err=Terms');
		die;
	}
	//represents successful submission
	echo "<div class='alert-success'>";
	echo "<h2>You have filled in all the fields correctly.</h2>";
	echo "</div>";
}
?>
</div>
<div class='row'>
<!--The Form with all input fields. regex is used for client side checks where appropriate-->
<form action='promoform.php' method='POST'>
<label for='First'><strong>Your First Name<span>*</span></strong></label>
<input type='text' name='First' placeholder='First Name' required autocomplete='false' pattern='^{1,30}$'/>
<?php printError('First', 'There seems to be an issue with your Frst Name. Make sure it is 30 Charecters or Less.');?>
<label for='Last'><strong>Your Last Name<span>*</span></strong></label>
<input type='text' name='Last' placeholder='Last Name' required autocomplete='false' pattern='^{1,30}$'/>
<?php printError('Last', 'There seems to be an issue with your Last Name. Make sure it is 30 Charecters or Less.');?>
<label for='Phone'>Your Phone Number<span>*</span></label>
<input type='text' name='Phone' placeholder='Phone Number' required autocomplete='false' pattern='^\d{10,30}$'/>
<?php printError('Phone', 'There seems to be an issue with your Phone Number. Make sure it is 30 Charecters or Less and that Only Digits Are Used.');?>
<label for='Email'><em>Your Email Address<span>*</span></em></label>
<input type='text' name='Email' placeholder='Email Address' required autocomplete='false' pattern='^.*@.*\..*$' maxlength='50'/>
<div class='bg-info'><label>This field is required in order to receive an email confirmation.</label></div> <!--Info Div For Email Field-->
<?php printError('Email', 'There seems to be an issue with your Email Address. Make sure it is 50 Charecters or Less and that it is a Valid Email Address Format (i.e JohnDoe@Doenuts.com).');?>
<label for='Promo'>Promo Code</label>
<input type='text' name='Promo' placeholder='Promo Code You Recieved (If None Was Provided, Answer Question Below)' autocomplete='false' pattern='^[A-Za-z0-9]{1,7}$'/>
<?php printError('Promo', 'Promo Or Reference of Where You Heard About Us is Required. Provide At Least 1 of the 2 please.');?>
<?php printError('PromoSize', 'There seems to be an issue with your Promo Code. Make sure it is 7 Charecters or Less and that Only Digits or Letters Are Used.');?>
<label for='Reference'>How did you hear?</label>
<select name='Reference'>
<option value='Pick'>Choose a Source Below</option><!--Default Start Option to Secure Dropdown-->
<option value='Social'>Social Media</option>
<option value='Friend'>From a Friend</option>
<option value='Email'>Email</option>
<option value='Other'>Other</option>
</select>
<?php printError('Reference', 'No Valid Choice was selected. Please make sure the option selected is in the dropdown.');?>
<?php printError('Mismatch', 'There is a mismatch in your sources. Only fill other field if you select Other from dropdown and that Other is filled if you select Other.');?>
<label for='Reference'>Please Specify</label>
<!--Other Text Field If Other in Dropdown is picked-->
<input type='text' name='Other' placeholder='Where You Heard About The Event From. (Only If You Selected Other)' autocomplete='false' pattern='^{1,255}$'/>
<?php printError('Other', 'There seems to be an issue with your Reference Source. Make sure it is 255 Charecters or Less.');?>
<label for='Terms'><a href='#term' data-toggle='collapse'>Accept Terms and Conditions<span>*</span></a></label><!--Hyperlink works with bootstrap collapse class instead of page refresh-->
<input type='checkbox' name='Terms' value='Accept' required autocomplete='false'/>
<label for='Terms'>I agree to the terms and conditions of this event.</label>
<?php printError('Terms', 'Terms of Services Must be Agreed to. Check the Box once they have been understood and accepted.');?>
<br>
<div id='term' class='collapse bg-info'><!--The Collapse class called by the hyperlink above-->
<ul>
<li>All cancellation requests must be received by March 1, 2022 </li>
<li>All cancellation requests are subject to a $100 cancellation fee.</li>
<li>No one under the age of 16 will be allowed on the show floor.</li>
</ul>
</div>
<br>
<input type='submit' value='Sign Up Now'/>
</form>
</div>
<div class='row' style='font-size:18px;font-weight:bold;'> <!--Footer-->
<p>For assistence please call 555-5555 or email test@test.com</p>
</div>
</div>
<script>
//JQuery Calls To Deal with Styling and Bootstrap Class Assignment
$('label').css({'font-size': '12px'});
$('span').css({'color': 'red', 'font-weight': 'bold'});
$('strong').css({'font-size': '14px'});
$('select, input[type="text"]').addClass('form-control');
$('h1, p, h2').css({'text-align': 'center'});
</script>
</body>
</html>