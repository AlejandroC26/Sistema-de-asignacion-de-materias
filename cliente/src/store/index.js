import Vue from 'vue'
import Vuex from 'vuex'
import auth from '../modules/auth'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: null,
        sessionUser: {
            id: '',
            name: '',
            email: '',
            groups: '',
            password: '',
            rol: 'student',
            createdAt: '',
            updatedAt: ''
        },
        alphabet: ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","u","v","w","x","y","z"],
    },
    mutations: {
        setToken(state, payload) {
            state.token = payload
        },
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