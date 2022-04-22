<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>DIAGNOSTIC</title>
        <!-- Favicon-->
        <link rel="shortcut icon" href="{{ asset('assets/logo/navicon.ico') }}">
        <!-- Bootstrap icons-->
        <!-- Google fonts-->
        <!-- Core theme CSS (includes Bootstrap)-->
        @include('_partials.styles')

        <style type="text/css">
            header.masthead {
                background-image: url("{{asset('img/diagnostic-vect.jpg')}}");
                background-attachment: fixed;
                height: 470px;
                background-size: cover;
                background-position: center;
            }

            /* header.masthead:before {
                background-color: black;
            } */

            .personal-detail {
                box-shadow: 0px 0px 10px 0px #0000005e;
                border-radius: 20px !important;
                padding: 15px;
                top: 230px;
            }

            .table-borderless > :not(caption) > * > * {
                border-bottom-width: 0 !important;
                border-top-width: 0 !important;
            }
            .table-borderless > :not(:first-child) {
                border-top-width: 0 !important;
            }

            table.table-question > thead > tr > th {
                border-bottom-width: 1px !important;
                border-top: 0px solid #e7e7e7 !important;
            }
            .table-question > tbody > tr > td {
                vertical-align: middle;
            }
            .ibox-question {
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 1px 1px 20px #80808040
            }
            .content-wrapper {
                margin-top: 130px;
            }
            @media(max-width:991px) {
                .content-wrapper {
                    margin-top: 230px;
                }
            }
        </style>
    </head>
    <body class="" style="background-color: #f3f3f4;">

        <div id="vue" class="pb-5" v-cloak>
            <nav class="navbar navbar-light bg-white static-top">
                <div class="container">
                    <a class="navbar-brand text-primary px-2 d-flex" href="/dashboard"><i class="fa fa-heartbeat"></i>&nbsp;<b>DIAGNOSTIC</b></a>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="">
                        @csrf
                        <a onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="btn btn-sm btn-outline-danger" href="{{ route('auth.logout') }}"><b>LOGOUT</b>&nbsp;&nbsp;<i class="fa fa-sign-out-alt"></i></a>
                    </form>
                    
                </div>
            </nav>
            <!-- Masthead-->
            <header class="masthead pb-0">
                <div class="container position-relative" style="top: 120px;">
                    <div class="row justify-content-start">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="text-left text-white">
                                <!-- Page heading-->
                                <!-- <h1 class="mb-3 text-black" style="text-shadow: 2px 1px 5px white;"><b>Selamat Datang!</b></h1> -->
                                <h1 class="text-primary" style=""> Welcome To </h1>
                                <h1 class="text-primary" style="font-size: 42px;font-weight: bolder;">DIAGNOSTIC</h1>

                                <template v-if="!tesStarting">
                                    <button type="button" @click="tesStarter" class="btn btn-lg btn-outline-primary animated fadeIn infinite rounded-pill">
                                        <template v-if="loadStatus == 'load'">
                                            <span class="loading open-circle" role="status" aria-hidden="true"></span> &nbsp;
                                            Sedang mengambil data
                                        </template>
                                        <template v-else-if="loadStatus == 'ready'">
                                            Lakukan Tes Sekarang &nbsp; <i class="fa fa-arrow-down"></i>
                                        </template>
                                        
                                    </button>
                                </template>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container position-relative bg-white personal-detail p-4">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td width="40%" class="text-danger" style="text-align: left;">
                                            <b>Nama</b>
                                        </td>
                                        <td width="5%" style="text-align: left;">:</td>
                                        <td style="text-align: left;">{{Auth::user()->name}}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="text-danger" style="text-align: left;">
                                            <b>Email</b>
                                        </td>
                                        <td width="5%" style="text-align: left;">:</td>
                                        <td style="text-align: left;">{{Auth::user()->email}}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="text-danger" style="text-align: left;">
                                            <b>Tanggal Lahir</b>
                                        </td>
                                        <td width="5%" style="text-align: left;">:</td>
                                        <td style="text-align: left;">{{date("d M Y", strtotime(Auth::user()->bod))}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td width="40%" class="text-danger" style="text-align: left;">
                                        <b>Umur</b>
                                    </td>
                                    <td width="5%" style="text-align: left;">:</td>
                                    <td style="text-align: left;">{{Auth::user()->age}} Tahun</b></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="text-danger" style="text-align: left;">
                                        <b>Alamat</b>
                                    </td>
                                    <td width="5%" style="text-align: left;">:</td>
                                    <td style="text-align: left;font-size: 10pt;">{{Auth::user()->address}}</td>
                                </tr>
                                <tr>
                                    <td width="40%" class="text-danger" style="text-align: left;">
                                        <b>Riwayat</b>
                                    </td>
                                    <td width="5%" style="text-align: left;">:</td>
                                    <td style="text-align: left;">
                                        <a v-if="pageStatus != 'history'" href="#" class="text-primary" @click="histories">Lihat Riwayat</a>
                                        <a v-else-if="pageStatus == 'history'" href="#" class="text-danger" @click="histories">Tutup Riwayat</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </header>

            <template v-if="pageStatus == 'question'">
                <!-- <div v-if="!tesStarting" class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" @click="tesStarter" class="btn btn-lg btn-primary animated fadeIn infinite rounded-pill text-white">
                                <template v-if="loadStatus == 'load'">
                                    <span class="loading open-circle" role="status" aria-hidden="true"></span> &nbsp;
                                    Sedang mengambil data
                                </template>
                                <template v-else-if="loadStatus == 'ready'">
                                    Lakukan Tes Sekarang &nbsp; <i class="fa fa-arrow-down"></i>
                                </template>
                                
                            </button>
                        </div>
                    </div>
                </div> -->
                <div v-if="tesStarting" class="container animated fadeInUp content-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-8 col-sm-12" style="">
                            <form action="POST" id="form-data">
                                <div class="ibox ibox-question" v-for="(val, idx) in dataPertanyaan">
                                    <div class="ibox-title bg-primary">
                                        <input type="hidden" name="ukp_penyakit_id[]" :value="val.p_id">
                                        <h3>@{{idx+1}}.&nbsp; @{{val.p_nama}}</h3>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-responsive table-borderless table-hover table-question mb-0">
                                            <tbody>
                                                <tr v-for="(value, key) in val.rules">
                                                    <td align="center">
                                                        <input type="checkbox" :name="'ukpd_value['+idx+'][]'" :value="value.g_id">
                                                    </td>
                                                    <td style="vertical-align: center;">
                                                        <input type="hidden" :name="'ukpd_gejala_id['+idx+'][]'" :value="value.g_id">
                                                        @{{value.g_nama}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="ibox-footer d-flex justify-content-end">
                                        <!-- <button class="btn btn-sm btn-outline-primary">Selanjutnya &nbsp;<i class="fa fa-arrow-right"></i></button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-8 col-sm-12" style="">
                                    <div class="w-100 d-flex justify-content-between">
                                        <button type="button" @click="stopTester" class="btn btn-lg btn-rounded btn-outline-secondary" :disabled="disabledButton">
                                        <i class="fa fa-times text-danger"></i>&nbsp;Batal
                                        </button>

                                        <button type="button" @click="simpan" class="btn btn-lg btn-rounded btn-outline-success" :disabled="disabledButton">
                                            <template v-if="loadStatus == 'load'">
                                                <span class="loading open-circle" role="status" aria-hidden="true"></span> &nbsp;
                                                Sedang menyimpan data
                                            </template>
                                            <template v-else-if="loadStatus == 'ready'">
                                                Selesai & Simpan &nbsp; <i class="fa fa-save"></i>
                                            </template>
                                        </button>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </template>

            <template v-else-if="pageStatus == 'history'">
                <div class="container animated fadeInUp content-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-8 col-sm-12" style="">
                            <div class="ibox ibox-question">
                                <div class="ibox-title bg-danger">
                                    <h3>Riwayat Hasil Diagnosa </h3>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-responsive table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>
                                                    No.
                                                </th>
                                                <th>
                                                    Tanggal Tes
                                                </th>
                                                <th>
                                                    Hasil
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="!dataHistories.length">
                                                <td colspan="3" align="center">
                                                    <i class="fa fa-folder-open"></i>&nbsp;
                                                    Anda belum pernah melakukan tes!
                                                </td>
                                            </tr>
                                            <tr v-else-if="dataHistories.length" v-for="(value, key) in dataHistories">
                                                <td align="center">
                                                    @{{key + 1}}
                                                </td>
                                                <td>
                                                    @{{value.is_date}}
                                                </td>
                                                <td>
                                                    <a href="#" class="text-info" @click="getDetail($event, value.uk_id)">
                                                        Lihat Hasil
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            @include('Dashboard::modals')
        </div>
        <!-- Navigation-->
        
        @include('_partials.scripts')

        <script type="text/javascript">
            let vue = new Vue({
                el      : '#vue',
                data    : {

                    tesStarting   : false,
                    loadStatus    : 'ready',
                    disabledButton: false,
                    pageStatus : 'question',
                    dataPertanyaan: [],
                    dataHistories: [],
                    dataDetail: [],

                    single : {

                    }
                },

                mounted: function(){
                    // axios.get("", {
                    //     params: {
                    //         id: '{{Auth::user()->id}}'
                    //     }
                    // })
                    // .then((e) => {
                    //     single = e.data;
                    //     console.log(single);
                    // });
                },

                updated: function () {
                    $('[data-toggle=tooltip]').tooltip();
                },

                computed: {
                    finalResult: function() {
                        let result = {};

                        this.dataDetail.forEach((val, idx) => {
                            let listResult = [];

                            var gejala = val.detail;
                            gejala.forEach((value, index) => {
                                if (value.upkd_value == true) {
                                    listResult.push({
                                        'id' : value.ukp_id,
                                        'bel'  : parseFloat(value.g_bel),
                                        'pls'  : parseFloat(value.g_pls)
                                    });
                                }
                            });


                        });
                    }
                },

                methods: {
                    tesStarter: function() {
                        this.loadStatus = 'load';
                        axios.get("{{route('dashboard.get_pertanyaan')}}")
                        .then(e => {
                            this.dataPertanyaan = e.data;
                            this.tesStarting = true;
                            
                        })
                        .catch((e) => {
                            toast('Segera hubungi developer.', 'error', 5000, 'top-right', 'Terjadi Kesalahan!');
                        })
                        .then((e) => {
                            this.loadStatus = 'ready';
                        })
                    },

                    stopTester: function() {
                        this.tesStarting = false;
                    },

                    simpan: function(e) {
                        this.loadStatus         = 'load';
                        this.disabledButton     = true;
                        const params            = new FormData(document.getElementById('form-data'));
                        axios.post("{{ route('dashboard.store') }}", params)
                        .then((e) => {
                            if (e.data.status == 'success') {
                                toast(e.data.message, 'success', 200, 'top-right', 'Berhasil!');
                            }
                        })
                        .catch((e) => {
                            toast('Segera hubungi developer.', 'error', 5000, 'top-right', 'Terjadi Kesalahan!');
                        })
                        .then((e) => {
                            this.tesStarting = false;
                            this.loadStatus = 'ready';
                            this.disabledButton = false;
                        })
                    },

                    histories: function(e) {
                        if (this.pageStatus == 'question') {
                            this.loadStatus = 'load';
                            this.pageStatus = 'history';
                        }else{
                            this.pageStatus = 'question';
                        }

                        if (this.pageStatus == 'history') {
                            axios.get("{{ route('dashboard.get_histories')}}")
                            .then((e) => {
                                this.dataHistories = e.data;
                            })
                            .catch((e) => {
                                toast('Segera hubungi developer.', 'error', 5000, 'top-right', 'Terjadi Kesalahan!');
                            })
                            .then((e) => {
                                this.loadStatus = 'ready';
                            })
                        }
                    },

                    getDetail: function(e, id) {
                        $context = this.dataHistories.findIndex(x => x.uk_id == id);
                        
                        console.log($context, id);
                        if ($context >= 0) {
                            this.dataDetail = this.dataHistories[$context].penyakit;
                            $('#modalDetailLabel').text('Data Riwayat [' + this.dataHistories[$context].is_date + ']')
                            $('#modalDetail').modal('show');
                            console.log(this.dataDetail);
                        }
                    }
                }
            })
        </script>
    </body>
</html>
