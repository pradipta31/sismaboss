<template>
    <div>
        <section class="content-header">
            <h1>
                Data Rapat
                <small>data-data rapat UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Rapat</li>
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
                                <th>No</th>
                                <th>Periode</th>
                                <th>Sekretaris</th>
                                <th>Judul Rapat</th>
                                <th>Tanggal</th>
                                <th>Pemimpin Rapat</th>
                                <th>Opsi</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in meeting" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.periode}}</td>
                                    <td>{{item.username}}</td>
                                    <td>{{item.judul_rapat}}</td>
                                    <td>{{format(item.tgl_rapat)}}</td>
                                    <td>{{item.moderator}}</td>
                                    <td>
                                        <center>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="showModal(item.id)">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </center>

                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLabel">Judul Rapat : {{modal.judul_rapat}}</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-md-6">
                                                            <h4>Tanggal Rapat </h4>
                                                            <h4>Jumlah Anggota Hadir </h4>
                                                            <h4>Pemimpin Rapat </h4>
                                                            <h4>Hasil Rapat </h4>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>: {{format(modal.tgl_rapat)}}</h4>
                                                            <h4>: {{modal.jumlah_hadir}} Orang</h4>
                                                            <h4>: {{modal.moderator}}</h4>
                                                        </div>
                                                        <textarea v-model="modal.hasil_rapat" cols="85" rows="14" class="form-control" readonly></textarea>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    data(){
        return {
            table: null,
            modal: {
                judul_rapat: '',
                tgl_rapat: '',
                moderator: '',
                jumlah_hadir: '',
                hasil_rapat: ''
            },
            meeting: []
        }
    },
    mounted(){
        this.getData()
    },
    methods: {
        format(tgl_rapat){
            return moment(tgl_rapat).format('DD MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/rapat')
            .then(r => {
               console.log(r);
               this.meeting = r.data.meetings;
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
            axios.get(`api/rapat/${id}`)
            .then(r => {
                console.log(r);
                this.modal = r.data.meetings
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
