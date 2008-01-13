<?php 
class BaseConnection {
	function BaseConnection(){
		if(get_class($this) == 'BaseConnection')
			trigger_error('Not implemented yet');
	}
	function open($info){	
		trigger_error('Not implemented yet');
	}
	function close(){
		trigger_error('Not implemented yet');
	}
	function execute($query){
		trigger_error('Not implemented yet');
	}
	function query($query){
		trigger_error('Not implemented yet');
	}
	function last_insert_id($sequence_name){
		trigger_error('Not implemented yet');
	}
	function bind_params($query, $params){
		trigger_error('Not implemented yet');
	}
	function escape($string){
		trigger_error('Not implemented yet');
	}
	function quote($value){
		trigger_error('Not implemented yet');
	}
	function quote_identifier($id){
		trigger_error('Not implemented yet');
	}
}
