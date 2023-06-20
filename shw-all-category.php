<!DOCTYPE html>
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
    require_once("dbconnect.php");
    include "nav.php";
?>
  </header>
<section>
<h1>Overzicht categorieën</h1>
<?php
    try {
      $fullQuery = $db->prepare("SELECT category.name AS 'Categorie naam', category.ID AS 'Categorie ID' FROM category");
      $fullQuery->execute();
      $result = $fullQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Fout bij verbinden met database: " . $e->getMessage());
    }
    ?>

<table style="border: 1px solid black; border-collapse: collapse;">
  <caption>Hier is een overzicht van de soort categorieën die wij leveren.</caption>
  <tr>
    <th style="border: 1px solid black; padding: 8px;">Categorie ID</th>
    <th style="border: 1px solid black; padding: 8px;">Categorie Naam</th>
  </tr>
  <?php
  // Fetching data from the database and iterating through the results
  foreach ($result as $row) {
    echo "<tr>";
    echo "<td style='border: 1px solid black; padding: 8px;'>" . $row['Categorie ID'] . "</td>";
    echo "<td style='border: 1px solid black; padding: 8px;'>" . $row['Categorie naam'] . "</td>";
    echo "</tr>";
  }
  ?>
</table>
    </section>
  </header>
</body>

</html>