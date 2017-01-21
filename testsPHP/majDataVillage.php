<?php

include "constants.php"; //voir si necessaire

$id = (int) $_GET['id']; // en doublon ici au cas où


/* Récupération des données du village */
$sql = "SELECT * FROM village WHERE id=". $id;
if ($result = $conn->query($sql)) {
    if($result->num_rows > 0 && $row = $result->fetch_assoc()){
        $date = date_create($row["last_maj"]);
        $citoyens = $row["citoyens"];
        $soldats = $row["soldats"];
        $soldatDateDebut = $row["soldatDateDebut"];
        $mineurs = $row["mineurs"];
        $ress1 = $row["ress1"];
        $ress2 = $row["ress2"];
        $reliques = $row["reliques"];
        $reliqueDateDebut = $row["reliqueDateDebut"];
        $casernes = $row["casernes"];
        $habitations = $row["habitations"];
        $centresFormation = $row["centresFormation"];
        $fabriques = $row["fabriques"];
        $depots1 = $row["depots1"];
        $depots2 = $row["depots2"];
        $constrEnCours = $row["constrEnCours"];
        $constrDateDebut = $row["constrDateDebut"];
        $protected = $row["protected"];
        echo "<br/>Date enregistrée: " . date_format($date, 'Y-m-d H:i:s');

        date_default_timezone_set('Europe/Madrid');
        $now = date_create();
        echo "<br />Date now: ".date_format($now, 'Y-m-d H:i:s');
        $lastMaj = strtotime(date_format($date, 'Y-m-d H:i:s'));
        $nowSec =  strtotime(date_format($now, 'Y-m-d H:i:s'));
        $diffTime = abs($nowSec - $lastMaj); //TODO enlever le abs
        echo "<br/> Différence : " . abs($nowSec - $lastMaj) ."<br/>";


        /***********************************/
        /*      Update des ressources      */
        /***********************************/

        /* Update citoyens */
        if($habitations * $stockCitByHab < $citoyens + $diffTime*$habitations){ //On ne peut pas dépasser le stockage max
            $citoyens = $habitations * $stockCitByHab;
        }else{
            $citoyens = $citoyens + $diffTime*$habitations;
        }

        /* Update ressources 1 */
        $calcul1 = $ress1 + $diffTime*(1+10*$habitations);
        //Suite arithmétique un+1 = un + 1 + 10*$habitations; (par seconde)
        //Formule d'une suite arithmétique un = uo +n*r
        //avec n = diffTime, u0 = ress1 de raison 1+10*$habitations

        //On ne peut pas dépasser le stockage max
        if($depots1 * $stockRess1ByDep < $calcul1){
            //Seulement, il est possible qu'un dépot ait été créé entre temps, on vérifie et adapte plus loin dans dépôt1
            $newRess1 = $depots1 * $stockRess1ByDep;
        }else{
            $newRess1 = $calcul1;
        }
        //On vérifie aussi si une habitation a été ajouté durant cette période plus loin dans habitation


        /* Update ressources 2 */
        $calcul2 = $ress2 + $diffTime*(1+5*$mineurs);
        //Suite arithmétique un+1 = un + 1 + 5*mineurs; (par seconde)
        //Formule d'une suite arithmétique un = uo +n*r
        //avec n = diffTime, u0 = ress2 de raison 1+5*mineurs

        if($depots2 * $stockRess2ByDep < $calcul2){ //On ne peut pas dépasser le stockage max
            //Seulement, il est possible qu'un dépot ait été créé entre temps, on vérifie et adapte plus loin dans dépôt2
            $newRess2 = $depots2 * $stockRess2ByDep;
        }else{
            $newRess2 = $calcul2;
        }
        //On vérifie aussi si un mineur a été ajouté durant cette période plus loin dans mineur




        /************************************************/
        /*      Vérication si un batiment est fini      */
        /************************************************/
        if($constrEnCours!=0){
            $constr =  strtotime(date_format(date_create($constrDateDebut), 'Y-m-d H:i:s'));
            if ($constrEnCours == 1){ //Habitation
                $constr = $constr + $timeConstrHab;
                if(($nowSec - $constr)>=0){

                    /* Mise à jour ressources 1 */
                    $newRess1 = $newRess1 + 10*($nowSec - $constr); //Ici, on ajoute ce que l'habitation supplémentaire a permis de récupérer
                    if($depots1 * $stockRess1ByDep < $newRess1){ //On ne peut pas dépasser le stockage max
                        $newRess1 = $depots1 * $stockRess1ByDep;
                    }

                    /* Mise à jour citoyens */
                    if($habitations * $stockCitByHab <= $citoyens){ //Modification seulement si on a atteint le stock max
                        //On doit savoir au bout de combien de temps ce stock max a été atteint
                        if($habitations!=0){
                            $secAvantFull = ceil(($habitations * $stockCitByHab - $citoyens) / ($habitations)); //valeur entière supérieure
                        }else{ //Si on a pas d'habitation, le stock atteint des de debut
                            $secAvantFull = 0;
                        }
                        //Formule suite: n = (un - u0) / r
                        $secApresFull = $diffTime - $secAvantFull; //Temps pendant lequel le stock était jugé plein
                        $secHabConstr = $nowSec - $constr; //Temps pendant lequel le dépôt était construit
                        if($secApresFull > $secHabConstr){
                            //Le stock était plein avant la fin de la construction, on ajoute donc tout ce que le depot a pu stocker en plus
                            $calcul = $citoyens + $secHabConstr*($habitations+1);
                            //On ne peut pas dépasser le nouveau stockage max
                            if(($habitations+1) * $stockCitByHab < $calcul){
                                $citoyens = ($habitations+1) * $stockCitByHab;
                            }else{
                                $citoyens = $calcul;
                            }
                        }else{
                            //Le stock était plein après la fin de la construction
                            $calcul = $citoyens + $secApresFull*($habitations+1);
                            //On ne peut pas dépasser le nouveau stockage max
                            if(($habitations+1) * $stockCitByHab < $calcul){
                                $citoyens = ($habitations+1) * $stockCitByHab;
                            }else{
                                $citoyens = $calcul;
                            }
                        }
                    }
                    $habitations = $habitations +1;
                    $constrEnCours=0;
                }
            }else if($constrEnCours == 2){ //Caserne
                $constr = $constr + $timeConstrCas;
                if(($nowSec - $constr)>=0){
                    $casernes = $casernes +1;
                    $constrEnCours=0;
                }
            }else if($constrEnCours == 3){ //Centre de formation
                $constr = $constr + $timeConstrCen;
                if(($nowSec - $constr)>=0){
                    $centresFormation = $centresFormation +1;
                    $constrEnCours=0;
                }
            }else if($constrEnCours == 4){ //Fabrique à reliques
                $constr = $constr + $timeConstrFab;
                if(($nowSec - $constr)>=0){
                    $fabriques = $fabriques +1;
                    $constrEnCours=0;
                }
            }else if($constrEnCours == 5){ //Dépot 1
                $constr = $constr + $timeConstrDep1;
                if(($nowSec - $constr)>=0){

                    /* Mise à jour ressources 1 */
                    if($depots1 * $stockRess1ByDep <= $newRess1){ //Modification seulement si on a atteint le stock max
                        //On doit savoir au bout de combien de temps ce stock max a été atteint
                        $secAvantFull = ceil(($depots1 * $stockRess1ByDep - $ress1) / (1+10*$habitations)); //valeur entière supérieure
                        //Formule suite: n = (un - u0) / r
                        $secApresFull = $diffTime - $secAvantFull; //Temps pendant lequel le stock était jugé plein
                        $secDepotConstr = $nowSec - $constr; //Temps pendant lequel le dépôt était construit
                        if($secApresFull > $secDepotConstr){
                            //Le stock était plein avant la fin de la construction, on ajoute donc tout ce que le depot a pu stocker en plus
                            $calcul1 = $newRess1 + $secDepotConstr*(1+10*$habitations);
                            //On ne peut pas dépasser le nouveau stockage max
                            if(($depots1+1) * $stockRess1ByDep < $calcul1){
                                $newRess1 = ($depots1+1) * $stockRess1ByDep;
                            }else{
                                $newRess1 = $calcul1;
                            }
                        }else{
                            //Le stock était plein après la fin de la construction
                            $calcul1 = $newRess1 + $secApresFull*(1+10*$habitations);
                            //On ne peut pas dépasser le nouveau stockage max
                            if(($depots1+1) * $stockRess1ByDep < $calcul1){
                                $newRess1 = ($depots1+1) * $stockRess1ByDep;
                            }else{
                                $newRess1 = $calcul1;
                            }

                        }

                    } //Note: on ne peut pas avoir un dépôt et une habitation en création en même temps, donc pas de conflits

                    $depots1 = $depots1 +1;
                    $constrEnCours=0;
                }
            }else if($constrEnCours == 6){ //Dépot 2
                $constr = $constr + $timeConstrDep2;
                if(($nowSec - $constr)>=0){

                    /* Mise à jour ressources 2 */
                    if($depots2 * $stockRess2ByDep <= $newRess2){ //Modification seulement si on a atteint le stock max
                        //On doit savoir au bout de combien de temps ce stock max a été atteint
                        $secAvantFull = ceil(($depots2 * $stockRess2ByDep - $ress2) / (1+5*$mineurs)); //valeur entière supérieure
                        //Formule suite: n = (un - u0) / r
                        $secApresFull = $diffTime - $secAvantFull; //Temps pendant lequel le stock était jugé plein
                        $secDepotConstr = $nowSec - $constr; //Temps pendant lequel le dépôt était construit
                        if($secApresFull > $secDepotConstr){
                            //Le stock était plein avant la fin de la construction, on ajoute donc tout ce que le depot a pu stocker en plus
                            $calcul2 = $newRess2 + $secDepotConstr*(1+5*$mineurs);
                            //On ne peut pas dépasser le nouveau stockage max
                            if(($depots2+1) * $stockRess2ByDep < $calcul2){
                                $newRess2 = ($depots2+1) * $stockRess2ByDep;
                            }else{
                                $newRess2 = $calcul2;
                            }
                        }else{
                            //Le stock était plein après la fin de la construction
                            $calcul2 = $newRess2 + $secApresFull*(1+5*$mineurs);
                            //On ne peut pas dépasser le nouveau stockage max
                            if(($depots2+1) * $stockRess2ByDep < $calcul2){
                                $newRess2 = ($depots2+1) * $stockRess2ByDep;
                            }else{
                                $newRess2 = $calcul2;
                            }

                        }

                    } //Note: un nouveau mineur est tout de suite opérationnel et donc comptabilisé ici,donc pas de conflits

                    $depots2 = $depots2 +1;
                    $constrEnCours=0;
                }


            }

            // Voir si on traite le cas d'erreur au niveau de l'argument ou si on laisse sans rien faire
        }

        /*----- Vérification si autre formation terminée -----*/
        if($soldatDateDebut != NULL){ //On a un soldat en formation
            $EndTime =  strtotime(date_format(date_create($soldatDateDebut), 'Y-m-d H:i:s')) + $timeFormSoldat;
            if(($nowSec - $EndTime)>=0){
                    $soldats = $soldats +1;

                    $update = "UPDATE village SET soldatDateDebut = NULL WHERE id=" . $id;
                    $conn->query($update);
            }
        }

        if($reliqueDateDebut != NULL){ //On a une relique en fabrication
            $EndTime =  strtotime(date_format(date_create($reliqueDateDebut), 'Y-m-d H:i:s')) + $timeFabricRel;
            if(($nowSec - $EndTime)>=0){
                $reliques = $reliques +1;
                $update = "UPDATE village SET reliqueDateDebut = NULL WHERE id=" . $id;
                $conn->query($update);
            }
        }

        /*----- Mise à jour de la protection du village ----*/
        if($protected!=NULL){ //le village est protegé
            $EndTime =  strtotime(date_format(date_create($protected), 'Y-m-d H:i:s')) + $timeProtectedFromAttack;
            if(($nowSec - $EndTime)>=0){
                $update = "UPDATE village SET protected = NULL WHERE id=" . $id;
                $conn->query($update);
            }

        }

        $update = "UPDATE village SET ress1=". $newRess1.
            ", ress2=". $newRess2.
            ", citoyens=". $citoyens.
            ", soldats=". $soldats.
            ", mineurs=". $mineurs.
            ", reliques=". $reliques.
            ", constrEnCours =". $constrEnCours.
            ", habitations = ". $habitations.
            ", casernes= ". $casernes.
            ", centresFormation = ". $centresFormation.
            ", fabriques = ". $fabriques.
            ", depots1 = ". $depots1.
            ", depots2 = ". $depots2.
            ", last_maj=\"". date_format($now, 'Y-m-d H:i:s')."\" WHERE id=" . $id;

        if ($conn->query($update)) {
            echo "Update ok du village ".$id. " <br />";
        } else {
            echo "Error: " . $update . "<br/>" . $conn->error . "<br/>";
        }



    }else {
        echo "Impossible de mettre à jour: pas de village avec l'id ". $id;
        return FALSE;
    }
} else {
    echo "Error: " . $sql . "<br/>" . $conn->error . "<br/>";
}

?>
