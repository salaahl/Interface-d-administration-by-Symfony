$("#active-only").change(function () {

    let toggle = $(this).prop("checked");
    
    if (toggle == true)
    {
        $('.part_non_actif').parents('.liste_part').css("display", "none");
    }
    else
    {
        $('.part_non_actif').parents('.liste_part').css("display", "flex");
    }
});