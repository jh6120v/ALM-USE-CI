<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message {
	public static function getMsg($t, $u = "") {
		if (isset($u) && $u != "") {
			echo "
			<script language=\"javascript\">
				alert(\"$t\");
				location.href=\"$u\";
			</script>";
			exit();
		} else {
			echo "
			<script language=\"javascript\">
				alert(\"$t\");
				location.href=\"javascript:history.back(-1)\";
			</script>";
			exit();
		}
	}

	public static function getAjaxMsg($data) {
		echo json_encode($data);
		exit();
	}
}
