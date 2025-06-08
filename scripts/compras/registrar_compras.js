$('#BtnAgregar').on('click',function(e){
e.preventDefault();
    verificarCampos();
});
/*
$('#BtnLimpiar').on('click',function(e){
e.preventDefault();
    LimpiarCampos();
    
});*/


function verificarCampos(){

    var ID_proveedor = $('#ID_proveedor').val();
  
    var IVA = $('#IVA').val();
    var cantidad = $('#cantidad').val();
    var precio = $('#precio').val();
    var registarCmp = $('#registarCmp').val();
   


    if (ID_proveedor === '' || IVA === ''  || cantidad === '' || precio === '' ||registarCmp === '')
    {
        respuest('Este campo es obligatorio' ,'error');

    }
    //respuest('hgg','info');
}

/*
function LimpiarCampos() {
     $('#ID_proveedor').val('');
     $('#IVA').val('');
     $('#cantidad').val('');
     $('#precio').val('');
     $('#registarCmp').val('');

}*/