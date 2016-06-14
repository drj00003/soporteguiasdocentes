

function isNaturalNumber(n) {
    n = n.toString(); // force the value incase it is not
    var n1 = Math.abs(n),
        n2 = parseInt(n, 10);
    return !isNaN(n1) && n2 === n1 && n1.toString() === n;
}

$(document).ready(function(){



document.getElementById("guiasdocentes_appbundle_consultahasasignatura_save").addEventListener("click", function (event) {

  if (!/^[a-zA-Z]*$/g.test(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_nombre").value)) {
      document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_nombre").focus();
      $('#alert-nombre').show();
      event.preventDefault();
  }
  if (!/^[a-zA-Z]*$/g.test(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_apellidos").value)) {
      document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_apellidos").focus();
      $('#alert-apellidos').show();
      event.preventDefault();
  }
  if (!/^[0-9;]*$/g.test(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_asignaturaCodigo_codigo").value)) {
      document.getElementById("guiasdocentes_appbundle_consultahasasignatura_asignaturaCodigo_codigo").focus();
      $('#alert-asignaturas').show();
      event.preventDefault();
  }else{
      if (isNaturalNumber(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_nombre").value) === false){
          $('#alert-asignaturas').show();
          event.preventDefault(); 
      }
  }
  if ($('.g-recaptcha-response').val()==""){

    $('#alert-captcha').show();
    event.preventDefault();
  }
});
});  