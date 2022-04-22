
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/logo/navicon.ico') }}">
    <title>Diagnostic - Daftar</title>

    @include('_partials.styles')

    <style type="text/css">
        .row.wrapper{
            background: var(--custom-blue);
            min-height: 550px;
        }

        .row.wrapper .container .login-wrap{
            min-height: 500px;
            max-width: 100%;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0, 0.1);
        }

        .row.wrapper .container .login-wrap .top-content{
            text-align: center;
            margin-bottom: 20px;
        }

        .cursor-info{
            cursor: help;
        }

        label{
            font-size: 12px;
            padding-left: 10px;
            font-weight: 700;
            color: var(--sidebarActiveBg);
        }

        .loginColumns input{
            border: 0px !important;
            background: #f0f0f0 !important;
            height: 45px;
            border-radius: 5px !important;
            font-size: 12px !important;
            font-weight: 600;
            color: var(--custom-blue) !important;
        }

        .form-group {
            margin-top: 20px;
        }

        .app {
            position: relative;
            padding-bottom: 50px;
            min-height: 100vh !important;
        }
    </style>

</head>

<body class="bg-white">
    <div class="row wrapper app" id="vue">
        <div class="container" v-cloak>
            <div class="loginColumns" id="loginsection" style="padding-top: 50px;">
                <div class="login-wrap">
                    <form id="form-data" method="POST">
                    <div class="row">
                        <div class="col-md-12 top-content">
                            <span class="apk-name" style="font-size: 22px; display: block">
                                <img src="{{ asset('img/vec_reg.png') }}" alt="" width="30%">
                            </span>

                            <div style="background: var(--primary); width: 80%; height: 5px; margin: 0 auto; margin-top: 13px;"></div>

                            <span style="display: block; margin-top: 15px; font-size: 15px; color: var(--custom-blue); font-weight: bold;">
                                Daftar Akun Baru
                            </span>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="cursor-info" :style="$v.single.name.$error ? 'color: var(--custom-red)' : ''" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">
                                    * Nama Lengkap
                                </label>

                                <input type="text" :placeholder="isReg ? 'Masukkan Nama' : 'Masukkan Nama'" class="form-control" id="name" name="name" v-model="single.name" tabindex="1">
                            </div>

                            <div class="form-group">
                                <label class="cursor-info" :style="" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">
                                    * Jenis Kelamin
                                </label>

                                <vue-select :options="genders" v-model="single.gender" name="gender"></vue-select>
                            </div>

                            <div class="form-group">
                                <label class="cursor-info" :style="$v.single.bod.$error ? 'color: var(--custom-red)' : ''" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">
                                    * Tanggal Lahir
                                </label>

                                <vue-picker :range="false" format="DD/MM/YYYY" v-model="single.bod" placeholder="Pilih Tanggal" name="bod">
                                </vue-picker>
                            </div>

                            <div class="form-group">
                                <label class="cursor-info" :style="" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">
                                    Alamat Lengkap
                                </label>

                                <input type="text" :placeholder="isReg ? 'Masukkan Alamat Lengkap' : ''" class="form-control" id="address" name="address" v-model="single.address" tabindex="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="cursor-info" :style="$v.single.email.$error ? 'color: var(--custom-red)' : ''" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">
                                    * Email
                                </label>

                                <input type="text" :placeholder="isReg ? 'Masukkan Alamat Email' : 'Masukkan Alamat Email'" class="form-control" id="email" name="email" v-model="single.email" tabindex="1">
                            </div>

                            <div class="form-group" style="position: relative;">
                                <label class="cursor-info" :style="$v.single.password.$error ? 'color: var(--custom-red)' : ''" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">* Password</label>

                                <div class="input-group">
                                    <input :type="!passwordShow ? 'password' : 'text'" name="password" placeholder="Masukkan Password" class="form-control" v-model="single.password" tabindex="2">

                                    <div class="input-group-append" style="width: 50px; text-align: center; background: #f0f0f0; padding: 16px 10px 10px 10px;">
                                        <i class="far fa-eye" style="cursor: help;" v-if="!passwordShow" @mouseover="passwordEvent"></i>
                                        <i class="far fa-eye-slash" style="cursor: help;" @mouseout="passwordEvent" v-else></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center" style="margin-top: 40px;">
                            <button type="submit" class="btn btn-primary btn-sm" style="padding: 8px 30px; font-family: 'Open Sans','sams-serif'; font-size: 11px; font-weight: 600;" @click="submit" :disabled="disabledButton">
                                <template v-if="pageStatus == 'authenticating'">
                                    <span class="loading open-circle" role="status" aria-hidden="true"></span> &nbsp;
                                    Harap Tunggu ...
                                </template>

                                <template v-if="pageStatus == 'standby'">
                                    Simpan & Daftar
                                </template>
                            </button>
                        </div>

                        <a class="btn btn-link btn-sm btn-block mt-3" href="{{route('login')}}">Kembali</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->

    @include('_partials.scripts')
    <script type="text/javascript">
        const { required, minLength, email, requiredIf } = validator;

        let vue = new Vue({
            el      : '#vue',
            data    : {
                pageStatus    : 'standby',
                disabledButton: true,
                isReg         : true,

                passwordShow: false,

                genders: [
                    {
                        id: 'M',
                        text: 'Laki-laki'
                    },
                    {
                        id: 'F',
                        text: 'Perempuan'
                    }
                ],

                single : {
                    name : '',
                    gender: {
                        id: 'M',
                        text: 'Laki-laki'
                    },
                    bod: '',
                    address: '',
                    email   : '{{ old("email") }}',
                    password: ''
                }
            },

            validations: {
                single : {
                    name : {
                        required
                    },
                    bod : {
                        required
                    },
                    email : {
                        required
                    },
                    password : {
                        required:requiredIf(function(e){
                            return this.isReg;
                        }),
                    }
                }
            },

            mounted: function(){
                $('[data-toggle=tooltip]').tooltip();

                setTimeout(() => {
                    this.disabledButton = false;
                }, 500);
            },

            updated: function () {
                $('[data-toggle=tooltip]').tooltip();
            },

            methods: {
                pindahHalaman:function(){
                    this.isReg = !this.isReg;
                },
                passwordEvent: function(){
                    if(this.passwordShow)
                        this.passwordShow = false;
                    else
                        this.passwordShow = true;
                },

                submit: function(evt){
                    evt.preventDefault();
                    evt.stopImmediatePropagation();

                    this.$v.$touch();

                    if(this.$v.$error){
                        toast('Ada Yang Salah Dengan Inputan Anda, (*) Tidak boleh kosong!', 'info');
                        return;
                    }

                    if(this.isReg){

                        this.pageStatus     = 'authenticating'
                        this.disabledButton = true;
                        const params        = new FormData(document.getElementById('form-data'));

                        axios.post("{{ url('/api/auth/register') }}", params)
                            .then(response => {
                                if (response.data.status == 'success') {
                                    toast(response.data.message, 'success');
                                    setTimeout(() => {
                                        window.location.href = "{{route('login')}}";
                                    }, 1000);
                                }
                            })
                            .catch(e => {
                                if (e.response && e.response.status == '401') {
                                    window.location = '{{ Route("dashboard") }}'
                                } else {
                                    let message, title;
                                    if(e.response.data.message == 'User tidak ditemukan'){
                                        message = 'Harap hubungi admin apabila ini adalah sebuah kesalahan';
                                        title   = e.response.data.message;
                                    }else if(e.response.data.message == 'Password salah !'){
                                        message = 'Password salah untuk user '+this.single.email;
                                        title   = e.response.data.message;
                                    }else if(e.response.data.message == 'User tidak terhubung dengan perusahaan manapun, hubungi Admin Sistem Pusat'){
                                        message = 'User '+this.single.email+' belum terhubung dengan cabang manapun. Segera hubungi admin pusat untuk mengatasi masalah ini.';
                                        title   = 'Akses Ditolak';
                                    }

                                    toast(message, e.response.data.status, 5000, 'top-right', title);
                                    // console.log(e.response);
                                }

                                this.pageStatus = 'standby';
                                this.disabledButton = false;

                            }).then(() => {
                                // this.disabledButton = false;
                            });
                    } else {

                        this.pageStatus     = 'authenticating'
                        this.disabledButton = true;
                        const params        = new FormData(document.getElementById('form-data'));
                        axios.post("{{ url('/api/auth/forgot-password') }}", params)
                            .then(e => {

                                if(e.data.status == 'success'){
                                    this.isReg = true;
                                    this.single.email = '';
                                    this.single.password = '';
                                    toast(e.data.message, 'success')
                                }

                            })
                            .catch(error => {
                                if (error.response) {

                                    // Request made and server responded
                                    console.log(error.response.data);
                                    console.log(error.response.status);
                                    console.log(error.response.headers);

                                    let pesan = '';

                                    if(error.response.data.status == 'error'){
                                        pesan = error.response.data.message;
                                    }

                                    let text = 'Error Code : <b>' + error.response.status + '</b>.<br>' + pesan;
                                    toast(text, 'error');

                                    } else if (error.request) {

                                    // The request was made but no response was received
                                    console.log(error.request);
                                    toast(error.request, 'error');

                                    } else {

                                    // Something happened in setting up the request that triggered an Error
                                    console.log('Error', error.message);
                                    toast('Sedang terjadi Kesalahan, silahkan coba lagi', 'error');

                                    }


                            }).then(() => {
                                this.pageStatus = 'standby';
                                this.disabledButton = false;

                            });
                    }
                }
            }
        })
    </script>
</body>
</html>
