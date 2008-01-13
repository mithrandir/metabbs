<?php 
class BaseConnection {
	function BaseConnection(){
	if(get_class($this)=='BaseConnection')
		trigger_error('Implement BaseConnection class');
	}
	function open($info){	
		trigger_error('Implement BaseConnection class');
	}
	function close(){
		trigger_error('Implement BaseConnection class');
	}
	function execute($query){
		trigger_error('Implement BaseConnection class');
	}
	function query($query){
		trigger_error('Implement BaseConnection class');
	}
	function last_insert_id($sequence_name){
		trigger_error('Implement BaseConnection class');
	}
	function bind_params($query,$params){
		trigger_error('Implement BaseConnection class');
	}
	function escape($string){
		trigger_error('Implement BaseConnection class');
	}
	function quote($value){
		trigger_error('Implement BaseConnection class');
	}
	function quote_identifier($id){
		trigger_error('Implement BaseConnection class');
	}
}
