$(document).ready(function () {
  $('.toggle').change(function () {
    let partnerToggle = $(this).prop('checked');
    let toggleName = $(this).attr('name');
    let searchParams = new URLSearchParams(window.location.search);
    let city = searchParams.get('city');

    if (confirm('Veuillez confirmer votre choix') == true) {
      $.ajax({
        url: '../index.php',
        method: 'POST',
        data: {
          partner_toggle: partnerToggle,
          toggle_name: toggleName,
          city: city,
        },
        error: function () {
          alert(
            'Impossible de mettre à jour la permission. Veuillez contacter un administrateur.'
          );
        },
      });
    } else {
      return toggle
        ? $(this).prop('checked', false)
        : $(this).prop('checked', true);
    }
  });
});
