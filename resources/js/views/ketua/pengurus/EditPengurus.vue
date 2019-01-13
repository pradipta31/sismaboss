<template>
    <div>
        <section class="content-header">
            <h1>
                Edit Data Pengurus
                <small>Edit data pengurus yang dipilih</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Edit Data Pengurus</li>
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
                                        Edit Pengurus
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
                                            <input type="text" v-model="data.name" class="form-control" placeholder="Masukan nama ketua">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input type="text" v-model="data.username" class="form-control" placeholder="Masukan Username">
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
                                            <small>Note: Kosongkan jika tidak ingin mengubah password</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary" @click="saveEdit">
                                            <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                            <i class="fa fa-check" v-else></i>
                                            Simpan
                                        </button>
                                        <router-link :to="{name : 'ketua_pengurus_index'}" class="btn btn-warning">Kembali</router-link>
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
            data:{
                role: '',
                name: '',
                username: '',
                email: '',
                nim: '',
                password: ''
            },
            users: [],
            isLoading: false
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        init(){
            axios.get('api/pengurus/'+this.$route.params.id)
            .then(r => {
                this.data = r.data.user;
            })
            .catch(e => {
                console.log(e);
            })
        },
        saveEdit(){
            swal({
                title: "Apakah anda yakin ingin menyimpan?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((yes) => {
                if(yes){
                    axios.put('api/pengurus/'+this.$route.params.id, this.data)
                    .then(r => {
                        this.isLoading = false;
                        toast.success(r.data.message);
                        this.$router.push({name: 'ketua_pengurus_index'});
                    })
                    .catch(e => {
                        this.isLoading = false;
                        console.log(e.response.data.errors);
                        toast.error('Gagal mengubah data');
                    })
                }
            })
        }
    }
}
</script>

<style>

</style>
