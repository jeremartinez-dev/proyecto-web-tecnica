// Cambia entre los formularios de login y registro
function toggleForm() {
  const loginForm = document.getElementById("login-form");
  const registerForm = document.getElementById("register-form");
  const formText = document.getElementById("form-text");

  const isLoginVisible = loginForm.style.display !== "none";

  loginForm.style.display = isLoginVisible ? "none" : "block";
  registerForm.style.display = isLoginVisible ? "block" : "none";

  formText.innerText = isLoginVisible ? "Registrarse" : "Iniciar Sesión";

  document.getElementById("message").innerText = "";
}

function togglePassword(id, icon) {
  const input = document.getElementById(id);
  if (input.type === "password") {
    input.type = "text"; 
    icon.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    input.type = "password"; 
    icon.classList.replace("fa-eye-slash", "fa-eye");
  }
}

function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function register() {
  const username = document.getElementById("register-username").value;
  const email = document.getElementById("register-email").value;
  const password = document.getElementById("register-password").value;
  const terms = document.getElementById("terms").checked;
  const msg = document.getElementById("message");

  if (!username || !email || !password || !terms) {
    msg.innerText = "Completa todos los campos.";
    return;
  }

  if (!isValidEmail(email)) {
    msg.innerText = "Email no válido.";
    return;
  }

  const user = { username, email, password };

  localStorage.setItem("userData", JSON.stringify(user));

  msg.innerText = "Guardar contraseña. Ya estás registrado.";
  toggleForm();
}

function login() {
  const emailInput = document.getElementById("login-email").value;
  const password = document.getElementById("login-password").value;
  const msg = document.getElementById("message");

  const saved = JSON.parse(localStorage.getItem("userData"));

  if (saved && (emailInput === saved.email || emailInput === saved.username) && password === saved.password) {
    msg.innerText = "Sesión iniciada correctamente.";
  } else {
    msg.innerText = "Contraseña o email incorrecto.";
  }
}

