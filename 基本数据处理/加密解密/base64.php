<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-13
 * Time: 11:46
 */

function base64encode($str) {
	$base64 = [
		"A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
		'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '+', '/'
	];

	$len = strlen($str);
	$rstr = "";

	//入参的长度
	for($j=0; $j<$len/3; $j++) {

		$item = substr($str, $j*3, 3);
		$itemlen = strlen($item);
		$eightbit = "";

		for($i=0; $i<=$itemlen; $i++) {
			//十进制转二进制
			$bin[$i] = decbin(ord($item[$i]));
			//从字符串填充到8位
			$combin[$i] = str_pad($bin[$i], 8, "0", STR_PAD_LEFT);
			$eightbit .= $combin[$i];
		}

		for ($i = 0; $i <= $itemlen; $i++) {
			$sixbit = substr($eightbit, $i * 6, 6);
			$rstr .= $base64[bindec($sixbit)];
		}

		$pad = ["==", "=", ""];
		$rstr .= $pad[$itemlen-1];
	}


	return $rstr;
}

echo base64_encode("Maxwelldu");

$r = base64encode("Maxwelldu");
echo $r;
echo PHP_EOL;

echo base64_decode($r);


