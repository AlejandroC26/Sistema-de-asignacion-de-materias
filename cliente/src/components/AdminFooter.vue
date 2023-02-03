<template>
    <section class="footer">
        <div class="container-footer">
            <div class="derechos-autor">Derechos de Autor 2023 - Colombia</div>
            <div class="legality">
                <a href="#">Aviso de Privacidad</a>
                <a href="#">Política de tratamiento de datos</a>
                <a href="#">Condiciones de Uso</a>
                <a href="#">Términos y condiciones</a>
            </div>
        </div>
    </section>
</template>
<style scoped>
.footer {
	height: 55px;
	box-sizing: border-box;
	padding: 10px 20px;
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
@media (min-width: 1024px) {
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
		max-width: 1240px;
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