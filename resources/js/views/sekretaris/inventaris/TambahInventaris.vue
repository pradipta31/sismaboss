<template>
    <div>
        <section class="content-header">
            <h1>
                Tambah Inventaris
                <small>tambah Inventaris UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path: '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Tambah Inventaris</li>
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
                                        Tambah Inventaris
                                    </h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Nama Inventaris</label>
                                        <input type="text" class="form-control" v-model="data.nama" placeholder="Masukan nama inventaris">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Penanggung Jawab</label>
                                        <input type="text" class="form-control" v-model="data.penanggung_jawab" placeholder="Masukan penanggung jawab">
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <button class="btn btn-primary btn-md" @click="pilihFoto"><i class="fa fa-cloud-upload"></i></button>
                                                <input type="file" class="hidden" id="fileFoto" accept="image/*">
                                            </label>
                                            <input type="text" class="form-control" @click="pilihFoto" 
                                            style="cursor: default; caret-color: transparent" readonly="readonly"
                                            placeholder="Upload foto">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Keterangan</label>
                                        <textarea class="form-control" v-model="data.keterangan"></textarea>
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
        return {
            data:{
                nama: '',
                keterangan: '',
                penanggung_jawab: ''
            },
            form: new FormData(),
            isLoading: false
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        init(){
            var self = this;

            $('#fileFoto').change(function(){
                var picture = document.getElementById('fileFoto');
                if(picture.files.length > 0){
                    self.form.append('pict',picture.files[0]);
                }
            });
        },
        onChange(){
            this.form.append('nama',this.data.nama);
            this.form.append('keterangan',this.data.keterangan);
            this.form.append('penanggung_jawab',this.data.penanggung_jawab);
        },
        save(){
            this.isLoading = true;
            this.onChange();
            axios.post('api/inventaris/tambah-inventaris',this.form)
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
        },
        pilihFoto(){
            $('#fileFoto').trigger('click');
        }
    }
}
</script>

<style>

</style>
