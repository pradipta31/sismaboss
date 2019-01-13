<template>
    <div>
        <section class="content-header">
            <h1>
                Tambah Ketua
                <small>tambah ketua pada periode yang sudah didaftarkan</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Tambah Ketua</li>
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
                                        Tambah Ketua
                                    </h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Periode</label>
                                            <select v-model="data.periode_id" class="form-control">
                                                <option 
                                                v-for="(prd, index) in periode" :key="index"
                                                :value="prd.id">
                                                {{prd.periode}}</option>
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
                                            <input type="number" v-model="data.nim" class="form-control" placeholder="Masukan NIM">
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
    mounted(){
        this.init()
    },
    data(){
        return{
            data:{
                periode_id: 2,
                name: '',
                username: '',
                nim: '',
                email: '',
                password: ''
            },
            isLoading: false,
            periode:[]
        }
    },
    methods:{
        init(){
            axios.get('api/ketua/tambah-ketua')
            .then(r => {
                this.periode = r.data.periodes
            })
            .catch(e => {
                console.log(e)
            })
        },
        save(){
            this.isLoading = true;
            axios.post('api/ketua/tambah-ketua',this.data)
            .then(r => {
                this.isLoading = false
                toast.success(r.data.message)
            })
            .catch(e => {
                console.log(e);
            })
        }
    }
}
</script>

<style>

</style>
