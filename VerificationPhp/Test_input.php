<?php
  // Fonction qui permet d'éviter l'injection de code dans la base de données
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
