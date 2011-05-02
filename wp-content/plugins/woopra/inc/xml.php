<?php
/**
 * WoopraXML Class for Woopra
 *
 * This class contains all event related code for acessing the XML data.
 *
 * @since 1.4.1
 * @package woopra
 * @subpackage xml
 */
class WoopraXML {

	/**
	 * Parser object for XML-PHP
	 * @since 1.4.1
	 * @var object
	 */
	var $parser = null;
	
	/**
	 * Area of the set_url
	 * @since 1.4.2
	 * @var string
	 */
	var $area = null;
	
	/**
	 * URL
	 * @since 1.4.1
	 * @var string
	 */
	var $url = null;

	/**
	 * Data from XML
	 * @since 1.4.1
	 * @var array
	 */
	var $data = null;
	
	/**
	 * Counter at which tag.
	 * @since 1.4.1
	 * @var int
	 */
	var $counter = 0;
	
	/**
	 * Current TAG.
	 * @since 1.4.1
	 * @var string
	 */
	var $current_tag = null;
	
	/**
	 * What is the connection error?
	 * @since 1.4.1
	 * @var string
	 */
	var $connection_error = null;
	
	/**
	 * Any error messages?
	 * @since 1.4.1
	 * @var string
	 */
	var $error_msg = null;
	
	/**
	 * Bydays Found
	 * @since 1.4.1
	 * @var boolean
	 */
	var $byday_found = false;
	
	/**
	*Curl Check var
	*@since 1.4.5
	*@var boolean
	*/
	var $curlok = true;
	
	/**
	 * Hours Found
	 * @since 1.4.1
	 * @var boolean
	 */
	var $byhours_found = false;
	
	/**
	 * Index created
	 * @since 1.4.1
	 * @var boolean
	 */
	var $index_created = false;
	
	/**
	 * Has data been found?
	 * @since 1.4.1
	 * @var string
	 */
	var $founddata = false;
	
	/**
	 * Hostname of our site.
	 * @since 1.4.1
	 * @var string
	 */
	var $hostname = null;
	
	/**
	 * API Key
	 * @since 1.4.1
	 * @var string
	 */
	var $api_key = null;

	/**
	 * PHP 4 Style constructor which calls the below PHP5 Style Constructor
	 * @since 1.4.1
	 * @return none
	 */
	function WoopraXML() {
		$this->__construct();
	}

	/**
	 * Woopra XML
	 * @since 1.4.1
	 * @return none
	 * @constructor
	 */
	function __construct() {
		//	Nothing to do here...
	}
	
	/**
	 * Initialization of the Process Check
	 * @since 1.4.1
	 * @return boolean
	 */
	function init() {
		if (!$this->api_key)
			return false;
		return true;
	}
	
	/**
	curl extension functions
	chech if installed
	get content of a file using curl
	added by mario
	*/
	function iscurlinstalled() {
		return function_exists('curl_init');
	}
	function get_content($url)
	{
    $ch = curl_init();

    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
    $datas = curl_exec ($ch);
	
	if(curl_errno($ch)) $datas = false;

    curl_close ($ch);

    return $datas; 
	}
	/**
	 * Set the XML File Location
	 * 
	 * @since 1.4.2
	 * Modified by mario on 1.4.5
	 * 
	 * @param object $area
	 * @param object $xml_data
	 * @return 
	 */
	function set_xml($area, $xml_data) {
		
		$this->area = $area;
		
		switch ($area) {
			case 'render': {
				extract($xml_data, EXTR_OVERWRITE);
				$isset = false;
				if (strpos($key,'&')!== false) {
					$key2 = explode("&",$key);
					$key = $key2[0];
					$isset = true;
				}
				$this->url = "http://api.woopra.com/rest/analytics/get".strtolower($key).".jsp?website=".$this->hostname."&api_key=".$this->api_key."&date_format=".$date_format."&start_day=".$start_date."&end_day=".$end_date."&limit=".$limit."&offset=".$offset;
				if ($isset == true) { $this->url .= "&" . strtolower($key2[1]); }
				break;
			}
		}
		return true;
	}
	
	/**
	 * Clear the Data
	 * @since 1.4.1
	 * @return none
	 */
	function clear_data() {
		$this->data = null;
    	$this->counter = 0;
	}
	
	/**
	 * Process the XML File
	 * @since 1.4.1
	 *Modified by Mario on 1.4.5
	 * @return boolean
	 */
    function process_data() { 	
        $this->parser = xml_parser_create("UTF-8");
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'start_xml', 'end_xml');
        xml_set_character_data_handler($this->parser, 'char_xml');
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
				
        if (!($fp = @fopen($this->url, 'rb'))) {
		//fopen failed, try curl
			if (!$this->iscurlinstalled()) {
				//curl not installed go to error
				$this->connection_error = sprintf(__("%s: Cannot open URL. @fopen failed or URL failed.", 'woopra'), 'WoopraXML::parse(230)');
            return $this->error();
			} else {
				$data = $this->get_content($this->url);
				if ($data == "") {
					$this->curlok = false;
					return;
				}
				if ($data === false) {
					//curl failed go to error
					$this->connection_error = sprintf(__("%s: Cannot open URL. Curl failed", 'woopra'), 'WoopraXML::parse(240)');
					return $this->error();
				} else {
					//attempt parse
					if (!xml_parse($this->parser, $data, true)) {
						$this->error_msg = sprintf(__('%s: XML error at line %d column %d', 'woopra'), 'WoopraXML::parse(245)', xml_get_current_line_number($this->parser), xml_get_current_column_number($this->parser));
						return $this->error();
					}
				}
			}
        } else {
			while (($data = fread($fp, 8192))) {
				if (!xml_parse($this->parser, $data, feof($fp))) {
					$this->error_msg = sprintf(__('%s: XML error at line %d column %d', 'woopra'), 'WoopraXML::parse(253)', xml_get_current_line_number($this->parser), xml_get_current_column_number($this->parser));
					return $this->error();
				}
			}
		}
        if ($this->founddata) {
        	return true;
        } else {
        	$this->error_msg = sprintf(__("%s: No data entries found. Please check your API Key for mistakes", 'woopra'), 'WoopraXML::parse(261)');
        	return $this->error();
        }     
    }
	
	/**
	 * Resturn False
	 * @since 1.4.1
	 * @return boolean
	 */
	function error() {
		return false;
	}
	
	/** PRIVATE FUNCTIONS - Version 2.1 of the API **/
	
	/**
	 * Set the START Element Header
	 * @return  none
	 * @param object $parser
	 * @param object $name
	 * @param object $attribs
	 * @uses xml_set_element_handler
	 */
	function start_xml($parser, $name, $attribs) {
		
		//	Response Check
		if (($name == "response") && (!$this->founddata)) {
			if ($attribs['success'] == "true") {
				$this->founddata = true;
			}
		}
		
		if ($this->area == "status") {
			$this->current_tag = "status";
			return;
		}
		
		if ($this->area == "render") {
			//	By Day
			if ($name == "byday")
				$this->byday_found = true;
		
			if (($name == "day") && ($this->byday_found))
				$this->data[$this->counter]['days'][] = $attribs;
			
			//	Hours
			if ($name == "hours")
				$this->byhours_found = true;
			
			if (($name == "hour") && ($this->byhours_found))
				$this->data[$this->counter]['hours'][] = $attribs;
			
		}
		
		$this->current_tag = $name;
		
    }
	
	/**
	 * Set the END Element Header
	 * @return 
	 * @param object $parser
	 * @param object $name
	 * @uses xml_set_element_handler
	 */
    function end_xml($parser, $name) {
		if ($name == "item") {
			$this->counter++;
			$this->index_created = false;
		}	
    }
	
	/**
	 * Process the XML element
	 * @return 
	 * @param object $parser
	 * @param object $data
	 * @uses xml_set_character_data_handler
	 */
    function char_xml($parser, $data) {
    	
		//	Create Index ID
		if (!$this->index_created) {
			$this->data[$this->counter]['index'] = $this->counter;
			$this->index_created = true;
		}
		
		if ($this->founddata)
			$this->data[$this->counter][$this->current_tag] = $data;			
	}
}

?>