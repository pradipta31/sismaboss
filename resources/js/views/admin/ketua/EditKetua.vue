<template>
    <div>
        <section class="content-header">
            <h1>
                Edit Data Kepengurusan
                <small>edit data Kepengurusan pada periode yang sudah didaftarkan</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Edit Kepengurusan</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-8">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-ttitle">
                                Edit Data Kepengurusan
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" v-model="data.name">
                            </div>
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" class="form-control" v-model="data.username">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control" v-model="data.email">
                            </div>
                            <div class="form-group">
                                <label for="">NIM</label>
                                <input type="text" class="form-control" v-model="data.nim">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="text" class="form-control" v-model="data.password">
                                <h6>Note: Kosongkan jika tidak ingin mengubah password</h6>
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select class="form-control" v-model="data.status">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary" @click="saveEdit">
                                <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                <i class="fa fa-check" v-else></i>
                                Simpan
                            </button>
                            <router-link :to="{name:'admin_ketua_index'}" class="btn btn-info">Kembali</router-link>
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
                name: '',
                username: '',
                email: '',
                nim: '',
                status: '',
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
            axios.get('api/ketua/'+this.$route.params.id)
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
                    axios.put('api/ketua/'+this.$route.params.id, this.data)
                    .then(r => {
                        this.isLoading = false;
                        toast.success(r.data.message);
                        this.$router.push({name: 'admin_ketua_index'});
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
