<?php
    session_start();
    if(!isset($_SESSION['pseudo'])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <head>
    <meta charset="utf-8" />
    <title>Aide - Cube Fighter</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styleSheetPagesSite.css">
    <link rel="icon" type="image/png" href="Image/icon-cube.png" />
</head>

<body>
    <div class="wrapper">
    <?php
        include 'menu.php';
        ?>
    <div class="container" style="text-align:justify;">
        <h1  id="titre">Aide</h1>

        <h2>Ressources</h2>
        <p>Les ressources servent à mener la construction des différents bâtiments mais aussi à superviser la formation de citoyens spécialisés et la création de reliques. Chacun de ces éléments nécessite des quantités différentes de ressources, indiquées sous l’élément.
        <br>
        Exemple: une caserne coûte 600 de bois et 500 d’or.
        <br>
        Chaque ressource possède son propre type de dépôt qui ne peut en contenir qu’une quantité limitée.
        <br>
        Exemple: l’or est stocké dans une banque qui ne peut en contenir que 1000.
        <br>
        Ces ressources augmentent plus ou moins vite selon plusieurs critères. Le nombre d’habitations influence la quantité de citoyens ainsi que la récolte de bois tandis que les mineurs améliorent la récolte d’or.
        </p>

        <h2>Reliques</h2>
        <p>
        Les reliques permettent d’exposer sa richesse et sa supériorité face aux autres joueurs. Elles augmentent donc le score du village dans le classement général.
        </p>

        <h2>Bâtiments</h2>
        <p>
        Chaque bâtiment joue le rôle de dépôt pour une unité en particulier. Sa capacité de stockage varie selon le type d’élément qu’il contient.
        <br>La couleur du bâtiment est en corrélation avec la couleur de l’élément qu’il stocke.
        <br>Exemple: un centre de formation peut contenir jusqu’à 40 mineurs, la couleur associée est le bleu.
        </p>

        <h2>Constructions et formations</h2>
        <p>
        La construction d’un bâtiment nécessite des ressources. Le temps de construction est plus ou moins important selon le bâtiment construit.
        <br>Le temps d’attente restant est indiqué et mis à jour jusqu’à ce qu’il se termine. Il n’est possible de construire qu’un seul bâtiment à la fois.
        <br>De même, la formation de soldats et de reliques nécessite un temps de préparation avant d’être disponible. Les mineurs sont quant à eux directement opérationnels.
        <br>Il faudra tout de même attendre avant de pouvoir en former un nouveau.
        </p>

        <h2>Destructions de bâtiments</h2>
        <p>
        Il est possible de demander la destruction de bâtiments. Cela coûtera la moitié de son prix de construction et annulera toute construction en cours en perdant alors les ressources engagées.
        <br>Lorsqu’un bâtiment est détruit, les éléments qu’il contenait peuvent aussi être détruits si la capacité de stockage du village n’est plus suffisante pour les conserver dans un autre bâtiment du même type.
        <br>Exemple: une banque peut contenir jusqu’à 1000 d’or. Si un village possède deux banques et 2000 d’or et que l’on décide de détruire une banque, le stock d’or sera alors limité à 1000.
        </p>

        <h2>Attaque de villages et ennemis</h2>
        <p>
        Il est possible d’attaquer d’autres villages en envoyant un bataillon de soldats. Pendant l’attaque, les soldats peuvent réussir à détruire des bâtiments adverses et tuer des habitants s’ils ont une plus grande force d’attaque.
        <br>Ils peuvent aussi piller des ressources et des reliques pour les ramener au village. Cependant, il est possible que le bataillon subisse des pertes plus ou moins importantes pendant la bataille. Après une attaque, le village attaqué se barricade pendant un temps et est donc immunisé.
        </p>
        <br/><br/>

    </div>
        <div class="push"></div>
        </div>
        <?php
             include 'footer.php';
        ?>
</body>

</html>
