<template>
  <div class="home">
    <Header/>
	<div class="main-container">
		<section class="element-section">
			<div class="element-background-overlay"></div>
			<div class="content-element-header-info">
				<div class="element-pading-section">
					<div class="element-info-section">
						<div class="info-title-section">
							Lorem ipsum dolor sit amet consectetur adipisicing elit.
						</div>
						<div class="info-subtitle-section">
							Lorem ipsum dolor sit amet consectetur adipisicing elit.
						</div>
					</div>
				</div>
			</div>
			<div class="wabe" style="overflow: hidden">
				<svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%">
					<path d="M-0.33,91.08 C145.26,104.90 293.11,19.04 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff"></path>
				</svg>
			</div>
		</section>
		<div 
			v-if="bFormRegistro"
			style="display: flex;  justify-content: center; position: fixed; top: 10rem; z-index: 100; width: 100%"
		>
			<div 
					class="formulario-registro"
			>
					<p class="titulo">Registro de estudiante</p>
					<button class="cross-btn"
							@click="()=>{
									bFormRegistro = false;
									limpiarFormulario();
							}">×</button>
					<div class="row">
						<FormNumber
							sLabel="Documento"
							:value="nDocumento"
							@updateValor="onSetDocumento($event)"
						/>
						<FormText
							sLabel="Nombres"
							:value="sNombres"
							@updateValor="onSetNombres($event)"
						/>
						<FormNumber
							sLabel="Teléfono"
							:value="nTelefono"
							@updateValor="onSetTelefono($event)"
						/>
					</div>
					<div class="row">
						<FormText
							sLabel="Dirección"
							:value="sDireccion"
							@updateValor="onSetDireccion($event)"
						/>
						<FormText
							sLabel="Ciudad"
							:value="sCiudad"
							@updateValor="onSetCiudad($event)"
						/>
						<FormNumber
							sLabel="N° Semestre"
							:value="nSemestre"
							@updateValor="onSetSemestre($event)"
						/>
					</div>
					<div class="row">
						<FormText
							sLabel="Email"
							:value="sEmail"
							@updateValor="onSetEmail($event)"
						/>
						<FormPassword
							sLabel="Contraseña"
							:value="sPassword"
							@updateValor="onSetPassword($event)"
						/>
					</div>
				<div class="btn-actions">
					<button @click="()=>{ bFormRegistro = false }">
						Cancelar
					</button>
					<button @click="registrarEstudiante()">
						Guardar
					</button>
				</div>
			</div>
		</div>
		<section class="body-info-section">
			<div class="content-section-info">
				<div class="full-container">
					<h1 class="title-text">ASIGNACIÓN DE MATERIAS</h1>
					<div class="text-about" style="margin-top: 1.5rem; font-size: 1.2rem;">
						<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sit blanditiis animi optio cumque nisi, omnis deserunt dolores harum enim, rerum culpa ullam praesentium doloribus iure est nam hic odit voluptatum quidem natus nesciunt. Tempora veritatis praesentium harum? Laudantium praesentium architecto vitae, ex saepe eum accusantium repellendus hic dolor! Velit, qui!</p>
						<p style="margin-top: .5rem;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero error eveniet facilis ipsa corrupti. Explicabo mollitia debitis maiores, est tempore minima quae, atque deleniti animi doloribus maxime facere perferendis quidem nesciunt error corrupti? Repellat corrupti voluptatibus iusto placeat vel dolores, voluptatem mollitia dolorem quas rem nesciunt minus, sint magni impedit. Fugit mollitia eos atque iusto possimus modi illum sit ab.</p>
					</div>
				</div>
			</div>
		</section>


		<div class="login-wrapper" v-if="!bFormRegistro">
			<div id="login" class="modal">
				<a href="#" class="close-modal">
					<div class="close-icon"></div>
				</a>
				<div class="logo_sm">
					<div class="title-login">Iniciar Sesión</div>
				</div>
				<div class="wabe-login" style="overflow: hidden">
					<svg
						viewBox="0 0 500 150"
						preserveAspectRatio="none"
						style="height: 100%; width: 100%"
					>
						<path
							d="M-21.10,127.59 C142.55,44.70 330.47,24.96 515.01,131.54 L500.00,150.00 L0.00,150.00 Z"
							style="stroke: none; fill: #e3f2fd"
						></path>
					</svg>
				</div>
				<div class="login-content">
					<div class="bg-white">
						<FloatingFormText
							sLabel="Correo"
							@updateValor="onSetUserEmail($event)"
						/>
						<FloatingFormPassword 
							sLavel="Contraseña"
							@updateValor="onSetUserPassword($event)"
							style="margin-top: 1rem;"
						/>
						<p style="text-align: center; margin-top: .8rem;">
							¿Aún no estás registrado? 
							<span class="link" @click="()=>{ 
								bFormRegistro = true;
							}">Regístrate</span>
						</p>
					</div>
					<div class="buttons-login">
						<a class="button-cancelar" href="#" rel="modal:close">Cancelar</a>
						<button class="button_enviar" v-on:click="login(user)">Iniciar Sesión</button>
					</div>
				</div>
			</div>
		</div>
	</div>
    <Footer/>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex';
import axios from 'axios';
/* import axios from "axios" */
import Header from '@/components/MainHeader';
import Footer from '@/components/MainFooter';
import FormText from '@/components/form/components/FormText';
import FormNumber from '@/components/form/components/FormNumber';
import FormPassword from '@/components/form/components/FormPassword';
import FloatingFormText from '@/components/form/floating-components/FloatingFormText';
import FloatingFormPassword from '@/components/form/floating-components/FloatingFormPassword';
export default {
  name: 'Home',
  components: {
    Header,
    Footer,
		FormText,
		FormNumber,
		FormPassword,
		FloatingFormText,
		FloatingFormPassword,
  },
  data: function (){
		return{
			nDocumento: '123',
			sNombres: 'Alejandro',
			nTelefono: '313',
			sEmail: 'cubillosalejandro122@gmail.com',
			sDireccion: 'Cra 16',
			sCiudad: 'Pitalito',
			nSemestre: '3',
			sPassword: '123',

			bFormRegistro: false,

			user:{
				email: '',
				password: '',
			},
			error_msg: '',
		}
  },
  methods: {
		// LOGIN
		onSetEmail(value) {
			this.sEmail = value;
		},
		onSetPassword (value) {
			this.sPassword = value;
		},
		// FORMULARIO
		onSetNombres(value) {
			this.sNombres = value;
		},
		onSetDocumento(value) {
			this.nDocumento = value;
		},
		onSetTelefono(value) {
			this.sTelefono = value;
		},
		onSetDireccion(value) {
			this.sDireccion = value;
		},
		onSetCiudad(value) {
			this.sCiudad = value;
		},
		onSetSemestre(value) {
			this.nSemestre = value;
		},
		//LOGIN
		onSetUserEmail(value) {
			this.user.email = value;
		},
		onSetUserPassword (value) {
			this.user.password = value;
		},

		limpiarFormulario(){
				this.bFormRegistro = false;
				this.nDocumento = '';
				this.sNombres = '';
				this.nTelefono = '';
				this.sEmail = '';
				this.sDireccion = '';
				this.sCiudad = '';
				this.nSemestre = '';
				this.sPassword = '';
				this.sIdEstudiante = '';
		},

		isValidText(data){
				var regex = new RegExp("^[a-zA-ZÀ-ÿ ]+$");
				var key = data;
				if (!regex.test(key)) return false
				return true;
		},
		isValidEmail(email) {
				let re = /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i
				if (re.test(email)) return true
				else return false
		},
		
		login(data) {
			axios.post('http://127.0.0.1:8000/api/auth/login', data)
			.then(({data}) => {
				console.log(data)
				if(data.status === 'success'){
					this.setToken(data.authorisation.token);
					localStorage.setItem('token', data.authorisation.token);
					window.location.href = 'dashboard';
				}
			}).catch(e => {
				if(e) return this.launchAlert({type: 'error', title: 'Correo o contraseña incorrectos!'})
			})
		},
		async registrarEstudiante(){
			let data = {
				documento: this.nDocumento,
				nombres: 	 this.sNombres,
				telefono:  this.nTelefono,
				email:     this.sEmail,
				direccion: this.sDireccion,
				ciudad:    this.sCiudad,
				semestre:  this.nSemestre,
				password:  this.sPassword,
			}



			if(!this.isValidText(data.nombres))
					return this.launchAlert({type: 'warning', title: '¡El nombre no puede contener carácteres especiales!'})

			if(!this.isValidEmail(data.email))
					return this.launchAlert({type: 'warning', title: '¡El correo no es válido!'})

			try {
				console.log(data)
					let user = await axios.post('http://127.0.0.1:8000/api/user/register', data, 
					{ headers: { "Authorization": "Bearer " + localStorage.getItem('token')}});

					axios.post('http://127.0.0.1:8000/api/estudiante/register', {
							id_user: user.data.data.id,
							semestre: data.semestre
					}, { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
					.then(() => {
							this.bFormRegistro = false;
							this.limpiarFormulario();
							return this.launchAlert({type: 'success', title: '¡Estudiante registrado!'})
					})
					.catch(e => {
						if(e.response)
							console.log(e.response)
						else console.log(e)
					})
			} catch (error) {
					this.launchAlert({type: 'error', title: error.response.data.message})
					console.log(error.response)
			}
		},
		launchAlert(config){
			if(!config.timeout) config.timeout = 2500;
			const Toast = this.$swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: config.timeout,
			})
			Toast.fire({
					icon: config.type,
					title: config.title,
					text: config.message,
			})
		},
    ...mapMutations(["setToken"]),
  },
  mounted(){
	const $ = require('jquery')
	window.$ = $;
	const button = document.querySelector('#OpenLogin');
	const popup = document.querySelector('.login-wrapper');
	const close = document.querySelector('.close-modal');
	
	button.addEventListener('click', () => {
		popup.style.display = 'block';
	});
	
	close.addEventListener('click', () => {
		popup.style.display = 'none';
	});
	
	popup.addEventListener('click', e => {
		if(e.target.className === 'login-wrapper') {
			popup.style.display = 'none';
		}
	});
  },
}
</script>

<style scoped>
.element-section {
    background-image: url('../assets/img/backgrounds/school-1974369_1920.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    max-height: 704px;
    font-family: 'Source Sans Pro';
}

.element-info-section {
	padding: 0 50px 50px 0;
	position: relative;
	margin-bottom: 100px;
	z-index: 20;
}

.element-info-section .info-title-section {
	font-size: 4em;
	text-shadow: rgb(0, 0, 0) 0 0 10px;
	color: rgb(255, 255, 255);
}
.element-info-section .info-subtitle-section {
	font-size: 1.5em;
	color: white;
}
.element-info-section .info-button-section {
	margin-top: 70px;
}

.element-pading-section {
	padding: 150px 80px 0 80px;
	display: flex;
}
.element-background-overlay {
	background-color: transparent;
	background: radial-gradient(#0059ff 60%, #5f5f5f);
	position: absolute;
	opacity: 0.2;
	width: 100%;
	height: 100%;
	z-index: 10;
}

.content-element-header-info {
	max-width: 1440px;
	margin: auto;
	display: block;
}
.wabe {
	position: absolute;
	bottom: -10px;
	width: 100%;
	z-index: 100;
	height: 150px;
}
.button-info-section {
	width: 350px;
	height: 50px;
	background: rgb(206, 0, 45);
	color: white;
	font-size: 1em;
	font-family: 'Source Sans Pro';
	font-weight: bold;
	line-height: 1.44em;
	border: none;
	border-radius: 5px;
	box-shadow: 0 0 10px #000;
	bottom: 50px;
	transition: all 0.2s;
}
.button-info-section:hover {
	background: rgb(228, 64, 100);
	cursor: pointer;
}
/* INFO */
.full-container {
	display: block;
}
.login-button {
	width: 100%;
	height: 50px;
	background: #001d5f;
	color: white;
	font-size: 1em;
	font-family: 'Source Sans Pro';
	font-weight: bold;
	line-height: 1.44em;
	border: none;
	border-radius: 5px;
	bottom: 50px;
}
.resalt-text {
	font-size: 1.5em;
	color: #ce002d;
	font-weight: bold;
}
.container-card {
	margin: 20px auto 0 auto;
	display: block;
}

.middle-card {
	padding: 20px;
}

.middle-card:first-child {
	background: rgb(206, 0, 45);
	padding-right: 25px;
}
.middle-card:last-child {
	/* background: blue; */
	padding-left: 25px;
}
.middle-card:last-child .row-card {
	margin: 10px 0;
	font-weight: bold;
	font-size: 1.1em;
}
.row-card {
	display: flex;
	margin-bottom: 10px;
	padding-bottom: 10px;
	border-bottom: 2px dashed #fff;
}

.title-footer-card {
	display: block;
	color: #fff;
	font-size: 1.1em;
	font-weight: bold;
}
.red {
	background: #fff;
	color: rgb(206, 0, 45);
}
.text-blue {
	color: rgb(0, 29, 95);
}
.blue {
	color: #fff;
	font-weight: bold;
	background: rgb(0, 29, 95);
}
.title-card {
	display: block;
	font-size: 1.3em;
	font-weight: 900;
	padding: 5px 10px;
	text-align: center;
}
.num_resalt {
	display: inline-block;
}
.age {
	width: 90px;
	font-weight: bold;
	font-size: 1.1em;
}
.age .age_name {
	color: #fff;
}
.age .age_num {
	color: #00276e;
}
.details {
	padding: 5px 0 0 5px;
	font-size: 1.1em;
	color: #fff;
	font-weight: bold;
}
.details .row-detail .num_resalt {
	background: #fff;
	font-size: 1.2em;
	color: rgb(206, 0, 45);
	margin-left: 5px;
	padding: 3px 10px;
}

.oval {
	background: rgb(0, 29, 95);
	font-size: 1.5em;
	color: #fff;
	padding: 8px 10px;
	width: 200px;
	text-align: center;
	border-radius: 20px;
	border: 5px solid rgb(206, 0, 45);
	margin-left: auto;
}

/* Login */
.login-wrapper {
    background: rgba(0, 0, 0, 0.5);
    position: fixed;
	display: none;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
	z-index: 10000;
}
.modal a.close-modal {
	position: absolute;
	top: 5px;
	right: 5px;
}
.modal a .close-icon{
	background-image: url('../assets/img/btn/close_60x60.png');
	background-size: cover;
	width: 25px;
	height: 25px;
}
#login {
	margin: 10% auto;
	width: 90%;
	max-width: 450px;
	background-color: #fff;
	position: relative;
	top: 0;
	z-index: 1000000;
	border-radius: .5rem;
}
#login .logo_sm {
	height: 80px;
	display: inline-flex;
	align-items: center;
}
#login .login-content,
#login .logo_sm {
	padding: 10px 30px;
}
#login .wabe-login {
	height: 20px;
}
#login .login-content {
	background-color: #e3f2fd;
	border-bottom-left-radius: .5rem;
	border-bottom-right-radius: .5rem;

}

.logo_sm .title-login {
	font-size: 2em;
	font-family: 'Meera Inimai';
	font-weight: bold;
	color: #ce002d;
}
/* BOTĆ“N MOSTRAR */
.btn-mostrar {
	height: 30px;
	background: rgb(206, 0, 45);
	color: white;
	font-size: 1em;
	font-family: 'Source Sans Pro';
	border: none;
	border-radius: 5px;
	padding: 0 5px;
}
.buttons-login {
	margin-top: 20px;
	width: 100%;
	display: inline-flex;
}
.button_enviar,
.button-cancelar {
	border: none;
	font-family: 'Source Sans Pro';
	border-radius: 5px;
	padding: 5px 10px;
	font-size: 1em;
	color: white;
	transition: all 0.3s;
}
.button_enviar:hover,
.button-cancelar:hover {
	opacity: 0.7;
	cursor: pointer;
}
.buttons-login .button_enviar {
	height: 40px;
	background: rgb(206, 0, 45);
	margin-left: auto;
}
.buttons-login .button-cancelar {
	height: 30px;
	background: rgb(0, 29, 95);
	text-decoration: none;
	align-items: center;
	display: inline-flex;
}

@media (min-width: 1024px){
	.container-card{
		display: flex;
	}
	.middle-card{
		width: 100%;
	}
}

@media screen and (max-width: 850px){
	.element-pading-section{
		padding: 70px 40px;
	}
	.element-pading-section,
	.body-info-section {
		padding: 70px 40px;
	}
	.element-info-section {
		padding: 20px 0;
		margin-bottom: 50px;
	}
	.element-info-section .button-info-section {
		width: 230px;
		bottom: 30px;
	}
	.wabe {
		height: 100px;
	}
	.element-section-footer {
		padding: 20px 40px;
	}
}
@media screen and (max-width: 490px) {
	.element-info-section .info-title-section {
		font-size: 2.5em;
		line-height: 1em;
	}
	.element-info-section .info-subtitle-section {
		font-size: 1.8em;
		line-height: 1em;
	}
	.element-pading-section,
	.body-info-section {
		padding: 35px 20px;
	}
	.element-info-section {
		padding: 20% 0 0 0;
	}
}
</style>
