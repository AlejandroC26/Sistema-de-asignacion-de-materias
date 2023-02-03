
import axios from "axios" 
import store from '../store/index';
export default {
    namespaced: true,
    state: {
        error: null
    },
    mutations: {
        setError(state, payload){
            state.error = '401';
        }
    },
    actions: {
        login({commit}, user) {
            axios.post('http://localhost:3000/api/user/login', user)
            .then(res => {
                if(res.data.status === 200){
                    commit('setToken', res.data.token, {root: true})
                    localStorage.setItem('token', res.data.token);
                    window.location.href = __dirname + 'dashboard';
                }
            })
            .catch(err => {
                commit('setError', err.response)
            })
        },
    }
}