<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<script src="html5.js"></script><!-- this is the javascript allowing html5 to run in older browsers -->

<title>My Unhosted node</title>
<link rel="stylesheet" href="css/uncompressed/reset.css" />
<link rel="stylesheet" href="css/uncompressed/text.css" />
<link rel="stylesheet" href="general.css" />
<link rel="stylesheet" href="css/uncompressed/login.css" />
</head>
	<header>
		<h1><strong>dev.unhosted.org </strong>Unhosted storage node</h1>
	</header>
	<body>

<?php
$showForm = true;
$errorMsg="";
if($_POST["user_name"]) {
	if($_POST["pwd"] && ($_POST["pwd"] == $_POST["pwd2"])) {
		if(!ctype_alnum($_POST["user_name"])) {
			$errorMsg = "please use only alphanumeric characters in your username";
		} else {
			$userDir = "/var/www/unhosted/dav/dev.unhosted.org/".strtolower($_POST["user_name"]);
			if(is_dir($userDir)) {
				$errorMsg = "user name taken";
			} else {//create the user
				mkdir($userDir);
				file_put_contents($userDir."/.htpasswd", sha1($_POST["pwd"]));
				$showForm = false;
			}
		}
	} else {
		$errorMsg="please enter the same password twice";
	}
}
if($showForm) {
?>
	<H2>Welcome developer of unhosted web apps!</H2>
	You can register here for a free test account, so you can quickly test and debug your unhosted web app.
	<H3><strong><?= $errorMsg ?></strong></H3>
	<form method="POST" target="?">
	<table>
	<tr><td align="right">Nick:</td><td align="left">
		<input name="user_name" type="text">@dev.unhosted.org</td></tr>
	<tr><td align="right">Password:</td><td align="left">
		<input name="pwd" type="password"></td></tr>
	<tr><td align="right">Repeat:</td><td align="left">
		<input name="pwd2" type="password"></td></tr>
	<tr><td></td><td align="left">
	<input type="submit">
	</td></tr>
	</table>
	</form>

<?php
} else {
?>
	<H2>Thank you!</H2>
	You now have an unhosted account at <?=$_POST["user_name"]?>@dev.unhosted.org. <a onclick="window.location=<?=$_GET["redirect_url"]?>;>Click here to return to the app you were logging into.</a>

<?php
}
?>

	</body>
</html>
