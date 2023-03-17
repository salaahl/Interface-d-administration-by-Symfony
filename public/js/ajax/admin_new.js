$(document).ready(function () {
  jQuery.validator.addMethod("isEmail", function (value, element) {
    return (
      this.optional(element) ||
      /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(
        value
      )
    );
  });

  $.validator.addMethod("noCommonPassword", function () {
    return commonPassword("#password");
  });

  $("form").validate({
    rules: {
      admin_mail: {
        required: true,
        isEmail: true,
      },
      password: {
        required: true,
        minlength: 5,
        noCommonPassword: true,
      },
      confirm_password: {
        required: true,
        equalTo: "#password",
      },
    },
    messages: {
      admin_mail: {
        required: "Ce champ est obligatoire.",
        isEmail: "Veuillez entrer un mail valide.",
      },
      password: {
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

        $.ajax({
          type: "post",
          url: "../../index.php",
          data: $(this).serialize(),
          success: function (data) {
            if (data == "") {
              alert("Administrateur enregistré ! Veuillez vous connecter.");
              location.replace("../../login.html");
            } else {
              alert(data);
            }
          },
          error: function () {
            alert("Erreur. L'administrateur n'a pas été créé.");
          },
        });
      });
    },
  });
});
