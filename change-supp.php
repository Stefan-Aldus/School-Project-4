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
    <form action="change-supp-script.php" method="POST">
      <p>U zal alles in moeten vullen met de informatie die u aan wilt brengen, ookal wilt u dit niet veranderen</p>
      <h3>verander wachtwoord</h3>
      <div>
        <label for="pass">original company ID:</label>
        <input type="text" id="original" name="original" required />
      </div>
      <div>
        <label for="pass">Verander company:</label>
        <input type="text" id="newemail" name="newemail" required />
      </div>
      <div>
        <label for="pass">Verander adress:</label>
        <input type="text" id="nfn" name="nfn" required />
      </div>
      <div>
        <label for="pass">Verander straatnr:</label>
        <input type="text" id="nln" name="nln" required />
      </div>
      <div>
        <label for="pass">Verander postcode:</label>
        <input type="text" id="nad" name="nad" required />
      </div>
      <div>
        <label for="pass">Verander stad:</label>
        <input type="text" id="npc" name="npc" required />
      </div>
      <div>
        <label for="pass">Verander staat:</label>
        <input type="text" id="state" name="state" required />
      </div>
      <div>
        <label for="pass">Verander telefoon:</label>
        <input type="text" id="nci" name="nci" required />
      </div>
      <div>
        <label for="pass">Verander website:</label>
        <input type="text" id="nst" name="nst" required />
      </div>
      <input type="submit" name="submit" id="submit" value="verander gegevens">
    </form>

  </main>
</body>