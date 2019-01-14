<template>
    <div>
        <section class="content-header">
            <h1>
                Data Surat Keluar
                <small>data-data surat keluar UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Surat Keluar</li>
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
                                        <td>{{item.nomor_surat}}</td>
                                        <td>{{item.perihal}}</td>
                                        <td>{{item.tanggal}}</td>
                                        <td>{{item.username}}</td>
                                        <td>
                                            <a :href="`file/surat/${item.surat}`" class="btn btn-primary">Download</a>
                                            <button class="btn btn-warning" @click="editFile(item.id)">Edit</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="showModal(item.id)"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></button>
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
                                                                <div class="col-md-6">
                                                                    <h4>Nomor Surat : {{modal.nomor_surat}}</h4>
                                                                    <h4>Perihal : {{modal.perihal}}</h4>
                                                                    <h4>Tanggal : {{modal.tanggal}}</h4>
                                                                    <h4>Penanggung Jawab : {{modal.username}}</h4>
                                                                    <h4>Deskripsi : {{modal.deskripsi}}</h4>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <img :src="'images/surat/'+modal.pict" class="img-square" width="250px" height="250px">
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
            modal: {
                table: null,
                periode_id: '',
                user_id: '',
                jenis: '',
                nomor_surat: '',
                perihal: '',
                tanggal: '',
                pict: '',
                deskripsi: ''
            },
            letter: []
        }
    },
    methods:{
        getData(){
            axios.get('api/surat-keluar')
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
        editFile(id){
            this.$router.push({name: 'sekretaris_surat_edit',params: {id: id}});
        }
    }
    
}
</script>

<style>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
