<template>
    <div>
        <div class="login-logo">
            <img src="images/logo_boss.png" alt="" height="170px" width="200px">
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Silahkan login terlebih dahulu</p>

            <div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" v-model="auth.email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" v-model="auth.password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <button class="btn btn-info btn-md btn-block"  data-toggle="modal" data-target="#modalShow">Deskripsi</button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Deskripsi Sistem Informasi Manajemen UKM BOSS (SISMABOSS)</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit voluptates voluptate repellat. Aperiam hic assumenda molestias corporis dolore ut, quae nemo, alias reiciendis corrupti incidunt ex soluta rerum, minima vero.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <br>
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-primary btn-md btn-block" @click="login"><i class="fa fa-spin fa-spinner" v-if="isLoading"></i> Sign In</button>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            auth: {
                email: '',
                password: '',
            },
            isLoading: false
        }
    },
    mounted(){
        this.isLoading = true;
        let user_config = this.$cookies.get('sismaboss_auth_data');
        if(user_config == null){
            this.isLoading = false;
        }else{
            this.isLoading = false;
            this.$router.push({name:'main'});
        }
        document.body.className = 'hold-transition login-page';
        document.getElementById('app').className = 'login-box';
    },
    methods: {
        login(){
            if (this.auth.email.length == 0 || this.auth.password.length == 0) {
                toast.error('Email atau password tidak boleh kosong!');
                return ;
            }
            this.isLoading = true
            axios.post('api/auth/login', this.auth)
            .then(r => {
                console.log(r);
                this.$cookies.set('sismaboss_token',r.data.access_token,r.data.expires_in);
                this.$cookies.set('sismaboss_auth_data',r.data.access_token,r.data.expires_in);
                this.$localStorage.set('access_token',r.data.access_token);
                this.$store.state.auth.token = r.data.access_token;
                this.$store.state.auth.role = r.data.role;
                this.$store.state.auth.data = r.data.user_config;
                this.$store.state.auth.email = r.data.email;
                this.setToken(r.data.access_token);
                toast.success('Selamat datang ',r.data.email);
                if (r.data.email != null) {
                    this.$router.push({path: 'main'});
                    window.location.reload();
                }else{
                    toast.error('Login gagal!');
                }
            }).catch(e => {
                console.log(e);
                toast.error('Email atau password tidak ditemukan atau Akun di nonaktifkan!');
                this.isLoading = false;
                this.email = this.password = '';
            }).finally(() => {
                this.isLoading = false
            })
        },
        setToken(token){
            window.axios.defaults.headers.common['Authorization'] = 'Bearer '+token;
        },
    },
    
}
</script>

<style>

</style>
