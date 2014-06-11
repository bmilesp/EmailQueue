<p>Your Login Information for Underground Printing's Order Center is:</p>
<?php
	foreach ($users as $user)
	{
		echo "<p>";
		echo 	"<strong>" . $user['User']['first_name'] . " " . $user['User']['last_name'] . ":</strong><BR><BR>";
		echo 	"Username: " . $user['User']['username'] . "<BR>";
		echo 	"Password: " . $user['User']['password'];
		echo "</p>---------------------------------------------------";
	}
	
	if (count($users)>1)
	{
		echo "<p><strong>Why do I have multiple users?</strong>  Multiple users mean that you have multiple accounts with us that have the same email address.</p>";
	}
	
	echo "<p><strong>How do I change my password?</strong>  When you login, there is a link to your account settings in the top right corner of the page.  From there you can edit your user information, including your password.</p>";
?>
