<?php
class KashRow extends CComponent
{
    private $_d;
    
    public function setData($data){
    	$this->_d = $data;
    }
	
	public function inXML($oXML) {
		$values=json_decode(json_encode($oXML),true);
		foreach($values as $key => $value)
		{
		    if(array_key_exists($key,get_class_vars(get_class($this))))
			$this->$key=$value;
		}
		return $this;
    }
    
    public function outXML() {
		$xml="";
		foreach(get_class_vars(get_class($this)) as $key => $value) {
		    if($this->$key && !is_array($value)){
				$xml.='<'.$key.'>'.$this->$key.'</'.$key.'>';
		    }
		}
		if($this->XMLPrefix){
	    	$xml='<'.$this->XMLPrefix.'>'.$xml.'</'.$this->XMLPrefix.'>';
		}
	    
		return $xml;
    }
    
    public function __toString() {
		return $this->outXML();
    }
}