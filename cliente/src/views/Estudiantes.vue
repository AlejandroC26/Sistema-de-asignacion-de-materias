<template>
    <div>
        <Header/>
        <div class="admin-container">
        <section class="body-info-section">
            <div class="content-section-info">
                <Title :title="'Estudiantes'"/>
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
                        <p class="titulo" v-if="update === false">Registro de estudiante</p>
                        <p class="titulo" v-else>Actualizar estudiante</p>
                        <button class="cross-btn"
                            @click="()=>{
                                register = false;
                                limpiarFormulario();
                            }">×</button>
                        <div class="row">
                            <div class="col">
                                <p>Documento</p>
                                <input type="number" v-model="estudiante.documento">
                            </div>
                            <div class="col">
                                <p>Nombres</p>
                                <input type="text" v-model="estudiante.nombres">
                            </div>
                            <div class="col">
                                <p>Teléfono</p>
                                <input type="text" v-model="estudiante.telefono">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>Dirección</p>
                                <input type="text" v-model="estudiante.direccion">
                            </div>
                            <div class="col">
                                <p>Ciudad</p>
                                <input type="text" v-model="estudiante.ciudad">
                            </div>
                            <div class="col">
                                <p>Semestre</p>
                                <input type="number" v-model="estudiante.semestre">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>Email</p>
                                <input type="text" v-model="estudiante.email">
                            </div>
                            <div 
                                v-if="update === false"
                                class="col"
                            >
                                <p>Contraseña</p>
                                <input type="number" v-model="estudiante.password">
                            </div>
                        </div>
    
                        <div class="btn-confirm" v-if="update === false">
                            <button @click="registrarEstudiante(estudiante)">
                                Registrar
                            </button>
                        </div>
                        <div class="btn-confirm" v-else>
                            <button @click="actualizarEstudiante(estudiante)">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>


                <table class="styled-table">
                    <thead>
                        <tr>
                            <td>Documento</td>
                            <td>Nombres</td>
                            <td>Teléfono</td>
                            <td>Email</td>
                            <td>Dirección</td>
                            <td>Ciudad</td>
                            <td>Semestre</td>
                            <td>Acción</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="estudiante in estudiantes" :key="estudiante.id">
                            <td>{{ estudiante.documento }}</td>
                            <td>{{ estudiante.nombres }}</td>
                            <td>{{ estudiante.telefono }}</td>
                            <td>{{ estudiante.email }}</td>
                            <td>{{ estudiante.direccion }}</td>
                            <td>{{ estudiante.ciudad }}</td>
                            <td>{{ estudiante.semestre }}</td>
                            <td><span class="link" @click="cargarEstudiante(estudiante)">Editar</span></td>
                        </tr>
                    </tbody>
                </table>
                <div style="display: flex; justify-content: flex-end;">
                    <div class="pagination">
                        <a 
                            href="#" 
                            v-for="link in links" :key="generateUUID(link)"
                            :class="{'active': link.active}"
                            @click="listarEstudiantes(link.url)"
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

            links: [],
            estudiantes: [],
            estudiante: {
                id: '',
                documento: '123',
                nombres: 'Alejandro',
                telefono: '313',
                email: 'cubillosalejandro122@gmail.com',
                direccion: 'Cra 16',
                ciudad: 'Pitalito',
                semestre: '3',
                password: '123',
                id_estudiante: '',
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

        listarEstudiantes(url){
            if(!url) url = 'http://127.0.0.1:8000/api/estudiante';
            axios.get(url, 
            { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
            .then(({data})=> {
                this.links = data.links;
                this.estudiantes = data.data;
            }).catch(e => {
                console.log(e.response)
            })
        },

        cargarEstudiante(data) {
            this.update = true;
            this.register = false;

            this.estudiante.id = data.id_user;
            this.estudiante.documento = data.documento;
            this.estudiante.nombres = data.nombres;
            this.estudiante.telefono = data.telefono;
            this.estudiante.email = data.email;
            this.estudiante.direccion = data.direccion;
            this.estudiante.ciudad = data.ciudad;
            this.estudiante.semestre = data.semestre;
            this.estudiante.password = data.password;
            this.estudiante.id_estudiante = data.id;
        },

        limpiarFormulario(){
            this.update = false;
            this.estudiante.id = '';
            this.estudiante.documento = '';
            this.estudiante.nombres = '';
            this.estudiante.telefono = '';
            this.estudiante.email = '';
            this.estudiante.direccion = '';
            this.estudiante.ciudad = '';
            this.estudiante.semestre = '';
            this.estudiante.password = '';
            this.estudiante.id_estudiante = '';
        },

        async registrarEstudiante(data){
            if(!this.isValidText(data.nombres))
                return this.launchAlert({type: 'warning', title: '¡El nombre no puede contener carácteres especiales!'})

            if(!this.isValidEmail(data.email))
                return this.launchAlert({type: 'warning', title: '¡El correo no es válido!'})

            try {

                let user = await axios.post('http://127.0.0.1:8000/api/user/register', data, 
                { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})

                axios.post('http://127.0.0.1:8000/api/estudiante/register', {
                    id_user: user.data.data.id,
                    semestre: data.semestre
                }, { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
                .then(() => {
                    this.register = false;
                    this.limpiarFormulario();
                    this.listarEstudiantes();
                    return this.launchAlert({type: 'success', title: '¡Estudiante registrado!'})
                })
                .catch(e => {
                    console.log(e.response)
                })
            } catch (error) {
                console.log(error.response)
            }
        },
        async actualizarEstudiante(data){
            if(!this.isValidText(data.nombres))
                return this.launchAlert({type: 'warning', title: '¡El nombre no puede contener carácteres especiales!'})

            if(!this.isValidEmail(data.email))
                return this.launchAlert({type: 'warning', title: '¡El correo no es válido!'})

            try {
                await axios.post('http://127.0.0.1:8000/api/user/update/'+data.id, data, 
                { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
                
                await axios.post('http://127.0.0.1:8000/api/estudiante/update/'+data.id_estudiante, 
                { semestre: data.semestre },
                { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})

                this.listarEstudiantes();
                this.limpiarFormulario();
                return this.launchAlert({type: 'success', title: '¡Estudiante actualizado!'})

            } catch (error) {
                console.log(error.response)
            }
            
        }



    },
    computed: {
        ...mapState(['sessionUser']),
    },
    mounted(){
        this.listarEstudiantes();
    }
}
</script>
<style scoped>
    .row > .col {
        width: 100%;
        box-sizing: border-box;
    }
    .row > .col input {
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