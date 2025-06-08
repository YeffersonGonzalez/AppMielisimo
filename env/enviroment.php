<?php

function urlServidor()
{
    /*     // Obtener el origen (protocolo + dominio)
    $origen = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

    // Obtener el pathname (ruta después del dominio)
    $ruta = $_SERVER['REQUEST_URI'];

    // Suponiendo que el nombre del proyecto es el primer segmento del pathname
    $segmentos = explode('/', trim($ruta, '/'));
    $nombreProyecto = count($segmentos) > 0 ? $segmentos[0] : '';

    // Construir la URL base
    $baseUrl = $origen . '/' . $nombreProyecto . '/';

    // Retornar el arreglo con la URL base
    return [
        'baseUrl' => $baseUrl
    ]; */
    /* return "library-system/"; */
    // Obtener el origin (protocolo + dominio)
    $origen = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

    // Obtener el pathname (ruta después del dominio)
    $ruta = $_SERVER['REQUEST_URI'];

    // Suponiendo que el nombre del proyecto es el primer segmento del pathname
    $segmentos = explode('/', $ruta);
    $nombreProyecto = count($segmentos) > 1 ? $segmentos[1] : '';

    $baseUrl = $origen . '/' . $nombreProyecto . '/';

    return $baseUrl;
}
