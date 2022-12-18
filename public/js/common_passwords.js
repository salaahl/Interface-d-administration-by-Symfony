window.onload = function () {

  NBP.init("mostcommon_100", "../collections", true);

  let status_msg = document.getElementById("niveau_mot_de_passe");
  let a = document.getElementById("partenaire_mot_de_passe");
  let b = document.getElementById("structure_mot_de_passe");

  if(a) 
  {
      a.addEventListener("keyup", function (evt) {

        var pwd = a.value;

        if (pwd.length < 1) {
          status_msg.innerHTML = "";
        } else if (NBP.isCommonPassword(pwd) || pwd.length < 5) {
          status_msg.innerHTML = "Faible";
          status_msg.style.color = "red";
        } else {
          status_msg.innerHTML = "Ok";
          status_msg.style.color = "green";
        }
      });
  } 
  else if(b) 
  {
    b.addEventListener("keyup", function (evt) {

      var pwd = b.value;

      if (pwd.length < 1) {
        status_msg.innerHTML = "";
      } else if (NBP.isCommonPassword(pwd) || pwd.length < 5) {
        status_msg.innerHTML = "Faible";
        status_msg.style.color = "red";
      } else {
        status_msg.innerHTML = "Ok";
        status_msg.style.color = "green";
      }
    });
  }
}