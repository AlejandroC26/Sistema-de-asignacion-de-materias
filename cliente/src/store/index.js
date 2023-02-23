import Vue from 'vue'
import axios from 'axios'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: null,
        sessionUser: {
            id: '',
            nombres: '',
            documento: '',
            telefono: '',
            direccion: '',
            ciudad: '',
            permisos: {
                admin: false,
                profesor: false,
                estudiante: false
            }
        },
    },
    mutations: {
        setToken(state, payload) {
            state.token = payload;
        },
        loadSessionUser(state, payload){
            if(!state.token && payload.force === false) return;
            axios.get('http://127.0.0.1:8000/api/auth/me', 
            { headers: { "Authorization": "Bearer " + state.token} })
            .then(({data}) => {
                state.sessionUser.id = data.data.id;
                state.sessionUser.nombres = data.data.nombres;
                state.sessionUser.documento = data.data.documento;
                state.sessionUser.telefono = data.data.telefono;
                state.sessionUser.direccion = data.data.direccion;
                state.sessionUser.ciudad = data.data.ciudad;
                state.sessionUser.email = data.data.email;
                state.sessionUser.permisos = data.permisos;
            }).catch(e => console.log(e.response))
        }
    },
    actions: {
        readToken({commit}){
            if(localStorage.getItem('token')){
                commit('setToken', localStorage.getItem('token'));
            } else {
                commit('setToken', null);
            }
        },
    },
})