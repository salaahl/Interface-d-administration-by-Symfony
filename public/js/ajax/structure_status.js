$(document).ready(function () {
  $('#structure-status').change(function () {
    var toggle = $(this).prop('checked');
    var searchParams = new URLSearchParams(window.location.search);
    var structureMail = searchParams.get('structure_mail');

    if (confirm('Veuillez confirmer votre action') == true) {
      $.ajax({
        url: '../index.php',
        method: 'POST',
        data: { structure_activate: toggle, structure_mail: structureMail },
        error: function () {
          alert(
            'Impossible de mettre à jour le statut. Veuillez contacter un administrateur.'
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
