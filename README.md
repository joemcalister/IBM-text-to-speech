# IBM Bluemix Text to speech request helper
This class allows easy authentication and request for IBM's Bluemix text to speech. More info on [Bluemix here](https://console.ng.bluemix.net/catalog/services/text-to-speech).

## How to install
Simply include the IBMClient.php file.
```php
include_once("IBMClient.php");
```

## How to use
Initiate the IBMClient class and pass it the voice id you wish to generate your speech using, more information and id's are available on IBM's website as linked above.
```php
$client = new IBMClient("en-US_AllisonVoice");
```
Generate the request and recieve the generated audio file using speakFormatted() or speakSSML().
```php
$audio = $client->speakFormatted('[Apology]Sorry Joe, I cant do that.[/Apology]');
```
speakFormatted() allows plain text but also includes optional emotive identifiers, to do this simply include the emotion within square brackets e.g. [Apology]text[/Apology]. This is a wrapper for the SSML text designed by me to simplify the process. For a list of supported emotions visit IBM's Bluemix website. (It's also important to note that not all voices support this). If do you wish to use custom SSML use the speakSSML() function.