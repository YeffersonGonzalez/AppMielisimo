$('#BtnGuardar').on('click',function(e){
e.preventDefault();
    verificarCampos();
});

function verificarCampos(){

    var RazonSocial = $('#RazonSocial').val();
    var Telefono = $('#Telefono').val();
    var email = $('#email').val();
    var direccion = $('#direccion').val();
    var BtnGuardar = $('#BtnGuardar').val();
    


    if (RazonSocial === '' || Telefono ==='' || email === ''  || direccion === '' || BtnGuardar === '' )
    {
        respuest('Este campo es obligatorio' ,'error');

    }
    //respuest('hgg','info');
}

function LimpiarCampos() {
     $('#RazonSocial').val('');
     $('#Telefono').val('');
     $('##email').val('');
     $('#direccion').val('');
     $('#BtnGuardar').val('');

}