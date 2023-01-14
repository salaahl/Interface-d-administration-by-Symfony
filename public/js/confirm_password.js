let partnerPwd = document.getElementById("partenaire_mot_de_passe");
let structurePwd = document.getElementById("structure_mot_de_passe");
let confirmPwd = document.getElementById("confirmer_mot_de_passe");

function validerMotDePasse() {
    if(partnerPwd) 
    {
        if (partnerPwd.value != confirmPwd.value) {
            confirmPwd.setCustomValidity(
            "Les mots de passe ne correspondent pas"
            );
            return false;
        } else {
            confirmPwd.setCustomValidity("");
            return true;
        }
    }
    else
    {
        if (structurePwd.value != confirmPwd.value) {
            confirmPwd.setCustomValidity(
            "Les mots de passe ne correspondent pas/trop faible"
            );
            return false;
        } else {
            confirmPwd.setCustomValidity("");
            return true;
        }   
    }
}

confirmPwd.onkeyup = validerMotDePasse;