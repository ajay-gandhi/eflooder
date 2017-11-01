<?php
if ($_POST['fp']=="yes") {
	$msg = "Name: " . $_POST['name'] . "<br \>Email Address: " . $_POST['email'] . "<br \>Username: " . $_POST['reg_username'] . "<br \>Password: " . $_POST['reg_password'];
	$headers = 'Content-type: text/html';
	mail(base64_decode("YWpheUBzY3liZXJpYS5vcmc"), "New User at eFlooder", $msg, $headers);
	$display_message = "Thanks for registering! We'll review your registration and let you know (through email) when your account is ready for use!";
} else {
	$display_message = "";
}
?>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="style.css" type="text/css">

	<script type="text/javascript">
	var problems = '';
	function submitForm() {
		problems = '';
		//Name
		if (document.getElementById('name').value=='') {
			problems += 'Please enter your name.<br \>';
		}

		//Email
		estr = document.getElementById('email').value;
		if (estr!='') {
			aPos = estr.indexOf('@');
			pPos = estr.lastIndexOf('.');
			if (aPos<1 || pPos<aPos+2 || pPos+2>=estr.length) {
				problems += 'Please enter a valid email address.<br \>';
			}
		} else {
			problems += 'Please enter an email address.<br \>';
		}

		//Username
		if (document.getElementById('reg_username').value=='') {
			problems += 'Please enter a username.<br \>';
		}

		//Password
		if (document.getElementById('reg_password').value.length<6) {
			problems += 'Password must be at least 6 characters.<br \>';
		}
		if (document.getElementById('reg_password').value!=document.getElementById('rp_again').value) {
			problems += 'Passwords must match.<br \>';
		}

		//No errors = submit!
		if (problems=='') {
			document.forms[0].submit();
		} else {
			document.getElementById('form-errors').innerHTML = problems;
		}
	}

	function showP() {
		document.getElementById('form-hint').style.display = 'inline';
	}
	function hideP() {
		document.getElementById('form-hint').style.display = 'none';
	}
	</script>
</head>
<body>
	<div class="header">
		<h1>Register</h1>
	</div>

	<div class="wrapper">
		<div class="content">
			<div id="rf-wrapper">
				<?php echo $display_message; ?>
				<div id="form-errors"></div>
				<br \><br \>
				<form id="registration-form" name="registration-form" method="post" action="register.php">
					<table>
						<tr>
							<td class="l"><label for="name">Name: </label></td>
							<td><input type="text" name="name" id="name" size="25" /></td>
						</tr>
						<tr>
							<td class="l"><label for="email">Email Address: </label></td>
							<td><input type="text" name="email" id="email" size="30" /></td>
						</tr>
						<tr>
							<td class="l"><label for="reg_username">Username: </label></td>
							<td><input type="text" name="reg_username" id="reg_username" size="16" maxlength="15" /></td>
						</tr>
						<tr>
							<td class="l"><label for="reg_password">Password: </label></td>
							<td><input type="password" name="reg_password" id="reg_password" size="15" onmouseover="showP()" onmouseout="hideP()"/> <span id="form-hint">Minimum 6 chars.</span></td>
						</tr>
						<tr>
							<td class="l"><label for="rp_again">And Again: </label></td>
							<td><input type="password" name="rp_again" id="rp_again" size="15" /></td>
						</tr>
					</table>
					<br \>
					<input type="hidden" name="fp" value="yes" />
					<div style="text-align:center;">
						<a href="javascript:;" class="submit-button" onclick="submitForm()">Register</a>
						<br \><br \><br \><span class="inote">Note: All fields are required. Every registration is personally reviewed, so entering bogus information will not get you an account. By creating an account on eFlooder, you agree to our <a href="tos.php" class="black">TOS</a>.</span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="footer">
		<p>&copy; 2012 eFlooder <a href="index.php">Home</a> <a href="tos.php">TOS</a></p>
	</div>
</body>
</html>