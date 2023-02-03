<template>
    <div>
    <section class="element-section-footer">
        <div class="content-section-footer">
        </div>
    </section>
    <section class="footer">
        <div class="container-footer">
            <div class="derechos-autor">Derechos de Autor 2021 - Colombia</div>
            <div class="legality">
                <a href="#">Aviso de Privacidad</a>
                <a href="#">Política de tratamiento de datos</a>
                <a href="#">Condiciones de Uso</a>
                <a href="#">Términos y condiciones</a>
            </div>
        </div>
    </section>
    </div>
</template>
<script>
export default {
    mounted(){
        const subMenuBtn = document.querySelectorAll('.submenu-btn');
        for (let i = 0; i < subMenuBtn.length; i++) {
            subMenuBtn[i].addEventListener('click', function () {
                //Este anoche debe ser el mismo de el @media en css
                if (window.innerWidth < 1024) {
                    const submenu = this.nextElementSibling;
                    const rotate = this.querySelector('.rotate-item');
                    const height = submenu.scrollHeight;
                    if (submenu.classList.contains('desplegar')) {
                        submenu.classList.remove('desplegar');
                        rotate.classList.remove('rotate-anim');
                        submenu.removeAttribute('style');
                    } else {
                        submenu.classList.add('desplegar');
                        submenu.style.height = height + 'px';
                        rotate.classList.add('rotate-anim');
                    }
                }
            });
        }
    }
}
</script>
<style scoped>


/* FOOTER */
.footer {
	padding: 20px 50px;
	background: #5f5f5f;
	color: #fff;
	display: block;
	font-size: 0.8em;
}

.legality a {
	text-decoration: none;
	color: #fff;
	padding: 0;
	margin-right: 10px;
}
.legality {
	margin-left: auto;
}
.derechos-autor,
.legality {
	display: block;
}
input,
button {
	outline: none;
}
.element-section-footer {
	padding: 70px 40px;
	background: rgb(0, 29, 95);
	font-family: 'Meera Inimai';
}
.menu_link {
	display: block;
	padding: 20px;
	color: white;
	font-size: 1.2em;
	text-decoration: none;
	transition: all 0.2s;
}
.menu_link:hover {
	opacity: 0.9;
}
ul.submenu {
	height: 0;
	overflow: hidden;
	transition: all 0.3s;
}

.mostrar {
	margin-left: 0;
}
.container_submenu {
	font-family: 'Meera Inimai';
	list-style: none;
	border-bottom: solid 1px #ff6958;
}
.rotate-item {
	background: #f1948a;
	width: 20px;
	height: 20px;
	transition: all 0.2s;
	display: inline-flex;
	padding: 7px 7px;
	border-radius: 50%;
	align-items: center;
	float: right;
}
.text-tittle-block {
	width: 50%;
	display: inline-flex;
}
.rotate-anim {
	transform: rotate(-180deg);
}

/* BLOQUE ÚNICO FOOTER*/
.element-block-unic {
	width: 100%;
	margin: auto;
	background: #fff;
	color: #5f5f5f;
}
.element-row {
	padding: 20px;
	display: block;
	font-size: 1.1em;
	text-align: center;
}
.element-row .info-row-btn {
	text-decoration: none;
	color: rgb(129, 129, 129);
}
.slogan {
	display: flex;
	align-items: center;
	justify-content: center;
	overflow: hidden;
	padding: 10px;
}
.element-row .slogan img {
	width: 150px;
	border-right: 50px;
	border-radius: 2px;
	background: #fff;
}
.red-social-boton {
	width: 30px;
	height: 30px;
	border: solid 2px rgb(129, 129, 129);
	border-radius: 45%;
	display: inline-block;
	margin: 0 5px;
}
.red-social-boton a {
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	text-decoration: none;
	color: rgb(129, 129, 129);
	font-size: 1.2em;
}
.submenu-btn {
	background: #ce002d;
}
ul.submenu .menu_link {
	background: #ebeff8;
	padding: 20px 30px;
	color: rgb(129, 129, 129);
}

@media (min-width: 1024px){
    .element-section-footer {
		display: flex;
	}
    .content-section-footer {
		width: 100%;
		max-width: 1240px;
		margin: auto;
		display: flex;
	}
    .element-unic-section-footer-block {
		width: max-content;
		display: inline-flex;
	}
    .container-section-blocks {
		display: inline-block;
		margin-left: auto;
		width: 70%;
	}
    .element-section-footer-block {
		width: auto;
		display: inline-flex;
		margin: 0 5px;
		float: right;
	}
    .element-section-footer-block .container_submenu,
	.text-tittle-block {
		width: 100%;
	}
	.container_submenu,
	.element-unic-section-footer-block .container_submenu {
		border-bottom: none;
	}
    .submenu-btn {
		background: #ce002d;
		border-radius: 5px 5px 0 0;
		font-weight: bold;
	}
    ul.submenu {
		height: 243px;
		border-radius: 0 0 5px 5px;
	}
    .rotate-item {
		display: none;
	}

    .element-block-unic {
		width: 250px;
		background: #fff;
		color: #5f5f5f;
	}

    /* Footer */
    .footer {
		padding: 20px 50px;
		background: #5f5f5f;
		color: #fff;
		display: flex;
		font-size: 0.8em;
	}
    .footer .container-footer {
		display: flex;
		width: 100%;
		max-width: 1440px;
		margin: auto;
	}

    .legality a {
		text-decoration: none;
		color: #fff;
		padding: 0 10px;
	}
	.legality {
		margin-left: auto;
	}
	.derechos-autor,
	.legality {
		display: inline-block;
	}
	
}

</style>