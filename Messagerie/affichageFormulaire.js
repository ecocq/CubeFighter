function displayForm() {

        if (document.getElementById('destinataire').value !=''){document.getElementById('destinataire').value='';}
        if (document.getElementById('sujet').value !=''){document.getElementById('sujet').value='';}
        if (document.getElementById('text').value !=''){document.getElementById('text').value='';}
        if (document.getElementById('msgenvoye').value !=''){document.getElementById('msgenvoye').innerHTML='';}


        form = document.getElementById('nouveau');
        form.style.display = 'block';
}

function reverseDisplayForm() {

    form = document.getElementById('nouveau');
    form.style.display = 'none';
    $('#liste').load('jouer.php #liste');
}


function displayFormLect(callback,id) {
	var xhr = null;
    $('html,body').scrollTop(0);


	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest();
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}


	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {

			callback(xhr.responseText);
		}
	};

    var mainID = id;

	xhr.open("GET", "Messagerie/getMessage.php?id="+id, true);
	xhr.send(null);
}

function readData(sData) {

    var array = JSON.parse(sData);

    document.getElementById('auteurLect').value=array["pseudo"];

    document.getElementById('sujetLect').value=array["sujet"];
    document.getElementById('textLect').value=array["texte"];
    document.getElementById('dateLect').value=array["date"];

    form = document.getElementById('lecture'),
    form.style.display = 'block';
}

function reverseDisplayFormLect() {

    form = document.getElementById('lecture');
    form.style.display = 'none';
    $('#liste').load('jouer.php #liste');

}

$(document).ready(function(){
    $('#formenvoi').on('submit',function(e){
        e.preventDefault();

        var $this = $(this);

        var destinatare = $('#destinataire').val();
        var sujet = $('#sujet').val();
        var text = $('#text').val();

        $.ajax({
            url:$this.attr('action'),
            type: $this.attr('method'),
            data: $this.serialize(),
            dataType: 'json',
            success: function(json)
            {
                document.getElementById('msgenvoye').innerHTML=json.reponse;

                if (json.reponse == 'Votre message a bien été envoyé!')
                { setTimeout(function(){
                        form = document.getElementById('nouveau');
                        form.style.display = 'none';
                    },3000);
                }
                $('#liste').load('jouer.php #liste');
            }
        });

    });
});

$(document).ready(function(){
    $('#formsup').on('submit',function(e){
        e.preventDefault();

        var $this = $(this);

        $.ajax({
            url:$this.attr('action'),
            type: $this.attr('method'),
            data: $this.serialize(),
            dataType: 'json',
            success: function(json)
            {
                $('#liste').load('jouer.php #liste');
                document.getElementById('msgsup').innerHTML=json.reponse;
                setTimeout(function(){
                         document.getElementById('msgsup').innerHTML="";
                    },2000);

            },
        });

    });
});




