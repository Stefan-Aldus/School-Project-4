<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="company.css">
    <title>Document</title>
</head>

<body>
    <header>
        <?php
        
        
        session_start();
    

        // checks if user is signed in as a Admin, if not it will redirect you to the login page
        if (!isset($_SESSION["signedInCustomer"])) {
            header_remove();
            header("Location: index.php ");
            exit();
        }


        require_once("dbconnect.php");
        include "nav.php";
        ?>
    </header>

    <main>
<form action="change-pass-script.php" method="post"
>
<h3>verander wachtwoord</h3>
    <div>
      <label for="pass">oudwachtwooord:</label>
      <input type="password" id="oldpass" name="oldpass" required />
    </div>
    <div>
      <label for="pass">nieuw wachtwoord:</label>
      <input type="password" id="n-pass" name="n-pass" required />
    </div>
    <div>
      <label for="pass">herhaal wachtwoord:</label>
      <input type="password" id="n-pass" name="n-c-pass" required />
    </div>
    <input type="submit" name="submit" id="submit" value="verander wachtwoord">
</form>


<?php 


?>
    
    </main>        
    </body>