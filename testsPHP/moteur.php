<html>

    <!------------------------------------------------------------------>
    <!------------------ Fichier de test du moteur --------------------->
    <!------------------------------------------------------------------>


    <!-------------------------------->
    <!------- Creer un village ------->
    <!-------------------------------->
    <br />
    <input type="button" name="newVillage" value="Creer un nouveau village" onClick="createNewVillage()">
    <div id="newVillage">Aucune requete envoyée</div>
    <br /><br/>

    <!-- Include du jquery -->
    <script src = "Scripts/jquery-1.12.0.js"></script>

    <script type="text/javascript">
        function createNewVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('newVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'insertVillage.php');
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!------- Récupérer les données du village ------->
    <!------------------------------------------------>

    <br />
    <input type="text" name="id" id="id" value="1" onchange="replaceButtonText(butInfosVillage, this.value)">
    <button id="butInfosVillage" name="InfosVillage" onClick="getInfosVillage()">Récupérer les données du village 1</button> <br />
    <div id="infosVillage">Aucune requete envoyée</div>

    <br /><br/>

    <!-- Include du jquery -->
    <script src = "Scripts/jquery-1.12.0.js"></script>

    <script type="text/javascript">
        /* change le contenu du bouton selon le contenu du texte */
        function replaceButtonText(buttonId, id){
            var textBut = "Récupérer les données du village ";
            if(document.getElementById){
                var button=buttonId;
                if (button){
                    if (button.value){
                        button.value=textBut+id;
                    }
                    else if (button.childNodes[0]){
                        button.childNodes[0].nodeValue=textBut+id;
                    }
                    else //if (button.innerHTML)
                    {
                        button.innerHTML=textBut+id;
                    }
                }
            }
        }

        /* Renvoie les donnees du village */
        function getInfosVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('infosVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'getInfosVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!------ Ajout d'une habitation dans village ----->
    <!------------------------------------------------>
    <br />
    <br />
    <button id="butAddHabVillage" name="butAddHabVillage" onClick="AddHabVillage()">Ajouter une habitation au village</button> <br />
    <div id="addHabVillage">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function AddHabVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('addHabVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'addHabVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>



    <!------------------------------------------------>
    <!-------- Ajout d'une caserne dans village ------>
    <!------------------------------------------------>
    <br />
    <br />
    <button id="butAddCasVillage" name="butAddCasVillage" onClick="AddCasVillage()">Ajouter une caserne au village</button> <br />
    <div id="addCasVillage">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function AddCasVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('addCasVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'addCaserneVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!------- Formation d'un soldat dans village ----->
    <!------------------------------------------------>

    <br />
    <br />
    <button id="butTrainSolVillage" name="butTrainSolVillage" onClick="TrainSolVillage()">Former un soldat pour le village</button> <br />
    <div id="trainSolVillage">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function TrainSolVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('trainSolVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'trainSoldatVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>



    <!---------------------------------------------------->
    <!-- Creation d'un centre de formation dans village -->
    <!---------------------------------------------------->
    <br />
    <br />
    <button id="butAddCenVillage" name="butAddCenVillage" onClick="addCentreVillage()">Ajouter un centre de formation au village</button> <br />
    <div id="addCenVillage">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function addCentreVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('addCenVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'addCentreFormationVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>


    <!------------------------------------------------>
    <!------- Formation d'un mineur dans village ----->
    <!------------------------------------------------>
    <br />
    <br />
    <button id="butTrainMinVillage" name="butTrainMinVillage" onClick="trainMineurVillage()">Former un mineur pour le village</button> <br />
    <div id="trainMinVillage">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function trainMineurVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('trainMinVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'trainMineurVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>



    <!------------------------------------------------>
    <!------- Création d'un dépot 1 dans village ----->
    <!------------------------------------------------>
    <br />
    <br />
    <button id="butAddDep1Village" name="butAddDep1Village" onClick="addDep1Village()">Ajouter un dépot de ress1 au village</button> <br />
    <div id="addDep1Village">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function addDep1Village() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('addDep1Village').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'addDepot1Village.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>


    <!------------------------------------------------>
    <!------- Création d'un dépot 2 dans village ----->
    <!------------------------------------------------>
    <br />
    <br />
    <button id="butAddDep2Village" name="butAddDep2Village" onClick="addDep2Village()">Ajouter un dépot de ress2 au village</button> <br />
    <div id="addDep2Village">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function addDep2Village() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('addDep2Village').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'addDepot2Village.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!------ Création d'une fabrique dans village ---->
    <!------------------------------------------------>
    <br />
    <br />
    <button id="butAddFabVillage" name="butAddFabVillage" onClick="addFabVillage()">Ajouter une fabrique à reliques au village</button> <br />
    <div id="addFabVillage">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function addFabVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('addFabVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'addFabVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>


    <!------------------------------------------------>
    <!------ Création d'une relique dans village ----->
    <!------------------------------------------------>
    <br />
    <br />
    <button id="butMakeRelVillage" name="butMakeRelVillage" onClick="makeRelVillage()">Créer une relique dans le village</button> <br />
    <div id="makeRelVillage">Aucune requete envoyée</div>

    <script type="text/javascript">
        //
        function makeRelVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('makeRelVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'makeReliqueVillage.php?id='+document.getElementById('id').value);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!------ Destruction de casernes du village ------>
    <!------------------------------------------------>
    <br/>
    <br />
    <div>Nombre de batiments à détruire: </div>
    <input type="text" name="nbr" id="nbr" value="1">
    <div>L'utilisateur veut le détruire: </div>
    <input type="checkbox" name="voulue" id="voulue">
    <br />
    <button id="butDesCasVillage" name="butDesCasVillage" onClick="desCasVillage()">Détruire ces casernes du village</button> <br />
    <div id="desCasVillage">Aucune requete envoyée</div>


    <script type="text/javascript">
        //
        function desCasVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('desCasVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'remCaserneVillage.php?id='+document.getElementById('id').value+'&nbr='+document.getElementById('nbr').value+'&voulue='
                +document.getElementById('voulue').checked);
            xhr.send('');
        }
    </script>


    <!------------------------------------------------>
    <!----- Destruction d'habitations du village ----->
    <!------------------------------------------------>
    <br/>
    <button id="butDesHabVillage" name="butDesHabVillage" onClick="desHabVillage()">Détruire ces habitations du village</button> <br />
    <div id="desHabVillage">Aucune requete envoyée</div>


    <script type="text/javascript">
        //
        function desHabVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('desHabVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'remHabVillage.php?id='+document.getElementById('id').value+'&nbr='+document.getElementById('nbr').value+'&voulue='
                +document.getElementById('voulue').checked);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!---- Destruction de centres dans le village ---->
    <!------------------------------------------------>
    <br/>
    <button id="butDesCenVillage" name="butDesCenVillage" onClick="desCenVillage()">Détruire ces centres du village</button> <br />
    <div id="desCenVillage">Aucune requete envoyée</div>


    <script type="text/javascript">
        //
        function desCenVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('desCenVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'remCentreVillage.php?id='+document.getElementById('id').value+'&nbr='+document.getElementById('nbr').value+'&voulue='
                +document.getElementById('voulue').checked);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!------ Destruction de fabriques du village ----->
    <!------------------------------------------------>
    <br/>
    <button id="butDesFabVillage" name="butDesFabVillage" onClick="desFabVillage()">Détruire ces fabriques du village</button> <br />
    <div id="desFabVillage">Aucune requete envoyée</div>


    <script type="text/javascript">
        //
        function desFabVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('desFabVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'remFabVillage.php?id='+document.getElementById('id').value+'&nbr='+document.getElementById('nbr').value+'&voulue='
                +document.getElementById('voulue').checked);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!--- Destruction de dépots 1 dans le village ---->
    <!------------------------------------------------>
    <br/>
    <button id="butDesDep1Village" name="butDesDep1Village" onClick="desDep1Village()">Détruire ces dépots 1 du village</button> <br />
    <div id="desDep1Village">Aucune requete envoyée</div>


    <script type="text/javascript">
        //
        function desDep1Village() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('desDep1Village').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'remDepot1Village.php?id='+document.getElementById('id').value+'&nbr='+document.getElementById('nbr').value+'&voulue='
                +document.getElementById('voulue').checked);
            xhr.send('');
        }
    </script>

    <!------------------------------------------------>
    <!--- Destruction de dépots 2 dans le village ---->
    <!------------------------------------------------>
    <br/>
    <button id="butDesDep2Village" name="butDesDep2Village" onClick="desDep2Village()">Détruire ces dépots 2 du village</button> <br />
    <div id="desDep2Village">Aucune requete envoyée</div>


    <script type="text/javascript">
        //
        function desDep2Village() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('desDep2Village').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'remDepot2Village.php?id='+document.getElementById('id').value+'&nbr='+document.getElementById('nbr').value+'&voulue='
                +document.getElementById('voulue').checked);
            xhr.send('');
        }
    </script>



    <!---------------------------------------------------->
    <!---------- Combattre les autres villages ----------->
    <!---------------------------------------------------->
    <br/>
    <br />
    <div>Village à attaquer: </div>
    <input type="text" name="attacked" id="attacked" value="1">
    <br/>
    <div>Nombre de soldats à envoyer: </div>
    <input type="text" name="soldats" id="soldats" value="1">
    <br/>
    <button id="butAttackVillage" name="butAttackVillage" onClick="attackVillage()">Attaquer le village ennemi</button> <br />
    <div id="attackVillage">Aucune requete envoyée</div>


    <script type="text/javascript">
        //
        function attackVillage() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(xhr.status = 200 && xhr.readyState == 4) { //voir ce que c'est, car ne marche pas vraiment
                    document.getElementById('attackVillage').innerHTML = xhr.responseText; //change le contenu de l'element
                }
            }
            xhr.open('GET', 'attackVillage.php?id='+document.getElementById('id').value+'&attacked='+document.getElementById('attacked').value
                     +'&soldats='+document.getElementById('soldats').value);
            xhr.send('');
        }
    </script>


</html>


