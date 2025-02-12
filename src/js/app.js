const diasFeriados = [
    '2025-01-01',
    '2025-02-03',
    '2025-03-17',
    '2025-09-16',
    '2025-11-17',
    '2025-12-25'
]

const contacto = {
    telefono: '',
    fecha: '',
    hora: '',
    email: ''
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    eventListener();
    darkMode();
}

function darkMode() {
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    const botonDarkMode = document.querySelector('.dark-mode-boton');
    
    // Verificar si hay preferencia guardada en localStorage
    const modoGuardado = localStorage.getItem('dark-mode');

    if (modoGuardado) {
        if (modoGuardado === 'enabled') {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    } else {
        // Si no hay preferencia guardada, usar las preferencias del sistema
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    }

    // Escuchar cambios en las preferencias del sistema
    prefiereDarkMode.addEventListener('change', function () {
        if (!localStorage.getItem('dark-mode')) { // Solo cambiar si no hay preferencia guardada
            if (prefiereDarkMode.matches) {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        }
    });

    // Toggle de modo oscuro al hacer clic en el botón
    botonDarkMode.addEventListener('click', function () {
        const isDarkMode = document.body.classList.toggle('dark-mode');

        // Guardar la preferencia en localStorage
        if (isDarkMode) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }
    });
}

function eventListener() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');

    metodoContacto.forEach(input => input.addEventListener( 'click', mostrarMetodosContacto));

}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar');
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');

    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `  
            <label for="telefono">Número de Teléfono:</label>
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]" required>

            <p>Elija la hora y fecha para la llamada</p>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="contacto[fecha]" required>

            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="contacto[hora]" required>
        `; // Funciona como un template string ( ALT GR + } )
         seleccionarFecha();
         seleccionarHora();
    } else {
        contactoDiv.innerHTML = `
            <label for="email">E-Mail:</label>
            <input type="email" placeholder="Tu E-Mail" id="email" name="contacto[email]" required>
        `;
    }
}

function seleccionarFecha() {
    const inputfecha = document.querySelector('#fecha');
    const diaDespues = new Date();
    diaDespues.setDate(diaDespues.getDate() + 1); // Dia actual +1
    const fechaMinima = diaDespues.toISOString().split('T')[0]; // Convertir a 'YYYY-MM-DD'

    inputfecha.addEventListener('input', function(e) {
        const dia = new Date(e.target.value).getUTCDay(); 
        const fechaSeleccionada = e.target.value;
        
        if ( [6, 0].includes(dia) ) {
            e.target.value = ''; // Limpia el input
            mostrarAlerta("Cerrado Fines de Semana", "error", ".fecha-contacto");
        } else if(fechaSeleccionada < fechaMinima) {
            e.target.value = '';
            mostrarAlerta("No puedes seleccionar una fecha actual o anterior a " + fechaSeleccionada, "error", ".fecha-contacto");
        } else if(diasFeriados.includes(fechaSeleccionada)) {
            e.target.value = ''; // Limpia el input
            mostrarAlerta("Cerrado Días Festivos", "error", ".fecha-contacto");
        } else {
            contacto.fecha = fechaSeleccionada;
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) {

        const horaCita = e.target.value;
        const [hora, minutos] = horaCita.split(":").map(Number);
        if (hora < 8 || (hora === 20 && minutos > 0) || hora > 18) {
            e.target.value = ''; // Limpia el input si la hora no es valida
            mostrarAlerta("La hora de la llamada debe ser entre las 08:00 AM y las 08:00 PM", "error", ".fecha-contacto");
        } else {
            contacto.hora = e.target.value;
        }
    });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // Previene que se generen más de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    // Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        // Elimina la alerta después de 3 segundos
        setTimeout(() => {
        alerta.remove();
        }, 3000);
    }
    
}
