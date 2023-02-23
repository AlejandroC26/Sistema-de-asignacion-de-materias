<template>
    <div>
        <Header/>
        <div class="admin-container">
        <section class="body-info-section">
            <div class="content-section-info">
                <Title :title="'Selección de asignaturas'"/>
                <div style="display: flex; justify-content: center;" v-if="!bPaginaCargada">
                    <Loader/>
                </div>  
                <div v-else>
                    <div v-if="!cargados">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <td colspan="7"><center>Asignaturas registradas</center></td>
                                </tr>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Descripción</td>
                                    <td>Area</td>
                                    <td>Tipo</td>
                                    <td>Créditos</td>
                                    <td>Docente</td>
                                    <td>Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="elemento in carrito" :key="elemento.id">
                                    <td>{{ elemento.nombre }}</td>
                                    <td>{{ elemento.descripcion }}</td>
                                    <td>{{ elemento.area_nombre }}</td>
                                    <td>{{ elemento.tipo }}</td>
                                    <td>{{ elemento.creditos }}</td>
                                    <td>{{ elemento.docente.nombre_profesor }}</td>
                                    <td><span class="link" @click="onRemoverAsignatura(elemento.id)">Eliminar</span></td>

                                </tr>
                                <tr v-if="carrito.length > 0">
                                    <td colspan="4" style="text-align:end;"><b>Total</b></td>
                                    <td colspan="2">{{ creditos }}</td>
                                    <td>
                                        <button 
                                            class="save-btn"
                                            @click="asignarCursos()"
                                        >GUARDAR</button>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="6"><center>No hay materias registradas</center></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- MODAL SELECCIÓN -->
                        <div style="display: flex; justify-content: center; position: relative;">
                            <div 
                                v-if="seleccion"
                                class="formulario-registro"
                            >
                                <p class="titulo">SELECCIONAR PROFESOR</p>
                                <button class="cross-btn" @click="seleccion=false;">×</button>
                                <div class="row">
                                    <div class="col">
                                        <p>Nombre</p>
                                        <input type="text" v-model="asignatura.nombre" disabled>
                                    </div>
                                    <div class="col">
                                        <p>Tipo</p>
                                        <input type="text" v-model="asignatura.tipo" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p>Créditos</p>
                                        <input type="number" v-model="asignatura.creditos" disabled>
                                    </div>
                                    <div class="col">
                                        <p>Area</p>
                                        <input type="text" v-model="asignatura.area_nombre" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p><b>DOCENTES</b></p>
                                        <div v-if="asignatura.docentes.length > 0">
                                            <div 
                                                class="row" 
                                                style="padding: 0 1.2rem; margin-bottom: .5rem; border-bottom: 2px dashed #4a4a4a;"
                                                v-for="docente in asignatura.docentes" :key="docente.id"
                                            >
                                                <div 
                                                    class="col" 
                                                    style="display: flex; align-items: center;"
                                                >{{ docente.nombre_profesor }}</div>
                                                <div class="col" style="display: flex; justify-content: flex-end;">
                                                    <button 
                                                        class="select-btn"
                                                        @click="agregarAsignatura(docente)"
                                                    >SELECCIONAR</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div 
                                            v-else
                                            style="padding: .5rem 1rem"
                                        >No hay docentes registrados en esta asignatura</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LISTA LAS ASIGNATURAS -->
                        <div class="contenedor-asignaturas">
                            <div 
                                class="asignatura-box"
                                v-for="asignatura in asignaturas" :key="asignatura.id"
                            >
                                <div class="cabecera">
                                    <div class="nombre">{{ asignatura.nombre }}</div>
                                    <div class="creditos">{{ asignatura.creditos }} créditos</div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        {{ asignatura.tipo  }}
                                    </div>
                                    <div class="col" style="display: flex; justify-content: flex-end; margin-top: .5rem;">
                                        {{ asignatura.area_nombre  }}
                                    </div>
                                </div>
                                <div class="descripcion">{{ asignatura.descripcion }}</div>
                                <div class="mostrar-mas" @click="()=>{
                                    cargarAsignatura(asignatura)
                                    listarDocentes(asignatura.id)
                                }">MOSTRAR DOCENTES</div>
                            </div>
                        </div>
                        <!-- PAGINADOR -->
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
                    <div v-else>
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <td colspan="6"><center>Tus asignaturas</center></td>
                                </tr>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Descripción</td>
                                    <td>Tipo</td>
                                    <td>Créditos</td>
                                    <td>Docente</td>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="elemento in mis_asignaturas" :key="elemento.id">
                                    <td>{{ elemento.nombre_asignatura }}</td>
                                    <td>{{ elemento.descripcion }}</td>
                                    <td>{{ elemento.tipo }}</td>
                                    <td>{{ elemento.creditos }}</td>
                                    <td>{{ elemento.nombre_profesor }}</td>
                                </tr>
                            </tbody>
                        </table>
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
import Loader from '@/components/Loader.vue';
import {mapState} from 'vuex';
import axios from 'axios';
export default {
    name: 'Dashboard',
    components: {
        Header,
        Footer,
        Title,
        Loader
    },

    data: function(){
        return {
            bPaginaCargada: false,
            seleccion: false,
            cargados: false,

            links: [],
            asignaturas: [],
            mis_asignaturas: [],

            creditos: 0,

            carrito: [],
            asignatura: {
                id: '',
                nombre: '',
                descripcion: '',
                tipo: 'electiva',
                creditos: '',
                area_nombre: '',
                docentes: [],
            }
        }
    },
    
    methods: {
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

        listarAsignaturasEstudiante(id){
            axios.get(`http://127.0.0.1:8000/api/estudiante/${id}/courses`, 
            { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
            .then(({data}) => {
                this.bPaginaCargada = true;
                if(data.length > 0) this.cargados = true;
                this.mis_asignaturas = data;
            }).catch((e)=> console.log(e.response) )
        },

        listarDocentes(id){
            axios.get(`http://127.0.0.1:8000/api/asignatura/${id}/profesor`,
            { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
            .then(({data})=> {
                this.asignatura.docentes = data;
            }).catch(e => console.log(e.response))
        },

        cargarAsignatura(data) {
            this.seleccion = true;

            this.asignatura.id = data.id;
            this.asignatura.nombre = data.nombre;
            this.asignatura.descripcion = data.descripcion;
            this.asignatura.tipo = data.tipo;
            this.asignatura.creditos = data.creditos;
            this.asignatura.area_nombre = data.area_nombre;
        },

        agregarAsignatura(data){
            let json = {
                id: this.asignatura.id,
                nombre: this.asignatura.nombre,
                descripcion: this.asignatura.descripcion,
                tipo: this.asignatura.tipo,
                creditos: this.asignatura.creditos,
                area_nombre: this.asignatura.area_nombre,
                docente: data
            }
            if(this.carrito.find(elemento => elemento.id === json.id))
                return this.launchAlert({type: 'warning', title: '¡No se puede repetir asignatura!'})
 
            let creditos = 0;
            this.carrito.push(json);
            this.carrito.forEach(element => creditos += element.creditos);
            this.seleccion = false;
            this.creditos = creditos;
        },


        onRemoverAsignatura(id) {
            const index = this.carrito.findIndex(elemento => elemento.id === id);
            this.carrito = this.carrito.slice(index-1, index)
        },

        asignarCursos() {
            if(this.creditos < 7)
                return this.launchAlert({type: 'warning', title: '¡Registra mínimo 7 créditos!'});

            let json = {
                id_estudiante: this.sessionUser.permisos.estudiante,
                asignaturas: []
            }

            this.carrito.forEach(element => {
                json.asignaturas.push(element.docente.id_ap)
            });

            axios.post('http://127.0.0.1:8000/api/estudiante/course/assign', json,
            { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
            .then(() => {
                this.carrito = [];
                this.cargados = true;
                this.listarAsignaturasEstudiante(this.sessionUser.permisos.estudiante);
                return this.launchAlert({type: 'success', title: '¡Cursos asignados exitosamente!'})
            }).catch(e => console.log(e))
        }


    },
    computed: {
        ...mapState(['sessionUser']),
    },
    mounted(){
        this.listarAsignaturas();
        this.listarAsignaturasEstudiante(this.sessionUser.permisos.estudiante);
    }
}
</script>
<style scoped>
    .contenedor-asignaturas{
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 18.5rem), 1fr));
        grid-gap: 20px;
    }
    .asignatura-box {
        border-radius: 5px;
        box-shadow: 0 0 1px #4a4a4a;
        padding: 1rem 1.2rem;
    }
    .asignatura-box .cabecera {
        display: grid;
        grid-template-columns: auto 3rem;
        position: relative;
    }
    .asignatura-box .creditos {
        position: absolute;
        color: #fff;
        position: absolute;
        right: -1.8rem;
        background: #0056a0;
        padding: .4rem 1.2rem;
    }
    .asignatura-box .nombre {
        text-transform: uppercase;
        font-weight: bold;
        margin: .2rem 0;
    }
    .asignatura-box .descripcion {
        margin: 1rem 0;
    }
    .asignatura-box .mostrar-mas{
        text-align: center;
        cursor: pointer;
        cursor: pointer;
        color: #0064bb;
        text-decoration: underline;
    }


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
        z-index: 100;
        margin: 0 auto;
        width: 95%;
        padding: 2rem 1.5rem;
        padding-top: 4rem;
        max-width: 750px;
        box-shadow: inset  0 0 2px #818181,
                    0 0 5px #c9c9c9;
        border-radius: 1rem;
        position: fixed;
        top: 35%;
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
    .select-btn{
        border: 0;
        box-shadow: 0 0 1px #4a4a4a;
        padding: .4rem 1rem;
        cursor: pointer;
    }
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
    .save-btn{
        width: 100%;
        border: 0;
        cursor: pointer;
        color: #0060c6;
        font-size: 1.2rem;
        background: none;
    }
    .save-btn:hover {
        text-decoration: underline;
    }
</style>