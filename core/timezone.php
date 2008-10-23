<?php
// 이 라이브러리는 태터툴즈 코드에서 가져와 약간 수정되었습니다. (components/Eolin.PHP.Core.php)

// 코드 저작권:
/// Copyright (c) 2004-2007, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.

// MetaBBS 팀에서 고침

class Timezone {
	function isGMT() {
		return (date('Z') == 0);
	}
	
	function get() {
		$timezone = getenv('TZ');
		if (empty($timezone))
			$timezone = date('T');
		return (empty($timezone) ? 'UTC' : $timezone);
	}
	
	function getOffset() {
		return (int)date('Z');
	}
	
	function getCanonical() {
		return sprintf("%+03d:%02d", intval(Timezone::getOffset() / 3600), abs((Timezone::getOffset() / 60) % 60));
	}
	
	function getRFC822() {
		if (Timezone::isGMT())
			return 'GMT';
		else
			return sprintf("%+05d", intval(Timezone::getOffset() / 3600) * 100 + ((Timezone::getOffset() / 60) % 60));
	}
	
	function getISO8601($timezone = null) {
		if (Timezone::isGMT())
			return 'Z';
		else
			return sprintf("%+03d:%02d", intval(Timezone::getOffset() / 3600), abs((Timezone::getOffset() / 60) % 60));
	}
	
	function set($timezone) {
		if (@strncmp($_ENV['OS'], 'Windows', 7) == 0)
			$timezone = Timezone::getAlternative($timezone);
		
		return putenv('TZ=' . $timezone);
	}
	
	function setOffset($offset) {
		return Timezone::setISO8601(sprintf("%+02d:%02d", floor($offset / 3600), abs(($offset / 60) % 60)));
	}
	
	function setRFC822($timezone) {
		if (($timezone == 'GMT') || ($timezone == 'UT'))
			return Timezone::set('GMT');
		else if (!is_numeric($timezone) || (strlen($timezone) != 5))
			return false;
		else if ($timezone{0} == '+')
			return Timezone::set('UTC-' . substr($timezone, 1, 2) . ':' . substr($timezone, 3, 2));
		else if ($timezone{0} == '-')
			return Timezone::set('UTC+' . substr($timezone, 1, 2) . ':' . substr($timezone, 3, 2));
		else
			return false;
	}
	
	function setISO8601($timezone) {
		if ($timezone == 'Z')
			return Timezone::set('GMT');
		if (!preg_match('/^([-+])(\d{1,2})(:)?(\d{2})?$/', $timezone, $matches))
			return false;
		$matches[0] = 'GMT';
		$matches[1] = ($matches[1] == '+' ? '-' : '+');
		if (strlen($matches[2]) == 1)
			$matches[2] = '0' . $matches[2];
		if (empty($matches[3]))
			$matches[3] = ':';
		if (empty($matches[4]))
			$matches[4] = '00';
		return Timezone::set(implode('', $matches));
	}
	
	function getList() {
		return array(
			'Asia/Seoul',
			'Asia/Tokyo',
			'Asia/Shanghai',
			'Asia/Taipei',
			'Asia/Calcutta',
			'Europe/Berlin',
			'Europe/Paris',
			'Europe/London',
			'GMT',
			'America/New_York',
			'America/Chicago',
			'America/Denver',
			'America/Los_Angeles',
			'Australia/Sydney',
			'Australia/Melbourne',
			'Australia/Adelaide',
			'Australia/Darwin',
			'Australia/Perth',
			);
	}
	
	function getAlternative($timezone) {	
		switch ($timezone) {
			case 'Asia/Seoul':
				return 'KST-9';
			case 'Asia/Tokyo':
				return 'JST-9';
			case 'Asia/Shanghai':
				return 'CST-8';
			case 'Asia/Taipei':
				return 'CST-8';
			case 'Asia/Calcutta':
				return 'UTC-5:30';
			case 'Europe/Berlin':
			case 'Europe/Paris':
				return 'UTC-1CES';
			case 'Europe/London':
				return 'UTC0BST';
			case 'America/New_York':
				return 'EST5EDT';
			case 'America/Chicago':
				return 'CST6CDT';
			case 'America/Denver':
				return 'MST7MDT';
			case 'America/Los_Angeles':
				return 'PST8PDT';
			case 'Australia/Sydney':
			case 'Australia/Melbourne':
				return 'EST-10EDT';
			case 'Australia/Adelaide':
			case 'Australia/Darwin':
				return 'CST-9:30';
			case 'Australia/Perth':
				return 'WST-8';
		}
		return $timezone;
	}
}
?>
