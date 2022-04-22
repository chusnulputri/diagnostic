
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/logo/res-navicon.ico') }}">
    <title>Bubur Onic - Management System</title>

    @include('_partials.styles')

    <style type="text/css">
        .row.wrapper{
            background: var(--custom-blue);
            min-height: 550px;
        }

        .row.wrapper .container .login-wrap{
            min-height: 500px;
            width: 350px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0, 0.1);
        }

        .row.wrapper .container .login-wrap .top-content{
            text-align: center;
        }

        .cursor-info{
            cursor: help;
        }

        label{
            font-size: 12px;
            padding-left: 10px;
            font-weight: 700;
            color: var(--sidebarActiveBg);
            font-family: 'Open Sans','sams-serif';
        }

        .loginColumns input{
            border: 0px !important;
            background: #f0f0f0 !important;
            height: 45px;
            border-radius: 5px !important;
            font-size: 12px !important;
            font-weight: 600;
            color: var(--custom-blue) !important;
            font-family: 'Open Sans','sams-serif';
        }
    </style>  

</head>

<body>
    <div>
        <div class="row wrapper" id="vue">
            <div class="container" v-cloak>
                <div class="loginColumns" id="loginsection" style="padding-top: 50px;" v-cloak>
                    <div class="login-wrap">
                        <form id="form-data" action="#" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="true">
                        <input type="hidden" name="tokenKeranjang" v-model="localStorage" readonly="true">
                        
                        <div class="row" v-cloak>
                            <div class="col-md-12 top-content">                                    
                                <span class="apk-name" style="font-size: 22px; display: block">
                                    <img src="{{ asset('assets/logo/res-logo.png') }}" alt="" width="30%">
                                </span>

                                <div style="background: var(--primary); width: 80%; height: 5px; margin: 0 auto; margin-top: 13px;"></div>

                                <span style="display: block; margin-top: 15px; font-family: 'Open Sans', sans-serif; font-size: 15px; color: var(--custom-blue); font-weight: bold;">
                                    Login Akun
                                </span>
                            </div>

                            <div class="col-md-12" style="margin-top: 40px;">
                                <div class="form-group">
                                    <label class="cursor-info" :style="$v.single.u_username.$error ? 'color: var(--custom-red)' : ''" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">* Username atau Email</label>

                                    <input type="text" placeholder="Masukkan Username atau Email" class="form-control" id="u_username" name="u_username" v-model="single.u_username" tabindex="1">
                                </div>

                                <div class="form-group" style="margin-top: 30px; position: relative;">
                                    <label class="cursor-info" :style="$v.single.u_password.$error ? 'color: var(--custom-red)' : ''" data-toggle="tooltip" data-placement="top" data-title="Tidak Boleh Kosong">* Password / Kode Unik</label> 

                                    <a href="#" style="position: absolute; top: 2px; right: 8px; font-size: 10px;">Lupa Password ?</a>
                                    
                                    <div class="input-group">
                                        <input :type="!passwordShow ? 'password' : 'text'" name="u_password" placeholder="Masukkan Password / Kode Unik" class="form-control" v-model="single.u_password" tabindex="2">

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

                                    <template v-else>
                                        Login Ke Akun Anda
                                    </template>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('_partials.footer')
    </div>

    <!-- Mainly scripts -->

    @include('_partials.scripts')

    <script type="text/javascript">
        const { required, minLength, email } = validator;

        let vue = new Vue({
            el      : '#vue',
            data    : {
                pageStatus      : 'standby',
                disabledButton  : true,
                
                passwordShow    : false,
                localStorage    : localStorage.getItem('keranjang'),

                single : {
                    u_username : '{{ old("u_username") }}',
                    u_password : ''
                }
            },

            validations: {
                single : {
                    u_username : { required },
                    u_password : { required }
                }
            },

            mounted: function(){
                $('[data-toggle=tooltip]').tooltip();

                setTimeout(() => {
                    document.getElementById('u_username').focus();
                    this.disabledButton = false;

                    @if(Session::has("notif"))
                        toast('{{ Session::get("notif") }}', 'error');
                    @endif
                }, 500);
            },
            
            updated: function () {
                $('[data-toggle=tooltip]').tooltip();
            },

            methods: {
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
                        toast('Ada Yang Salah Dengan Inputan Anda', 'info');
                        return;
                    }

                    this.pageStatus     = 'authenticating'
                    this.disabledButton = true;

                    document.getElementById('form-data').submit();
                }
            }
        })
    </script> 
</body>
</html>
