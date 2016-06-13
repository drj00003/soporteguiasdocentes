/* Determinamos el tiempo total en segundos */
var totalTiempo=10;
/* Determinamos la url donde redireccionar */
var url="/web/app_dev.php/";

function updateReloj()
{
    document.getElementById('homeRedirect').innerHTML = "Será redireccionado al inicio en "+totalTiempo+" segundos";

    if(totalTiempo==0)
    {
        window.location=url;
    }else{
        /* Restamos un segundo al tiempo restante */
        totalTiempo-=1;
        /* Ejecutamos nuevamente la función al pasar 1000 milisegundos (1 segundo) */
        setTimeout("updateReloj()",1000);
    }
}

window.onload=updateReloj;