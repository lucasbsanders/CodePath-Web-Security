<?php

  //
  // COUNTRY QUERIES
  //

  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  // Find country by ID
  function find_country_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM countries ";
    $sql .= "WHERE id='" . $id . "';";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  function validate_country($country, $errors=array()) {
		if (is_blank($country['name'])) {
      $errors[] = "Country name cannot be blank.";
    } elseif (!has_length($country['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Country name must be between 2 and 255 characters.";
    }

    if (is_blank($country['code'])) {
      $errors[] = "Country code cannot be blank.";
    } elseif (!has_length($country['code'], array('exact' => 2))) {
      $errors[] = "Country code must be 2 characters.";
    }

    return $errors;
  }

  // Add a new country to the table
  // Either returns true or an array of errors
  function insert_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!empty($errors)) {
      return $errors;
    }

		$sql = "INSERT INTO countries ";
    $sql .= "(name, code) ";
    $sql .= "VALUES (";
    $sql .= "'" . sanitize($country['name']) . "',";
    $sql .= "'" . sanitize($country['code']) . "' ";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a country record
  // Either returns true or an array of errors
  function update_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!empty($errors)) {
      return $errors;
    }

		$sql = "UPDATE countries SET ";
    $sql .= "name='" . sanitize($country['name']) . "',";
    $sql .= "code='" . sanitize($country['code']) . "' ";
		$sql .= "WHERE id='" . sanitize($country['id']) . "' ";
    $sql .= "LIMIT 1;";

    // For update_country statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // STATE QUERIES
  //

  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id='" . $country_id . "' ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find state by ID
  function find_state_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id='" . $id . "';";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  function validate_state($state, $errors=array()) {
		if (is_blank($state['name'])) {
      $errors[] = "State name cannot be blank.";
    } elseif (!has_length($state['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "State name must be between 2 and 255 characters.";
    }

    if (is_blank($state['code'])) {
      $errors[] = "State code cannot be blank.";
    } elseif (!has_length($state['code'], array('exact' => 2))) {
      $errors[] = "State code must be 2 characters.";
    }

    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }
		$sql = "INSERT INTO states ";
    $sql .= "(name, code, country_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . sanitize($state['name']) . "',";
    $sql .= "'" . sanitize($state['code']) . "',";
    $sql .= "'" . sanitize($state['country_id']) . "' ";
    $sql .= ");";

    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

		$sql = "UPDATE states SET ";
    $sql .= "name='" . sanitize($state['name']) . "',";
    $sql .= "code='" . sanitize($state['code']) . "',";
    $sql .= "country_id='" . sanitize($state['country_id']) . "' ";
		$sql .= "WHERE id='" . sanitize($state['id']) . "' ";
    $sql .= "LIMIT 1;";

    // For update_state statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // TERRITORY QUERIES
  //

  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id='" . $state_id . "' ";
    $sql .= "ORDER BY position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find territory by ID
  function find_territory_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE id='" . $id . "';";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  function validate_territory($territory, $errors=array()) {
		if (is_blank($territory['name'])) {
      $errors[] = "Territory name cannot be blank.";
    } elseif (!has_length($territory['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Territory name must be between 2 and 255 characters.";
    }

    if (is_blank($territory['position'])) {
      $errors[] = "Position cannot be blank.";
    } elseif (!is_number($territory['position'])) {
      $errors[] = "Position must be numeric.";
    }

    return $errors;
  }

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO territories ";
    $sql .= "(name, state_id, position) ";
    $sql .= "VALUES (";
    $sql .= "'" . sanitize($territory['name']) . "',";
    $sql .= "'" . sanitize($territory['state_id']) . "',";
    $sql .= "'" . sanitize($territory['position']) . "' ";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

		$sql = "UPDATE territories SET ";
    $sql .= "name='" . sanitize($territory['name']) . "',";
		$sql .= "state_id='" . sanitize($territory['state_id']) . "',";
    $sql .= "position='" . sanitize($territory['position']) . "' ";
		$sql .= "WHERE id='" . sanitize($territory['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_territory statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // SALESPERSON QUERIES
  //

  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id='" . $territory_id . "' ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "WHERE id='" . $id . "';";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  function validate_salesperson($salesperson, $errors=array()) {
		if (is_blank($salesperson['first_name'])) {
			$errors[] = "First name cannot be blank.";
		} elseif (!has_length($salesperson['first_name'], array('min' => 2, 'max' => 255))) {
			$errors[] = "First name must be between 2 and 255 characters.";
		}

		if (is_blank($salesperson['last_name'])) {
			$errors[] = "Last name cannot be blank.";
		} elseif (!has_length($salesperson['last_name'], array('min' => 2, 'max' => 255))) {
			$errors[] = "Last name must be between 2 and 255 characters.";
		}

		if (is_blank($salesperson['phone'])) {
			$errors[] = "Phone cannot be blank.";
		} elseif (!has_length($salesperson['phone'], array('max' => 20))) {
			$errors[] = "Phone must be less than 20 characters.";
		} elseif (!is_whitelisted_phone($salesperson['phone'])) {
			$errors[] = "Phone must only contain valid characters.";
		}

		if (is_blank($salesperson['email'])) {
			$errors[] = "Email cannot be blank.";
		} elseif (!has_length($salesperson['email'], array('max' => 255))) {
			$errors[] = "Email must be less than 255 characters.";
		} elseif (!has_valid_email_format($salesperson['email'])) {
			$errors[] = "Email must be a valid format.";
		}

    return $errors;
  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

		$sql = "INSERT INTO salespeople ";
    $sql .= "(first_name, last_name, email, phone) ";
    $sql .= "VALUES (";
    $sql .= "'" . sanitize($salesperson['first_name']) . "',";
    $sql .= "'" . sanitize($salesperson['last_name']) . "',";
    $sql .= "'" . sanitize($salesperson['email']) . "',";
    $sql .= "'" . sanitize($salesperson['phone']) . "' ";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

		$sql = "UPDATE salespeople SET ";
    $sql .= "first_name='" . sanitize($salesperson['first_name']) . "', ";
    $sql .= "last_name='" . sanitize($salesperson['last_name']) . "', ";
    $sql .= "email='" . sanitize($salesperson['email']) . "', ";
    $sql .= "phone='" . sanitize($salesperson['phone']) . "' ";
    $sql .= "WHERE id='" . sanitize($salesperson['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_salesperson statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id='" . $id . "' ";
    $sql .= "ORDER BY territories.name ASC;";
    $territories_result = db_query($db, $sql);
    return $territories_result;
  }

  //
  // USER QUERIES
  //

  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // Find user using id
  function find_user_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM users WHERE id='" . $id . "' LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_user($user, $errors=array()) {
    if (is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($user['email'], array('max' => 255))) {
			$errors[] = "Email must be less than 255 characters.";
		} elseif (!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if (is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('max' => 255))) {
      $errors[] = "Username must be less than 255 characters.";
    } elseif (!is_whitelisted_username($user['username'])) {
			$errors[] = "Username must only contain valid characters.";
		}

    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, created_at) ";
    $sql .= "VALUES (";
    $sql .= "'" . sanitize($user['first_name']) . "',";
    $sql .= "'" . sanitize($user['last_name']) . "',";
    $sql .= "'" . sanitize($user['email']) . "',";
    $sql .= "'" . sanitize($user['username']) . "',";
    $sql .= "'" . $created_at . "' ";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . sanitize($user['first_name']) . "', ";
    $sql .= "last_name='" . sanitize($user['last_name']) . "', ";
    $sql .= "email='" . sanitize($user['email']) . "', ";
    $sql .= "username='" . sanitize($user['username']) . "' ";
    $sql .= "WHERE id='" . sanitize($user['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

	function sanitize($value){
		$value = trim($value);
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
		return $value;
	}
?>
