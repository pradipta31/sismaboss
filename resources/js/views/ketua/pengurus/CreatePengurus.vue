<template>
    <div>
        <section class="content-header">
            <h1>
                Tambah Pengurus
                <small>tambah pengurus berdasarkan jabatan</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path: '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Tambah Pengurus</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-body">
                                <div class="box-header">
                                    <h3 class="box-ttitle">
                                        Tambah Pengurus
                                    </h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Jabatan</label>
                                            <select v-model="data.role" class="form-control">
                                                <option value="wakil">Wakil Ketua</option>
                                                <option value="sekretaris">Sekretaris</option>
                                                <option value="bendahara">Bendahara</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nama</label>
                                            <input type="text" v-model="data.name" class="form-control" placeholder="Masukan nama pengurus">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input type="text" v-model="data.username" class="form-control" placeholder="Masukan Username">
                                            <small>Username maksimal 15 huruf</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">NIM</label>
                                            <input type="number" v-model="data.nim" class="form-control" placeholder="Masukan NIM" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" v-model="data.email" class="form-control" placeholder="Masukan Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="text" v-model="data.password" class="form-control" placeholder="Masukan Password">
                                            <small>Password minimal 6 huruf atau angka</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary" @click="save">
                                            <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                            <i class="fa fa-check" v-else></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data(){
        return{
            data: {
                role: 'wakil',
                name: '',
                nim: '',
                email: '',
                username: '',
                password: ''
            },
            admin:[],
            isLoading: false
        }
    },
    methods:{
        save(){
            if (this.data.name.length == 0) {
                toast.error('Kolom nama tidak boleh kosong!');
                return ;
            }else if(this.data.username.length == 0){
                toast.error('Kolom username tidak boleh kosong!');
                return ;
            }else if(this.data.nim.length == 0){
                toast.error('Kolom NIM tidak boleh kosong!');
                return ;
            }else if(this.data.email.length == 0){
                toast.error('Kolom email tidak boleh kosong!');
                return ;
            }else if(this.data.password.length == 0){
                toast.error('Kolom password tidak boleh kosong!');
                return ;
            }
            this.isLoading = true
            axios.post('api/pengurus/tambah-pengurus',this.data)
            .then(r => {
                this.isLoading = false
                if(r.data.message){
                    toast.success(r.data.message)
                    this.$router.push({name: 'ketua_pengurus_index'});
                }else{
                    toast.error(r.data.error)
                }
            })
            .catch(e => {
                console.log(e);
                toast.error(r.data.error)
            })
        }
    }
}
</script>

<style>

</style>
