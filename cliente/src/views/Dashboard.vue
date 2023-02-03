<template>
    <div>
        <Header/>
        <div class="admin-container">
        <section class="body-info-section">
            <div class="content-section-info">
                <Title :title="'Dashboard'"/>
                <div class="content-section-info" v-if="sessionUser.rol == 'admin'">
                    <div class="container-options">
                        <div class="box" style="--clr:#3498DB">
                            <router-link to="/users">
                                <div class="box-content">
                                    <div class="icon">
                                        <span class="icon-user2"></span>
                                    </div>
                                    <div class="text">
                                        <h3>Usuarios</h3>
                                        <p>Gestión de usuarios</p>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                        <div class="box" style="--clr:#5DADE2">
                            <router-link to="/groups">
                                <div class="box-content">
                                    <div class="icon">
                                        <span class="icon-users1"></span>
                                    </div>
                                    <div class="text">
                                        <h3>Grupos</h3>
                                        <p>{{sessionUser.groups.length}} Grupos</p>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="container-options mt-1">
                    <div class="box activity-box" style="--clr:#CB4335">
                        <router-link to="library">
                            <div class="box-content">
                                <div class="icon"><span class="icon-books"></span></div>
                                <div class="text">
                                    <h3>BIBLIOTECA</h3>
                                    <p>Llénate de información y expande tu conocimiento con los documentos que britana tiene para brindarte</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                    <div class="box activity-box" style="--clr:#CB4335">
                        <router-link to="tests">
                            <div class="box-content">
                                <div class="icon"><span class="icon-book-reference"></span></div>
                                <div class="text">
                                    <h3>TEST</h3>
                                    <p>Pon a prueba tu conocimiento con los test personalizados que Britana tiene para ti</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div style="margin-bottom: 50px;" v-if="sessionUser.groups.length > 0">
                    <h2 style="margin-top: 30px; color: #CB4335">TUS GRUPOS</h2>
                    <div class="group-container mt-1">
                        <div class="group-user-box" style="--clr:#3498DB;"
                        v-for="group in sessionUser.groups" :key="group.id"
                        @click="redirectToGroup(group.id)">
                            <div class="group-box-content">
                                <div class="title-of-box">
                                    <h1>{{ group.name }}</h1>
                                </div>
                            </div>
                        </div>
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
import {mapState, mapActions, mapMutations} from 'vuex'
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
.container-options .activity-box .box-content .text h3 {font-weight: 800}
.container-options .activity-box .box-content .text p {font-size: 1.1em;}
</style>