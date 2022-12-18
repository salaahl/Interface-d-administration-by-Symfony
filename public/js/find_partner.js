$(document).ready(function () {
$("#recherche_part").keyup(function () {
$("#resultat_part").html("");

let saisie = $(this).val();

if (saisie != "") {
$.ajax({
    type: "POST",
    data: { find_partner: encodeURIComponent(saisie) },
    dataType: "JSON",
    success: function (data) {
        if (data.mail.length !== 0)
        {
            for (let c = 0; data.mail.length > c; c++) {
            if (data.rights_level[c] == 2) {
                var statut = "Partenaire activé";
                var classe = "part_actif";
            } else {
                var statut = "Partenaire désactivé";
                var classe = "part_non_actif";
            }
            $("#resultat_part").append(
                '<div class="liste_part">' +
                '<div class="infos_part">' +
                "<div>" + data.city[c] + "</div>" +
                "<div>" + data.mail[c] + "</div>" +
                "<div>Nombre de structures : " +
                data.number_structures[c] +
                "</div>" +
                '<div class="' + classe + ' px-2">' + statut + "</div>" +
                "</div>" +
                '<div class="lien">' +
                '<a href="./' +
                data.mail[c] +'">Détails</a>' +
                "</div>" +
                "</div>"
            );
            $(".liste_part").animate({ opacity: 1 }, 200);
            }
        }
        else
        {
            document.getElementById("resultat_part").innerHTML =
            "<div style='font-size: 20px; text-align: center;'>Aucun partenaire trouvé</div>";
        }
    },
});
}
});
});