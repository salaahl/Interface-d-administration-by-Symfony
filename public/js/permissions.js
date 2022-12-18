$(".toggle").change(function () {

  let toggle = $(this).prop("checked");
  let id = $(this).attr("id");
  
  if (confirm("Veuillez confirmer votre choix") == true) {
    $.ajax({
      method: "POST",
      data: {
        statut_toggle: toggle,
        id: id,
      },
      success: function (data) {
        alert(data);
      },
      error: function () {
        alert("Erreur. Veuillez contacter un administrateur.");
      },
    });
  } else {
    return toggle
      ? $(this).prop("checked", false)
      : $(this).prop("checked", true);
  }
});