<template>
    <div>
        <Header/>
        <div class="admin-container">
        <section class="body-info-section">
            <div class="content-section-info">
                <Title :title="'Reportes'"/>
                <div class="row">
                    <div class="col">
                        <canvas id="profesor-chart"></canvas>
                    </div>
                    <div class="col">
                        <canvas id="asignatura-chart"></canvas>
                    </div>
                </div>


                <div style="display: flex; justify-content: flex-end;">
                    <download-excel
                        class="btn-download"
                        :data="asignaturas"
                        :fields="json_fields"
                        name="estudiantes_asignaturas.xls"
                        >
                        Download Excel
                    </download-excel>
                </div>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <td colspan="3"><center>Asignaturas por estudiantes</center></td>
                        </tr>
                        <tr>
                            <td>Asignatura</td>
                            <td>Estudiante</td>
                            <td>Profesor</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="asignatura in asignaturas" :key="asignatura.id">
                            <td>{{ asignatura.nombre_asignatura }}</td>
                            <td>{{ asignatura.nombre_estudiante }}</td>
                            <td>{{ asignatura.nombre_profesor }}</td>
                        </tr>
                    </tbody>
                </table>
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

import Chart from 'chart.js'

export default {
    name: 'Dashboard',
    components: {
        Header,
        Footer,
        Title,
    },

    data: function(){
        return {
            asignaturas: [],
            json_fields: {
                "Asignatura": "nombre_asignatura",
                "Estudiante": "nombre_estudiante",
                "Profesor": "nombre_profesor",
            },
            profesoresChartData: {
                type: "bar",
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: "Número de Estudiantes",
                            data: [],
                            backgroundColor: "#6cb1ec",
                            borderColor: "#0275d8",
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    lineTension: 1,
                    scales: {
                    yAxes: [
                        {
                        ticks: {
                            beginAtZero: true,
                            padding: 25
                        }
                        }
                    ]
                    }
                }
            },
            asignaturaCharData: {
                type: "bar",
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: "Número de Estudiantes",
                            data: [],
                            backgroundColor: "#d47287",
                            borderColor: "#ce002d",
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    lineTension: 1,
                    scales: {
                    yAxes: [
                        {
                        ticks: {
                            beginAtZero: true,
                            padding: 25
                        }
                        }
                    ]
                    }
                }
            },
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
        agruparPorProfesor(data){
            let nuevoObjeto = {}
            //Recorremos el arreglo 
            data.forEach( x => {
                if( !nuevoObjeto.hasOwnProperty(x.id_profesor)){
                    nuevoObjeto[x.id_profesor] = {
                        nombre: x.nombre_profesor,
                        estudiantes: []
                    }
                }
                //Agregamos los datos de profesionales. 
                nuevoObjeto[x.id_profesor].estudiantes.push({
                    ...x
                })
            })
            return Object.values(nuevoObjeto);
        },

        agruparPorAsignatura(data){
            let nuevoObjeto = {}
            //Recorremos el arreglo 
            data.forEach( x => {
                if( !nuevoObjeto.hasOwnProperty(x.id_asignatura)){
                    nuevoObjeto[x.id_asignatura] = {
                        nombre: x.nombre_asignatura,
                        estudiantes: []
                    }
                }
                //Agregamos los datos de profesionales. 
                nuevoObjeto[x.id_asignatura].estudiantes.push({
                    ...x
                })
            })
            return Object.values(nuevoObjeto);
        },


        listarReporte(){
            axios.get("http://127.0.0.1:8000/api/asignatura/estudiantes", 
            { headers: { "Authorization": "Bearer " + localStorage.getItem('token')}})
            .then(({data})=> {
                this.asignaturas = data;
                //Creamos un nuevo objeto donde vamos a almacenar por ciudades. 
                let profesores = this.agruparPorProfesor(data);
                let asignaturas = this.agruparPorAsignatura(data);

                let labelsProfesor = [];
                let totalesProfesor = [];

                let labelsAsignatura = [];
                let totalesAsignatura = [];

                profesores.forEach(x => {
                    labelsProfesor.push(x.nombre);
                    totalesProfesor.push(x.estudiantes.length);
                })
                
                asignaturas.forEach(x => {
                    labelsAsignatura.push(x.nombre);
                    totalesAsignatura.push(x.estudiantes.length);
                })

                this.profesoresChartData.data.labels = labelsProfesor;
                this.profesoresChartData.data.datasets[0].data = totalesProfesor;

                this.asignaturaCharData.data.labels = labelsAsignatura;
                this.asignaturaCharData.data.datasets[0].data = totalesAsignatura;

                const ctxP = document.getElementById('profesor-chart');
                new Chart(ctxP, this.profesoresChartData);

                const ctxA = document.getElementById('asignatura-chart');
                new Chart(ctxA, this.asignaturaCharData);
            }).catch(e => {
                console.log(e)
                console.log(e.response)
            })
        },
    },
    computed: {
        ...mapState(['sessionUser']),
    },
    mounted(){
        this.listarReporte();
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
        top: -3rem;
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

    .btn-download {
        border: solid 2px #008037;
        padding: .5rem 1rem;
        color: #008037;
        background: #ffffff;
        border-radius: 2px;
        cursor: pointer;
    }
</style>