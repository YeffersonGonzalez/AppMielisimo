$('#BtnRegistrar').on('click',function(e){
e.preventDefault();
    verificarCampos();
});

$('#BtnLimpiar').on('click',function(e){
e.preventDefault();
    LimpiarCampos();
    
});


function verificarCampos(){

    var nombre = $('#nombre').val();
    var usuario = $('#usuario').val();
    var contraseña = $('#contraseña').val();


    if (nombre === '' || usuario === '' || contraseña === '' ){

         respuest('Este campo es obligatorio' ,'error');
    }
    //respuest('hgg','info');
}


function LimpiarCampos() {
     $('#nombre').val('');
     $('#usuario').val('');
     $('#contraseña').val('');

}