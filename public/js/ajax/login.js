$(document).ready(function () {
  // Va lancer mes scripts de création de tables
  $.ajax({ url: '/' });

  $('form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      type: 'post',
      url: 'index.php',
      dataType: 'JSON',
      data: $(this).serialize(),
      success: function (response) {
        function changePassword() {
          return location.replace('./reset_password.php?mail=' + response.mail);
        }
        if (response.rights == 3) {
          location.replace('./template/partners.php');
        } else if (response.rights == 2) {
          if (response.first_connection == false) {
            location.replace('./template/partner.php?city=' + response.city);
          } else {
            changePassword();
          }
        } else if (response.rights == 1) {
          if (response.first_connection == false) {
            location.replace(
              './template/structure.php?structure_mail=' +
                response.structure_mail +
                '&city=' +
                response.city
            );
          } else {
            changePassword();
          }
        } else if (response.rights == 0) {
          $('.error').text(
            'Profil désactivé. Veuillez contacter un administrateur.'
          );
        } else {
          $('.error').text(response.rights);
        }
      },
    });
  });
});
