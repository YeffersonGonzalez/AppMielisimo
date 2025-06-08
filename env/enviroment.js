// Obtener el origin (protocolo + dominio)
const origen = window.location.origin;

// Obtener el pathname (ruta después del dominio)
const ruta = window.location.pathname;

// Suponiendo que el nombre del proyecto es el primer segmento del pathname
const segmentos = ruta.split('/');
const nombreProyecto = segmentos.length > 1 ? segmentos[1] : '';

const enviroments = {
    baseUrl: origen + '/' + nombreProyecto + '/api',
    ImgUrl: origen + '/' + nombreProyecto + '/'
}
