<?php

define('TRENDOO_CREDITS_REQUEST','/Trend/CREDITS');
define('TRENDOO_SEND_SMS_REQUEST','/Trend/SENDSMS');
define('TRENDOO_REMOVE_DELAYED_REQUEST','/Trend/REMOVE_DELAYED');
define('TRENDOO_MSG_STATUS_REQUEST','/Trend/SMSSTATUS');
define('TRENDOO_HISTORY_REQUEST','/Trend/SMSHISTORY');
define('TRENDOO_LOOKUP_REQUEST','/OENL/NUMBERLOOKUP');
define('TRENDOO_NEW_SMS_MO_REQUEST','/OESRs/SRNEWMESSAGES');
define('TRENDOO_MO_HIST_REQUEST','/OESRs/SRHISTORY');
define('TRENDOO_MO_BYID_REQUEST','/OESRs/SRHISTORYBYID');
define('TRENDOO_SUBACCOUNTS_REQUEST','/Trend/SUBACCOUNTS');

define('TRENDOO_DATE_TIME_FORMAT','%Y%m%d%H%M%S');

class Trendoo_POST {
	var $params;
	var $result;

	function Trendoo_POST() {
		$this->params['login'] = TRENDOO_USERNAME;
		$this->params['password'] = TRENDOO_PASSWORD;
	}

	function add_param($name, $value) {
		$this->params[$name] = $value;
	}

	function do_post($request) {
		$request_url = 'http://'.TRENDOO_HOSTNAME;
		if (TRENDOO_DEFAULT_PORT != 80) {
			$request_url = $request_url.':'.TRENDOO_DEFAULT_PORT;
		}
		$request_url = $request_url.$request;
		$postdata = http_build_query($this->params);
		if (TRENDOO_PROXY == '') {
			$opts = array('http' =>
	    		array(
	        		'method'  => 'POST',
			        'header'  => 'Content-type: application/x-www-form-urlencoded',
			        'content' => $postdata
			    )
			);
		}
		else
		{
			$opts = array('http' =>
	    		array(
	        		'method'  => 'POST',
			        'header'  => 'Content-type: application/x-www-form-urlencoded',
			        'content' => $postdata,
	    			'proxy' => TRENDOO_PROXY.':'.TRENDOO_PROXY_PORT, 
	    			'request_fulluri' => true
			    )
			);
		
		}
		$context  = stream_context_create($opts);
		$this->result = file_get_contents($request_url, false, $context);
		list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
		switch($status_code) {
			case 200: return new Trendoo_response_parser($this->result);
			// maybe we could implement better error handling?
			default: return null;
		}
	}

}

define('TRENDOO_SEPARATOR','|');
define('TRENDOO_NEWLINE',';');
class Trendoo_response_parser {
	var $cursor;
	var $response;
	var $isok;
	var $errcode;
	var $errmsg;
	
	function Trendoo_response_parser($response) {
		$this->response = $response;
		$this->cursor = 0;
		if (strlen($response) >= 2) {
			$code = $this->next_string();
			if ('OK' == $code) {
				$this->isok = true;
			}
			if ('KO' == $code) {
				$this->isok = false;
				$this->errcode = $this->next_int();
				$this->errmsg = $this->next_string();
			}
		}
	}

	function next_string() {
		$nstr = '';
//		echo 'cursor:|'.$this->cursor.'|';
//		echo 'nstr:|'.$nstr.'|';
		while (($this->response[$this->cursor] != TRENDOO_SEPARATOR) &&
			($this->response[$this->cursor] != TRENDOO_NEWLINE)) {
//		echo 'Cnstr:|'.$nstr.'|';
			$nstr = $nstr.$this->response[$this->cursor++];
			if ($this->cursor >= strlen($this->response))
				break;
		}
//		echo 'Enstr:|'.$nstr.'|';
		if ($this->cursor < strlen($this->response) && $this->response[$this->cursor] != TRENDOO_NEWLINE) {
			$this->cursor++;
		}
		return urldecode($nstr);
	}
	function next_int() {
		return (int)$this->next_string();
	}
	function next_long() {
		return (float)$this->next_string();
	}

	function go_next_line() {
		while ($this->response[$this->cursor++] != TRENDOO_NEWLINE) {
			if ($this->cursor > strlen($this->response)) {
				return false;
			}
		}
		return strlen($this->response) != $this->cursor;
	}

	function get_result_array() {
		return array('ok' => $this->isok, 'errcode' => $this->errcode, 'errmsg' => $this->errmsg);
	}
}

?>
