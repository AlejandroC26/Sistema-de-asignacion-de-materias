<template>
    <div>
        <div v-if="config.showForm" class="border-box">
            <!-- Question Content -->
            <div class="form-data">
                <input type="text" id="question" placeholder="Digita el contenido de la pregunta"
                    v-model="question.content"
                    @focus="focusQuestion()"
                    @blur="lostFocusQuestion()">
            </div>
            <!-- Edit question option form -->
            <div class="input-save-info mt-1"
                v-for="(option, index) in question.options" :key="option.id">
                <p><b>{{ alphabet[index] }}. </b></p> 
                <div v-if="config.editingOption === index">
                    <input type="text" v-model="option.content">
                    <div class="check-labels">
                        <div>
                            <input id="checkRight" type="radio" name="tipo" value="1" v-model="option.type">
                            <label for="checkRight">Correcto</label> 
                        </div>
                        <div>
                            <input id="checkWrong" type="radio" name="tipo" value="0" v-model="option.type">
                            <label for="checkWrong">Incorrecto</label>
                        </div>
                    </div>
                    <button class="btn btn-success" v-on:click="confirmEditOption(option)">Confirmar</button>
                </div>
                <div v-else>
                    <p>{{option.content}} </p>
                    <label v-if="option.type == 0"><span class="wrong-label">✗</span>  Incorrecta</label>
                    <label v-if="option.type == 1"><span class="success-label">✓</span>  Correcta</label>
                    <div class="btn-group">
                        <button class="btn btn-edit" v-on:click="editingOption(index)">Editar</button>
                        <button class="btn btn-delete" v-on:click="delOption(index)">Eliminar</button>
                    </div>
                </div>
            </div>
            <!-- New Option Form -->
            <div class="input-info mt-1"
                v-if="question.content && config.editingOption === false">
                <p>
                    <b v-if="question.options">
                        {{ alphabet[question.options.length] }}.
                    </b>
                    <b v-else>
                        {{ alphabet[0] }}.
                    </b>
                </p>
                <input id="option" type="text" placeholder="Nueva...." 
                    v-model="general.option.content">
                <div class="check-labels">
                    <div>
                        <input id="checkRight" type="radio" name="tipo" value="1" v-model="general.option.type">
                        <label for="checkRight">Correcto</label> 
                    </div>
                    <div>
                        <input id="checkWrong" type="radio" name="tipo" value="0" v-model="general.option.type">
                        <label for="checkWrong">Incorrecto</label>
                    </div>
                </div>
                <button class="btn btn-primary"
                @click="addOption(general.option)">Agregar</button>
            </div>
            <div class="mt-12">
                <div v-if="question.labels.length > 0" >
                    <h3>Etiquetas</h3>
                    <div class="container-label">
                        <div class="label" 
                            v-for="(label, index) in question.labels" :key="label.id"
                            v-bind:style="{ background:  colorList[index]}"
                            @click="removeLabel(index)">
                            <label class="data-label">{{label.name}} </label>
                        </div>
                    </div>
                </div>
                <div v-if="general.labels.length > 0">
                    <h3>Agrega Etiquetas</h3>
                    <div class="container-label">
                        <div class="label" 
                            v-for="(label, index) in general.labels" :key="label.id"
                            v-bind:style="{ background:  colorList[index]}"
                            v-on:click="addLabel(index)">
                            <label class="data-label">{{label.name}} </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-right">
                <div class="btn-group">
                    <button class="btn btn-big btn-cancel" @click="showForm()"><span>Cancelar</span></button>
                    <button class="btn btn-big btn-save" v-on:click="saveQuestion(question)">Guardar</button>
                </div>
            </div>
        </div>
        <button class="btn btn-bold btn-primary" v-if="!config.showForm" @click="showForm()">
            <span >Nueva pregunta</span>
        </button>
    </div>
</template>
<script>

import {mapState, mapActions, mapMutations} from 'vuex' 
export default {
    data: function () {
        return {
            question:{
                content: '',
                options: [], 
                labels: [],
            },
            general: {
                option: {
                    content: '',
                    type: 0,
                },
                labels: []
            },
            config: {
                showForm: false,
                questionFocus: false,
                editingOption: false,
            }
        }
    },
    methods: {
        ...mapActions('question', ['createQuestion']),
        ...mapMutations('label', ['loadLabel']),
        clearFields(){
            this.question.content = '';
            this.question.options = '';
        },
        focusQuestion(){
            this.config.questionFocus = true;
        },
        lostFocusQuestion(){
            this.config.questionFocus = false;
        },
        showForm(){
            if(this.config.showForm == true){
                this.config.showForm = false;
            } else {
                this.config.showForm = true;
                setTimeout(() => {
                    document.getElementById('question').focus();
                }, 100);
            }
        },
        saveQuestion(question){
            if(!question.content)return this.launchAlert({type: 'warning', message: 'Digita la descripción'});
            if(question.options.length <= 0)return this.launchAlert({type: 'warning', message: 'Es necesario crear por lo menos una opción'});
            if(!question.options.find(option => option.type == 1))return this.launchAlert({type: 'warning', message: 'Es necesaria una opción correcta'});
            this.createQuestion(question)
            this.showForm();
        },
        /* Option */
        addOption(option){
            let json = {
                "content": option.content,
                "type": option.type
            }
            if(json.content == ''){
                return this.launchAlert({type: 'warning', message: 'La opción no puede quedar vacía'});
            }
            this.question.options.push(json);
            this.general.option.content = ''
            document.getElementById('option').focus();
        },
        editingOption(index){
            this.config.editingOption = index;
        },
        confirmEditOption(){
            this.config.editingOption = false;
        },
        delOption(index){
            this.question.options.splice(index, 1)
        },
        GeneralLabels(){
            this.general.labels = this.labelList;
        },
        /* Label */
        addLabel(index){
            if(this.question.labels.length == 3){
                return this.launchAlert({type: 'warning', message: 'No se pueden agregar mas etiquetas'});
            }
            this.question.labels.push(this.general.labels[index]);
            this.general.labels.splice(index, 1);
        },
        removeLabel(index){
            this.general.labels.push(this.question.labels[index]);
            this.question.labels.splice(index, 1);
        },
        launchAlert(config){
            if(!config.timeout) config.timeout = 2000;
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: config.timeout,
            })
            Toast.fire({
                icon: config.type,
                title: config.message,
            })
        },
    },
    computed: {
        ...mapState(['alphabet']),
        ...mapState('label', ['labelList']),
        ...mapState('label', ['colorList'])
    },
    mounted: function(){
        this.loadLabel();
        setTimeout(() => {
            this.GeneralLabels();
        }, 100); 
    },
    
}
</script>
<style>

</style>
