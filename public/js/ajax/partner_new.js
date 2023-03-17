$(document).ready(function () {
  $("form").on("submit", function (e) {
    e.preventDefault();

    let mail = $("#partner-mail").val();

    function isEmail(email) {
      var regex =
        /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if (!regex.test(email)) {
        return false;
      } else {
        return true;
      }
    }

    if (isEmail(mail) == true) {
      $.ajax({
        type: "post",
        url: "../index.php",
        data: $(this).serialize(),
        success: function (data) {
          if (data == "") {
            alert(
              "Profil partenaire crée ! Un mail lui a été automatiquement envoyé avec ses informations d'identification."
            );
            location.replace("../template/partners.php");
          } else {
            alert(data);
          }
        },
        error: function () {
          alert("Erreur. Le partenaire n'a pas été créé.");
        },
      });
    } else {
      alert("Le format du mail est incorrect. Veuillez le modifier");
    }
  });
});
