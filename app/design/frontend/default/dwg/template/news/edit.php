<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
	 //make sure the subject id sent is an integer
	if (!isset($_GET['editType'])) {
		redirect_to('reservations.php?room={$room}');
	}
	include_once("includes/form_functions.php");

		// clean up the form data before putting it in the database
		$id = mysql_prep($_GET['id']);
		$year = mysql_prep($_GET['year']);
		$month = mysql_prep($_GET['month']);
		$day = mysql_prep($_GET['day']);
		$room = mysql_prep($_GET['cabin']);

	// START FORM PROCESSING
	// only execute the form processing if the form has been submitted
	if ($_GET['editType'] == 'insert') {
//		// initialize an array to hold our errors
//		$errors = array();
//	
//		// perform validations on the form data
//		$required_fields = array('room', 'day', 'month', 'year');
//		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));
//		
//		$fields_with_lengths = array('menu_name' => 30);
//		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));		
	
		// Database submission only proceeds if there were NO errors.
//		if (empty($errors)) {
			$query = "INSERT INTO rooms (
						room, day, month, year
					) VALUES (
						{$room}, {$day}, '{$month}', {$year}
					)";
			if ($result = mysql_query($query, $connection)) {
				// as is, $message will still be discarded on the redirect
				$message = "The page was successfully created.";
				// get the last id inserted over the current db connection
				$new_page_id = mysql_insert_id();
				redirect_to("reservations.php?cabin={$room}&success={$new_page_id}");
			} //else {
//				$message = "The page could not be created.";
//				$message .= "<br />" . mysql_error();
//			}
//		} else {
//			if (count($errors) == 1) {
//				$message = "There was 1 error in the form.";
//			} else {
//				$message = "There were " . count($errors) . " errors in the form.";
//			}
//		}
		// END FORM PROCESSING
	} elseif ($_GET['editType'] =="delete") {
	// make sure the page exists (not strictly necessary)
	// it gives some extra security and allows use of 
	// the page's subject_id for the redirect
		// LIMIT 1 isn't necessary but is a good fail safe
		$query = "DELETE FROM rooms WHERE id = {$id} LIMIT 1";
		$result = mysql_query ($query);
		if (mysql_affected_rows() == 1) {
			// Successfully deleted
			redirect_to("reservations.php?cabin={$room}");
		} else {
			// Deletion failed
			echo "<p>Reservation deletion failed contact administrator at ambaum2@gmail.com.</p>";
			echo "<p>" . mysql_error() . "</p>";
			echo "<a href=\"reservations.php?cabin={$room}\">Return to Main Site</a>";
		}

	} else {
		redirect_to("reservations.php?cabin={$room}");
	}
		
?>
