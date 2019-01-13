<template>
    <div>
        <section class="content-header">
            <h1>
                Event
                <small>data-data event UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Event</li>
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
                                    <th>Periode</th>
                                    <th>Sekretaris</th>
                                    <th>Nama Event</th>
                                    <th>Ketua Panitia</th>
                                    <th>Tanggal Event</th>
                                    <th>Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(e, index) in event" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{e.periode}}</td>
                                        <td>{{e.username}}</td>
                                        <td>{{e.nama_event}}</td>
                                        <td>{{e.ketua_panitia}}</td>
                                        <td v-if="e.tgl_akhir">
                                            {{tglMulai(e.tgl_mulai)}} s/d {{tglAkhir(e.tgl_akhir)}}
                                        </td>
                                        <td v-else>
                                            {{tglAkhir(e.tgl_mulai)}}
                                        </td>
                                        <td>
                                            <center>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="showModal(e.id)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </center>

                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="exampleModalLabel">Nama Event : {{show.nama_event}}</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-5">
                                                                <h4>Tanggal Event </h4>
                                                                <h4>Nama Ketua Panitia </h4>
                                                                <h4>Deskripsi Event </h4>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <h4 v-if="show.tgl_akhir">: 
                                                                    {{tglMulai(show.tgl_mulai)}} s/d {{tglAkhir(show.tgl_akhir)}}
                                                                </h4>
                                                                <h4 v-else>: 
                                                                    {{tglAkhir(show.tgl_mulai)}}
                                                                </h4>
                                                                <h4>: {{show.ketua_panitia}}</h4>
                                                            </div>
                                                            <textarea v-model="show.deskripsi" cols="78" rows="15" class="form-control" readonly></textarea>
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
            </div>
        </section>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    data(){
        return {
            show: {
                nama_event: '',
                ketua_panitia: '',
                tgl_mulai: '',
                tgl_akhir: '',
                deskripsi: ''
            },
            event: []
        }
    },
    mounted(){
        this.getData()
    },
    methods: {
        tglMulai(tgl_mulai){
            return moment(tgl_mulai).format('DD MMMM');
        },
        tglAkhir(tgl_akhir){
            return moment(tgl_akhir).format('DD MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/event')
            .then(r => {
               console.log(r);
               this.event = r.data.events;
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
            axios.get(`api/event/${id}`)
            .then(r => {
                console.log(r);
                this.show = r.data.events
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
