<template>
    <div>
        <section class="content-header">
            <h1>
                User Profile
            </h1>
            <ol class="breadcrumb">
                <li><a href="/#/main"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">User profile</li>
            </ol>
        </section>
        <section class="content">

        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <span v-if="user.pict">
                            <img class="profile-user-img img-responsive img-circle" :src="'images/avatar/'+user.pict" alt="User profile picture">
                        </span>
                        <span v-else>
                            <img class="profile-user-img img-responsive img-circle" src="images/logo_boss.png" alt="User profile picture">
                        </span>
                        <h3 class="profile-username text-center">{{user.name}}</h3>
                        <p class="text-muted text-center">{{user.role}}</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                            <b>NIM</b><h5 class="pull-right">{{user.nim}}</h5>
                            </li>
                            <li class="list-group-item">
                            <b>Username</b><h5 class="pull-right">{{user.username}}</h5>
                            </li>
                            <li class="list-group-item">
                            <b>Email</b><h5 class="pull-right">{{user.email}}</h5>
                            </li>
                        </ul>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <button class="btn btn-primary btn-md" @click="pilihFoto"><i class="fa fa-cloud-upload"></i></button>
                                
                                <input type="file" class="hidden" id="fileFoto" accept="image/*">
                            </label>
                            <input type="text" class="form-control" @click="pilihFoto" 
                            style="cursor: default; caret-color: transparent" readonly="readonly"
                            placeholder="Ganti Foto">
                        </div>
                        <button class="btn btn-primary btn-sm btn-block" style="margin-top: 5px" @click="saveAva">
                            <i class="fa fa-spinner" v-if="isLoadingAva"></i>
                            <i class="fa fa-check" v-else></i>
                            Update Foto Profile
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                <input type="nama" class="form-control" id="inputName" placeholder="Nama" v-model="data.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail" placeholder="Email" v-model="data.email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" placeholder="Username" v-model="data.username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">NIM</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="NIM" v-model="data.nim">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSkills" placeholder="Password" v-model="data.password">
                                    <small>Kosongkan jika tidak ingin mengubah password</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" v-model="data.tgl_lahir">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="form-control" v-model="data.jenis_kelamin">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputExperience" placeholder="Alamat" v-model="data.alamat"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">No Telepon</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputSkills" placeholder="Nomor Telepon" v-model="data.no_telp">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" @click="saveEdit">
                                    <i class="fa fa-spinner" v-if="isLoading"></i>
                                    <i class="fa fa-check" v-else></i>
                                    Submit
                                </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            data:{
                name: '',
                nim: '',
                username: '',
                email: '',
                tgl_lahir: '',
                no_telp: '',
                alamat: '',
                jenis_kelamin: '',
                password: ''
            },
            modal:{
                name: '',
                pict: ''
            },
            form: new FormData(),
            isLoading: false,
            isLoadingAva: false
        }
    },
    mounted(){
        this.checkAuth();
        this.getData();
        this.init();
    },
    computed:{
        ...mapGetters([
            'user'
        ])
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
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/profile/'+this.$route.params.id)
            .then(r => {
                this.data = r.data.users;
            })
            .catch(e => {
                console.log(e);
            })
        },
        saveEdit(){
            this.isLoading = true;
            axios.put('api/profile/'+this.$route.params.id, this.data)
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
                this.isLoading = false;
                console.log(r.data.error);
                console.log('test');
                toast.error('Gagal mengubah data');
            })
        },
        pilihFoto(){
            $('#fileFoto').trigger('click');
        },
        saveAva(){
            this.isLoadingAva = true;
            axios.post('api/profile/avatar',this.form)
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
            })
        }
    }
}
</script>

<style>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
