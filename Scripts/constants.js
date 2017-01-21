

/*------------------ STOCKAGE ET DEPOTS -----------------*/
var stockCitByHab = 100;
var stockSolByCas = 50;
var stockMinByCen = 40;
var stockRess1ByDep = 5000;
var stockRess2ByDep = 1000;
var stockRelByFab = 10;


// HashMap des images des batiments avec les couts associés
var cubeBatiments = {};
cubeBatiments[1] = {};
cubeBatiments[1]['image'] = 'habitation';
cubeBatiments[1]['text'] = 'Habitation';
cubeBatiments[1]['res1'] = 500;
cubeBatiments[1]['res2'] = 100;
cubeBatiments[1]['timeConstr'] = 45;
cubeBatiments[1]['nbr'] = 0;
cubeBatiments[2] = {};
cubeBatiments[2]['image'] = 'caserne';
cubeBatiments[2]['text'] = 'Caserne';
cubeBatiments[2]['res1'] = 600;
cubeBatiments[2]['res2'] = 500;
cubeBatiments[2]['timeConstr'] = 60;
cubeBatiments[2]['nbr'] = 0;
cubeBatiments[3] = {};
cubeBatiments[3]['image'] = 'centre';
cubeBatiments[3]['text'] = 'Centre de formation';
cubeBatiments[3]['res1'] = 800;
cubeBatiments[3]['res2'] = 200;
cubeBatiments[3]['timeConstr'] = 90;
cubeBatiments[3]['nbr'] = 0;
cubeBatiments[4] = {};
cubeBatiments[4]['image'] = 'fabrique';
cubeBatiments[4]['text'] = 'Fabrique à reliques';
cubeBatiments[4]['res1'] = 1000;
cubeBatiments[4]['res2'] = 1000;
cubeBatiments[4]['timeConstr'] = 90;
cubeBatiments[4]['nbr'] = 0;
cubeBatiments[5] = {};
cubeBatiments[5]['image'] = 'depot1';
cubeBatiments[5]['text'] = 'Grange';
cubeBatiments[5]['res1'] = 200;
cubeBatiments[5]['res2'] = 200;
cubeBatiments[5]['timeConstr'] = 30;
cubeBatiments[5]['nbr'] = 0;
cubeBatiments[6] = {};
cubeBatiments[6]['image'] = 'depot2';
cubeBatiments[6]['text'] = 'Banque';
cubeBatiments[6]['res1'] = 200;
cubeBatiments[6]['res2'] = 200;
cubeBatiments[6]['timeConstr'] = 30;
cubeBatiments[6]['nbr'] = 0;

//Pour créer une relique
var ress1rel = 10000;
var ress2rel = 5000;
var nbrCitoyensToMakeRel = 100;
var timeFabricRel = 120;

//Pour former un soldat
var ress1sol = 10;
var ress2sol = 50;
var nbrCitoyensToFormSol = 30;
var timeFormSoldat = 20;

//Pour former un mineur
var ress1min = 50;
var ress2min = 30;
var nbrCitoyensToFormMin = 20;
var timeFormMineur = 20;



