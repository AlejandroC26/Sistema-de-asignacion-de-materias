<template>
  <div class="home">
    <Header/>
	<div class="main-container">
		<section class="body-info-section">
			<div class="content-section-info">
				<div class="full-container">
					<h1 class="title-text">404</h1>
					<div class="text-about">
						Page not found.
					</div>
                    <div>
                        <router-link to="/">Home</router-link>
                    </div>
				</div>
			</div>
		</section>
		<div class="login-wrapper">
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
						<div class="wrapper-form-data pd-1">
							<div class="input-data">
								<input
									type="text"
									name="email"
									size="40"
									maxlength="50"
									required
									v-model="user.email"
								/>
								<div class="underline"></div>
								<label>Correo</label>
							</div>
						</div>
						<div class="wrapper-form-data pd-1">
							<div class="input-data">
								<input
									type="password"
									name="password"
									size="40"
									maxlength="50"
									id="password"
									required
									v-model="user.password"
								/>
								<div class="underline"></div>
								<label>Contraseña</label>
							</div>
							<div class="show-input">
								<span class="icon-view-show" id="show-password"></span>
							</div>
						</div>
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
import { mapActions } from 'vuex'
/* import axios from "axios" */
import Header from '@/components/MainHeader'
import Footer from '@/components/MainFooter'
export default {
  components: {
    Header,
    Footer,
  },
  data: function (){
	return{
		user:{
			email: 'cubillosa862@asd.net',
			password: 'Alejandro',
		},
		error: false,
		error_msg: '',
	}
  },
  methods: {
	...mapActions('auth', ['login']),
  },
  mounted(){
	const $ = require('jquery')
	window.$ = $
	var m_estado = 0;
	$('#show-password').click(function () {
		if (m_estado == 0) {
			$('#password').prop('type', 'text');
			$(this).removeClass('icon-view-show');
			$(this).addClass('icon-view-hide');
			m_estado = 1;
		} else {
			$('#password').prop('type', 'password');
			$(this).removeClass('icon-view-hide');
			$(this).addClass('icon-view-show');
			m_estado = 0;
		}
	});
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
  }
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
}
.logo_sm .logo_img {
	width: 70px;
	height: 70px;
	background-size: cover;
	margin-right: 30px;
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
