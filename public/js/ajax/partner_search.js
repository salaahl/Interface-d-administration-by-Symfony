$(document).ready(function () {
  $("#search-bar").keyup(function () {
    let input = $(this).val();
    $("#search-result").html("");

    if (input != "") {
      $.ajax({
        type: "POST",
        url: "../index.php",
        data: { partner_search: encodeURIComponent(input) },
        dataType: "JSON",
        success: function (data) {
          if (data != "") {
            for (let c = 0; data.partner_city.length > c; c++) {
              if (data.partner_rights[c] == 2) {
                var status = "Partenaire activé";
                var statusClass = "active";
              } else {
                var status = "Partenaire désactivé";
                var statusClass = "inactive";
              }
              $("#search-result").append(
                '<div class="partner-card col-12">' +
                  '<div class="about">' +
                  "<div>" +
                  data.partner_city[c] +
                  "</div>" +
                  "<div>" +
                  data.partner_mail[c] +
                  "</div>" +
                  "<div>Nombre de structures : " +
                  data.partner_structures_number[c] +
                  "</div>" +
                  '<div class="' +
                  statusClass +
                  ' px-2">' +
                  status +
                  "</div>" +
                  "</div>" +
                  '<div class="link">' +
                  '<a href="partner.php?city=' +
                  data.partner_city[c] +
                  '">Détails</a>' +
                  "</div>" +
                  "</div>"
              );
              $(".partner-card").animate({ opacity: 1 }, 500);
            }
          } else {
            $("#search-result").html(
              "<div style='font-size: 20px; text-align: center;'>Aucun partenaire trouvé</div>"
            );
          }
        },
      });
    }
  });
});
