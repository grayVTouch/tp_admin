<?php

namespace app\admin\util;

class Calc extends Util {

	public static function add($number1, $number2, $num = 16) {
		return bcadd($number1, $number2, $num);
	}

	public static function min($number1, $number2, $num = 16) {
		return bcsub($number1, $number2, $num);
	}

	public static function mul($number1, $number2, $num = 16) {
		return bcmul($number1, $number2, $num);
	}

	public static function div($number1, $number2, $num = 16) {
		return bcdiv($number1, $number2, $num);
	}

	public static function ransfer2eth($value) {
		return self::div($value, 1000000000000000000);
	}

	public static function transfer2token($value) {
		return self::div($value, 10000);
	}

	public static function transfer2btc($value) {
		return self::div($value, 100000000);
	}

	public static function newfloor($val) {
		return floor($val * 100) / 100;
	}

	public static function transfer2ripple($value) {
		return self::div($value, 1000000);
	}

	public static function bc_dechex($decimal) {
		$result = array();
		while ($decimal != 0) {
			$mod = bcmod($decimal, 16);
			$decimal = bcdiv($decimal, 16);
			array_push($result, dechex($mod));
		}
		return "0x" . join(array_reverse($result));
	}

	public static function generate_order_id() {
		return date('YmdHis', time()) . ceil((microtime(5) - time()) * 10000) . rand(100, 999);
	}

	public static function number_to_string($number, $decimal_count = 4) {
		return number_format($number, $decimal_count, '.', '');
	}

}
