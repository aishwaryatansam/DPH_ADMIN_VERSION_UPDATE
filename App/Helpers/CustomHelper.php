<?php
use Illuminate\Support\Str;
use Carbon\Carbon;	
use Illuminate\Support\Facades\Crypt;
	
	function dateOf($date,$format='d/M/Y h:i A') {
		return Carbon::parse($date, 'UTC')->tz('Asia/Kolkata')->format($format);
	}

	function createdAt($date,$format='d/M/Y h:i A') {
		return Carbon::parse($date)->format($format);
	}

	function amount($amount) {
		return $amount. ' INR';
	}
	function showDate($time, $date_time_format='', $timezone='') {

		if($time != "") {
			return '--';
		}

		$timezone = ($timezone)?$timezone:config('constant.custom_timezone');

		$time = Carbon::parse($time);
		// if ((is_string($time))) {
		// 	$time = \Carbon\Carbon::createFromFormat('Y-m-d', $time);
		// }
		
		$time = $time->setTimezone($timezone);

		$date_time_format = ($date_time_format)?$date_time_format:config('constant.view_date_time_format');

        $custom_date_time = $time->format($date_time_format);

		return $custom_date_time;
	}

	function stringLength($string, $length = ''){

		$stringLimited = Str::limit($string,($length)?$length:config('constant.default_string_length'), '...');
		
        return $stringLimited;
	}

	function slugger($string,$glue='') {

		$glue = ($glue)?$glue:'-';

		return Str::slug($string,$glue);
	}


	function pageTitle($title) {
		return trans($title);
	}

	function saltFileName($filename) {

		/*this function will added the current time within the filename*/

		$filename_exploded = explode('.', $filename);

		return time().'_'.Str::slug($filename_exploded[0], '_').'.'.$filename_exploded[1];				
	}


	function checkAjax() {

		if(!request()->ajax()) {

			echo 'Bad Request.';
			exit;

		}
		return true;
	}

	function _status($status){
		return ($status == 1 || $status == true)?'Active':'False';
	}

	function Time24to12($time){
		$time = Carbon::parse($time);
		return $time->format('g:i A');
	}

	function Time12to24($time,$format="H:i"){
		$time = Carbon::parse($time);
		return $time->format($format);
	}

	function convertTimeFormat($time,$format="g:i a") {

		$time = Carbon::parse($time);
		return $time->format($format);	
	}

	function isPastTime($time) {

		$givenTime = Time12to24($time);
		$currentTime = Time12to24(now());
		
		if($currentTime < $givenTime) {
			return false;
		}

		return true;
	}

	function isOpenForOrder($opening,$closing) {
		
		$opening = Carbon::createFromFormat('Y-m-d H:i:s', $opening);
        $closing = Carbon::createFromFormat('Y-m-d H:i:s', $closing);
        $now = Carbon::createFromFormat('Y-m-d H:i:s', now());

		if($opening->lte($now) && $closing->gte($now)) {
			return 1; //open
		}

		if($opening->gte($now)) {
			return 2; //next
		}

		if($closing->lte($now)) {
			return 0; //closed
		}

		return 3;
	}

	function seconds_from_time($time) {
		list($h, $m, $s) = explode(':', $time);
		return ($h * 3600) + ($m * 60) + $s;
	}

	function dateTimePickerFormat($datetime) {

		return Carbon::parse($datetime)->toDateTimeLocalString();
	}


	function validateMobile($mobile)
	{
		$mobile = trim($mobile);
	    return preg_match('/^[0-9]{10}+$/', $mobile);
	}

	function urlWithQueryString($url) {

		$queries = request()->query();		
		$queryString = url($url)."?".http_build_query($queries);
		return $queryString;
	}

	function _today() {
		return Carbon::parse(today())->format('Y-m-d');
	}

	function getColorClass() {
		$colors = collect(['info','success','danger','primary','dark', 'warning']);
		$colors = $colors->shuffle();
		return $colors->first();

	}


	function getColorCode() {
		$str= 'ABCDEF0123456789';
	   $color_code = '#';
	   for ( $i = 0; $i < 6; $i++ ) {
	      $color_code .= $str[rand(0, strlen($str) - 1)];
	   }
	   return $color_code;

	}

	function addTrialZero($int) {
		return sprintf('%03d', $int);
	}

	function generateUniqueCode($name, $id){

		$slugKey = Str::slug(str_replace(' ', '', $name));

		$uniqueCode = $slugKey . str_pad($id, 5, '0', STR_PAD_LEFT);

		return $uniqueCode;
	}

	function encryptData($string)
	{
		return Crypt::encryptString($string);
	}

	function decryptData($encryptedString)
	{
		return Crypt::decryptString($encryptedString);
	}


