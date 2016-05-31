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
$(document).ready(function(){
  $('.alert').hide();
});  

document.getElementById("guiasdocentes_appbundle_consultahasasignatura_save").addEventListener("click", function () {
  // var recaptcha = document.forms["guiasdocentes_appbundle_consultahasasignatura"]["g-recaptcha-response"];
  // console.log(recaptcha);
  // recaptcha.required = true;
  // recaptcha.oninvalid = function(e) {
  //   // do something
  //   alert("Por favor, complete el captcha.");
  // }
  if ($('.g-recaptcha-response').val()==""){
    // alert("Por favor, complete el captcha.");
    //podemos cambiar el estilo aquí de g-recaptcha o g-recaptcha-response y ponerle borde rojo o fondo amarillo y meter un evento que al click not robot 
    //quite el borde
    $('.alert').show();
    exit();
  }
});