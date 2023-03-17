$(document).ready(function () {
  $('#partners-active').change(function () {
    $('#partners-list').html('');
    $.ajax({
      url: '../index.php',
      method: 'POST',
      data: {
        partners: 'initialize',
        active_only: $(this).prop('checked'),
      },
      dataType: 'JSON',
      success: function (data) {
        if (data != '') {
          for (let c = 0; data.partner_city.length > c; c++) {
            if (data.partner_rights[c] == 2) {
              var status = 'Partenaire activé';
              var statusClass = 'active';
            } else {
              var status = 'Partenaire désactivé';
              var statusClass = 'inactive';
            }
            $('#partners-list').append(
              '<div class="partner-card col-12 col-xl-5">' +
                '<div class="about">' +
                '<div>' +
                data.partner_city[c] +
                '</div>' +
                '<div>' +
                data.partner_mail[c] +
                '</div>' +
                '<div>Nombre de structures : ' +
                data.partner_structures_number[c] +
                '</div>' +
                '<div class="' +
                statusClass +
                ' px-2">' +
                status +
                '</div>' +
                '</div>' +
                '<div class="link">' +
                '<a href="partner.php?city=' +
                data.partner_city[c] +
                '">Détails</a>' +
                '</div>' +
                '</div>'
            );
          }
        }
      },
      error: function () {
        alert('Erreur. Impossible de charger la liste des partenaires actifs');
      },
    });
  });
});
