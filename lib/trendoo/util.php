<?php

function trendoo_is_valid_tpoa($tpoa) {
	return 
		preg_match('/^00[0-9]{7,16}$/',$tpoa) ||		// phone number in local format, or
		preg_match('/^\\+[0-9]{7,16}$/',$tpoa) ||	// phone number in international format, or
		strlen($tpoa) < 12;			// < 12 chars alphanumeric string
}

function trendoo_is_valid_international($phone) {
  return preg_match('/^\\+[0-9]{7,16}$/',$phone);
}

function trendoo_date_to_unix_timestamp($trendoo_date) {
  $res = strptime($trendoo_date,TRENDOO_DATE_TIME_FORMAT);
  if ($res != false) {
    return mktime($res['tm_hour'],$res['tm_min'],$res['tm_sec'],$res['tm_mon'],$res['tm_mday'],$res['tm_year']+1900);
  } else {
    return null;
  }
}

?>

