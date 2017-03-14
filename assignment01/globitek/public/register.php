<?php require_once('../private/initialize.php'); ?>
<?php
// Set default values for all variables the page needs.
$first_name=$last_name=$email=$username='';
$errors=[];

// if this is a POST request, process the form
// Hint: private/functions.php can help
if(is_post_request()){
	// Confirm that POST values are present before accessing them.
	$first_name=$_POST['first_name'] ?? '';
	$last_name=$_POST['last_name'] ?? '';
	$email=$_POST['email'] ?? '';
	$username=$_POST['username'] ?? '';
	// Perform Validations
	// Hint: Write these in private/validation_functions.php
  if(is_blank($_POST['first_name'])) {
    $errors[]="First name cannot be blank.";
  } elseif(!has_length($_POST['first_name'], ['min' => 2, 'max' => 20])) {
    $errors[]="First name must be between 2 and 20 characters.";
  } elseif(!preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $first_name)) {
    $errors[]="First name can only contain spaces, letters, and  - , . '";
  }

  if(is_blank($_POST['last_name'])) {
    $errors[]="Last name cannot be blank.";
  } elseif(!has_length($_POST['last_name'], ['min' => 2, 'max' => 30])) {
    $errors[]="Last name must be between 2 and 30 characters.";
  } elseif(!preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $last_name)) {
    $errors[]="Last name can only contain spaces, letters, and  - , . '";
  }
	if(is_blank($_POST['email'])) {
    $errors[]="Email cannot be blank.";
  } elseif(!has_length($_POST['email'], ['min' => 2, 'max' => 50])) {
    $errors[]="Email must be between 2 and 50 characters.";
  } elseif(!has_valid_email_format($_POST['email'])) {
    $errors[]="Email must be a valid format.";
  } elseif(!preg_match('/\A[0-9A-Za-z_@\.]+\Z/', $email)) {
    $errors[]="Email can only contain numbers, letters, and _ @ .";
  }
	if(is_blank($_POST['username'])) {
    $errors[]="Username cannot be blank.";
  } elseif(!has_length($_POST['username'], ['min' => 8, 'max' => 50])) {
    $errors[]="Username must be at least 8 characters.";
  } elseif(!preg_match('/\A[0-9A-Za-z_]+\Z/', $_POST['username'])) {
    $errors[]="Username can only contain numbers, letters, and _";
  } elseif(db_fetch_assoc(find_user_by_username($username))['id'] > 0){
		$errors[]="Username must be unique";
	}
}

// if there were no errors, submit data to database
if(empty($errors)&&!is_blank($first_name)&&!is_blank($last_name)&&!is_blank($email)&&!is_blank($username)){
	// Write SQL INSERT statement
	$sql="INSERT INTO users (first_name, last_name, email, username, created_at) VALUES ( ";
	$sql.="'".$first_name."'".", ";
	$sql.="'".$last_name."'".", ";
	$sql.="'".$email."'".", ";
	$sql.="'".$username."'".", ";
	$sql.="'".date('Y-m-d H:i:s')."'".");";

	// For INSERT statments, $result is just true/false
	$result = db_query($db, $sql);
	if($result) {
		db_close($db);
		header('Location: registration_success.php');
		exit;
	} else {
		echo db_error($db);
		db_close($db);
		exit;
	}
}
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
	<h1>Register</h1>
	<p>Register to become a Globitek Partner.</p>

	<?php echo display_errors($errors); ?>

	<!-- TODO: HTML form goes here -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
		<span>First Name:<br>
			<input type="text" name="first_name" maxlength="255" value="<?php echo $first_name?>">
		</span><br>
		<span>Last Name:<br>
			<input type="text" name="last_name" maxlength="255" value="<?php echo $last_name?>">
		</span><br>
		<span>Email:<br>
			<input type="text" name="email" maxlength="255" value="<?php echo $email?>">
		</span><br>
		<span>Username:<br>
			<input type="text" name="username" maxlength="255" value="<?php echo $username?>">
		</span><br><br>
		<input type="submit" name="submit" value="Submit">
	</form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
