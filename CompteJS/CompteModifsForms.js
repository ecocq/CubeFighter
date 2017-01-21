/* Permet de valider les champs de formModif suivant des règles, et affiche des messages suivant les erreurs d'input */
$('#formModif').validate({
          rules: {
            /* Vérification de l'email */
            email: {
              email: true,
              remote: {
                type: "post",
                url: "VerificationPhp/VerifMail.php",
                data: {mail: function(){return $('#email').val();}}
              }
            },
            /* Vérification de la longueur du mot de passe */
            newMDP: {
              //minlength: 8,
              remote: {
                type: "post",
                url: "VerificationPhp/VerifPassword.php",
                data: {
                  password: function(){return $('#newMDP').val()},
                  passwordcheck: function(){return $('#confNewMDP').val();}
                }
              }
            },
            /* Vérification des deux mots de passes */
            confNewMDP: {
              remote: {
                type: "post",
                url: "VerificationPhp/VerifPasswordCheck.php",
                data: {
                  password: function(){return $('#newMDP').val()},
                  passwordcheck: function(){return $('#confNewMDP').val();}
                },
              }
            }
          },
          messages: {
            email: {
              remote: "Erreur existe déjà",
              email: "Entrez une adresse email valide"
            },
            newMDP: {
              minlength: "Veuillez entrer un mot de passe d'au moins 8 caractères",
              remote: "Problème de taille ou mots de passes qui ne sont pas égaux"
            },
            confNewMDP: {
              remote: "Les mots de passes ne correspondent pas"
            }
          },
          highlight: function(element) {
              var id_attr = "#" + $( element ).attr("id") + "1";
              $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
              $(id_attr).removeClass('glyphicon-ok').addClass('glyphicon-remove');
          },
          unhighlight: function(element) {
              var id_attr = "#" + $( element ).attr("id") + "1";
              $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
              $(id_attr).removeClass('glyphicon-remove').addClass('glyphicon-ok');
          },
          errorElement: 'span',
              errorClass: 'help-block',
              errorPlacement: function(error, element) {
                  if(element.length) {
                      error.insertAfter(element);
                  } else {
                  error.insertAfter(element);
                  }
              }
});

/* Bypass pour la vérification du mot de passe courant avec de l'ajax */
$(document).ready(function(){
  $('#formModif').on('submit',function(e){
    e.preventDefault();

    var $this = $(this);

    $.ajax({
        url:$this.attr('action'),
        type: $this.attr('method'),
        data: $this.serialize(),
        dataType: 'json',
        success: function(json)
        {
            /* Il y a un problème dans un des champs */
            if (json.reponse != "ok")
            {
               var id_attr = "#currentMDP1";
               $('#currentMDP1').closest('.form-group').removeClass('has-success').addClass('has-error');
               $(id_attr).removeClass('glyphicon-ok').addClass('glyphicon-remove');
            }
            else /* Tout va bien on recharge la page pour afficher les changements */
            {
              window.location.reload();
            }
        },
    });
  });
});
