<?php
class KashConnection
{	
    // Declare our global use variables
    private $curl;         // our curl handler
    private $httpheaders;  // the custom http headers (SOAPAction etc) we want to send to the API
    private $xml;          // the xml we are going to send to the API
    private $username = '';     // username to access the API
    private $password = '';     // password to access the API
    private $debugmode = 0;    // sets debug mode on, prints out all kinds of info
    
    private static $_self = null;
    
    /**
    * Constructor Function.
    * Pass username, password, output preferences and debug switch to the class
    * 
    * @param string $username Your KashFlow username
    * @param string $password Your KashFlow password
    * @param string $debugmode (Optional) Prints out a summary of whats being sent/received for tracking down issues. Default is OFF
    * 
    */
	private function __construct()
    {
		// check that curl and simplexml are available
		$extensions=get_loaded_extensions();
		if(!array_search("curl",$extensions))
		    die("Fatal Error: CURL is required");
		
		// start building out the headers and xml as much as possible before a specific function
		$this->InitVariables();
		$this->username = Yii::app()->getModule('kashflow')->username;
		$this->password = Yii::app()->getModule('kashflow')->password;
    }
    
    public static function get(){
    	if(self::$_self === null) self::$_self = new KashConnection();
		return self::$_self;
    } 
    
    /**
     * Private Function for Setting up initial values and cURL connection
     */           
    private function InitVariables()
    {
		// add the first few lines of the soap request
		$this->xml="<?xml version=".chr(34)."1.0".chr(34)." encoding=".chr(34)."utf-8".chr(34)."?>";
		$this->xml.="<soap:Envelope xmlns:xsi=".chr(34)."http://www.w3.org/2001/XMLSchema-instance".chr(34)." xmlns:xsd=".chr(34)."http://www.w3.org/2001/XMLSchema".chr(34)." xmlns:soap=".chr(34)."http://schemas.xmlsoap.org/soap/envelope/".chr(34).">";
		$this->xml.="<soap:Body>";
		
		// specify a few http headers to send
		$this->httpheaders=array();
		$this->httpheaders[]="User-Agent: CreoKashFlow/cURL";
		$this->httpheaders[]="Host: securedwebapp.com";
		$this->httpheaders[]="Content-Type: text/xml; charset=utf-8";
		$this->httpheaders[]="Accept: text/xml";
		
		// create a new curl instance, and set all the required base parameters
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_URL,"https://securedwebapp.com/api/service.asmx");                            
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_POST, 1);
    }
    
    /**
     * Private Function for sending the request to KashFlow
     * @param string $function The KashFlow function you are calling, eg: UpdateCustomer
     * @param string $xml The XML for the call, excluding username/password and the envelope stuff
     * @param integer $outputasarray If 1, will return the output as associative array
     */ 	    
    public function CallFunction($function,$xml='',$outputasarray=1){

		// add the remaining XML, using the function we're calling, the right namespace (not that we need it)
		// username and password etc, and close it all off
		$this->xml.="<".$function." xmlns=".chr(34)."KashFlow".chr(34).">";
		$this->xml.="<UserName>".$this->username."</UserName>";
		$this->xml.="<Password>".$this->password."</Password>";
		$this->xml.=$xml;
		$this->xml.="</".$function."></soap:Body></soap:Envelope>";
		
		// add the remaining headers, that we could only add once the xml is fully formed
		$this->httpheaders[]="Content-Length: ".strlen($this->xml);
		$this->httpheaders[]="SOAPAction: ".chr(34)."KashFlow/".$function.chr(34);

		// add the remaining curl options, that we could only add once the xml is fully formed
		// and the chosen method run
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->httpheaders);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->xml);

		// we make the curl call, and take what the server spits back as a string, then close the connection
		$output = curl_exec($this->curl);
		
		if($this->debugmode)
		{
		    echo "<b>Debug mode: Http Headers</b><br />".implode("<br />",$this->httpheaders)."<br /><br />";
		    echo "<b>Debug mode: Sent XML</b><br />".nl2br(htmlspecialchars($this->xml))."<br /><br />";
		    echo "<b>Debug mode: Received XML</b><br />".nl2br(htmlspecialchars($output))."<br /><br />";
		}
		  
		if(curl_errno($this->curl)) 
		{                                           
		    // if curl errors, then we copy the error to a variable so we can gracefully close down curl
		    $curlerror=curl_error($this->curl);
		    $curlerrorno=curl_errno($this->curl);
		    
		    // close the curl instance, so we can create another one later                    
		    curl_close($this->curl); 
		     
		    // we now reinit the header and xml variables, so after the exception we can make another call without redeclaring the object
		    $this->InitVariables();
		    
		    // then we throw an exception with the error text
		    // this means you could use a try/catch if you wanted to, or just let it error out.
		    throw new Exception("Error Connecting with KashFlow, CURL Error ".$curlerrorno.": ".$curlerror,$curlerrorno);                  
		}
		else
		{   
		    // close the curl instance, so we can create another one                          
		    curl_close($this->curl);   
		    
		    // we now reinit the header and xml variables, so we can make another call without redeclaring the object
		    $this->InitVariables();   

		    // simplexml has a hard time with tags with colons in, so we use this nice preg replace to kill them off
		    // credit where its due, thank you Dion: http://dd32.id.au/2007/09/29/php-simplexml-soap/
		    $xmlresponse=preg_replace('|<([/\w]+)(:)|m','<$1',preg_replace('|(\w+)(:)(\w+=\")|m','$1$3',$output));
		    
		    return $this->FaultCheck($function,$xmlresponse,$outputasarray);		    
		}               
    }
    
    protected function FaultCheck($function,$xmlresponse,$outputasarray=0){
		// we pass the xml we get back from KF to simplexml, so we can check for a soapFault
		//FB::log(htmlspecialchars_decode(htmlentities($xmlresponse)));
		$xml = @new SimpleXMLElement($xmlresponse);
		
		// if theres one or more instance of soapFault (realistically there will only ever be one)
		// we throw an exception with the text from KF                  
		if(count($xml->xpath('/soapEnvelope/soapBody/soapFault')))
		{
		    $fault=$xml->xpath('/soapEnvelope/soapBody/soapFault');
		    throw new Exception("Error returned from KashFlow, there might be something wrong with the values you supplied?: ".$fault[0]->faultstring);   
		}
		else
		{
		    // use some XPATH to get to our response
		    $info=$xml->xpath("//*[local-name()='".$function."Response']");
		    
		    // status check                         
		    /*if($info[0]->Status!="OK")
			throw new Exception("Error from Kashflow: ".$info[0]->StatusDetail);
		    else
		    {*/
			$result=$xml->xpath("//*[local-name()='".$function."Result']");
			
			if(!$outputasarray)
			    return $result[0];
			else
			    return $this->SimpleXmlToArray($result[0]);
		    //}
		}
	}
	    
	protected function SimpleXmlToArray($input){
		return json_decode(json_encode($input),true);
	}

}