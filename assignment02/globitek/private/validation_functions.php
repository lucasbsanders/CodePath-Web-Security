<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    } elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return is_whitelisted_email($value);
  }

	function is_number($value){
		return is_numeric($value);
	}
	
	function is_whitelisted_username($value) {
		return preg_match('/[^a-zA-Z0-9_]*/', $value) == true;
	}
	function is_whitelisted_phone($value) {
		return preg_match('/[^0-9()-]*/', $value) == true;
	}
	function is_whitelisted_email($value) {
		return preg_match('/[^a-zA-Z0-9@._-]*/', $value) == true;
	}

?>
