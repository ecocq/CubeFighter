
        <div id="addBatiment" style="border: 1px solid black; max-width:350px; border-radius:5px; padding:3px;background-color:#e2e2e2; display:none; z-index:100000;">
                <p id="batiment">Voulez-vous ajouter un batiment à cet emplacement ?</p>
                <center><button type="button" class="btn btn-success" id="Oui">Oui</button><button type="button" class="btn btn-danger" id="Non">Non</button></center>
        </div>

        <div id="supprBatiment" style="border: 1px solid black; max-width:350px; border-radius:5px; padding:3px;background-color:#e2e2e2; display:none; z-index:100000;">
                <p id="batiment">Voulez-vous supprimer ce batiment ?</p>
                <center><button type="button" class="btn btn-success" id="OuiSuppr">Oui</button><button type="button" class="btn btn-danger" id="NonSuppr">Non</button></center>
        </div>

        <div id="attaque" style="border: 1px solid black; max-width:350px; border-radius:5px; padding:3px;background-color:#e2e2e2; display:none; z-index:100000;">
                <div class="form-group">
                    <label class="control-label">Selectionnez un village à attaquer</label>
                    <div class="selectContainer">
                        <select class="form-control" name="village" id="selectVillage">

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Combien de soldats</label>
                    <div class="selectContainer">
                        <select class="form-control" name="soldats" id="selectSoldats">

                        </select>
                    </div>
                </div>

                <center><button type="button" class="btn btn-success" id="OuiAttaque">Oui</button><button type="button" class="btn btn-danger" id="NonAttaque">Non</button></center>
        </div>



        <script src="phaser/phaser.js"></script>
        <script src="phaser/phaser-plugin-isometric.js"></script>
        <script src="phaser/phaser-kinetic-scrolling-plugin.min.js"></script> <!-- A enlever -->
        <script src="phaser/Phasetips.js"></script>
        <script>
            window.onload = function () {
                // Chargement des ressources du village
                var village_id = parseInt('<?php echo  $_SESSION['id_village'] ; ?>');
                var myData = {
                    id_village: village_id
                }

                // Initialisation, récupération des ressources du village
                $.getScript("Scripts/init.js");

                // Définition des constantes du jeu, identiques aux variables PHP
                $.getScript("Scripts/constants.js");

                var soldatEnCours = false;
                var mineurEnCours = false;
                var reliqueEnCours = false;
                var attaqueEnCours = false;


                $.ajax({
                    type: "POST"
                    , url: "BDD/getInfosVillage.php"
                    , data: myData
                    , dataType: "json"
                    , success: function (results) {
                        console.log(results);
                        ressource1 = results.ress1;
                        ressource2 = results.ress2;
                        nbrCitoyens = results.citoyens;
                        nbrMineurs = results.mineurs;
                        nbrSoldats = results.soldats;
                        nbrReliques = results.reliques;
                        constrDateDebut = parseDate(results.constrDateDebut);
                        // Construction d'un batiment en cours
                        if (results.constrEnCours != 0) {
                            timerConstruction = dateNow.getTime() / 1000 - constrDateDebut.getTime() / 1000;
                            console.log(timerConstruction);

                        }
                        // Formation d'un soldat en cours
                        if(results.soldatDateDebut != null) {
                            soldatDateDebut = parseDate(results.soldatDateDebut);
                            soldatTimer = dateNow.getTime() / 1000 - soldatDateDebut.getTime() / 1000;
                            soldatEnCours = true;
                        }
                        // Formation d'un mineur en cours
                        if(results.mineurDateDebut != null) {

                            mineurDateDebut = parseDate(results.mineurDateDebut);
                            mineurTimer = dateNow.getTime() / 1000 - mineurDateDebut.getTime() / 1000;
                            if(mineurTimer>timeFormMineur) {
                               mineurDateDebut = null;
                               mineurTimer = 0;
                            }else {
                                mineurEnCours = true;
                            }

                        }
                        // Formation d'une relique
                        if(results.reliqueDateDebut != null) {
                            reliqueDateDebut = parseDate(results.reliqueDateDebut);
                            reliqueTimer = dateNow.getTime() / 1000 - reliqueDateDebut.getTime() / 1000;
                            reliqueEnCours = true;
                        }

                        // Attaque en cours
                        if(results.attaquePossible==0) {
                            // Récupération de la date de l'attaque en cours
                            $.ajax({
                                type: "POST"
                                , url: "BDD/getLastDateAttaque.php"
                                , data: myData
                                , dataType: "json"
                                , success: function (results) {
                                    console.log(results);
                                    var attaqueDateDebut = parseDate(results.reg_date);

                                    attaqueTimer = dateNow.getTime() / 1000 - attaqueDateDebut.getTime() / 1000;
                                    attaqueEnCours = true;
                                }, error: function (resultat, statut, erreur) {
                                    console.log(resultat);
                                }
                            });
                        }
                    }
                    , error: function (resultat, statut, erreur) {
                        console.log(resultat);
                    }
                });

                $.ajax({
                    type: "POST"
                    , url: "BDD/getBatimentsVillage.php"
                    , data: myData
                    , dataType: "json"
                    , success: function (results) {
                        listBatiments = results;
                    }
                });

                function getTimeConstr(name) {
                    console.log(name);
                    if(name=='habitation') {
                        return cubeBatiments[1]['timeConstr'];
                    }else if(name=='caserne') {
                        return cubeBatiments[2]['timeConstr'];
                    }
                    return 0;
                }

                // Mise à jour des ressources. A changer selon la fonction d'évolution adoptée
                setInterval(updateRessources, 1000);
                function updateRessources() {
                    ressource1 = parseInt(ressource1);
                    ressource2 = parseInt(ressource2);
                    nbrCitoyens = parseInt(nbrCitoyens);

                    ressource1 = ressource1 + 1 + 10*cubeBatiments[1]['nbr'];

                    if(cubeBatiments[5]['nbr']*stockRess1ByDep < ressource1) {
                        ressource1 = cubeBatiments[5]['nbr']*stockRess1ByDep;
                    }

                    ressource2 = ressource2 + 1 + 5*nbrMineurs;

                    if(cubeBatiments[6]['nbr']*stockRess2ByDep < ressource2) {
                        ressource2 = cubeBatiments[6]['nbr']*stockRess2ByDep;
                    }


                    if(cubeBatiments[1]['nbr'] * stockCitByHab < nbrCitoyens + cubeBatiments[1]['nbr']){ //On ne peut pas dépasser le stockage max
                        nbrCitoyens = cubeBatiments[1]['nbr'] * stockCitByHab;
                    }else{
                        nbrCitoyens = nbrCitoyens + cubeBatiments[1]['nbr'];
                    }
                }

                var game = new Phaser.Game(1000, 600, Phaser.AUTO, 'game', {
                    preload: preload
                    , create: create
                    , update: update
                    , render: render
                }, true);

                function preload() {
                    // Chargement des images
                    game.load.image('tile', 'img/tuile.png');
                    game.load.image('habitation', 'img/habitation.png');
                    game.load.image('caserne', 'img/caserne.png');
                    game.load.image('centre', 'img/centre.png');
                    game.load.image('fabrique', 'img/fabrique.png');
                    game.load.image('depot1', 'img/depot1.png');
                    game.load.image('depot2', 'img/depot2.png');
                    game.load.image('construction', 'img/construction.png');
                    game.load.image('mineur', 'img/mineur.png');
                    game.load.image('soldat', 'img/soldat.png');
                    game.load.image('relique', 'img/relique.png');
                    game.load.image('attaquer', 'img/attaquer.png');

                    game.time.advancedTiming = true;

                    // Chargement de la police
                    game.load.bitmapFont('desyrel', 'fonts/font.png', 'fonts/font.fnt');

                    // Active le plugin isometrique et le scroll
                    game.plugins.add(new Phaser.Plugin.Isometric(game));
                    game.kineticScrolling = this.game.plugins.add(Phaser.Plugin.KineticScrolling);

                    game.world.setBounds(0, 0, 800, 600);

                    // Active le moteur physique
                    game.physics.startSystem(Phaser.Plugin.Isometric.ISOARCADE);

                    // Offset qui permet de placer les origines de x, y  et z vers le centre du canvas
                    game.iso.anchor.setTo(0.5, 0.2);
                }

                var res1;
                var res2;
                var soldats;
                var cit;
                var min;
                var rel;
                var imageMineur;
                var imageSoldat;
                var imageRelique;

                var createBatimentButton;
                var floorGroup;
                var batGroup;
                var listBatGroup;
                var cursor;
                var spriteSelected = null;
                var batSelected = null;
                var house;
                var iconeBatConstr;
                var iconeBatConstrTimer;
                var attaqueTimerText;

                var attaqueButton;

                var soldatTimerText;
                var mineurTimerText;
                var reliqueTimerText;
                var tabTiles = new Array(9);
                var drag = {};
                var batEnConstruction = {};

                var styleBois = {
                        font: "bold 20px Arial"
                        , fill: "#2ba043"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                };

                var styleCaserne = {
                    font: "bold 20px Arial"
                        , fill: "#ff022c"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                };

                var styleCitoyen = {
                    font: "bold 20px Arial"
                        , fill: "#7e2af3"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                };

                batEnConstruction['image'] = null;
                batEnConstruction['bat'] = null;
                batEnConstruction['id'] = null;

                drag['image'] = null;
                drag['bat'] = null;
                drag['id'] = null;

                for (var i = 0; i < 9; i++)
                    tabTiles[i] = new Array(9);

                // Tooltips
                var tip1;
                var tipsDejaEnConstr = {};
                var tipsBatPasAssez = {};
                var tipsConstruction;
                var tipsEspaceOccupe = {};
                var tipsPlusDeCentre;
                var tipsPlusDeFabrique;
                var tipsPlusDeCaserne;
                var tipsPlusDeRessourceC;
                var tipsPlusDeRessourceCentre;
                var tipsPlusDeRessourceF;
                var tipsPasDeVillageSelec;
                var tipsPasAssezDeSoldat;

                //Ami
                var cube;

                var debugText = "Texte de debug";

                function create() {
                    game.stage.backgroundColor = "#4488AA";

                    // Affichage des ressources
                    res1 = game.add.text(5, 5, 'Bois : ' + ressource1, styleBois);
                    res2 = game.add.bitmapText(5, 30, 'desyrel', 'Or : ' + ressource2, 20);

                    cit = game.add.text(200, 5, 'Citoyens : ' + nbrCitoyens, styleCitoyen);

                    if(!attaqueEnCours) {
                        attaqueButton = game.add.button(730, 500, 'attaquer', attaquer);
                    }


                    // Définition de la gravité globale
                    game.physics.isoArcade.gravity.setTo(0, 0, -500);

                    // Groupe correspondant aux tuiles du sol
                    floorGroup = game.add.group();

                    batGroup = game.add.group();

                    // Groupe de la liste des batiments affichée à droite
                    listBatGroup = game.add.group(600, 0, 'listBatGroup');
                    //floorGroup.enableBody = true;

                    // Affichage des tuiles
                    drawTiles();


                    // Affichage des batiments
                    drawBatiments();

                    // Affiche la liste des batiments à droite du jeu
                    drawListeBatiments();

                    // Affiche la liste des formations
                    drawListeFormations();

                    if(soldatEnCours) {
                        imageSoldat.alpha = 0.2;
                    }
                    if(mineurEnCours) {
                        imageMineur.alpha = 0.2;
                    }

                    if(reliqueEnCours) {
                        imageRelique.alpha = 0.2;
                    }

                    if(attaqueEnCours) {
                        attaqueTimerText = game.add.bitmapText(600, 515, 'desyrel', '0', 20);
                    }

                    // Active le curseur
                    cursor = new Phaser.Plugin.Isometric.Point3();

                    tipsPlusDeCentre = new Phasetips(game, {
                        targetObject: imageMineur,
                        context: "Besoin de plus de centres de formation",
                        strokeColor: 0xff0000,
                        position: "top",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    tipsPlusDeFabrique = new Phasetips(game, {
                        targetObject: imageRelique,
                        context: "Besoin de plus de Fabrique à reliques",
                        strokeColor: 0xff0000,
                        position: "top",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    tipsPlusDeCaserne = new Phasetips(game, {
                        targetObject: imageSoldat,
                        context: "Besoin de plus de Caserne",
                        strokeColor: 0xff0000,
                        position: "top",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    tipsPlusDeRessourceC = new Phasetips(game, {
                        targetObject: imageSoldat,
                        context: "Besoin de plus de ressources",
                        strokeColor: 0xff0000,
                        position: "top",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    tipsPlusDeRessourceF = new Phasetips(game, {
                        targetObject: imageRelique,
                        context: "Besoin de plus de ressources",
                        strokeColor: 0xff0000,
                        position: "top",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    tipsPlusDeRessourceCentre = new Phasetips(game, {
                        targetObject: imageMineur,
                        context: "Besoin de plus de ressources",
                        strokeColor: 0xff0000,
                        position: "top",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    tipsPasDeVillageSelec = new Phasetips(game, {
                        targetObject: attaqueButton,
                        context: "Pas de village choisi",
                        strokeColor: 0xff0000,
                        position: "left",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    tipsPasAssezDeSoldat = new Phasetips(game, {
                        targetObject: attaqueButton,
                        context: "Pas assez de soldat",
                        strokeColor: 0xff0000,
                        position: "left",
                        clickTooltip: 1,
                        positionOffset: 20,
                        onHoverCallback: function() {
                         // block1.loadTexture("char-stroke");
                        },
                        onOutCallback: function() {
                         // block1.loadTexture("char");
                        }
                    });

                    // Active le plugin de scroll
                    game.kineticScrolling.start();

                    // Création du text de timer
                    if(soldatDateDebut!=null) {
                        soldatTimerText = game.add.bitmapText(5, 490, 'desyrel', '0', 20);
                    }
                    if(mineurDateDebut!=null) {
                        mineurTimerText = game.add.bitmapText(155, 490, 'desyrel', '0', 20);
                    }
                    if(reliqueDateDebut!=null) {
                        reliqueTimerText = game.add.bitmapText(300, 490, 'desyrel', '0', 20);
                    }

                }




                function update() {
                    game.iso.unproject(game.input.activePointer.position, cursor);



                    game.physics.isoArcade.collide(floorGroup); //Collision du cube avec les tiles
                    game.iso.topologicalSort(floorGroup);

                    game.physics.isoArcade.overlap(cube, floorGroup, function () {
                        debugText = "Overlapped!!!!!";
                    });

                    // Mise à jour des ressources
                    res1.text = 'Bois : ' + ressource1;
                    res2.text = 'Or : ' + ressource2;
                    cit.text = 'Citoyens : ' + nbrCitoyens;
                    min.text = 'Mineurs : ' + nbrMineurs;
                    soldats.text = 'Soldats : ' + nbrSoldats;
                    rel.text = "Reliques : " + nbrReliques;

                    // Drag si un batiment a été choisi
                    if (drag['image'] != null) {
                        drag['image'].position.set(game.input.mousePointer.worldX, game.input.mousePointer.worldY);
                    }

                    if(iconeBatConstr != null) {
                        iconeBatConstrTimer.text = batEnConstruction['bat']['timeConstr'] - Math.floor(timerConstruction);
                    }

                    if(soldatTimerText != null) {
                        soldatTimerText.text = timeFormSoldat - Math.floor(soldatTimer);
                    }

                    if(mineurTimerText != null) {
                        mineurTimerText.text = timeFormMineur - Math.floor(mineurTimer);
                    }

                    if(reliqueTimerText != null) {
                        reliqueTimerText.text = timeFabricRel - Math.floor(reliqueTimer);
                    }
                    if(attaqueTimerText != null) {
                        attaqueTimerText.text = 20 - Math.floor(attaqueTimer);
                    }

                }


                function render() {
                    //game.debug.text(debugText,10, game.world.height-20);
                    //game.debug.body(cube, 'rgba(189, 221, 235, 0.6)', false);
                    //game.debug.bodyInfo(cube, 100,400);
                }


                // Dessine les tuiles qui constituent la map
                function drawTiles() {
                    var tile;
                    for (var xx = 0; xx < 332; xx += 38) {
                        tipsEspaceOccupe[xx/38] = {}
                        for (var yy = 0; yy < 332; yy += 38) {
                            // Create a tile using the new game.add.isoSprite factory method at the specified position.
                            // The last parameter is the group you want to add it to (just like game.add.sprite)

                            tile = game.add.isoSprite(xx, yy, 0, 'tile', 0, floorGroup);
                            tile.anchor.set(0.5, 0);
                            tile.inputEnabled = true;
                            tile.events.onInputDown.add(tileListener, this);
                            tile.events.onInputOver.add(tileHoverListener, this);
                            tile.events.onInputOut.add(tileOutListener, this);
                            tabTiles[xx / 38][yy / 38] = tile;
                            tipsEspaceOccupe[xx/38][yy/38] = new Phasetips(game, {
                                targetObject: tabTiles[xx / 38][yy / 38],
                                context: "Espace occupé",
                                strokeColor: 0xff0000,
                                position: "top",
                                clickTooltip: 1,
                                onHoverCallback: function() {
                                 // block1.loadTexture("char-stroke");
                                },
                                onOutCallback: function() {
                                 // block1.loadTexture("char");
                                }
                            });
                        }
                    }
                }


                // Dessine tous les batiments du joueur au lancement de la partie
                function drawBatiments() {
                    var tile;
                    for (var i in listBatiments) {
                        if (listBatiments[i].data.enConstruction == 1) {
                            batEnConstruction['image'] = game.add.isoSprite(listBatiments[i].data.x * 38, listBatiments[i].data.y * 38, 50, 'construction', 0, batGroup);
                            batEnConstruction['image'].anchor.set(0.5);
                            batEnConstruction['image'].enableBody = true;
                            game.physics.isoArcade.enable(batEnConstruction['image']);
                            batEnConstruction['image'].body.collideWorldBounds = true;
                            batEnConstruction['bat'] = cubeBatiments[listBatiments[i].data.id_batiment];
                            batEnConstruction['id'] = listBatiments[i].data.id_batiment;

                            iconeBatConstr = game.add.sprite(500, 445, 'construction');
                            iconeBatConstrTimer = game.add.bitmapText(522, 515, 'desyrel', '0', 20);

                            // Ajout d'un tooltip
                            tipsConstruction = new Phasetips(game, {
                                targetObject: iconeBatConstr,
                                context: batEnConstruction['bat']['text'],
                                 strokeColor: 0xff0000,
                                 position: "top",
                                 onHoverCallback: function() {
                                 // block1.loadTexture("char-stroke");
                                 },
                                onOutCallback: function() {
                                 // block1.loadTexture("char");
                                }
                            });
                        } else {
                            cube = game.add.isoSprite(listBatiments[i].data.x * 38, listBatiments[i].data.y * 38, 50, cubeBatiments[listBatiments[i].data.id_batiment]['image'], 0, batGroup);
                            cube.anchor.set(0.5);
                            cube.enableBody = true;
                            game.physics.isoArcade.enable(cube);
                            cube.body.collideWorldBounds = true;
                            cube.inputEnabled = true;
                            cube.events.onInputDown.add(destroyBatiment, this);

                            cubeBatiments[listBatiments[i].data.id_batiment]['nbr'] = cubeBatiments[listBatiments[i].data.id_batiment]['nbr']+1;

                            cube.events.onInputOver.add(cubeOverListener, this);
                            cube.events.onInputOut.add(cubeOutListener, this);
                        }

                        game.iso.simpleSort(batGroup);

                        var tile = tabTiles[listBatiments[i].data.x][listBatiments[i].data.y];
                        tile.hasBatiment = true;


                    }
                }


                // Timer qui gère la construction des batiments
                setInterval(updateConstruction, 1000);
                function updateConstruction() {
                    if (batEnConstruction['image'] != null) {
                        timerConstruction++;

                        if (timerConstruction >= cubeBatiments[batEnConstruction['id']]['timeConstr']) { // Mettre à jour avec les constantes PHP ! getTimeConstr(batEnConstruction['bat']['image'])
                            console.log("Construction terminée");
                            cube = game.add.isoSprite(batEnConstruction['image'].isoX, batEnConstruction['image'].isoY, 10, batEnConstruction['bat']['image'], 0, batGroup);
                            cube.anchor.set(0.5);
                            cube.enableBody = true;
                            game.physics.isoArcade.enable(cube);
                            cube.body.collideWorldBounds = true;

                            cube.events.onInputOver.add(cubeOverListener, this);
                            cube.events.onInputOut.add(cubeOutListener, this);

                            timerConstruction = 0;
                            cubeBatiments[batEnConstruction['id']]['nbr'] = cubeBatiments[batEnConstruction['id']]['nbr']+1;
                            batEnConstruction['image'].destroy(true);
                            batEnConstruction['image'] = null;
                            batEnConstruction['bat'] = null;
                            batEnConstruction['id'] = null;

                            iconeBatConstr.destroy(true);
                            iconeBatConstr = null;
                            iconeBatConstrTimer.destroy(true);
                            iconeBatConstrTimer = null;

                            tipsConstruction.destroy();


                            game.iso.simpleSort(batGroup);
                        }
                    }
                }


                // Dessine la liste des batiments pouvant être placés
                function drawListeBatiments() {
                    var y = 0;
                    var deltay = 80;
                    var x = 730;
                    var styleOr = {
                        font: "bold 16px Arial"
                        , fill: "#e5981e"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };
                    var styleBois = {
                        font: "bold 16px Arial"
                        , fill: "#2ba043"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };
                    var styleTitre = {
                        font: "bold 20px Arial"
                        , fill: "#000000"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };
                    for (var i in cubeBatiments) {
                        bat = game.add.button(x, y, cubeBatiments[i]['image'], dragBatiment, {
                            bat: cubeBatiments[i], id: i, x: x, y: y
                        });
                        text = game.add.text(x + 80, y, cubeBatiments[i]['text'], styleTitre);
                        textres1 = game.add.text(x + 80, y + 30, cubeBatiments[i]['res1'], styleBois);
                        textres2 = game.add.text(x + 120, y + 30, cubeBatiments[i]['res2'], styleOr);

                        y += deltay;
                        listBatGroup.add(bat);
                        listBatGroup.add(text);
                        listBatGroup.add(textres1);
                        listBatGroup.add(textres2);

                        tipsDejaEnConstr[i] = new Phasetips(game, {
                            targetObject: bat,
                            context: "Un batiment est déjà en construction !",
                            strokeColor: 0xff0000,
                            position: "left",
                            clickTooltip: 1,
                            positionOffset: 100,
                            onHoverCallback: function() {
                             // block1.loadTexture("char-stroke");

                            },
                            onOutCallback: function() {
                             // block1.loadTexture("char");
                            }
                        });

                        tipsBatPasAssez[i]  = new Phasetips(game, {
                            targetObject: bat,
                            context: "Vous n'avez pas assez de ressources !",
                            strokeColor: 0xff0000,
                            position: "left",
                            clickTooltip: 1,
                            positionOffset: 100,
                            onHoverCallback: function() {
                             // block1.loadTexture("char-stroke");

                            },
                            onOutCallback: function() {
                             // block1.loadTexture("char");
                            }
                        });
                    }
                }

                function drawListeFormations() {
                    var textRes1;
                    var textRes2;
                    var textRes3;
                    var deltax = 150;
                    var x = 0;
                    var y = 510;

                    var styleOr = {
                        font: "bold 16px Arial"
                        , fill: "#e5981e"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };
                    var styleBois = {
                        font: "bold 16px Arial"
                        , fill: "#2ba043"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };
                    var styleCitoyens = {
                        font: "bold 16px Arial"
                        , fill: "#7e2af3"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };
                    var styleMineur = {
                        font: "bold 20px Arial"
                        , fill: "#4488AA"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };
                    var styleRelique = {
                        font: "bold 20px Arial"
                        , fill: "#525252"
                        , boundsAlignH: "center"
                        , boundsAlignV: "middle"
                    };

                    imageSoldat = game.add.button(x+25, y-60, 'soldat', addSoldat);
                    soldats = game.add.text(x, y,  'Soldats : ' + nbrSoldats, styleCaserne);
                    textRes1 = game.add.text(x, y + 30, ress1sol , styleBois);
                    textRes2 = game.add.text(x + 30, y + 30, ress2sol , styleOr);
                    textRes3 = game.add.text(x + 60, y + 30, nbrCitoyensToFormSol, styleCitoyens);

                    x = x + deltax;
                    imageMineur = game.add.button(x+25, y-60, 'mineur', addMineur);
                    min = game.add.text(x, y, 'Mineurs : ' + nbrMineurs, styleMineur);
                    textRes1 = game.add.text(x, y + 30, ress1min , styleBois);
                    textRes2 = game.add.text(x + 30, y + 30, ress2min , styleOr);
                    textRes3 = game.add.text(x + 60, y + 30, nbrCitoyensToFormMin, styleCitoyens);

                    x = x + deltax;
                    imageRelique = game.add.button(x+25, y-60, 'relique', addRelique);
                    rel = game.add.text(x, y, 'Reliques : ' + nbrReliques, styleRelique);
                    textRes1 = game.add.text(x, y + 30, ress1rel , styleBois);
                    textRes2 = game.add.text(x+50, y + 30, ress2rel , styleOr);
                    textRes3 = game.add.text(x + 95, y + 30, nbrCitoyensToMakeRel, styleCitoyens);

                }

                // Lancée lorsque l'on choisit un nouveau batiment
                function dragBatiment() {
                    if (drag['image'] == null) {
                        // Vérifie si l'utilisateur a le nombre nécessaire de ressources
                        if (this.bat['res1'] > ressource1 || this.bat['res2'] > ressource2) {
                            tipsBatPasAssez[this.id].showTooltip();
                        } else if (batEnConstruction['image'] != null) {
                            //alert("Un batiment est déjà en construction ! ");
                            tipsDejaEnConstr[this.id].showTooltip();

                        } else {
                            drag['image'] = game.add.image(game.input.mousePointer.worldX, game.input.mousePointer.worldY, this.bat['image']);
                            drag['bat'] = this.bat;
                            drag['id'] = this.id;
                        }
                    }
                }

                // Lancée lorsque le joueur veut ajouter un soldat
                function addSoldat() {


                    // Pas suffisamment de ressources
                    if(ressource1<ress1sol || ressource2<ress2sol || parseInt(nbrCitoyens)
                       <nbrCitoyensToFormSol) {
                        tipsPlusDeRessourceC.showTooltip();
                    }else

                    // Pas suffisamment de casernes pour stocker un autre soldat
                    if(stockSolByCas * cubeBatiments[2]['nbr'] < parseInt(nbrSoldats) + 1) {
                        tipsPlusDeCaserne.showTooltip();
                    }else {
                        // Commencer la formation
                        var myData = { id_village: village_id};
                        $.ajax({
                                type: "POST"
                                , url: "BDD/trainSoldatVillage.php"
                                , data: myData
                                , dataType: "json"
                                , success: function (results) {
                                    console.log(results);
                                    ressource1 = parseInt(ressource1) - ress1sol;
                                    ressource2 = parseInt(ressource2) - ress2sol;
                                    nbrCitoyens = parseInt(nbrCitoyens) - nbrCitoyensToFormSol;
                                    soldatTimerText = game.add.bitmapText(5, 490, 'desyrel', '0', 20);
                                    soldatTimer = 0;
                                    imageSoldat.alpha = 0.2;
                                }
                                , error: function (resultat, statut, erreur) {
                                     console.log(resultat);
                                }
                        });
                    }
                }

                setInterval(updateSoldat, 1000);
                function updateSoldat() {
                    if(soldatTimerText!=null) {
                        soldatTimer++;
                        if(soldatTimer>=timeFormSoldat) {
                            soldatTimerText.destroy(true);
                            soldatTimerText = null;

                            nbrSoldats = parseInt(nbrSoldats) + 1;
                            imageSoldat.alpha = 1;
                        }
                    }
                }

                function addMineur() {


                    // Pas suffisamment de ressources
                    if(ressource1 < ress1min || ressource2<ress2min || parseInt(nbrCitoyens)<nbrCitoyensToFormMin) {
                        tipsPlusDeRessourceCentre.showTooltip();
                    }else

                    // PAs suffisamment de centre pour stocker un autre mineur
                    if(stockMinByCen * cubeBatiments[3]['nbr'] < parseInt(nbrMineurs)+1) {
                       tipsPlusDeCentre.showTooltip();
                    }else {
                       // Commencer la formation
                        console.log("La formation peut commencer");
                        var myData = { id_village: village_id};
                        $.ajax({
                                type: "POST"
                                , url: "BDD/trainMineurVillage.php"
                                , data: myData
                                , dataType: "json"
                                , success: function (results) {
                                    console.log(results);
                                    nbrMineurs = parseInt(nbrMineurs) + 1;
                                    ressource1 = parseInt(ressource1) - ress1min;
                                    ressource2 = parseInt(ressource2) - ress2min;
                                    nbrCitoyens = parseInt(nbrCitoyens) - nbrCitoyensToFormMin;
                                    mineurTimerText = game.add.bitmapText(155, 490, 'desyrel', '0', 20);
                                    mineurTimer = 0;
                                    imageMineur.alpha = 0.2;
                                }
                                , error: function (resultat, statut, erreur) {
                                     console.log(resultat);
                                }
                        });
                    }
                }

                setInterval(updateMineur, 1000);
                function updateMineur() {
                    if(mineurTimerText!=null) {
                        mineurTimer++;
                        if(mineurTimer>=timeFormMineur) {
                            mineurTimerText.destroy(true);
                            mineurTimerText = null;
                            imageMineur.alpha = 1;
                        }
                    }
                }

                function addRelique() {


                    // Pas suffisamment de ressources
                    if(ressource1<ress1rel || ressource2<ress2rel || parseInt(nbrCitoyens)
                       <nbrCitoyensToMakeRel) {
                        tipsPlusDeRessourceF.showTooltip();
                    }else

                    // Pas suffisamment de fabrique pour stocker une autre relique
                    if(stockRelByFab * cubeBatiments[4]['nbr'] < parseInt(nbrReliques) + 1) {
                        tipsPlusDeFabrique.showTooltip();
                    }else {
                        // Commencer la formation
                        var myData = { id_village: village_id};
                        $.ajax({
                                type: "POST"
                                , url: "BDD/makeReliqueVillage.php"
                                , data: myData
                                , dataType: "json"
                                , success: function (results) {
                                    console.log(results);
                                    ressource1 = parseInt(ressource1) - ress1rel;
                                    ressource2 = parseInt(ressource2) - ress2rel;
                                    nbrCitoyens = parseInt(nbrCitoyens) - nbrCitoyensToMakeRel;

                                    reliqueTimerText = game.add.bitmapText(300, 490, 'desyrel', '0', 20);
                                    reliqueTimer = 0;

                                    imageRelique.alpha = 0.2;
                                }
                                , error: function (resultat, statut, erreur) {
                                     console.log(resultat);
                                }
                        });
                    }
                }

                setInterval(updateRelique, 1000);
                function updateRelique() {
                    if(reliqueTimerText!=null) {
                        reliqueTimer++;
                        if(reliqueTimer>=timeFabricRel) {
                            reliqueTimerText.destroy(true);
                            reliqueTimerText = null;

                            nbrReliques = parseInt(nbrReliques) + 1;
                            imageRelique.alpha = 1;
                        }
                    }
                }

                // Lancé au click sur une tuile
                function tileListener(sprite, pointer) {
                    if (drag['image'] != null && !sprite.hasBatiment) {
                        $('#addBatiment').css("display", "block");
                        $('#addBatiment').css("position", "absolute");
                        var click = $("#game").position();
                        $('#addBatiment').css("top", (pointer.y+click.top-$('#addBatiment').height()/2)+"px");
                        $('#addBatiment').css("left", (pointer.x+click.left-$('#addBatiment').width()/2)+"px");
                        spriteSelected = sprite;
                        game.input.enabled = false;

                    }
                }

                // Gestion du popup de validation de la construction
                $("#Oui").click(function(){
                    game.input.enabled = true;
                  $('#addBatiment').css("display", "none");
                            ressource1 = ressource1 - drag['bat']['res1']; // TOTO Mettre à jour en fonction des ressources de chaque batiment
                            ressource2 = ressource2 - drag['bat']['res2'];

                            batEnConstruction['image'] = game.add.isoSprite(spriteSelected.isoX, spriteSelected.isoY, 10, 'construction', 0, batGroup);
                            batEnConstruction['image'].anchor.set(0.5);
                            batEnConstruction['image'].enableBody = true;
                            batEnConstruction['bat'] = drag['bat'];
                            batEnConstruction['id'] = drag['id'];


                            game.physics.isoArcade.enable(batEnConstruction['image']);
                            batEnConstruction['image'].body.collideWorldBounds = true;

                            // Lancement du bon script de mise à jour BDD
                            if (drag['bat']['image'] == "habitation") {
                                script = "BDD/addHabVillage.php";
                            } else if (drag['bat']['image'] == "caserne") {
                                script = "BDD/addCaserneVillage.php";
                            } else if(drag['bat']['image'] =="depot1") {
                                script = "BDD/addDepot1Village.php";
                            } else if(drag['bat']['image'] =="depot2") {
                                script = "BDD/addDepot2Village.php";
                            } else if(drag['bat']['image'] =="centre") {
                                script = "BDD/addCentreFormationVillage.php";
                            } else if(drag['bat']['image'] =="fabrique") {
                                script = "BDD/addFabVillage.php";
                            }else {
                                console.log("error");
                            }

                            // Mise à jour de la tuile en dessous du batiment
                            spriteSelected.tint = 0xffffff;
                            spriteSelected.hasBatiment = true;
                            game.add.tween(spriteSelected).to({
                                isoZ: 0
                            }, 200, Phaser.Easing.Quadratic.InOut, true);


                            // Lancer la mise à jour serveur
                            var myData = {
                                id_village: village_id
                                , x: spriteSelected.isoX / 38
                                , y: spriteSelected.isoY / 38
                            }
                            $.ajax({
                                type: "POST"
                                , url: script
                                , data: myData
                                , dataType: "json"
                                , success: function (results) {
                                    console.log(results);
                                    timerConstruction = 0;

                                    iconeBatConstr = game.add.sprite(500, 445, 'construction');
                                    iconeBatConstrTimer = game.add.bitmapText(522, 515, 'desyrel', '0', 20);

                                    // Ajout d'un tooltip
                                    tipsConstruction = new Phasetips(game, {
                                        targetObject: iconeBatConstr,
                                        context: batEnConstruction['bat']['text'],
                                        strokeColor: 0xff0000,
                                        position: "top",
                                        onHoverCallback: function() {
                                         // block1.loadTexture("char-stroke");
                                        },
                                        onOutCallback: function() {
                                         // block1.loadTexture("char");
                                        }
                                    });
                                }
                                , error: function (resultat, statut, erreur) {
                                     console.log(resultat);
                                }
                            });

                            // Destruction de l'image utilisée pour le drag n' drop
                            drag['image'].destroy(true);
                            drag['image'] = null;
                            drag['bat'] = null;
                            drag['id'] = null;
                            game.iso.simpleSort(batGroup);
                            // Pas sûr de pouvoir factoriser le code (else vide dans ce cas)
                });
                $("#Non").click(function(){
                  $('#addBatiment').css("display", "none");
                  game.input.enabled = true;
                  drag['image'].destroy(true);
                  drag['image'] = null;
                  drag['bat'] = null;
                  drag['id'] = null;

                    spriteSelected.tint = 0xffffff;
                    game.add.tween(spriteSelected).to({
                        isoZ: 0
                    }, 200, Phaser.Easing.Quadratic.InOut, true);
                });

                function attaquer(sprite, pointer) {
                    $('#selectVillage')
                        .empty()
                        .append('<option selected="selected" value="0">Choisir un village</option>')
                    ;
                    $('#attaque').css("display", "block");
                    $('#attaque').css("position", "absolute");
                    var click = $("#game").position();
                    $('#attaque').css("top", (pointer.y+click.top-$('#attaque').height()/2)+"px");
                    $('#attaque').css("left", (pointer.x+click.left-$('#attaque').width()/2)+"px");
                    game.input.enabled = false;

                    // Récupérer les villages disponibles
                    var myData;
                    $.ajax({
                    type: "POST"
                    , url: "BDD/getListeVillages.php"
                    , data: myData
                    , dataType: "json"
                    , success: function (results) {
                        console.log(results);
                        $.each(results,function(key, value)
                        {
                            if(value.data.id_village!=parseInt(village_id)) {
                                $('#selectVillage').append('<option value=' + value.data.id_village + '>' + value.data.nomVillage + '</option>');
                            }
                        });
                        $('#selectSoldats').empty();
                        for(i = 0; i<=parseInt(nbrSoldats); i++) {
                            $('#selectSoldats').append('<option value=' + i + '>' + i + '</option>');
                        }
                    }
                    , error: function (resultat, statut, erreur) {
                        console.log(resultat);
                    }
                });
                }

                function destroyBatiment(sprite, pointer) {
                    $('#supprBatiment').css("display", "block");
                    $('#supprBatiment').css("position", "absolute");
                    var click = $("#game").position();
                    $('#supprBatiment').css("top", (pointer.y+click.top-$('#supprBatiment').height()/2)+"px");
                    $('#supprBatiment').css("left", (pointer.x+click.left-$('#supprBatiment').width()/2)+"px");
                    game.input.enabled = false;
                    batSelected = sprite;
                }

                $("#OuiSuppr").click(function(){
                    var script = "";
                    var id_bat = 0;
                  $('#supprBatiment').css("display", "none");
                  game.input.enabled = true;

                    // Supprimer le batiment
                    if(batSelected.key=="habitation") {
                        script = "BDD/remHabVillage.php";
                        id_bat = 1;
                        if(cubeBatiments[id_bat]['nbr']==1) {
                            return;
                        }
                    }else if(batSelected.key=="caserne"){
                        script = "BDD/remCaserneVillage.php";
                        id_bat = 2;
                    }else if(batSelected.key=="centre"){
                        script = "BDD/remCentreVillage.php";
                        id_bat = 3;
                    }else if(batSelected.key=="fabrique"){
                        script = "BDD/remFabVillage.php";
                        id_bat = 4;
                    }else if(batSelected.key=="depot1"){
                        script = "BDD/remDepot1Village.php";
                        id_bat = 5;
                        if(cubeBatiments[id_bat]['nbr']==1) {
                            return;
                        }
                    }else if(batSelected.key=="depot2"){
                        script = "BDD/remDepot2Village.php";
                        id_bat = 6;
                        if(cubeBatiments[id_bat]['nbr']==1) {
                            return;
                        }
                    }

                    // Le joueur doit avoir les ressources nécessaires
                    if(parseInt(ressource1)<cubeBatiments[id_bat]['res1']/2 || parseInt(ressource2)<cubeBatiments[id_bat]['res2']/2) { //pas suffisamment de ressources pour demander une destruction
                       console.log("Pas assez de ressources");
                        return;
                    }

                    var myData = {id: village_id, nbr: 1, voulue : "true", x: batSelected.isoX/38, y: batSelected.isoY/38};

                    $.ajax({
                            type: "POST"
                            , url: script
                            , data: myData
                            , dataType: "json"
                            , success: function (results) {
                                console.log(results);
                                cubeBatiments[id_bat]['nbr'] = cubeBatiments[id_bat]['nbr'] - 1;
                                tabTiles[batSelected.isoX/38][batSelected.isoY/38].hasBatiment = false;
                                batSelected.destroy(true);
                                ressource1 = parseInt(ressource1)-cubeBatiments[id_bat]['res1']/2;
                                ressource2 = parseInt(ressource2)-cubeBatiments[id_bat]['res2']/2;

                                if(id_bat==1) {
                                    if(parseInt(nbrCitoyens)>(cubeBatiments[id_bat]['nbr'])*stockCitByHab){
                                        nbrCitoyens=(cubeBatiments[id_bat]['nbr'])*stockCitByHab;
                                    }
                                }else if(id_bat==2) {
                                    if(parseInt(nbrSoldats)>cubeBatiments[id_bat]['nbr']*stockSolByCas){
                                        nbrSoldats=cubeBatiments[id_bat]['nbr']*stockSolByCas;
                                        //Dans ce cas, toute formation dans ce batiment est annulée
                                        if(soldatTimerText!=null){
                                            soldatTimerText.destroy(true);
                                            soldatTimerText = null;
                                            soldatTimer = 0;
                                        }
                                    }else if(parseInt(nbrSoldats)+1>cubeBatiments[id_bat]['nbr']*stockSolByCas){
                                        //Si on était tout juste, il faut aussi annuler la formation du prochain soldat
                                        if(soldatTimerText!=null){
                                            soldatTimerText.destroy(true);
                                            soldatTimerText = null;
                                            soldatTimer = 0;
                                        }
                                    }
                                }else if(id_bat==3) {
                                   //On perd aussi les mineurs qui étaient stockés dedans
                                    if(parseInt(nbrMineurs)>cubeBatiments[id_bat]['nbr'] *stockMinByCen){
                                        nbrMineurs=cubeBatiments[id_bat]['nbr']*stockMinByCen;
                                    }
                                }else if(id_bat==4) {
                                    //On perd aussi les reliques qui étaient stockées dedans
                                    if(parseInt(nbrReliques)>cubeBatiments[id_bat]['nbr']*stockRelByFab){
                                        nbrReliques=cubeBatiments[id_bat]['nbr']*stockRelByFab;
                                        //Dans ce cas, toute formation dans ce batiment est annulée
                                        if(reliqueTimerText!=null){
                                           reliqueTimerText.destroy(true);
                                           reliqueTimerText = null;
                                           reliqueTimer = 0;
                                        }

                                    }else if(parseInt(nbrReliques)+1>cubeBatiments[id_bat]['nbr']*stockRelByFab){
                                        //Si on était tout juste, il faut aussi annuler la creation de la prochaine relique
                                        if(reliqueTimerText!=null){
                                           reliqueTimerText.destroy(true);
                                           reliqueTimerText = null;
                                           reliqueTimer = 0;
                                        }
                                    }
                                } else if(id_bat==5) {
                                    //On perd aussi les ressources qui étaient stockés dedans
                                    if(parseInt(ressource1)>cubeBatiments[id_bat]['nbr']*stockRess1ByDep){
                                        ressource1=cubeBatiments[id_bat]['nbr']*stockRess1ByDep;
                                    }
                                }else if(id_bat==6) {
                                    //On perd aussi les ressources qui étaient stockés dedans
                                    if(parseInt(ressource2)>cubeBatiments[id_bat]['nbr']*stockRess2ByDep){
                                        ressource2=cubeBatiments[id_bat]['nbr']*stockRess2ByDep;
                                    }
                                }

                                if(batEnConstruction['image']!=null) {
                                    timerConstruction = 0;
                                    tabTiles[batEnConstruction['image'].isoX/38][batEnConstruction['image'].isoY/38].hasBatiment = false;
                                    cubeBatiments[batEnConstruction['id']]['nbr'] = cubeBatiments[batEnConstruction['id']]['nbr']+1;
                                    batEnConstruction['image'].destroy(true);
                                    batEnConstruction['image'] = null;
                                    batEnConstruction['bat'] = null;
                                    batEnConstruction['id'] = null;

                                    iconeBatConstr.destroy(true);
                                    iconeBatConstr = null;
                                    iconeBatConstrTimer.destroy(true);
                                    iconeBatConstrTimer = null;

                                    tipsConstruction.destroy();
                                }

                            } , error: function (resultat, statut, erreur) {
                                     console.log(resultat);
                                }
                            });


                });
                $("#NonSuppr").click(function(){
                  $('#supprBatiment').css("display", "none");
                  game.input.enabled = true;
                });


                $("#OuiAttaque").click(function(){
                  $('#attaque').css("display", "none");
                  game.input.enabled = true;

                    // Attaque
                    if($('#selectVillage').find(":selected").val()==0) {
                        // console.log("Pas de village choisi");
                        tipsPasDeVillageSelec.showTooltip();
                        return;
                    }
                    if($('#selectSoldats').find(":selected").val()==0) {
                        tipsPasAssezDeSoldat.showTooltip();
                        return;
                    }

                    var myData = {id : village_id, attacked : $('#selectVillage').find(":selected").val(), soldats : $('#selectSoldats').find(":selected").val()};

                    attaqueButton.destroy(true);
                    attaqueButton = null;

                    attaqueTimer = 0;
                    attaqueTimerText = game.add.bitmapText(600, 515, 'desyrel', '0', 20);



                    nbrSoldats = parseInt(nbrSoldats) - $('#selectSoldats').find(":selected").val();
                    $.ajax({
                        type: "POST"
                        , url: "BDD/attackVillage.php"
                        , data: myData
                        , dataType: "json"
                        , success: function (results) {
                            console.log(results);

                        }, error: function (resultat, statut, erreur) {
                            console.log(resultat);
                        }
                    });

                });
                $("#NonAttaque").click(function(){
                  $('#attaque').css("display", "none");
                  game.input.enabled = true;
                });

                setInterval(updateAttaque, 1000);
                function updateAttaque() {
                    if(attaqueTimerText!=null) {
                        attaqueTimer++;
                        if(attaqueTimer>=21) {
                            attaqueTimerText.destroy(true);
                            attaqueTimerText = null;

                            attaqueButton = game.add.button(730, 500, 'attaquer', attaquer);

                            alert("Votre attaque est terminée.");
                            location.reload();

                        }
                    }
                }

                setInterval(verifAttacked, 1000);
                function verifAttacked() {
                    var myData = { id: village_id};
                    $.ajax({
                                type: "POST"
                                , url: "BDD/verifAttacked.php"
                                , data: myData
                                , dataType: "json"
                                , success: function (results) {

                                    if(results!=null) {
                                        var dateAttaque = parseDate(results);
                                        var d = new Date();
                                        var interv = d.getTime() / 1000 - dateAttaque.getTime() / 1000;
                                        if(interv<=2) {
                                            alert("Vous avez été attaqué !");
                                            location.reload();
                                        }
                                    }
                                }
                                , error: function (resultat, statut, erreur) {
                                     console.log(resultat);
                                }
                    });
                }



                function tileHoverListener(sprite, pointer) {
                    if (drag['image'] != null && !sprite.hasBatiment) {
                        sprite.tint = 0x86bfda;
                        game.add.tween(sprite).to({
                            isoZ: 4
                        }, 200, Phaser.Easing.Quadratic.InOut, true);
                    }else if(drag['image'] != null && sprite.hasBatiment) {
                        tipsEspaceOccupe[parseInt((sprite.isoX / 38), 10)][parseInt((sprite.isoY / 38), 10)].showTooltip();
                    }
                }

                function cubeOverListener(sprite, pointer) {
                    if(drag['image'] != null) {
                        tipsEspaceOccupe[parseInt((sprite.isoX / 38), 10)][parseInt((sprite.isoY / 38), 10)].showTooltip();
                    }
                }

                function cubeOutListener(sprite, pointer) {
                    if(drag['image'] != null) {
                        tipsEspaceOccupe[parseInt((sprite.isoX / 38), 10)][parseInt((sprite.isoY / 38), 10)].hideTooltip();
                    }
                }

                function tileOutListener(sprite, pointer) {
                    // sprite.selected = false;
                    sprite.tint = 0xffffff;
                    game.add.tween(sprite).to({
                        isoZ: 0
                    }, 200, Phaser.Easing.Quadratic.InOut, true);
                }

                function onDragStop(sprite, pointer) {
                    game.add.tween(sprite).to({
                        isoZ: 4
                    }, 500, Phaser.Easing.Quadratic.InOut, true);
                }


            };
        </script>

