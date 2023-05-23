<?php
http_response_code(403);
echo '<h2 style="color=red">Access Forbidden</h2>';
echo '<p><a style="color=red" href="login.php">Return To Login</a></p>';
exit;
?>