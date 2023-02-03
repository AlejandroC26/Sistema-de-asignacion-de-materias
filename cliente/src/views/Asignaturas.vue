<template>
    <div>
        <Header/>
        <div class="admin-container">
        <section class="body-info-section">
            <div class="content-section-info">
                <Title :title="'Asignaturas'"/>
                <div 
                    class="btn-confirm primary"
                    style="display: flex; justify-content: flex-end;"
                >
                    <button @click="()=>{
                        register = true;
                        limpiarFormulario();
                    }" v-if="!register && !update">Nuevo registro</button>
                </div>
                <div style="display: flex; justify-content: center;">
                    <div 
                        v-if="register || update"
                        class="formulario-registro"
                    >
                        <p class="titulo" v-if="update === false">Registro de asignatura</p>
                        <p class="titulo" v-else>Actualizar asignatura</p>
                        <button class="cross-btn"
                            @click="()=>{
                                register = false;
                                limpiarFormulario();
                            }">×</button>
                        <div class="row">
                            <div class="col">
                                <p>Nombre</p>
                                <input type="text" v-model="asignatura.nombre">
                            </div>
                            <div class="col">
                                <p>Tipo</p>
                                <select v-model="asignatura.tipo">
                                    <option value="electiva">Electiva</option>
                                    <option value="obligatoria">Obligatoria</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>Créditos</p>
                                <input type="number" v-model="asignatura.creditos">
                            </div>
                            <div class="col">
                                <p>Area</p>
                                <select v-model="asignatura.id_area">
                                    <option 
                                        v-for="area in areas" :key="area.id"
                                        :value="area.id"
                                    >{{ area.nombre }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>Descripción</p>
                                <textarea cols="30" rows="10" v-model="asignatura.descripcion"></textarea>
                            </div>
                        </div>
    
                        <div class="btn-confirm" v-if="update === false">
                            <button @click="registrarAsignatura(asignatura)">
                                Registrar
                            </button>
                        </div>
                        <div class="btn-confirm" v-else>
                            <button @click="actualizarAsignatura(asignatura)">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>


                <table class="styled-table">
                    <thead>
                        <tr>
                            <td>Nombre</td>
                            <td>Descripción</td>
                            <td>Créditos</td>
                            <td>Area</td>
                            <td>Tipo</td>
                            <td>Acción</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="asignatura in asignaturas" :key="asignatura.id">
                            <td>{{ asignatura.nombre }}</td>
                            <td>{{ asignatura.descripcion }}</td>
                            <td>{{ asignatura.creditos }}</td>
                            <td>{{ asignatura.area_nombre }}</td>
                            <td>{{ asignatura.tipo }}</td>
                            <td><span class="link" @click="cargarAsignatura(asignatura)">Editar</span></td>
                        </tr>
                    </tbody>
                </table>
                <div style="display: flex; justify-content: flex-end;">
                    <div class="pagination">
                        <a 
                            href="#" 
                            v-for="link in links" :key="generateUUID(link)"
                            :class="{'active': link.active}"
                            @click="listarAsignaturas(link.url)"
                        ><span v-html="link.label"></span></a>
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
import {mapState} from 'vuex';
import axios from 'axios';
export default {
    name: 'Dashboard',
    components: {
        Header,
        Footer,
        Title
    },

    data: function(){
        return {
            register: false,
            update: false,

            areas: [],
            links: [],
            asignaturas: [],
            asignatura: {
                id: '',
                nombre: '',
                descripcion: '',
                tipo: 'electiva',
                creditos: '',
                id_area: ''
            }
        }
    },
    
    methods: {
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
        generateUUID() {
            var d = new Date().getTime();
            var uuid = 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = (d + Math.random() * 16) % 16 | 0;
                d = Math.floor(d / 16);
                return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
            return uuid;
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

        listarAsignaturas(url){
            if(!url) url = 'http://127.0.0.1:8000/api/asignatura';
            axios.get(url, 
            { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
            .then(({data})=> {
                this.links = data.links;
                this.asignaturas = data.data;
            }).catch(e => {
                console.log(e.response)
            })
        },
        listarAreas(){
            axios.get('http://127.0.0.1:8000/api/asignatura/areas', 
            { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
            .then(({data})=> {
                this.areas = data;
            }).catch((e)=>console.log(e.response))
        },
        cargarAsignatura(data) {
            this.update = true;
            this.register = false;

            this.asignatura.id = data.id;
            this.asignatura.nombre = data.nombre;
            this.asignatura.descripcion = data.descripcion;
            this.asignatura.tipo = data.tipo;
            this.asignatura.creditos = data.creditos;
            this.asignatura.id_area = data.id_area;
        },

        limpiarFormulario(){
            this.update = false;
            this.asignatura.id = '';
            this.asignatura.nombre = '';
            this.asignatura.descripcion = '';
            this.asignatura.tipo = 'electiva';
            this.asignatura.creditos = '';
            this.asignatura.id_area = this.areas[0].id;
        },

        async registrarAsignatura(data){
            try {
                axios.post('http://127.0.0.1:8000/api/asignatura/register', data, 
                { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
                .then(() => {
                    this.register = false;
                    this.limpiarFormulario()
                    this.listarAsignaturas();
                    return this.launchAlert({type: 'success', title: '¡Asignatura registrada!'})
                })
                .catch(e => {
                    console.log(e.response)
                })
            } catch (error) {
                console.log(error.response)
            }
        },
        async actualizarAsignatura(data){
            try {
                await axios.post('http://127.0.0.1:8000/api/asignatura/update/'+data.id, data, 
                { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})

                this.listarAsignaturas();
                this.limpiarFormulario();
                return this.launchAlert({type: 'success', title: '¡Asignatura actualizada!'})

            } catch (error) {
                console.log(error.response)
            }
            
        }



    },
    computed: {
        ...mapState(['sessionUser']),
    },
    mounted(){
        this.listarAsignaturas();
        this.listarAreas();
    }
}
</script>
<style scoped>
    .row {
        display: flex;
        gap: .5rem;
        justify-content: space-between;
    }
    .row > .col {
        width: 100%;
        box-sizing: border-box;
    }
    .row > .col input,
    .row > .col textarea,
    .row > .col select {
        width: 100%;
        box-sizing: border-box;
        padding: .3rem .5rem;
        border: 0;
        box-shadow: 0 0 1px #000000;
        border-radius: 2px;
    }
    /* FORMULARIO */
    .formulario-registro{
        margin: 0 auto;
        width: 95%;
        padding: 2rem 1.5rem;
        padding-top: 4rem;
        max-width: 750px;
        box-shadow: inset  0 0 2px #818181,
                    0 0 5px #c9c9c9;
        border-radius: 1rem;
        position: absolute;
        background: #fff;
    }
    .formulario-registro .titulo {
        color: #fff;
        position: absolute;
        top: 1.5rem;
        left: -.7rem;
        background: #0056a0;
        padding: .4rem 2.5rem;
        font-size: 1.2rem;
        text-transform: uppercase;
    }
    .formulario-registro .cross-btn {
        background: none;
        border: 0;
        font-size: 2rem;
        color: #818181;
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
        cursor: pointer;
    }

    /* BOTÓN */
    .btn-confirm button {
        margin-top: 1rem;
        background: none;
        border: 0;
        text-transform: uppercase;
        font-size: 1.2rem;
        letter-spacing: .02rem;
        color: #4a4a4a;
        cursor: pointer;
    }
    .btn-confirm.primary button{
        padding: .3rem .5rem;
        border: dashed 2px #7f7f7f;
    }

</style>