<?php
include('converter.php');

if (!isset($_POST['step'])) $step = 1;
else $step = $_POST['step'];

print_header($step);

switch ($step) {
case 1:

	section("PHP 환경 검사...");

	$charset_converter = '';

	if(function_exists('iconv')) {
		ok('iconv 함수 확인됨');
		$charset_converter = 'iconv';
	} elseif(function_exists('mb_convert_encoding')) {
		ok('mb_convert_encoding 함수 확인됨');
		$charset_converter = 'mbstr';
	} else {
		error('Encoding 변환 함수를 사용할 수 없습니다.');
		break;
	}

	msg("변환에 필요한 환경 확인 완료");

	section("경고");

	warning("이 변환기는 기존 제로보드의 DB를 지우거나 덮어쓰는 작업을 하지 않습니다.<br/>그러나 이를 사용함으로써 발생하는 모든 피해는 사용자의 책임 하에 있습니다.");
	warning("변환기를 사용하기에 앞서 깨끗한 MetaBBS 설치본이 존재해야 합니다.");

	section("기본 정보 입력");
	
	form_start(2);
	input_hidden('charsetconv', $charset_converter);
	input_general('MySQL 사용자 이름', 'text', 'mysql_user', '');
	input_general('MySQL 암호', 'text', 'mysql_pw', '');
	input_general('MetaBBS 테이블 식별자', 'text', 'prefix', '');
	form_end();
	
	break;
	
case 2:

	section("MySQL 환경 검사...");

	section("변환 옵션");

	break;
case 3:

	break;
default:
	error("Invalid query.");	
}

print_footer();
?>
