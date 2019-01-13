<template>
    <div>
        <section class="content-header">
            <h1>
                Data Surat Masuk
                <small>data-data surat masuk UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Surat Masuk</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="15px">No</th>
                                    <th>Periode</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Tanggal</th>
                                    <th>PJ</th>
                                    <th>File</th>
                                    <th width="100px">Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in letter" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{item.periode}}</td>
                                        <td>{{item.nomor_surat}}</td>
                                        <td>{{item.perihal}}</td>
                                        <td>{{item.tanggal}}</td>
                                        <td>{{item.username}}</td>
                                        <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showGambar" @click="showModal(item.id)">
                                            Lihat Gambar
                                            </button>
                                            <div class="modal fade" id="showGambar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="exampleModalLabel">Data : {{modal.perihal}}</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <img :src="'images/surat/'+modal.pict" class="img-responsive" height="1080px" width="650px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="showModal(item.id)"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSurat" @click="editSurat(item.id)"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLabel">Data : {{modal.jenis}}</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-4">
                                                                    <h4>Nomor Surat </h4>
                                                                    <h4>Perihal </h4>
                                                                    <h4>Tanggal </h4>
                                                                    <h4>Penanggung Jawab </h4>
                                                                    <h4>Deskripsi </h4>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <h4>: {{modal.nomor_surat}}</h4>
                                                                    <h4>: {{modal.perihal}}</h4>
                                                                    <h4>: {{modal.tanggal}}</h4>
                                                                    <h4>: {{modal.username}}</h4>
                                                                    <h4>: {{modal.deskripsi}}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="editSurat" tabindex="-1" role="dialog" aria-labelledby="editSuratLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="editSuratLabel">Edit Surat {{edit.perihal}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nomor surat</label>
                                                <input type="text" v-model="edit.nomor_surat" class="form-control" placeholder="Masukan nomor surat">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Perihal</label>
                                                <input type="text" v-model="edit.perihal" class="form-control" placeholder="Masukan perihal">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tanggal Event</label>
                                                <input type="date" v-model="edit.tanggal" class="form-control">
                                            </div>
                                            <div>
                                                <div class="input-group">
                                                    <label class="input-group-btn">
                                                        <button class="btn btn-primary btn-md" @click="pilihFoto"><i class="fa fa-cloud-upload"></i></button>
                                                        
                                                        <input type="file" class="hidden" id="fileFoto" accept="image/*">
                                                    </label>
                                                    <input type="text" class="form-control" @click="pilihFoto" 
                                                    style="cursor: default; caret-color: transparent" readonly="readonly"
                                                    placeholder="Upload foto" v-model="edit.pict">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">Deskripsi</label>
                                                <textarea cols="78" rows="8" v-model="edit.deskripsi" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" @click="saveEdit">
                                                <i class="fa fa-spin fa-spinner" v-if="isLoadingEdit"></i>
                                                <i class="fa fa-check" v-else></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6>Note: PJ = Penanggung Jawab</h6>
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
        this.getData()
    },
    data(){
        return{
            table: null,
            modal: {
                periode_id: '',
                user_id: '',
                jenis: '',
                nomor_surat: '',
                perihal: '',
                tanggal: '',
                pict: '',
                deskripsi: ''
            },
            edit:{
                nomor_surat: '',
                perihal: '',
                tanggal: '',
                pict: '',
                deskripsi: ''
            },
            form: new FormData(),
            isLoadingEdit: false,
            letter: []
        }
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
        getData(){
            axios.get('api/surat-masuk')
            .then(r => {
                this.letter = r.data.letters
            })
            .catch(e => {
                console.log(e)
            })
            .finally(() => {
                if(this.table == null){
                    this.table = $('table').dataTable();
                }else{
                    this.table.rows().invalidate().draw();
                }
            })
        },
        showModal(id){
            axios.get(`api/surat-masuk/show/${id}`)
            .then(r => {
                this.modal = r.data.let
                console.log(r.data.let)
            })
            .catch(e => {
                console.log(e)
            })
        },
        pilihFoto(){
            $('#fileFoto').trigger('click');
        },
        editSurat(id){
            axios.get(`api/surat-masuk/edit/${id}`)
            .then(r => {
                this.edit = r.data.letters
                console.log(r.data.letters)
            })
            .catch(e => {
                console.log(e)
            })
        },
        saveEdit(){

        }
    }
    
}
</script>

<style>

</style>
