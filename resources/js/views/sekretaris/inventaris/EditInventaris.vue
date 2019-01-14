<template>
    <div>
        <section class="content-header">
            <h1>
                Edit Data Inventaris
                <small>edit data Inventaris pada periode yang sudah didaftarkan</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Edit Inventaris</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-ttitle">
                                Edit Data Inventaris
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Nama Inventaris</label>
                                <input type="text" class="form-control" v-model="data.nama" placeholder="Masukan nama inventaris">
                            </div>
                            <div class="form-group">
                                <label for="">Penanggung Jawab</label>
                                <input type="text" class="form-control" v-model="data.penanggung_jawab" placeholder="Masukan penanggung jawab">
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <textarea class="form-control" v-model="data.keterangan"></textarea>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary" @click="saveEdit">
                                <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                <i class="fa fa-check" v-else></i>
                                Simpan
                            </button>
                            <router-link :to="{name:'sekretaris_inventaris_index'}" class="btn btn-info">Kembali</router-link>
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
            data:{
                nama: '',
                penanggung_jawab: '',
                keterangan: ''
            },
            isLoading: false
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        init(){
            axios.get('api/inventaris/edit/'+this.$route.params.id)
            .then(r => {
                this.data = r.data.inventories;
            })
            .catch(e => {
                console.log(e);
            })
        },
        saveEdit(){
            this.isLoading = true
            axios.put('api/inventaris/edit/'+this.$route.params.id,this.data)
            .then(r => {
                this.isLoading = false
                if(r.data.message){
                    toast.success(r.data.message)
                    this.$router.push({name: 'sekretaris_inventaris_index'});
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
