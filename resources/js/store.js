import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
export default new Vuex.Store({
    state:{
        auth:{
            token: null,
            data: {
                email: '',
                name: '',
                role: '',
                username: '',
                nim: '',
                pict: '',
                id: ''
            },
            role: null
        },
        navigation:{
            navActive: 'dashboard',
            subNavActive: ''
        },
    },

    actions:{

    },

    mutations:{

    },

    getters:{
        user(state){
            return state.auth.data;
        }
    }
})