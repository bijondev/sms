<?php
// Data Senitizing Functions for Halkhata
// - RainWalker (http://iamrainwalker.wordpress.com/)

# HTMLpurifier Class
require_once('libs/htmlpurifier/HTMLPurifier.auto.php');
# pbkdf2 Class
require_once('libs/pbkdf2.php');

# Define Statics
define("RAIN_HASH_PASS", "r41nw4lk3r");
define("RAIN_HASH_SALT", "0p5h0r4");

# Sanitizing Function --------------------------------------------
function _rainsenitizedata($datainput){
	// Define HTMLpurifier
	$htmlpurifierconfig = HTMLPurifier_Config::createDefault();
	$rainhtmlpurifier 	= new HTMLPurifier($htmlpurifierconfig);
	// Clean XSS & Purify Data
	$senitizeddata	=	$rainhtmlpurifier->purify($datainput);
	// Convert to UTF8
	$senitizeddata	=	utf8_decode($senitizeddata);
	// Convert HTMLspecial Char
	$senitizeddata = htmlspecialchars($senitizeddata, ENT_QUOTES);
	// Return Purified Data
	return $senitizeddata;
}

# UnToxify Sanitized data ----------------------------------------
function _rainutxsenitizedata($datainput){
	// Convert HTMLspecial Char
	$senitizeddata = htmlspecialchars_decode($datainput);
	// Convert to UTF8
	$senitizeddata	=	utf8_decode($senitizeddata);
	// Return Purified Data
	return $senitizeddata;
}

# Create password protected Hash ---------------------------------
function _raingenhash($inputdata){
	$hasheddata	= pbkdf2("SHA256", $inputdata, RAIN_HASH_PASS, 1000, 24, false);
	return $hasheddata;
}

# Create Password Protected & Salted string ----------------------
function _raingensecstring($inputdata){
	$rainhash 	= 	base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(RAIN_HASH_PASS), $inputdata, MCRYPT_MODE_CBC, md5(md5(RAIN_HASH_SALT))));
	$rainhash	=	urlencode(strtr($rainhash,'+/=','-_,'));
	return $rainhash;
}

# Decode Protected Hash to main String ---------------------------
function _raindecodesecstring($inputdata){
	$rainhash = strtr(urldecode($inputdata),'-_,','+/=');
	$rainhash = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(RAIN_HASH_PASS), base64_decode($rainhash), MCRYPT_MODE_CBC, md5(md5(RAIN_HASH_SALT))), "\0");
	return $rainhash;
}

# Genareting Non Matching Uniq IDs -------------------------------
function _rainuniqcodes($prefix, $lenght){
	$random_pred	=	md5(base64_decode(RAIN_HASH_SALT.rand(00000000,99999999).date("F j, Y, g:i a").time().RAIN_HASH_PASS));
	$hashcoderend	= 	strtoupper(pbkdf2("SHA256", $random_pred, RAIN_HASH_PASS, 1000, $lenght, false));
	return $prefix.$hashcoderend;
}


function getMac(){
exec("ipconfig /all", $output);
foreach($output as $line){
if (preg_match("/(.*)Physical Address(.*)/", $line)){
$mac = $line;
$mac = str_replace("Physical Address. . . . . . . . . :","",$mac);
}
}
return $mac;
}


/*
$nastydata	= _rainsenitizedata('<img src="javascript:evil();" onload="evil();" /><h1>test</h1><h2>Cool');
echo "<b>Sanitization Chk 		: </b>"._rainutxsenitizedata($nastydata)."<br>";
$hackdata	=	_raingensecstring("Fuck Yah! Hack ME!");
echo "<b>Protected Hach Chk	: </b>".$hackdata."<br>";
echo "<b>Deoced Hash Chk		: </b>"._raindecodesecstring($hackdata)."<br>";
echo "<b>Hash Chk 				: </b>"._raingenhash('Full Authority!')."<br>";
echo "<b>Uniq Code Chk			: </b>"._rainuniqcodes("R",10);
 * 
 * 
*/
?>