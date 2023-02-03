<template>
    <div>
        <Header/>
        <div class="admin-container">
        <section class="body-info-section">
            <div class="content-section-info">
                <Title :title="'Dashboard'"/>
                <!-- ADMIN - PROFESORES -->
                <div class="content-section-info">
                    <div class="container-options">
                        <div 
                            class="box" 
                            style="--clr:#3498DB"
                            v-if="sessionUser.permisos.admin"
                        >
                            <router-link to="/profesores">
                                <div class="box-content">
                                    <div class="icon">
                                        <span class="icon-user2"></span>
                                    </div>
                                    <div class="text">
                                        <h3>Profesores</h3>
                                        <p>Gestión de profesores</p>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                        <div 
                            class="box" 
                            style="--clr:#5DADE2"
                            v-if="sessionUser.permisos.profesor || sessionUser.permisos.admin"
                        >
                            <router-link to="/estudiantes">
                                <div class="box-content">
                                    <div class="icon">
                                        <span class="icon-users1"></span>
                                    </div>
                                    <div class="text">
                                        <h3>Estudiantes</h3>
                                        <p>Gestión de Estudiantes</p>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="container-options mt-1">
                    <div 
                        class="box activity-box" 
                        style="--clr:#CB4335"
                        v-if="sessionUser.permisos.admin || sessionUser.permisos.profesor"
                    >
                        <router-link to="asignaturas">
                            <div class="box-content">
                                <div class="icon"><span class="icon-book-reference"></span></div>
                                <div class="text">
                                    <h3>Asignaturas</h3>
                                    <p>Gestión de Asignaturas</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                    <div 
                        class="box activity-box" 
                        style="--clr:#CB4335"
                        v-if="sessionUser.permisos.estudiante"
                    >
                        <router-link to="seleccion-asignaturas">
                            <div class="box-content">
                                <div class="icon"><span class="icon-books"></span></div>
                                <div class="text">
                                    <h3>Selección de asignaturas</h3>
                                    <p>Selecciona las asignaturas que deseas registrar este semestre.</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div class="container-options mt-1"
                v-if="sessionUser.permisos.admin">
                    <div class="box activity-box" style="--clr:#239B56">
                        <router-link to="reportes">
                            <div class="box-content">
                                <div class="icon"><span class="icon-analytics"></span></div>
                                <div class="text">
                                    <h3>Reportes</h3>
                                    <p>Revisa los datos del sistema</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>
        </div>
        <Footer/>
    </div>
</template>
<script>
import Header from '@/components/AdminHeader.vue'
import Footer from '@/components/AdminFooter.vue'
import Title from '@/components/page/Title.vue'
import {mapState, mapActions} from 'vuex'
export default {
    name: 'Dashboard',
    components: {
        Header,
        Footer,
        Title
    },
    methods: {
        redirectToGroup(id){ this.$router.push('groups/'+id) },
        ...mapActions('alerts', ['launchAlert']),
    },
    computed: {
        ...mapState(['sessionUser']),
    },
    mounted(){
    }
}
</script>
<style>
.group-container {
    cursor: pointer;
    gap: 10px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(20rem, 12rem), 1fr));
}
.group-container > div{
    overflow: hidden;
    border-radius: 5px;
    min-height: 150px;
    box-sizing: border-box;
    box-shadow: 0 0 2px rgb(0 0 0 / 25%);
}
.group-user-box {
    transition: all 0.5s;
}
.group-user-box:hover{
    box-shadow: 0 0 10px var(--clr);
}
.group-user-box .group-box-content {
    height: 100%;
    display: flex;
    align-items: center;
    border: solid 3px var(--clr);
    box-sizing: border-box;
}
.group-user-box .title-of-box {
    min-width: 100px;
    height: 100%;
    padding: 10px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    color: var(--clr);
    word-break: break-word;
}
.group-user-box .group-box-content .group-info-box{
    margin: 0 10px;
    color: rgb(111, 111, 111);
}
.group-user-box .group-box-content .group-info-box > div{
    display: grid;
}
.group-user-box .group-box-content .group-info-box > div .count-box {
    margin: 0 10px;
    font-weight: 800;
}
/* ========CARDS PRINCIPALES=============== */
.container-options{
    position: relative;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 15rem), 1fr));
    gap: 10px;
}
.container-options a {
    text-decoration: none;
}
.container-options .box{
    position: relative;
    width: 100%;
    min-height: 120px;
    background: #fff;
    cursor: pointer;
    box-shadow: 0 0 2px rgba(0,0,0,0.25);
    border-radius: 5px;
}
.container-options .box::before{
    content: '';
    position: absolute;
    width: 6px;
    height: 100%;
    background: var(--clr);
    transition: 0.3s ease-in-out;
}
.container-options .box:hover::before{
    width: 100%;
}
.container-options .box .box-content {
    position: relative;
    display: flex;   
    align-items: center;
    height: 100%;
}
.container-options .box .box-content .icon{
    position: relative;
    min-width: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.container-options .box .box-content .icon span{
    font-size: 2.5em;
    color: var(--clr);
    transition:0.3s ease-in-out;
}
.container-options .box:hover .box-content .icon span{
    color: #fff;
}
.container-options .box .box-content .text h3 {
    font-weight: 500;
    color: var(--clr);
    transition:0.3s ease-in-out;
}
.container-options .box .box-content .text p {
    font-size: .9em;
    color: #999;
    transition:0.3s ease-in-out;
}
.container-options .box:hover .box-content .text h3,
.container-options .box:hover .box-content .text p{
    color: #fff;
}

/* ========OTRAS ACTIVIDADES======= */
.container-options .activity-box::before{
    width: 0;
}
.container-options .activity-box .box-content .icon span {
    padding: .5rem;
    border-radius: 5px;
    font-size: 3rem;
}
.container-options .activity-box .box-content .text {line-height: 1.4rem}
</style>