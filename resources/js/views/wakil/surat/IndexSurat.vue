<template>
    <div>
        <section class="content-header">
            <h1>
                Data Surat
                <small>data-data surat masuk dan keluar UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Surat</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="15px">No</th>
                                <th>Periode</th>
                                <th>Jenis</th>
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
                                    <td>{{item.jenis}}</td>
                                    <td>{{item.nomor_surat}}</td>
                                    <td>{{item.perihal}}</td>
                                    <td>{{item.tanggal}}</td>
                                    <td>{{item.username}}</td>
                                    <td>
                                        <span v-if="item.jenis == 'Surat Keluar'">
                                            <a :href="`file/surat/${item.surat}`" class="btn btn-primary">Download Surat</a>
                                        </span>
                                        <span v-else>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showGambar" @click="showModal(item.id)">
                                            Lihat Gambar
                                            </button>
                                        </span>
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
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="showItem(item.id)"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
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
    data(){
        return {
            table: null,
            letter: [],
            modal: {
                periode_id: '',
                user_id: '',
                jenis: '',
                nomor_surat: '',
                perihal: '',
                tanggal: '',
                pict: '',
                deskripsi: ''
            }
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            axios.get('api/surat')
            .then(r => {
               console.log(r);
               this.letter = r.data.letters
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
        showModal(id){
            axios.get(`api/surat/show/${id}`)
            .then(r => {
                this.modal = r.data.letters
            })
            .catch(e => {
                console.log(e)
            })
        },
        showItem(id){
            axios.get(`api/surat/show/${id}`)
            .then(r => {
                this.modal = r.data.letters
            })
            .catch(e => {
                console.log(e)
            })
        }
    }
}
</script>

<style>

</style>
