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
                    <a>Data Penyakit</a>
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
                            <i class="fa fa-file-medical"></i>&nbsp; Penyakit
                        </span>

                        <!-- <div class="ibox-tools" style="padding-top: 10px; padding-right: 20px;">
                            <button class="btn btn-primary btn-sm dropdown-toggle" style="font-weight: 600; font-size: 8pt; padding: 10px 20px;" @click="getServerData">
                                Refresh &nbsp;
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div> -->

                        <div class="ibox-tools" style="padding-top:90px; padding-right: 20px;">
                            <button class="btn btn-primary btn-sm dropdown-toggle" style="font-weight:600; font-size: 8pt;" @click="tambahData">
                                Tambah &nbsp;
                                <i class="fa fa-plus-square"></i>
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
@include('Admin::partials.modal-tambah-penyakit')
@include('Admin::partials.modal-edit-penyakit')
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
                            text: 'ID',
                            conteks: 'p_id',
                            style: 'text-align: left'
                        },
                        {
                            text: 'Kode',
                            conteks: 'p_kode',
                            style: 'text-align: left',
                            overide: function (e) {
                                return e;
                            }
                        },
                        {
                            text: 'Nama Penyakit',
                            conteks: 'p_nama',
                            style: 'text-align: left'
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
                
                axios.get("{{Route('admin.get_data_penyakit')}}")
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

            tambahData: function() {
                $('#modalTambahPenyakit').modal('show');
            },

            editData: function() {
                $('#modalEditPenyakit').modal('show');
            },

            detail: function(id) {
                const index = id;
                let context = this.tableData.feeder.data[index];
                this.dataDetail = context.detail;
                this.single.p_nama = context.p_nama;
                this.single.ukp_skor = context.ukp_skor;
                this.single.ukp_hasil = context.ukp_hasil;

                $('#modal-detail').modal('show');
                if (index >= 0) {
                    
                }else{
                    toast('Terjadi kesalahan, data tidak ditemukan.', 'error', 5000, 'top-right', 'Not Found!');
                }
            },

            humanizeDate: function(str, format){
                return humanizeDate(str, format)
            },
        }
    })

         $(document).on('click', '.edit-penyakit', function(){
        
        $.ajax({
            method: "GET",
            url: $(this).attr('data-url'),
            success: function(response){
                let penyakit = response.data;
                $('#modalEditPenyakit').modal('show');
                $('[name="p_kode"]').val(penyakit.p_kode);
                $('[name="p_nama"]').val(penyakit.p_nama);
                $('#formUpdatePenyakit').attr('action', response.update_url)
            }
        });
    });

</script>
@endsection