$(document).ready(function () {
  $('.toggle').change(function () {
    let structureToggle = $(this).prop('checked');
    let toggleName = $(this).attr('name');
    let city = document.getElementById('city').textContent.slice(26);
    let address = document
      .getElementById('structure-address')
      .textContent.slice(10);
    let searchParams = new URLSearchParams(window.location.search);
    let mail = searchParams.get('structure_mail');

    if (confirm('Veuillez confirmer votre choix') == true) {
      $.ajax({
        url: '../index.php',
        method: 'POST',
        data: {
          structure_toggle: structureToggle,
          toggle_name: toggleName,
          mail: mail,
          city: city,
          address: address,
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
