<?php

require_once('util.php');
require_once('config.php');
require_once('smstype.php');
require_once('http_post.php');
require_once('nations.php');

function trendoo_get_credits() {
	$post = new Trendoo_POST();
	$rp = $post->do_post(TRENDOO_CREDITS_REQUEST);
	$res = $rp->get_result_array();
	$count = 0;
	if ($rp->isok) {
		while ($rp->go_next_line()) {
			$res[] = new Trendoo_CREDIT($rp->next_string(), $rp->next_string(), $rp->next_int());
			$count++;
		}
	}
	$res['count'] = $count;
	return $res;
}

class Trendoo_CREDIT {
	var $credit_type;
	var $nation;
	var $availability;
	
	function Trendoo_CREDIT($credit_type, $nation, $availability) {
		$this->credit_type = $credit_type;
		$this->nation = $nation;
		$this->availability = $availability;
	}

	function is_international() {
		return strlen($this->nation) != 2;
	}

	function get_nation_name() {
		if (strlen($this->nation) == 2) {
			return trendoo_get_nation_name($this->nation);
		} else {
			return null;
		}
	}
}

?>
