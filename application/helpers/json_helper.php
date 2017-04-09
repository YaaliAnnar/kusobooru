<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('json')){
	function convert_to_camel_case($var){
		$result = [];
		if (is_array($var)){
			foreach ($var as $key => $value){
		        $key = str_replace('_', '', ucwords($key, '_'));
		        $key = lcfirst($key);
				$result[$key] = convert_to_camel_case($value);
		    }
		} else {
			$result = $var;
		}
	    return $result;
	}

    function camel_case_json($var){
        $result = convert_to_camel_case($var);

        return json_encode($result);
    }   
}