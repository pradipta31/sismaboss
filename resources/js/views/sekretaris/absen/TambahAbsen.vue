<template>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="style-text">
                                        <div class="input-group">
                                            <input type="text" class="form-control" v-model="nim" v-on:keyup.13="save" 
                                            placeholder="Masukan nim" 
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                            <label class="input-group-btn">
                                                <button class="btn btn-primary" @click="save">
                                                    <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a :href="`sekretaris/absen/${user.periode_id}`" class="btn btn-primary btn-block">Download .xls</a>
                            </div>
                            <div class="col-md-1">
                                <router-link :to="{name: 'sekretaris_absen_index'}" class="btn btn-warning">Kembali</router-link>
                            </div>
                            <div class="col-md-12"> 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th scope="col">NIM</th>
                                        <th scope="col">Nama</th>
                                        <th width="90px">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in absen" :key="index">
                                            <td>{{index+1}}</td>
                                            <td>
                                                {{item.nim}}
                                            </td>
                                            <td>
                                                {{item.name}}
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" @click="deleteForm(item.id)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</template>

<script>
import {mapGetters} from "vuex"
export default {
    data(){
        return{
            table: null,
            absen: [],
            nim: ''
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            axios.get('api/absen/tambah/'+this.$route.params.id)
            .then(r => {
               console.log(r);
               this.absen = r.data.absents;
            })
            .catch(e => {
                console.log(e);
            })
            .finally(() => {
                if(this.table == null){
                    this.table = $('table').dataTable();
                }else{
                    this.table.rows().invalidate().draw();
                }
            })
        },
        deleteForm(id){
            axios.delete(`api/absen/tambah/${id}`)
            .then(r => {
                toast.success(r.data.message)
                this.getData()
            })
            .catch(e => {
                toas.error(r.data.error)
            })
        },
        save(){
            axios.post(`api/absen/tambah/${this.$route.params.id}`,{nim: this.nim})
            .then(r => {
                console.log(r);
                if(r.data.message){
                    toast.success(r.data.message)
                    this.getData()
                }else{
                    toast.error('Anggota sudah melakukan absen')
                }
            })
            .catch(e => {
                console.log(e);
                toast.error('Data anggota tidak ada')
            })
        }
    },
    computed:{
        ...mapGetters([
            'user'
        ])
    }
}
</script>

<style>
</style>
