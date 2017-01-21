 $(document).ready(function(){
            $('#formconn').on('submit',function(e){
                e.preventDefault();



                var $this = $(this);

                $.ajax({
                url:$this.attr('action'),
                type: $this.attr('method'),
                data: $this.serialize(),
                dataType: 'json',
                success: function(json)
                {
                    if(json.reponse=="Identifiants incorrects")
                    {
                        document.getElementById('msgCo').innerHTML=json.reponse;
                        document.getElementById('msgCo').style.display='block';
                    }
                    else
                    {
                        document.location.href="index.php"
                    }
                },
                    });
            });
        });


            $(document).ready(function(){
        $('#forminscri').on('submit',function(e){
            e.preventDefault();

             var $this = $(this);

            $.ajax({
            url:$this.attr('action'),
            type: $this.attr('method'),
            data: $this.serialize(),
            dataType: 'json',
            success: function(json)
            {
                if(json.reponse=="ok")
                {
                    document.location.href="comptecree.php"
                }
            },
        });
        });


        });

    $(function() {
        $( "#pseudo" ).ready(function() {
            var l = $("#pseudo").val();
            $('#pseudoverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#pseudoverif').load('VerificationPhp/VerifPseudoInscription.php',{ pseudo:l, champ:'img'});
            $('#erreurPseudo').load('VerificationPhp/VerifPseudoInscription.php',{ pseudo:l, champ:'info'});
            var k = $("#mail").val();
            $('#mailverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#mailverif').load('VerificationPhp/VerifMailInscription.php',{ mail:k, champ:'img'});
            $('#erreurMail').load('VerificationPhp/VerifMailInscription.php',{ mail:k,champ:'info'});
            var o = $("#passwordcheck").val();
            var p = $("#password").val();
            $('#passwordverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#passwordverif').load('VerificationPhp/VerifPasswordInscription.php',{ password:p,champ:'img'});
            $('#erreurMDP').load('VerificationPhp/VerifPasswordInscription.php',{ password:p,champ:'info'});
            $('#passwordcheckverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#passwordcheckverif').load('VerificationPhp/VerifPasswordCheckInscription.php',{ password:p , passwordcheck:o,champ:'img'});
            $('#erreurCheckMDP').load('VerificationPhp/VerifPasswordCheckInscription.php',{ password:p , passwordcheck:o,champ:'info'});
        });

        $( "#pseudo" ).change(function() {
          var l = $("#pseudo").val();
          $('#pseudoverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#pseudoverif').load('VerificationPhp/VerifPseudoInscription.php',{ pseudo:l, champ:'img'});
            $('#erreurPseudo').load('VerificationPhp/VerifPseudoInscription.php',{ pseudo:l, champ:'info'});
        });

        $( "#mail" ).change(function() {
          var l = $("#mail").val();
            $('#mailverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#mailverif').load('VerificationPhp/VerifMailInscription.php',{ mail:l, champ:'img'});
            $('#erreurMail').load('VerificationPhp/VerifMailInscription.php',{ mail:l,champ:'info'});
        });


        $( "#password" ).change(function() {
            var l = $("#passwordcheck").val();
            var p = $("#password").val();
            $('#passwordverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#passwordverif').load('VerificationPhp/VerifPasswordInscription.php',{ password:p,champ:'img'});
            $('#erreurMDP').load('VerificationPhp/VerifPasswordInscription.php',{ password:p,champ:'info'});
            $('#passwordcheckverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#passwordcheckverif').load('VerificationPhp/VerifPasswordCheckInscription.php',{ password:p , passwordcheck:l,champ:'img'});
            $('#erreurCheckMDP').load('VerificationPhp/VerifPasswordCheckInscription.php',{ password:p , passwordcheck:l,champ:'info'});
        });


        $( "#passwordcheck" ).change(function() {
          var p = $("#password").val();
          var l = $("#passwordcheck").val();
            $('#passwordcheckverif').html('<img src="Image/ajax-loader.gif" style="z-index:1000;">');
            $('#passwordcheckverif').load('VerificationPhp/VerifPasswordCheckInscription.php',{ password:p , passwordcheck:l,champ:'img'});
            $('#erreurCheckMDP').load('VerificationPhp/VerifPasswordCheckInscription.php',{ password:p , passwordcheck:l,champ:'info'});
        });

    });
