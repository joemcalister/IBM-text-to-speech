<?php

header('Content-type: audio/mpeg');
include_once("IBMClient.php");

// create ibm instance -- pass the voice you want
$ibm = new IBMClient("en-US_AllisonVoice");

// echo the result of parsing the text
echo($ibm->speakFormatted('[Apology]Sorry Joe, I cant do that.[/Apology]'));

?>