<template>
    <div>
        <section class="content-header">
            <h1>
                Tambah Anggota
                <small>tambah anggota UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Tambah Anggota</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">No Telepon</th>
                                    <th width="90px">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in anggota" :key="index">
                                        <td>
                                            <input type="text" class="form-control" v-model="item.nim">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" v-model="item.name">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" v-model="item.handphone">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" @click="minForm(index)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button class="btn btn-primary btn-sm" @click="addForm(index)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                            <button class="pull-right btn btn-primary" @click="save()" style="margin-top: 5px; margin-left: 5px">
                                <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                <i class="fa fa-check" v-else></i>
                                Simpan
                            </button>
                            <router-link class="pull-right btn btn-warning" :to="{name: 'sekretaris_anggota_index'}" style="margin-top: 5px;">
                                Kembali
                            </router-link>
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
        return {
            anggota:[
                {
                    nim: '',
                    name: '',
                    handphone: ''
                }
            ],
            isLoading: false

        }
    },
    methods:{
        addForm(index){
            this.anggota.splice(index+1,0,{
                nim: '',
                name: '',
                handphone: ''
            })
        },
        minForm(index){
            if(this.anggota.length < 2){
                this.anggota[0].nim = '';
                this.anggota[0].name = '';
                this.anggota[0].handphone = '';
            }else{
                this.anggota.splice(index,1)
            }
        },
        save(){
            this.isLoading = true
            axios.post('api/anggota/tambah-anggota', {anggota: this.anggota})
            .then(r => {
                console.log(r);
                if (r.data.message) {
                    this.$router.push({name: 'sekretaris_anggota_index'});
                    toast.success(r.data.message)
                }else{
                    toast.error('Login gagal!');
                }
            })
            .catch(e => {
                console.log(e);
                toas.error(r.data.error);
            })
        }
    }
}
</script>

<style>

</style>
