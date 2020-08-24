<?php
/*
Credits: Bit Repository
URL: http://www.bitrepository.com/
*/

// To
define("WEBMASTER_EMAIL", 'mike@adrenaline4auto.com');

// Reply To
define("REPLY_TO", 'mike@adrenaline4auto.com');

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{

	function ValidateEmail($email)
	{
	/*
	Name: Letters, Numbers, Dots, Hyphens and Underscores
	@ sign
	Domain (with possible subdomain(s) ). Contains only letters, numbers, dots and hyphens (up to 255 characters)
	. sign
	Extension: Letters only (up to 10 (can be increased in the future) characters)
	*/

	$regex = "([a-z0-9_\.\-]+)". # name

	"@". # at

	"([a-z0-9\.\-]+){2,255}". # domain & possibly subdomains

	"\.". # period

	"([a-z]+){2,10}"; # domain extension 

	$eregi = eregi_replace($regex, '', $email);

	return empty($eregi) ? true : false;
	}

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = htmlspecialchars($_POST['message']);


$error = '';

// Check name

if(!$name)
{
$error .= 'Please enter your name.<br />';
}

// Check email

if(!$email)
{
$error .= 'Please enter an e-mail address.<br />';
}

if($email && !ValidateEmail($email))
{
$error .= 'Please enter a valid e-mail address.<br />';
}

// Check message (length)

if(!$message || strlen($message) < 15)
{
$error .= "Please enter your message. It should have at least 15 characters.<br />";
}


if(!$error)
{
$mail = mail(WEBMASTER_EMAIL, $subject, $message,
     "From: ".$email."\r\n"
    ."Reply-To: ".REPLY_TO."\r\n"
    ."X-Mailer: PHP/" . phpversion());

if($mail)
{
echo 'OK';
}

}
else
{
echo '<div class="notification_error">'.$error.'</div>';
}

}
?>