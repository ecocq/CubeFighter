// Fonction pour parser la date (utile pour la construction)
function parseDate(input) {
    var parts = input.match(/(\d+)/g);
    // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
    return new Date(parts[0], parts[1] - 1, parts[2], parts[3], parts[4], parts[5]); // months are 0-based
}


var ressource1 = 0;
var ressource2 = 0;
var nbrSoldats = 0;
var nbrCitoyens = 0;
var nbrMineurs = 0;
var nbrReliques = 0;
var constrDateDebut;
var soldatDateDebut = null;
var mineurDateDebut = null;
var reliqueDateDebut = null;
var dateNow = new Date();
var timerConstruction = 0;
var soldatTimer = 0;
var mineurTimer = 0;
var reliqueTimer = 0;
var attaqueTimer = 0;
var listBatiments;
