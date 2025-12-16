// script.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('inscripcionForm');
    const dniInput = document.getElementById('dni');
    const fechaNacimientoInput = document.getElementById('fecha_nacimiento');

    form.addEventListener('submit', (e) => {
        const dniValue = dniInput.value;
        if (!/^\d+$/.test(dniValue)) {
            alert('El DNI debe contener solo números.');
            e.preventDefault();
            return;
        }

        const fechaNacimiento = new Date(fechaNacimientoInput.value);
        const hoy = new Date();

        if (fechaNacimiento.getTime() > hoy.setHours(0,0,0,0)) {
            alert('La fecha de nacimiento no puede ser en el futuro.');
            e.preventDefault();
            return;
        }

        console.log('Formulario enviado y validado por JS.');
    });
});

    function logout() {
  const msg = document.getElementById("logout-message");
  msg.style.display = "block";

  setTimeout(() => {
    msg.style.display = "none";
    window.location.href = "index.html?logout=true";
  }, 5000);
}