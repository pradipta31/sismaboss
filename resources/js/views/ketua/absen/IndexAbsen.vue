<template>
    <div>
        <section class="content-header">
            <h1>
                Data Absen
                <small>data-data absen UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Absen</li>
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
                                    <th>No</th>
                                    <th>PJ</th>
                                    <th>Judul Absen</th>
                                    <th>Tanggal</th>
                                    <th>Absen</th>
                                    <th>Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in absent" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{item.username}}</td>
                                        <td>{{item.judul_absen}}</td>
                                        <td>{{format(item.created_at)}}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" @click="viewAbsent(item.id)">Lihat Absen</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showAbsent" @click="showAbsent(item.id)"><i class="fa fa-eye"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="showAbsent" tabindex="-1" role="dialog" aria-labelledby="showAbsentLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="showAbsentLabel">Judul Absen : {{show.judul_absen}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-6">
                                                <h4>Tanggal </h4>
                                                <h4>Deskripsi </h4>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>: {{format(show.created_at)}}</h4>
                                            </div>
                                            <textarea v-model="show.deskripsi" cols="56" rows="5" class="form-control" readonly></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
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
import moment from 'moment'
export default {
    data(){
        return{
            table: null,
            show:{
                judul_absen: '',
                user_id: '',
                created_at: '',
                deskripsi: ''
            },
            absent: []
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        format(created_at){
            moment.locale('id');
            return moment(created_at).format('dddd, DD MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/absen')
            .then(r => {
               console.log(r);
               this.absent = r.data.absents;
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
        showAbsent(id){
            axios.get(`api/absen/show/${id}`)
            .then(r => {
                console.log(r);
                this.show = r.data.absents
            })
            .catch(e => {
                console.log(e)
            })
        },
        viewAbsent(id){
            this.$router.push({name: 'ketua_absen_view',params: {id: id}});
        }
    }
}
</script>

<style>

</style>
