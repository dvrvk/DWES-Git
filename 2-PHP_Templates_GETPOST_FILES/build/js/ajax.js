const formulario_ajax = document.querySelectorAll('.formularioAJAX');


formulario_ajax.forEach(formulario => {
    formulario.addEventListener('submit', enviar_formulario_ajax);
})

function enviar_formulario_ajax(e) {
    e.preventDefault();
    let enviar = confirm("¿Quieres enviar el formulario?");

    if(enviar){
        // Crear un array de datos con los datos del formulario
        let data = new FormData(this);
        let method= this.getAttribute("method");
        let action= "/admin/subir.php";
        
        let headers = new Headers();

        let config = {
            method,
            headers, 
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action, config)
            .then(respuesta => respuesta.text())
            .then(respuesta => alert(respuesta));
    }
}

