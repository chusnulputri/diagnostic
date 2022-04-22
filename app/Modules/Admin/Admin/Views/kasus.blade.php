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
                    <a>Data Kasus Pasien</a>
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
                            <i class="fa fa-heartbeat"></i>&nbsp; Kasus
                        </span>

                        <div class="ibox-tools" style="padding-top:90px; padding-right: 20px;">
                            <button class="btn btn-primary btn-sm dropdown-toggle" style="font-weight:600; font-size: 8pt;" @click="tambahData">
                                Tambah Kasus &nbsp;
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
@endsection
@include('Admin::partials.modal-tambah-kasus')
@include('Admin::partials.modal-edit-Kasus')

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
                            conteks: 'k_id',
                            style: 'text-align: left'
                        },
                        {
                            text: 'Kode Gejala',
                            conteks: 'k_kode_gejala',
                            style: 'text-align: left',
                            overide: function (e) {
                                return e;
                            }
                        },
                        {
                            text: 'Nama Penyakit',
                            conteks: 'k_nama_penyakit',
                            style: 'text-align: left'
                        },
                        {
                            text: 'Kategori',
                            conteks: 'k_kategori',
                            style: 'text-align: left'
                        },
                        {
                            text: 'Persentase',
                            conteks: 'k_skor',
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
                
                axios.get("{{Route('admin.get_data_kasus')}}")
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
                $('#modalTambahKasus').modal('show');
            },

            editData: function() {
                $('#modalEditKasus').modal('show');
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

 $(document).on('click', '.edit-kasus', function(){
        
        $.ajax({
            method: "GET",
            url: $(this).attr('data-url'),
            success: function(response){
                let kasus = response.data;
                $('#modalEditKasus').modal('show');
                $('[name="k_kode_gejala"]').val(kasus.k_kode_gejala);
                $('[name="k_nama_penyakit"]').val(kasus.k_nama_penyakit);
                $('[name="k_kategori"]').val(kasus.k_kategori);
                $('[name="k_skor"]').val(kasus.k_skor);
                $('#formUpdatKasus').attr('action', response.update_url)
            }
        });
    });

</script>
@endsection