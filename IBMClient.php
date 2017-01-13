<?php

//
// Joe McAlister https://joemcalister.com
//

class IBMClient {
    
    // user credentials -- these are not the login credentials for IBM Bluemix!
    var $credUsername = “USERNAME”;
    var $credPassword = “PASSWORD”;
    var $voice = "en-US_AllisonVoice";
    
    function __construct($voice)
    {
        // set the correct voice
        $this->voice = $voice;
    }
    
    function speakFormatted($text)
    {
        // enclose the string in speak
        $text = "<speak>".$text."</speak>";
        
        // upgrade the shortcut phrases
        $flag = true;
        while ($flag)
        {
            // grab the keyword
            $type = $this->get_string_between($text, "[", "]");
            
            // grab the inner
            $inner = $this->get_string_between($text, "[$type]", "[/$type]");
            
            if (strlen($inner) != 0)
            {
                $newInner = "<express-as type=\"$type\">".$inner."</express-as>";
                $text = str_replace("[$type]".$inner."[/$type]", $newInner, $text);
            }else {
                $flag = false;
            }
        }
        
        // create the json
        $json = json_encode(array("text"=>$text));

        // return the audio data
        return $this->curl($json);
    }
    
    function speakSSML($text)
    {
        // create the json
        $json = json_encode(array("text"=>$text));

        // return the audio data
        return $this->curl($json);
    }
    
    function curl($json)
    {
        // create curl
        $curl = curl_init();

        // Set URL to download
        $theVoice = $this->voice;
        
        // set the url to request
        curl_setopt($curl, CURLOPT_URL, "https://stream.watsonplatform.net/text-to-speech/api/v1/synthesize?voice=$theVoice");
        
        // form the header
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                                'Content-Type: application/json',
                                                'Accept: audio/wav'
                                                ));

        // add the credentials to the http request
        curl_setopt($curl, CURLOPT_USERPWD, $this->credUsername . ":" . $this->credPassword);
        
        // add the json data -- containing the plaintext
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

        // download the audio
        $output = curl_exec($curl);

        // close the curl
        curl_close($curl);
        
        // return the output
        return $output;
    }
    
    // Implementation of Justin Cook's function -- http://www.justin-cook.com/wp/2006/03/31/php-parse-a-string-between-two-strings/
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        
        if ($ini == 0) 
        {
            return '';
        }
        
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}

?>