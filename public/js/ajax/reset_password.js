$(document).ready(function () {
  $.validator.addMethod("noCommonPassword", function () {
    return commonPassword("#change_password");
  });

  $("form").validate({
    rules: {
      change_password: {
        required: true,
        minlength: 5,
        noCommonPassword: true,
      },
      confirm_password: {
        required: true,
        equalTo: "#change_password",
      },
    },
    messages: {
      change_password: {
        required: "Ce champ est obligatoire.",
        minlength: "Veuillez saisir au moins 5 caractères.",
        noCommonPassword:
          "Votre mot de passe n'est pas assez sécurisé. Veuillez le modifier.",
      },
      confirm_password: {
        required: "Ce champ est obligatoire.",
        equalTo: "Veuillez entrer à nouveau la même valeur.",
      },
    },
    submitHandler: function () {
      $("form").on("submit", function (e) {
        e.preventDefault();

        let searchParams = new URLSearchParams(window.location.search);
        let mail = searchParams.get("mail");
        let changePassword = $("#change_password").val();

        $.ajax({
          type: "post",
          url: "index.php",
          data: { mail: mail, change_password: changePassword },
          success: function (data) {
            if (data == "") {
              alert(
                "Nouveau mot de passe enregistré. Veuillez vous reconnecter."
              );
              location.replace("./login.html");
            } else {
              alert(data);
            }
          },
          error: function () {
            alert("Erreur. Veuillez contacter un administrateur.");
          },
        });
      });
    },
  });
});
