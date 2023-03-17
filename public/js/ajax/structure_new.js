$(document).ready(function () {
  // Récupération des villes :
  $.ajax({
    type: "post",
    url: "../index.php",
    data: { cities_list: "initialize" },
    dataType: "JSON",
    success: function (data) {
      data.forEach((result) => {
        $("#city").append("<option>" + result.city + "</option>");
      });
    },
    error: function () {
      alert("Erreur. Impossible d'initialiser la liste des villes.");
    },
  });

  // Soumission du formulaire :
  $("form").on("submit", function (e) {
    e.preventDefault();

    let mail = $("#structure-mail").val();

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
              "Profil de la structure créée ! Un mail lui a été automatiquement envoyé avec ses informations d'identification."
            );
            location.replace("../template/partners.php");
          } else {
            alert(data);
          }
        },
        error: function () {
          alert("Erreur. La structure n'a pas été créée.");
        },
      });
    } else {
      alert("Le format du mail est incorrect. Veuillez le modifier");
    }
  });
});
