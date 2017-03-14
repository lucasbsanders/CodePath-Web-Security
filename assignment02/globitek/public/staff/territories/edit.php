<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$territories_result = find_territory_by_id($_GET['id']);
// No loop, only one result
$territory = db_fetch_assoc($territories_result);
// Set default values for all variables the page needs.
$errors = array();
$this_page = 'edit.php?id=' . $territory['id'];

if(is_post_request()) {

	// Confirm that values are present before accessing them.
	if(isset($_POST['name'])) { $territory['name'] = $_POST['name']; }
	if(isset($_POST['position'])) { $territory['position'] = $_POST['position']; }

	$result = update_territory($territory);
	if($result === true) {
		redirect_to('show.php?id=' . $territory['id']);
	} else {
		$errors = $result;
	}
}
?>
<?php $page_title = 'Staff: Edit Territory ' . $territory['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
	<?php echo "<a href=\"../states/show.php?id=" . rawurlencode($territory['state_id']) . "\">Back to State: ";
	echo db_fetch_assoc(find_state_by_id($territory['state_id']))['name'] . "</a>"; ?>

  <h1>Edit Territory: <?php echo $territory['name']; ?></h1>

	<?php echo display_errors($errors); ?>

	<form action=<?php echo $this_page; ?> method="post">
		Name:<br />
		<input type="text" name="name" value="<?php echo $territory['name']; ?>" /><br />
		Position:<br />
		<input type="text" name="position" value="<?php echo $territory['position']; ?>" /><br />
		<br />
		<input type="submit" name="submit" value="Update"  />
		<?php echo "<a href=\"show.php?id=" . rawurlencode($territory['id']) . "\">Cancel</a>"; ?>
	</form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
