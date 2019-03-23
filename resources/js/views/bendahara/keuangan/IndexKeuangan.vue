<template>
    <div>
        <section class="content-header">
            <h1>
                Keuangan
                <small>data-data keuangan UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Keuangan</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tambahKeuangan" style="margin-bottom: 10px">
                                <i class="fa fa-plus"></i> Keuangan
                            </button>
                            <a :href="`ketua/keuangan/${user.periode_id}`" class="btn btn-primary" style="margin-bottom: 10px">Download .xls</a>

                            <!-- Modal -->
                            <div class="modal fade" id="tambahKeuangan" tabindex="-1" role="dialog" aria-labelledby="tambahKeuanganLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="tambahKeuanganLabel">Tambah Data Keuangan</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="col-md-12" style="margin-left: -30px">
                                                    <div class="col-md-6">
                                                        <label for="">Jenis</label>
                                                        <select class="form-control" v-model="data.jenis">
                                                            <option value="Debit">Debit</option>
                                                            <option value="Kredit">Kredit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12" style="margin-left: -30px">
                                                    <div class="col-md-6">
                                                        <label for="">Tanggal</label>
                                                        <input type="date" class="form-control" v-model="data.tanggal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12" style="margin-left: -30px">
                                                    <div class="col-md-6">
                                                        <label for="">Nominal</label>
                                                        <input type="number" class="form-control" v-model="data.nominal" placeholder="Masukan nominal (0-9999999)" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">Keterangan</label>
                                                <textarea cols="78" rows="8" class="form-control" v-model="data.keterangan"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <small class="pull-left">Note: Debit = Pemasukan, Kredit = Pengeluaran</small>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" @click="saveKeuangan">
                                                <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                                <i class="fa fa-check" v-else></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                    <th>PJ</th>
                                    <th>Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(f, index) in fund" :key="index">
                                        <td>{{index+1}}</td>
                                        <td v-if="f.tanggal">
                                            {{f.tanggal}}
                                        </td>
                                        <td v-else>
                                            {{format(f.created_at)}}
                                        </td>
                                        <td>{{f.keterangan}}</td>
                                        <td>
                                            Rp. {{f.debit}}
                                        </td>
                                        <td>
                                            Rp. {{f.kredit}}
                                        </td>
                                        <td>
                                            Rp. {{f.saldo}}
                                        </td>
                                        <td>{{f.username}}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKeuangan" @click="editKeuangan(f.id)" v-if="!f.saldo">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSaldo" @click="editKeuangan(f.id)" v-else>
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" @click="deleteKeuangan(f.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="editKeuangan" tabindex="-1" role="dialog" aria-labelledby="editKeuanganLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="editKeuanganLabel">Edit Data {{edit.jenis}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="col-md-12" style="margin-left: -30px">
                                                    <div class="col-md-6">
                                                        <label for="">Jenis</label>
                                                        <select class="form-control" v-model="edit.jenis">
                                                            <option value="debit">Debit</option>
                                                            <option value="kredit">Kredit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12" style="margin-left: -30px">
                                                    <div class="col-md-6">
                                                        <label for="">Tanggal</label>
                                                        <input type="date" class="form-control" v-model="edit.tanggal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12" style="margin-left: -30px">
                                                    <div class="col-md-6">
                                                        <label for="">Nominal</label>
                                                        <input type="number" class="form-control" v-model="edit.nominal" placeholder="Masukan nominal (0-9999999)" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">Keterangan</label>
                                                <textarea cols="78" rows="8" class="form-control" v-model="edit.keterangan"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <small class="pull-left">Note: Debit = Pemasukan, Kredit = Pengeluaran</small>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" @click="saveKeuanganEdit">
                                                <i class="fa fa-spin fa-spinner" v-if="isLoadingKeuangan"></i>
                                                <i class="fa fa-check" v-else></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="editSaldo" tabindex="-1" role="dialog" aria-labelledby="editSaldoLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="editSaldoLabel">Edit Keuangan Bulan {{sld(edit.created_at)}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <span v-if="edit.jenis == 'debit'">
                                                <div class="form-group">
                                                    <label for="">Debit</label>
                                                    <input type="number" class="form-control" v-model="edit.nominal" disabled>
                                                </div>
                                            </span>
                                            <span v-else>
                                                <div class="form-group">
                                                    <label for="">Kredit</label>
                                                    <input type="number" class="form-control" v-model="edit.nominal" disabled>
                                                </div>
                                            </span>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">Keterangan</label>
                                                <textarea cols="78" rows="8" class="form-control" v-model="edit.keterangan"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <small class="pull-left">Note: Debit = Pemasukan, Kredit = Pengeluaran</small>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" @click="saveSaldoEdit">
                                                <i class="fa fa-spin fa-spinner" v-if="isLoadingSaldoEdit"></i>
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
            </div>
        </section>
    </div>
</template>

<script>
import moment from 'moment'
import {mapGetters} from "vuex"
export default {
    data(){
        return{
            table: null,
            data:{
                tanggal: '',
                jenis: '',
                nominal: '',
                keterangan: ''
            },
            saldo:{
                debit: [],
                kredit: [],
                saldo: [],
                keterangan: ''
            },
            edit:{
                tanggal: '',
                jenis: '',
                nominal: '',
                debit: '',
                kredit: '',
                saldo: '',
                keterangan: '',
                created_at: ''
            },
            isLoading: false,
            isLoadingSaldo: false,
            isLoadingKeuangan: false,
            isLoadingSaldoEdit: false,
            fund:[],
            result:''
        }
    },
    mounted(){
        this.getData();
        this.initResult();
    },
    methods: {
        format(created_at){
            return moment(created_at).format('YYYY-MM-DD');
        },
        sld(created_at){
            moment.locale('id');
            return moment(created_at).format('MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/keuangan')
            .then(r => {
               console.log(r);
               this.fund = r.data.funds;
            //    this.result = r.data.results
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
        saveKeuangan(){
            this.isLoading = true
            axios.post('api/keuangan/tambah-keuangan',this.data)
            .then(r => {
                this.data.tanggal = '';
                this.data.jenis = '';
                this.data.nominal = '';
                this.data.keterangan = '';
                this.isLoading = false;
                swal({
                    title: "Berhasil!",
                    text: r.data.message,
                    icon: "success",
                })
                .then((berhasil) => {
                    if(berhasil){
                        this.getData(true);
                    }
                })
            })
            .catch(e => {
                this.isLoading = false;
                console.log(e)
                toast.error('Salah satu kolom tidak boleh kosong!');
            })
        },
        initResult(){
            axios.get('api/keuangan/result')
            .then(r => {
                this.saldo.debit = r.data.debits.debit;
                this.saldo.kredit = r.data.kredits.kredit;
                this.saldo.saldo = r.data.results;
                console.log(r)
            })
            .catch(e => {
                toast.warning('Data saldo bulanan sudah ada pada bulan ini')
            })
        },
        saveSaldo(){
            this.isLoadingSaldo = true
            axios.post('api/keuangan/tambah-saldo',this.saldo)
            .then(r => {
                this.saldo.debit = '';
                this.saldo.kredit = '';
                this.saldo.saldo = '';
                this.saldo.keterangan = '';
                this.isLoading = false;
                if(r.data.message){
                    swal({
                        title: "Berhasil!",
                        text: r.data.message,
                        icon: "success",
                    })
                    .then((berhasil) => {
                        if(berhasil){
                            this.getData(true);
                        }
                    })
                }else if(r.data.error){
                    swal({
                        title: "Gagal!",
                        text: r.data.error,
                        icon: 'info',
                        dangerMode: true
                    })
                    .then((gagal) => {
                        if(gagal){
                            this.getData(true);
                        }
                    })
                }
            })
            .catch(e => {
                this.isLoading = false;
                console.log(e)
                toast.error('Semua kolom tidak boleh kosong!');
            })
        },
        editKeuangan(id){
            axios.get(`api/keuangan/edit/${id}`)
            .then(r => {
                console.log(r);
                this.edit = r.data.funds
            })
            .catch(e => {
                console.log(e)
            })
        },
        saveKeuanganEdit(id){
            swal({
                title: "Apakah anda yakin ingin menyimpan perubahan?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((yes) => {
                if(yes){
                    axios.put('api/keuangan/edit/'+this.edit.id,this.edit)
                    .then(r => {
                        this.edit.jenis = '';
                        this.edit.tanggal = '';
                        this.edit.nominal = '';
                        this.edit.keterangan = '';
                        console.log(r)
                        swal({
                            title: "Berhasil!",
                            text: "Data keuangan berhasil diubah!",
                            icon: "success",
                        })
                        .then((berhasil) => {
                            if(berhasil){
                                this.getData(true);
                            }
                        })

                    })
                    .catch(e => {
                        this.isLoadingKeuangan = false;
                        console.log(e)
                        toast.error('Gagal mengubah data keuangan');
                    })
                }
            })
        },
        saveSaldoEdit(id){
            swal({
                title: "Apakah anda yakin ingin menyimpan perubahan?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((yes) => {
                if(yes){
                    axios.put('api/keuangan/edit/'+this.edit.id,this.edit)
                    .then(r => {
                        this.edit.keterangan = '';
                        console.log(r)
                        swal({
                            title: "Berhasil!",
                            text: "Data saldo berhasil diubah!",
                            icon: "success",
                        })
                        .then((berhasil) => {
                            if(berhasil){
                                this.getData(true);
                            }
                        })

                    })
                    .catch(e => {
                        this.isLoadingSaldoEdit = false;
                        console.log(e)
                        toast.error('Gagal mengubah data saldo');
                    })
                }
            })
        },
        deleteKeuangan(id){
            swal({
                title: 'Apakah anda yakin ingin menghapus data ini ?',
                buttons: true,
                icon: 'info',
                dangerMode: true
            })
            .then(yes => {
                if(yes){
                    axios.delete(`api/keuangan/${id}`)
                    .then(r => {
                        swal({
                            title: "Berhasil!",
                            text: r.data.message,
                            icon: "success",
                        })
                        .then((berhasil) => {
                            if(berhasil){
                                this.getData(true);
                            }
                        })
                    })
                    .catch(e => {
                        console.log(e);
                        toast.error('Gagal menghapus data keuangan yang dipilih');
                    })
                }
            })
        }
    },
    computed:
    {
        ...mapGetters([
            'user'
        ])
    }
}
</script>

<style scoped>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
