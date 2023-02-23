<template>
    <div class="content-header">
        <div id="wrapper-menu"></div>
        <header>
            <router-link to="/dashboard">
            <div class="logo-nav">
                <div class="logo-slogan">
                    <div class="slogan" style="color: #72737d;">
                        INICIO
                    </div>
                </div>
            </div>
            </router-link>
            <nav id="main-navbar">
                <div class="content-button-close">
                    <span class="open-close btn-close-2 icon-cross"></span>
                </div>
                <ul>
                    <li>
                        <router-link to="/dashboard"><span class="icon-home"></span>Inicio</router-link>
                    </li>
                    <li v-if="sessionUser.permisos.admin">
                        <router-link to="/profesores">Profesores</router-link>
                    </li>
                    <li v-if="sessionUser.permisos.admin">
                        <router-link to="/estudiantes">Estudiantes</router-link>
                    </li>
                    <li v-if="sessionUser.permisos.admin">
                        <router-link to="/asignaturas">Asignaturas</router-link>
                    </li>
                    <li>
                        <a class="router-link-active" @click="logOut()"><span class="icon-home"></span>Cerrar Sesión</a>
                    </li>
                </ul>
            </nav>
            <div class="menu-visible">
                <nav>
                    <ul>
                        <li><a href="#" id="profile">{{sessionUser.nombres}} </a></li>
                        <li>
                            <div class="menu_bar open-close">
                                <a href="#e" class="bt-menu" id="btn-menu">
                                    <div class="icon-align"><span class="icon-menu5"></span></div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="profile-box" id="profile-box">
                <div class="profile-section">
                    <div class="user-name"> {{sessionUser.nombres}} </div>
                    <router-link to="/perfil">
                        <div class="admin-profile">
                            Administrar Perfíl
                        </div>
                    </router-link>
                </div>
                <div class="profile-section">
                    <div class="logout-profile" @click="logOut()">
                        Cerrar Sesión
                    </div>
                </div>
            </div>
        </header>
    </div>
</template>
<script>
import {mapState} from 'vuex'
export default {
    methods: {
        logOut(){
            localStorage.removeItem('token');
            window.location = '/';
        }
    },
     mounted(){
        const $ = require('jquery')
        window.$ = $
        $(document).ready(main);
        function main() {
            const btnMenu = document.querySelector('#btn-menu');
            let profileBtn = document.getElementById('profile');
            function animNav(){
                let navbar = document.getElementById('main-navbar');
                let wrapper = document.getElementById('wrapper-menu');
                if(navbar.className) {
                    wrapper.style.display = 'none';
                    return navbar.removeAttribute('class');
                }
                wrapper.style.display = 'block';
                return navbar.className += "show-navbar";
            }
            $('.submenu').click(function(){$(this).children('.children').slideToggle();});
            $('.bt-close').click(function () {animNav();});
            btnMenu.addEventListener('click', function () {animNav();});
            document.querySelector('.open-close').addEventListener('click', ()=>{animNav();});
            document.getElementById('wrapper-menu').addEventListener('click', ()=>{animNav();});
            /* ==========PROFILE BTN ================ */
            document.addEventListener('click', (e) => {
                let profileBox = document.getElementById('profile-box');
                if(!profileBox.getAttribute('style')) return;
                if(e.target.parentNode.className != 'profile-box' 
                && e.target.parentNode.className != 'profile-section' ) {
                    if(e.target.id == 'profile') return;
                    else OpenAndCloseProfileBox();
                }
            })
            function OpenAndCloseProfileBox(){
                let profileBox = document.getElementById('profile-box');
                if(profileBox.getAttribute('style')) profileBox.removeAttribute('style');
                else profileBox.setAttribute('style', 'display: block');
            }
            profileBtn.addEventListener('click', ()=> { OpenAndCloseProfileBox()});
        }
    },
    computed: {
        ...mapState(['sessionUser']),
    }
}
</script>
<style scoped>
.content-header{
    top: 0;
    position: fixed;
	background: #fff;
	z-index: 10000;
    width: 100%;
    box-shadow: 0px 0px 2px rgb(121 121 121);
    -webkit-box-shadow: 0px 0px 2px rgb(121 121 121);
}
/* LOGO */
.logo-nav {
	width: 220px;
	height: 60px;
	float: left;
	display: flex;
    margin-left: 1.2rem;
}
.logo-nav .slogan {
	display: flex;
	align-items: center;
}
.logo-nav .logo-slogan {
	display: inline-flex;
	align-items: center;
	padding: 12px 10px 10px 0;
}
.logo-nav .logo-slogan img {
	width: 90%;
}
.logo-nav .logo-img {
	padding: 8px;
}
.logo-nav .logo-img {
	display: flex;
	align-items: center;
}
.logo-nav .logo-img img {
	height: 44px;
}
.wabe {
	position: absolute;
	bottom: -10px;
	width: 100%;
	z-index: 100;
	height: 150px;
}


#wrapper-menu {
	top: 60px;
    position: fixed;
	left: 0;
    width:100%;
    height:100%;
    background-color: rgba(0,0,0, .3);
    z-index: 80;
    display:none;
    transition: all 0.5s;
}

/* ============ */
.show-navbar{left: 0;}
/* ============ */
header{
    position: relative;
	margin: 0 auto;
    width: 100%;
    max-width: 1245px;
	font-family: 'Roboto Condensed';
}
header > nav{
    padding:  40px 0 0 0 ;
    position: fixed;
    top: 60px;
    width: 80%;
    max-width: 320px;
    height: calc(100% - 60px);
    background-color: #fff;
    left: -100%;
    margin: 0;
    overflow-y: scroll;
    z-index: 100;
    box-sizing: border-box;
    box-shadow: 0px 0px 1px rgb(163, 163, 163);
    transition: left .5s ease;
}
header > nav .content-rol{
	position: absolute;
	top: 12px;
	left: 10px;
	font-weight: bold;	
	color: rgb(255, 103, 18);
}
header > nav .btn-close-2 {
    position: absolute;
    top: 12px;
    right: 10px;
    cursor: pointer;
	color: rgb(206, 0, 45);
	font-size: 1.2rem;
}
header > nav
header > nav ul{
    list-style: none;
    text-align: left;
}
header > nav ul li{
    display: block;
	transition: all 0.5s;
    position: relative;
}
header > nav ul li a {
    transition: color 0.5s;
}
header > nav ul li a span{
    display: none;
}
header > nav ul li span{
    margin-right: 10px;
}
header > nav ul li:hover{
	border-bottom-left-radius: 5px;
	border-bottom-right-radius: 5px;
}
header > nav ul li:hover > a {
	color: rgb(206, 0, 45);
}
header > nav ul li a{
    padding: 15px 30px;
    color: rgb(92, 92, 92);
    display: block;
    text-decoration: none;
    font-size: 1.1em;
}
header > nav ul li .children{
    box-sizing: border-box;
    width: 100%;
    display: none;
    position: relative;
    background: rgb(255, 233, 239);
    text-align: left;
	overflow: hidden;
	border-bottom-left-radius: 5px;
	border-bottom-right-radius: 5px;
}
header > nav ul li:hover .children{
    display: none;
    text-align: left;
}
header > nav ul li .children li{
	padding: 0 5px;
    overflow: hidden;
    display: block;
    transition: background-color 0.3s ease-in-out;
}
header > nav ul li .children li:hover {
    background-color: rgb(233, 72, 107);
}
header > nav ul li .children li:hover a{
    color: #fff;
}
header > nav ul li .children li a{
	color: #4e4e4e;
    margin-left: 20px;
    transition: color 0.3s ease-in-out;
}
header > nav ul li .children li a span{
    float: right;
    position: relative;
    top: 3px;
    margin-right: 0;
    margin-left: 0;
}
header > nav ul li .icon-chevron-small-down{
    position: relative;
    top: 3px;
    margin-left: 10px;
    float: right;
}
header > nav ul li.submenu span{
    display: inline;
}
/* =========SCROLL BAR ========= */
header > nav::-webkit-scrollbar {
	-webkit-appearance: none;
}
header > nav::-webkit-scrollbar:vertical {
	width:10px;
}
header > nav::-webkit-scrollbar-button:increment,header nav::-webkit-scrollbar-button {
	display: none;
} 
header > nav::-webkit-scrollbar:horizontal {
	height: 10px;
}
header > nav::-webkit-scrollbar-thumb {
	background-color: rgb(206, 0, 45);
	border-radius: 5px;
	border: 2px solid rgb(255, 255, 255);
}
header > nav::-webkit-scrollbar-track {
	border-radius: 10px;  
}
/* ====HEADER NAVBAR */
#menu {transition: all 0.3s;}
.open-close {display: block;}

.profile-box {
    z-index: 10000;
    display: none;
    color: #1c1c1c;
    top: 58px;
    right: 10px;
    width: 90%;
    position: absolute;
    max-width: 250px;
    background-color: #fff;
    box-shadow: 0 0 5px rgb(213, 213, 213);
    border-radius: 5px ;
}

.profile-box a {
    text-decoration: none;
    color: #1c1c1c;
}
.profile-box > .profile-section {
    padding: 15px 5px;
    border-bottom: 1px solid rgb(213, 213, 213);
}
.profile-box > .profile-section > a{
    display: block;
    width: 176px;
    margin: auto;
}
.profile-box > .profile-section:last-child {
    border-bottom: none;
}
.profile-box > .profile-section .user-name {
    font-weight: bold;
}
.profile-box > .profile-section .user-rol {
    color: #7b7b7b;
}
.profile-box > .profile-section .user-name,
.profile-box > .profile-section .user-rol {
    display: flex;
    margin: 5px 0;
    justify-content:center;
}
.profile-box > .profile-section .logout-profile {
    width: 60%;
}
.profile-box > .profile-section .admin-profile,
.profile-box > .profile-section .logout-profile {
    display: flex;
    justify-content: center;
    margin: 0 auto;
    padding: 8px 15px;
    border-radius: 3px;
    cursor: pointer;
    border: 1px solid rgb(213, 213, 213);
}
.profile-box > .profile-section .admin-profile:hover,
.profile-box > .profile-section .logout-profile:hover{
    background-color: #f8f8f8;
}



/* MENÚ VISIBLE */
.menu-visible{
	height: 60px;
	display: flex;
	align-items: center;
	justify-content: flex-end;
}
.menu-visible nav{
	width: 100%;
}
.menu-visible nav ul{
	overflow: hidden;
	list-style: none;
	display: flex;
	float: right;
	margin-bottom: 0;
}
.menu-visible nav ul li{
	display: inline-flex;
    margin-right: 20px;
	align-items: center;
}
.menu-visible nav ul li a{
    border-radius: 5px;
    padding: 5px 10px;
    background: #eeeeee;
	color: #72737d;
	display: block;
	text-decoration: none;
	font-size: 1.1em;
	transition: all 0.4s;
}
.menu-visible nav ul li a.bt-menu{
    display:flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    width: 35px;
    font-size: 1.2rem;
    border-radius:50%;
    height: 35px;
}
.menu-visible nav ul li a:hover{
	color: rgb(88, 87, 87);
}
.menu-visible nav ul li .search{
	background-color: white;
	padding-left: 5px;
}
.menu-visible nav ul li .search input{
	border: none;
	height: 100%;
}
.menu-visible nav ul li .search button{
	margin: 0;
	padding: 5px;
	border: none;
	color: white;
	background-color: #FF8F00;
}
.menu-visible nav ul li .search button span{	
	font-size: 1.05em;
}


@media screen and (max-width: 800px){
    .logo-nav{
        width: auto;
    }
    .logo-nav .logo-slogan img {
        display: none;
    }
}
@media screen and (max-width: 335px){
    .sub-logo-nav{
        width: 230px;
    }
}
</style>