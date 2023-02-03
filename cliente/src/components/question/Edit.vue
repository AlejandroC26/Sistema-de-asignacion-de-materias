<template>
    <div class="border-box">
        <!-- Question Content -->
        <div class="form-data">
            <input type="text" id="question" placeholder="Digita el contenido de la pregunta"
                v-model="question.content">
        </div>
        <!-- Question options  -->
        <div class="input-save-info mt-1"
            v-for="(option, index) in question.options" :key="option.id">
            <!-- Edit Option -->
            <p>
                <b>{{ alphabet[index] }}. </b>
            </p> 
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
                    <button class="btn btn-edit" v-on:click="showEditOption(index)">Editar</button>
                    <button class="btn btn-delete" v-on:click="delOption(option.id)">Eliminar</button>
                </div>
            </div>
        </div>
        <!-- New Option form -->
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
            <input id="option" type="text" placeholder="Nuevo" v-model="option.content">
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
            <button class="btn btn-primary" @click="addOption(option)">Agregar</button>
        </div>
        <!-- Labels -->
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
                        v-for="(label, index) in labelList" :key="label.id"
                        v-bind:style="{ background:  colorList[index]}"
                        v-on:click="addLabel(index)">
                        <label class="data-label">{{label.name}} </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- confirm buttons -->
        <div class="position-right">
            <div class="btn-group">
                <button class="btn btn-big btn-cancel" @click="cancelEdit()"><span>Cancelar</span></button>
                <button class="btn btn-big btn-save" @click="editarPregunta(question)">Guardar</button>
            </div>
        </div>
    </div>
</template>
<script>
import {mapState, mapMutations, mapActions} from 'vuex' 
export default {
    props: {
        question: {
            type: Object,
            default: ()=> {}
        }
    },
    data: function(){
        return {
            option: {
                content: "",
                type: 0
            },
            labels: [],
            config: {
                editingOption: false,
            },
            general: {
                labels: [],
            },
            editingQuestion: false
        }
    },
    
    methods: {
        editarPregunta(question){
            if(!question.content)return this.launchAlert({type: 'warning', message: 'Digita la descripción'});
            if(question.options.length <= 0)return this.launchAlert({type: 'warning', message: 'Es necesario crear por lo menos una opción'});
            if(!question.options.find(option => option.type == 1))return this.launchAlert({type: 'warning', message: 'Es necesaria una opción correcta'});
            this.updateQuestion(question).then(res => {
                if(res.data.status == 200){
                    this.launchAlert({type: 'success', message: 'Editado exitosamente'});
                    this.loadQuestion();
                    this.cancelEdit();
                } else {
                    this.launchAlert({type: 'error', message: 'Ha surgido un error'});
                }
            }).catch(err => {
                console.log(err);
            })
        },
        ...mapMutations('question', ['loadQuestion']),
        ...mapMutations('label', ['loadLabel']),
        ...mapActions('question', ['updateQuestion']),
        
        ...mapActions('question', ['createOption']),
        ...mapActions('question', ['editOption']),
        ...mapActions('question', ['deleteOption']),

        ...mapActions('question', ['addQuestionLabel']),
        ...mapActions('question', ['deleteLabel']),
        /* Option */
        showEditOption(index){
            this.config.editingOption = index;
        },
        addOption(option){
            let json = {
                content: option.content,
                type: option.type,
                questionId: this.question.id,
            }
            if(json.content == ''){
                return this.launchAlert({type: 'warning', message: 'La opción no puede quedar vacía'});
            }
            this.createOption(json);
            this.option.content = ''
            document.getElementById('option').focus();
            this.delayOptions();
        },
        confirmEditOption(data){
            let json = {
                id: data.id,
                content: data.content,
                type: data.type,
                questionId: this.question.id
            }
            this.editOption(json);
            this.delayOptions();
            this.config.editingOption = false;
        },
        delOption(id){
            this.deleteOption(id);
            this.delayOptions();
        },
        /* Label */
        addLabel(index){
            let json = {
                questionId: this.question.id,
                labelId: this.general.labels[index].id
            }
            var consulta = this.question.labels.find(label => label.id == this.general.labels[index].id)
            if(this.question.labels.length == 3){
                return this.launchAlert({type: 'warning', message: 'No se pueden agregar mas etiquetas'});
            }
            if(consulta) return this.launchAlert({type: 'warning', message: 'Esta etiqueta ya se encuentra en uso'});
            this.addQuestionLabel(json)
            this.delayOptions()
        },
        removeLabel(index){
            let json = {
                questionId: this.question.id,
                labelId: this.question.labels[index].id
            }
            this.deleteLabel(json)
            this.delayOptions()
        },
        /* Needed options  */
        loadFormLabels(){
            this.general.labels = this.labelList;
        },
        cancelEdit(){
            this.$emit('function', this.editingQuestion)
        },
        delayOptions(){
            setTimeout(() => {
                let question = this.questionList.find(question => question.id == this.question.id);
                this.question.options = question.options;
                this.question.labels = question.labels;
            }, 100);
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
        ...mapState('label', ['colorList']),
        ...mapState('label', ['labelList']),
        ...mapState('question', ['questionList']),
    },
    mounted(){
        this.loadLabel();
        setTimeout(() => {this.loadFormLabels()},100)
    }
}
</script>
<style>

</style>
