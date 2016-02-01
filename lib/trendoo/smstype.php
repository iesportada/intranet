<?php

define('SMSTYPE_GOLD','GS');
define('SMSTYPE_GOLD_PLUS','GP');
define('SMSTYPE_SILVER','SI');
define('SMSTYPE_TITANIUM','TI');

function trendoo_sms_type_valid($smstype) {
	return 	$smstype === SMSTYPE_GOLD ||
			$smstype === SMSTYPE_GOLD_PLUS ||
			$smstype === SMSTYPE_SILVER ||
			$smstype === SMSTYPE_TITANIUM;
}

function trendoo_sms_type_has_custom_tpoa($smstype) {
	return $smstype === SMSTYPE_GOLD_PLUS ||
			$smstype === SMSTYPE_TITANIUM;
}
	
?>
