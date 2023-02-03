<template>
    <router-view id="application"/>
</template>
<script>
import {mapActions, mapMutations, mapState} from 'vuex'
export default {
  methods:{
	...mapActions(['readToken']),
	...mapMutations(['loadSessionUser']),
  },
  computed: {
	...mapState(['token']),
  },
  mounted(){
	this.loadSessionUser();
  },
  created(){
	this.readToken();
  }
}
</script>
<style>
@import './assets/fonts/style.css';
@import './assets/style/alert.css';
@import './assets/fonts/families.css';
@import './assets/style/modal.css';
*{
  padding: 0;
  margin: 0;
}
body{
  padding-top: 60px;
}
section, div {
  font-family: 'Meera Inimai';
}
input[type="text"],
input[type="password"]{
  outline: none;
}

.mt-12{
	margin-top: 12px;
}


.body-info-section {
	padding: 25px 40px;
	min-height: 23.8vh;
}
.content-section-info {
	max-width: 1240px;
	margin: auto;
}


.progress-container{
    border-radius: 25px;
    width: 90%;
    margin: 0 auto;
    height: 1.2em;
    position: relative;
    background-color: rgb(239, 60, 105);
}
.progressbar{
    position: relative;
    height:  100%;
}
.progress-num{
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: -.3em;
    right: -10px;
    color: #8a8a8a;
    background-color: #ffff;
    height: 1.8em;
    width: 2.3em;
}
.green{
    border-radius: 25px;
    background-color: rgb(0, 201, 133);
}


/* LABEL ANIM*/
.wrapper-form-data {
	background: #fff;
	padding: 5px 0;
	display: flex;
	gap: 10px;
}
.wrapper-form-data .input-data {
	height: 40px;
	width: 100%;
	position: relative;
}
.wrapper-form-data .input-data input {
	height: 100%;
	width: 100%;
	border: none;
	font-size: 17px;
	transition: all .3s ease-in-out;
	border-bottom: 2px solid silver;
}
.input-data input:focus ~ label,
.input-data input:valid ~ label {
	transform: translateY(-20px);
	font-size: 15px;
}

.wrapper-form-data .input-data label {
	position: absolute;
	bottom: 10px;
	left: 0;
	color: grey;
	pointer-events: none;
	transition: all 0.3s ease;
}
.input-data .underline {
	position: absolute;
	height: 2px;
	width: 100%;
	bottom: 0;
}
.input-data .underline:before {
	position: absolute;
	content: '';
	height: 100%;
	width: 100%;
	transform: scaleX(0);
	transform-origin: center;
	transition: transform 0.3s ease;
}
.input-data input:focus ~ .underline:before,
.input-data input:valid ~ .underline:before {
	transform: scaleX(1);
}


@media screen and (max-width: 850px){
  .body-info-section{
    padding: 20px 40px;
  }
}
</style>
