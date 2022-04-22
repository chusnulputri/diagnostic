@extends('main')
@section('content')
<div id="vue">
    @include('Admin::partials.modal')
    <div class="row wrapper border-bottom white-bg page-heading" style="padding: 15px 8px;">
        <div class="col-lg-8" style="color: #757575;">
            <ol class="breadcrumb" style="font-size: 9pt;">
                <li class="breadcrumb-item">
                    <a href="{{url('/')}}">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <a>Data Diagnosa</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-4 text-right">
            <!-- <a href="javascript:void(0)" class="text-info">
                <i class="fa fa-info-circle"></i> &nbsp;
                Pusat Bantuan
            </a> -->
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight tootltip-demo" v-cloak>
        <div class="row" v-if="pageStatus == 'page-load'">
            <div class="col-md-12 loading-state">
                <div class="load-bar" style="height: 40px;"></div>
            </div>

            <div class="col-md-12 loading-state mt-2">
                <div class="load-bar"></div>
            </div>

            <div class="col-md-2 loading-state" v-for="a in 6">
                <div class="load-bar" v-for="a in 3"></div>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col-md-12" style="padding: 0px 10px">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="border-top-left-radius: 10px; border-top-right-radius: 10px; padding: 20px 30px; border: 0px; border-bottom: 2px solid #f5f5f5;">
                        <span style="font-size: 16pt; font-weight: 600; color: var(--sidebarActiveBg);">
                            <i class="fa fa-laptop-medical"></i>&nbsp; HASIL DIAGNOSA
                        </span>

                        <div class="ibox-tools" style="padding-top: 10px; padding-right: 20px;">
                            <button class="btn btn-primary btn-sm dropdown-toggle" style="font-weight: 600; font-size: 8pt; padding: 10px 20px;" @click="getServerData">
                                Refresh &nbsp;
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>

                    </div>
                    <div class="ibox-content" style="padding-top: 20px; border: 0px;">
                        <input type="hidden" name="perusahaan" value="">
                        <vue-datatable :config="tableData" :on_ajax="pageStatus == 'table-load'" :download="false">


                        </vue-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@csrf
@endsection

@section('extra_scripts')
<script>
    const vue = new Vue({
        el    : '#vue',
        data  : {
            pageStatus  : 'page-load',

            tableData: {
                feeder: {
                    column: [
                        {
                            text: 'Nama User',
                            conteks: 'name',
                            style: 'text-align: left'
                        },
                        {
                            text: 'Tanggal Tes',
                            conteks: 'uk_date',
                            style: 'text-align: left',
                            overide: function (e) {
                                return e;
                            }
                        },
                        {
                            text: 'Nama Gangguan',
                            conteks: 'p_nama',
                            style: 'text-align: left'
                        },
                        {
                            text: 'Hasil',
                            conteks: 'ukp_hasil',
                            style: 'text-align: center !important;'
                        },
                        {
                            text: 'Detail',
                            conteks: 'ukp_id',
                            style: 'text-align: center !important;',
                            overide: function (e) {
                                return '<a href="javascript:void(0);" onclick="vue.detail(' + e + ')">Lihat Detail</a>';
                            }
                        },
                        {
                            text: 'Aksi',
                            conteks: 'aksi',
                            style: 'text-align: center'
                        },
                    ],

                    data: []
                },
                addition: {
                    customButton: [{
                        html: ``
                    }]
                },
                config: {
                    title: 'Data Divisi',
                    dataPerPage: 10,
                }
            },

            dataDetail: [],

            single: {
                p_nama   : '',
                ukp_skor : '',
                ukp_hasil: ''
            }

        },

        mounted: function(){
            this.getServerData();
        },

        updated: function(){
            $('[data-toggle = tooltip]').tooltip();

            $('.slimscroll').slimScroll({
                height: '100%',
                start: 'top',
                alwaysVisible: false
            });
        },

        methods: {
            getServerData: function(){
                this.pageStatus = 'table-load';
                
                axios.get("{{Route('admin.get_data_diagnosa')}}")
                    .then(response => {
                        this.tableData.feeder.data = response.data.data;

                        this.pageStatus = 'standby'
                        
                    })
                    .catch(e => {
                        if (e.response && e.response.status == '401') {
                            window.location = '{{ Route("dashboard") }}'
                        } else {
                            toast(e.response.data.status, e.response.data.status, 5000, 'top-right', 'Terjadi Kesalahan');
                        }

                        this.pageStatus = 'standby';

                    }).then(() => {
                        this.disabledButton = false;
                    });
            },

            detail: function(id) {
                const index = this.tableData.feeder.data.findIndex(e => e.ukp_id == id);

                if (index >= 0) {
                    let context = this.tableData.feeder.data[index];
                    this.dataDetail = context.detail;
                    this.single.p_nama = context.p_nama;
                    this.single.ukp_skor = context.ukp_skor;
                    this.single.ukp_hasil = context.ukp_hasil;

                    $('#modal-detail').modal('show');
                }else{
                    toast('Terjadi kesalahan, data tidak ditemukan.', 'error', 5000, 'top-right', 'Not Found!');
                }
            },

            humanizeDate: function(str, format){
                return humanizeDate(str, format)
            },
        }
    })
</script>
@endsection