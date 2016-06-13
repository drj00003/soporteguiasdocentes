// var allowSubmit = false;

// function capcha_filled () {
//     allowSubmit = true;
// }

// function capcha_expired () {
//     allowSubmit = false;
// }

// function check_if_capcha_is_filled (e) {
//     if(allowSubmit) return true;
//     e.preventDefault();
//     alert('Fill in the capcha!');
// }

// Cambiar el document ready por cuando se pulse el boton submit.
// $(document).ready(function(){
//   var recaptcha = document.forms["guiasdocentes_appbundle_consultahasasignatura"]["g-recaptcha-response"];
//   console.log(recaptcha);
//   recaptcha.required = true;
//   recaptcha.oninvalid = function(e) {
//     // do something
//     alert("Please complete the captcha");
//   }
// });

// Necesitamos un evento de cuando se vaya enviar el formulario submit testee lo siguiente:
// $("guiasdocentes_appbundle_consultahasasignatura_save").onclick(){
//   if ($('#g-recaptcha-response').val()==""){
//   alert("Complete el captcha");
//   exit();
//   }
// }
// $(document).ready(function(){
// document.forms.submit(function( event ) {
//   if ($('#g-recaptcha-response').val()==""){
//   alert("Complete el captcha");
//   event.preventDefault();
//   }
// });
// });

function isNaturalNumber(n) {
    n = n.toString(); // force the value incase it is not
    var n1 = Math.abs(n),
        n2 = parseInt(n, 10);
    return !isNaN(n1) && n2 === n1 && n1.toString() === n;
}

$(document).ready(function(){
  // $('.alert').hide();
  
  // Validador de cadena de texto
//   $( "#target" ).submit(function( event ) {
//   alert( "Handler for .submit() called." );
//   event.preventDefault();
// });
});  

document.getElementById("guiasdocentes_appbundle_consultahasasignatura_save").addEventListener("click", function (event) {
  // var recaptcha = document.forms["guiasdocentes_appbundle_consultahasasignatura"]["g-recaptcha-response"];
  // console.log(recaptcha);
  // recaptcha.required = true;
  // recaptcha.oninvalid = function(e) {
  //   // do something
  //   alert("Por favor, complete el captcha.");
  // }
  

  // if (document.guiasdocentes_appbundle_consultahasasignatura.nombre.value == "") {
  //     alert("Enter a name");
  //     document.myForm.name.focus();
  //     return false;
  // }
  // if (!/^[a-zA-Z]*$/g.test(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_nombre").value)) {
  //     document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_nombre").focus();
  //     $('#alert-nombre').show();
  //     event.preventDefault();
  // }
  // if (!/^[a-zA-Z]*$/g.test(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_apellidos").value)) {
  //     document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_apellidos").focus();
  //     $('#alert-apellidos').show();
  //     event.preventDefault();
  // }
  // if (!/^[0-9;]*$/g.test(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_asignaturaCodigo_codigo").value)) {
  //     document.getElementById("guiasdocentes_appbundle_consultahasasignatura_asignaturaCodigo_codigo").focus();
  //     $('#alert-asignaturas').show();
  //     event.preventDefault();
  // }else{
  //     if (isNaturalNumber(document.getElementById("guiasdocentes_appbundle_consultahasasignatura_consulta_hiloid_consultanteemail_nombre").value) === false){
  //         $('#alert-asignaturas').show();
  //         event.preventDefault(); 
  //     }
  // }
  if ($('.g-recaptcha-response').val()==""){
    // alert("Por favor, complete el captcha.");
    //podemos cambiar el estilo aquí de g-recaptcha o g-recaptcha-response y ponerle borde rojo o fondo amarillo y meter un evento que al click not robot 
    //quite el borde
    $('#alert-captcha').show();
    event.preventDefault();
    // exit();
    // return false;
  }
});