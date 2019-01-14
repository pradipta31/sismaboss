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
                                Edit Foto/File Surat {{data.perihal}}
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group" v-if="data.jenis == 'Surat Masuk'">
                                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 10px;">
                                    <div class="input-group">
                                        <label class="input-group-btn">
                                            <button class="btn btn-primary btn-md" @click="pilihFoto"><i class="fa fa-cloud-upload"></i></button>
                                            
                                            <input type="file" class="hidden" id="fileFoto" accept="image/*">
                                        </label>
                                        <input type="text" class="form-control" @click="pilihFoto" 
                                        style="cursor: default; caret-color: transparent" readonly="readonly"
                                        placeholder="Upload foto">
                                    </div>
                                    <small class="pull-left" style="margin-top: 10px">Note: Upload file jika surat keluar, upload gambar jika surat masuk</small>
                                </div>  
                            </div>
                            <div class="form-group" style="margin-bottom: 10px" v-else>
                                <div class="col-md-12">
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
                            </div>
                            <button type="submit" class="btn btn-primary" @click="saveEdit">
                                <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                <i class="fa fa-check" v-else></i>
                                Simpan
                            </button>
                            <router-link :to="{name:'sekretaris_surat_keluar_index'}" class="btn btn-info" v-if="data.jenis == 'Surat Keluar'">Kembali</router-link>
                            <router-link :to="{name:'sekretaris_surat_masuk_index'}" class="btn btn-info" v-if="data.jenis == 'Surat Masuk'">Kembali</router-link>
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
                jenis: ''
            },
            form: new FormData(),
            isLoading: false
        }
    },
    mounted(){
        this.init();
        this.getInit();
    },
    methods:{
        getInit(){
            var self = this;
            $('#fileFoto').change(function(){
                var picture = document.getElementById('fileFoto');
                if(picture.files.length > 0){
                    self.form.append('pict',picture.files[0]);
                }
            });

            $('#fileSurat').change(function(){
                var data = document.getElementById('fileSurat');
                if(data.files.length > 0){
                    self.form.append('surat',data.files[0]);
                }
            });
        },
        init(){
            axios.get('api/surat-masuk/edit/'+this.$route.params.id)
            .then(r => {
                this.data = r.data.letters
                console.log(r.data.letters)
            })
            .catch(e => {
                console.log(e)
            })
        },
        saveEdit(){
            this.isLoading = true
        },
        pilihFoto(){
            $('#fileFoto').trigger('click');
        },
        pilihFile(){
            $('#fileSurat').trigger('click');
        },
    }
}
</script>

<style>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
