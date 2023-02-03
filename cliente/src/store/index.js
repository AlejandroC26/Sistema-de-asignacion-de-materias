import Vue from 'vue'
import axios from 'axios'
import Vuex from 'vuex'
import auth from '../modules/auth'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: null,
        sessionUser: {
            id: '',
            nombres: '',
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
            if(!state.token) return;
            axios.get('http://127.0.0.1:8000/api/auth/me', 
            { headers: { "Authorization": "Bearer " + state.token} })
            .then(({data}) => {
                state.sessionUser.id = data.data.id;
                state.sessionUser.nombres = data.data.nombres;
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
    modules: {
        auth,
    }
})