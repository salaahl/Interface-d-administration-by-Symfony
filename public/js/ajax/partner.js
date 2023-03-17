$(document).ready(function () {
  let searchParams = new URLSearchParams(window.location.search);
  let city = searchParams.get("city");

  $.ajax({
    type: "post",
    url: "../index.php",
    data: { partner_page: "initialize", city: city },
    dataType: "JSON",
    success: function (data) {
      $("#city h1").append(city);
      $("#mail").append(data.mail);
      $("#delete-user").val(data.mail);
      $("#partner-status").prop("checked", data.status);
      $("#drinks-permission").prop("checked", data.drinks_permission);
      $("#newsletter-permission").prop("checked", data.newsletter_permission);
      $("#planning-permission").prop("checked", data.planning_permission);

      for (let c = 0; data.structures_mails.length > c; c++) {
        $("#structures").append(
          '<div class="structure">' +
            '<a href="structure.php?structure_mail=' +
            data.structures_mails[c] +
            "&city=" +
            city +
            '">' +
            '<div class="structure-address">' +
            data.addresses[c] +
            "</div>" +
            '<div class="structure-mail">' +
            data.structures_mails[c] +
            "</div>" +
            "</a>" +
            "</div>"
        );
      }
    },
    error: function () {
      alert(
        "Impossible de charger correctement la page. Veuillez contacter un administrateur."
      );
    },
  });
});
