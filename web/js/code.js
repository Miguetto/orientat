// COMPROBACIÓN SERVICE WORKER EN NAVEGADOR
if('serviceWorker' in navigator){
    // si es soportado, ejecuta la promesa siguiente:
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('js/sw.js')
        .then(reg=>console.log('Registro de sw exitoso', reg))
        .catch(err=>console.warn('Error al registrar el sw', err))
    });
}