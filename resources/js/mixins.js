import Axios from "axios";

export default {
    methods: {
        checkAuth(){
            if(this.$localStorage.get('access_token') == null || this.$store.state.auth.role == null || this.$store.state.auth.data == null){
                var auth_data = this.$cookies.get('sismaboss_auth_data');
                console.log(auth_data);
            
                if(auth_data != null || auth_data != undefined){
                    this.setIdentify(auth_data);
                    window.axios.defaults.headers.common['Authorization'] = 'Bearer '+auth_data;
                    axios.post('api/auth/me')
                    .then(r => {
                        this.setIdentify(r.data);
                    });
                }else{
                    this.$router.push({name: 'login'});
                    console.log('Redirect to login!');
                }
            }
        },
        setIdentify(user){
            this.$store.state.auth.token = user.access_token;
            this.$store.state.auth.data = user;
            this.$store.state.auth.access = user.access;
            this.$store.state.auth.role = user.role;
        }
    }
}