<?php

if ($_GET['logout']=="true") {
	setcookie("scy-fm", "", time()-60);
} else {

$unames = array("1", "103020acd69acbc0a1b43915bea0378b", "2771977994b7f923065339b107dfd776", "0322646df0bc79f0c490086ed07e2400");
$pwds = array("1", "0bb16871f62c33ef50deebe2c98f3bd4", "062bfb2fb8da25634a29f1eda7106909", "691eaec600b44215be6b22fe58a9f560");

$display_message = "";
if ($_POST['submitted']=="yes") {
	if (array_search(md5($_POST['username']), $unames, true)!==false && array_search(md5($_POST['password']), $pwds, true)!==false) {
		if ($_POST['remember']=="yes") {
			setcookie("scy-fm", md5($_POST['password']));
		} else {
			setcookie("scy-fm", md5($_POST['password']), time()+120);
		}
	} else {
		$display_message = "<span style=\"color:red;\">Invalid username or password.</span><br \><br \>";
	}
}

if (array_search($_COOKIE['scy-fm'], $pwds, true)===false || empty($_COOKIE['scy-fm'])) {
?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<script type="text/javascript">
	function submitForm() {
		document.forms[0].submit();
	}
	</script>
</head>
<body>
	<div class="header">
		<h1>Login</h1>
	</div>

	<div class="wrapper">
		<div class="content">
			<form class="login-form" method="post" action="index.php">
				<?php echo $display_message; ?>
				<label for="username">Username: </label><input type="text" name="username" id="username" size="15" />
				<br \><label for="password">Password: </label><input type="password" name="password" id="password" size="15" />
				<br \><br /><input type="checkbox" name="remember" id="remember" value="yes" /><label for="remember"> Remember Me</label>
				<br \><br \><input type="hidden" name="submitted" value="yes" />
				<a href="javascript:;" class="submit-button" onclick="submitForm()">Login</a>
				<br \><br \><a href="register.php" class="black">Register</a> 
			</form>
		</div>
	</div>

	<div class="footer">
		<p>&copy; 2012 eFlooder <a href="register.php">Register</a> <a href="tos.php">TOS</a></p>
	</div>
</body>
</html>
<?php } else { ?>
<html>
<head>
	<title>eFlooder v1.0</title>
	<link rel="stylesheet" href="style.css" type="text/css">

	<script type="text/javascript" src="editor/nicEdit.js"></script>
	<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });

	function submitForm() {
		var from = document.getElementById('from').value;
		var replyto = document.getElementById('replyto').value;
		var to = document.getElementById('to').value;
		var subject = document.getElementById('subject').value;
		var number = document.getElementById('number').value;
		var msg = nicEditors.findEditor('message').getContent();

		if (window.XMLHttpRequest) {
			ajaxObj = new XMLHttpRequest();
		} else {
	 		ajaxObj = new ActiveXObject("Microsoft.XMLHTTP");
	  	}

		ajaxObj.onreadystatechange = function() {
			if (ajaxObj.readyState==4) {
				document.getElementById('results').innerHTML = ajaxObj.responseText;
			} else if (ajaxObj.readyState<4) {
				document.getElementById('results').innerHTML = '<i><span id="results-wait">Working...</span></i>';
			}
		}
		ajaxObj.open('POST', 'handler.php', true);
		ajaxObj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxObj.send('from='+from+'&replyto='+replyto+'&to='+to+'&subject='+subject+'&number='+number+'&msg='+msg+'&send-email=yes');
	}

	function showRT() {
		document.getElementById('form-hint').style.display = 'inline';
	}
	function hideRT() {
		document.getElementById('form-hint').style.display = 'none';
	}
	</script>
</head>
<body>
	<div class="header">
		<h1>eFlooder v1.0</h1>
	</div>

	<div class="wrapper">
		<div class="content">
			<table>
				<tr>
					<td class="l"><label for="from"><span class="required">* </span>From Email: </label></td>
					<td><input type="text" id="from" name="from" size="30" /></td>
				</tr>
				<tr>
					<td class="l"><label for="replyto">Reply-to Email: </label></td>
					<td><input type="text" id="replyto" name="replyto" size="30" onmouseover="showRT()" onmouseout="hideRT()"/> <span id="form-hint">If left blank, will be same as above.</span></td>
				</tr>
				<tr>
					<td class="l"><label for="to"><span class="required">* </span>To Email: </label></td>
					<td><input type="text" id="to" name="to" size="30" /></td>
				</tr>
				<tr>
					<td class="l"><label for="subject">Subject: </label></td>
					<td><input type="text" id="subject" name="subject" size="40" /></td>
				</tr>
				<tr>
					<td class="l"><label for="number">Number to Send: </label></td>
					<td><input type="text" id="number" name="number" size="2" maxlength="2"/></td>
				</tr>
				<tr>
					<td class="l" style="vertical-align:top;"><label for="message">Message: </label></td>
					<td><textarea id="message" name="message" rows="20" cols="60"></textarea></td>
				</tr>
				<tr>
					<td>
						<a href="javascript:;" class="submit-button" onclick="submitForm()">Send Email</a>
					</td>
				</tr>
			</table>
			<br \><span class="required">*</span><span class="inote"> denotes required field.</span>
			<br \><br \><div id="results"></div>
		</div>
	</div>

	<div class="footer">
		<p>&copy; 2012 eFlooder <a href="tos.php">TOS</a> <a href="index.php?logout=true">Logout</a></p>
	</div>
</body>
</html>
<?php } } ?>