const RegistroAdmin = document.getElementById('RegistroAdmin');
const inputs = document.querySelectorAll('#RegistroAdmin input');

const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{8,}$/, // 8 a 50 digitos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}

const campos = {
	nombre: false,
	apellido: false,
	email: false,
	password: false
}
const validarRegistro = (e) => {
	switch(e.target.name)
	{
		case "nombreA":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;
		case "apellidoA":
			validarCampo(expresiones.nombre, e.target, 'apellido');
		break;
		case "emailA":
			validarCampo(expresiones.correo, e.target, 'email');
		break;
		case "passA":
			validarCampo(expresiones.password, e.target, 'password');
			validarRePassword();
		break;
		case "repassA":
			validarRePassword();
		break;
	}
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value))
	{
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-circle-xmark');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-bounce');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-circle-check');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;
	}
	else
	{
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-circle-check');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-circle-xmark');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-bounce');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;
	}
}

const validarRePassword = () => {
	const inputPassword = document.getElementById('passA');
	const inputRePassword = document.getElementById('repassA');

	if (inputPassword.value.length < 8) {
        document.getElementById(`grupo__password`).classList.add('formulario__grupo-incorrecto');
        document.getElementById(`grupo__password`).classList.remove('formulario__grupo-correcto');
        document.querySelector(`#grupo__password i`).classList.add('fa-circle-xmark');
        document.querySelector(`#grupo__password .formulario__input-error`).textContent = "La contraseña debe contener al menos 8 caracteres";
        document.querySelector(`#grupo__password .formulario__input-error`).classList.add('formulario__input-error-activo');
        campos['password'] = false;
	}
	else if(inputPassword.value !== inputRePassword.value)
	{
		document.getElementById(`grupo__repassword`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__repassword`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__repassword i`).classList.remove('fa-circle-check');
		document.querySelector(`#grupo__repassword i`).classList.add('fa-circle-xmark');
		document.querySelector(`#grupo__repassword i`).classList.add('fa-bounce');
		document.querySelector(`#grupo__repassword .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos['password'] = false;
	}
	else
	{
		document.getElementById(`grupo__repassword`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__repassword`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__repassword i`).classList.remove('fa-circle-xmark');
		document.querySelector(`#grupo__repassword i`).classList.remove('fa-bounce');
		document.querySelector(`#grupo__repassword i`).classList.add('fa-circle-check');
		document.querySelector(`#grupo__repassword .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos['password'] = true;
	}
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarRegistro);
	input.addEventListener('blur', validarRegistro);
});

RegistroAdmin.addEventListener('submit', (e) => {
	if(campos.nombre && campos.apellido && campos.email && campos.password)
	{
		document.getElementById('formulario__mensaje-exito').classList.add('formulario__mensaje-exito-activo');
	}
	else
	{
		document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
		e.preventDefault();
	}
});

const actualizarBoton = () => {
	const btn = document.getElementById('submitRegistro');

	if(campos.nombre && campos.apellido && campos.email && campos.password)
	{
		btn.removeAttribute('disabled');
	}
	else
	{
		btn.setAttribute('disabled', 'true');
	}

}