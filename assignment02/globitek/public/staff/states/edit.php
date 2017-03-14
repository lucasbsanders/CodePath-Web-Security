<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
	redirect_to('index.php');
}
$states_result = find_state_by_id($_GET['id']);
// No loop, only one result
$state = db_fetch_assoc($states_result);
// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {

	// Confirm that values are present before accessing them.
	if(isset($_POST['name'])) { $state['name'] = $_POST['name']; }
	if(isset($_POST['code'])) { $state['code'] = $_POST['code']; }

	$result = update_state($state);
	if($result === true) {
		redirect_to('show.php?id=' . $state['id']);
	} else {
		$errors = $result;
	}
}
?>
<?php $page_title = 'Staff: Edit State ' . $state['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
	<?php echo "<a href=\"../countries/show.php?id=" . rawurlencode($state['country_id']) . "\">Back to Country: ";
	echo db_fetch_assoc(find_country_by_id($state['country_id']))['name'] . "</a>"; ?>

	<h1>Edit State: <?php echo $state['name']; ?></h1>

	<?php echo display_errors($errors); ?>

	<form action="edit.php?id=<?php echo $state['id']; ?>" method="post">
		Name:<br />
		<input type="text" name="name" value="<?php echo $state['name']; ?>" /><br />
		Code:<br />
		<input type="text" name="code" value="<?php echo $state['code']; ?>" /><br />
		<br />
		<input type="submit" name="submit" value="Update"  />
		<?php echo "<a href=\"show.php?id=" . rawurlencode($state['id']) . "\">Cancel</a>"; ?>
	</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
