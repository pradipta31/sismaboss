<template>
    <div>
        <section class="content-header">
            <h1>
                Tambah Surat
                <small>tambah Surat pada periode yang sudah didaftarkan</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Tambah Surat</li>
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
                                        Tambah Surat
                                    </h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Jenis Surat</label>
                                            <select v-model="data.jenis" class="form-control">
                                                <option value="Surat Masuk">Surat Masuk</option>
                                                <option value="Surat Keluar">Surat Keluar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nomor Surat</label>
                                            <input type="text" v-model="data.nomor_surat" class="form-control" placeholder="Masukan nomor surat">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Perihal</label>
                                            <input type="text" v-model="data.perihal" class="form-control" placeholder="Masukan perihal surat">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" class="form-control" v-model="data.tanggal">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 10px">
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
                                    <div class="form-group">
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
                                            <small class="pull-left" style="margin-top: 10px">Note: File boleh dikosongkan</small>
                                        </div>
                                            
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px">
                                        <div class="form-group">
                                            <label for="">Deskripsi</label>
                                            <textarea v-model="data.deskripsi" rows="5" class="form-control"></textarea>
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
            data:{
                jenis: '',
                nomor_surat: '',
                perihal: '',
                tanggal: '',
                deskripsi: ''
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

            $('#fileSurat').change(function(){
                var data = document.getElementById('fileSurat');
                if(data.files.length > 0){
                    self.form.append('surat',data.files[0]);
                }
            });
        },
        onChange(){
            this.form.append('jenis',this.data.jenis);
            this.form.append('nomor_surat',this.data.nomor_surat);
            this.form.append('perihal',this.data.perihal);
            this.form.append('tanggal',this.data.tanggal);
            this.form.append('deskripsi',this.data.deskripsi);
        },
        save(){
            this.isLoading = true;
            this.onChange();
            axios.post('api/surat/tambah-surat',this.form)
            .then(r => {
                this.isLoading = false
                toast.success(r.data.message)
            })
            .catch(e => {
                console.log(e);
            })
        },
        pilihFoto(){
            $('#fileFoto').trigger('click');
        },
        pilihFile(){
            $('#fileSurat').trigger('click');
        },
        // addButton(){
        //     console.log('berhasil klik button tambah')
        // },
        // removeButton(){
        //     console.log('berhasil klik button remove')
        // }
    }
}
</script>

<style scoped>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
