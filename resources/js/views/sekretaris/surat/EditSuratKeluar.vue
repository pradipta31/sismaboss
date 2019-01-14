<template>
    <div>
        <section class="content-header">
            <h1>
                Edit Data Surat
                <small>edit data Surat pada periode yang sudah didaftarkan</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Edit Surat</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-ttitle">
                                Edit File Surat {{data.perihal}}
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group" style="margin-bottom: 10px">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <button class="btn btn-warning btn-md" @click="pilihFile"><i class="fa fa-upload "></i></button>
                                        
                                        <input type="file" class="hidden" id="fileSurat">
                                    </label>
                                    <input type="text" class="form-control" @click="pilihFile" 
                                    style="cursor: default; caret-color: transparent" readonly="readonly"
                                    placeholder="Upload file">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" @click="saveEdit">
                                <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                <i class="fa fa-check" v-else></i>
                                Simpan
                            </button>
                            <router-link :to="{name:'sekretaris_surat_masuk_index'}" class="btn btn-info">Kembali</router-link>
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
                perihal: ''
            },
            form: new FormData(),
            isLoading: false
        }
    },
    mounted(){
        this.getData()
        this.init()
    },
    methods:{
        getData(){
            axios.get('api/surat-keluar/edit/'+this.$route.params.id)
            .then(r => {
                this.data = r.data.letters
                console.log(r.data.letters)
            })
            .catch(e => {
                console.log(e)
            })
        },
        init(){
            var self = this

            $('#fileSurat').change(function(){
                var data = document.getElementById('fileSurat');
                if(data.files.length > 0){
                    self.form.append('surat',data.files[0]);
                }
            });
        },
        saveEdit(){
            this.isLoading = true
            axios.post('api/surat-keluar/'+this.$route.params.id,this.form)
            .then(r => {
                this.isLoading = false
                if(r.data.message){
                    toast.success(r.data.message)
                    this.$router.push({name: 'sekretaris_surat_keluar_index'});
                }else{
                    toast.error(r.data.error)
                }
            })
            .catch(e => {
                console.log(e);
                toast.error(r.data.error)
            })
        },
        pilihFile(){
            $('#fileSurat').trigger('click');
        },
    }
}
</script>

<style>

</style>
