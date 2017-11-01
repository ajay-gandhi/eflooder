<?php

if ($_POST['send-email']=="yes") {
	$input_errors = "Error:<br \>";
	
	if (empty($_POST['from'])) {
		$errors .= "Please enter a 'from' address.<br \>";
	} else {
		$from = $_POST['from'];
	}
	if (empty($_POST['replyto'])) {
		$replyto = $from;
	} else {
		$replyto = $_POST['replyto'];
	}
	if (empty($_POST['to'])) {
		$errors .= "Please enter a 'to' address.<br \>";
	} else {
		$to = $_POST['to'];
	}
	if (empty($_POST['subject'])) {
		$subject = "(No Subject)";
	} else {
		$subject = $_POST['subject'];
	}
	if (empty($_POST['number'])) {
		$number = 1;
	} else if ($_POST['number']>30) {
		$number = 30;
	} else if (is_numeric($_POST['number'])==false) {
		$number = 1;
	} else {
		$number = $_POST['number'];
	}
	if (str_replace(" ", "", htmlentities($_POST['msg']))=="<br>") {
		$errors .= "Please enter a message.";
	} else {
		$msg = $_POST['msg'];
		echo $msg;
	}
	
	if ($input_errors=="Error:<br \>") {
		$validation_errors = "Error:<br \>";
	
		if (filter_var($from, FILTER_VALIDATE_EMAIL)==false) {
			$validation_errors .= "Please enter a valid 'from' address.<br \>";
		}
		if (!empty($_POST['replyto'])) {
			if (filter_var($replyto, FILTER_VALIDATE_EMAIL)==false) {
				$validation_errors .= "Please enter a valid 'reply-to' address.<br \>";
			}
		}
		if (filter_var($to, FILTER_VALIDATE_EMAIL)==false) {
			$validation_errors .= "Please enter a valid 'to' address.<br \>";
		}
	
		if ($validation_errors=="Error:<br \>") {
			$headers = 'From: ' . $from . "\r\n" .
				   'Reply-To: ' . $replyto . "\r\n" .
				   'Content-type: text/html';
	
			$num_sent = 0;
			for ($n=0; $n<$number; $n++) {
				$worked = mail($to, $subject, $msg, $headers);
				if ($worked==true) {
					$num_sent++;
				}
			}
			if ($num_sent==20) {
				$num_sent = "20 (max)";
			}
			if ($worked==true) {
				echo "Email(s) successfully sent.<br \><pre>To: " . $to . "<br \>From: " . $from . "<br \>Reply-to: " . $replyto . "<br \>Subject: " . $subject . "<br \>Number of Emails Sent: " . $num_sent . "<br \>Message:<br \>" . $msg . "</pre>";
			} else {
				echo "Error:<br \>Could not send email.";
			}
		} else {
			echo $validation_errors;
		}
	} else {
		echo $input_errors;
	}
}

?>