@extends('main')

@section('extra_styles')

<link rel="stylesheet" href="{{asset('chart.js/dist/Chart.min.css')}}">

<style>
    .card-baris-atas {
        min-height:400px;
    }

    .card-baris-tengah {
        min-height:450px;
    }
</style>
    
@endsection

@section('content')
<div id="vue" class="wrapper wrapper-content animated fadeInRight tootltip-demo" v-cloak>

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>
                        Grafik Penjualan
                    </h3>
                    <div class="ibox-tools">
                        <vue-picker :disabled="isLoading" :range="true" v-model="date_temp" format="DD/MM/YYYY" @input="resourcePCabang"></vue-picker>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="text-center" v-if="isLoading">
                        Sedang Mengambil Data..
                    </div>
                    <div v-else-if="isError" class="text-center">
                        
                        <i class="fa fa-info-circle" style="font-size: 20pt"></i>
                        <p>Sedang terjadi kesalahan, silahkan coba kembali</p>

                        <button class="btn btn-primary btn-block" @click="resourcePCabang()">Coba Kembali</button>

                    </div>
                    <div v-show="!isLoading">
                        <canvas id="chartPenjualan" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>
                        Grafik Arus Kas
                    </h3>
                    <div class="ibox-tools">
                        <vue-picker :disabled="isLoading3" :range="true" v-model="date_temp2" format="DD/MM/YYYY" @input="resourceArusKas"></vue-picker>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="text-center" v-if="isLoading3">
                        Sedang Mengambil Data..
                    </div>
                    <div v-else-if="isError3" class="text-center">
                        
                        <i class="fa fa-info-circle" style="font-size: 20pt"></i>
                        <p>Sedang terjadi kesalahan, silahkan coba kembali</p>

                        <button class="btn btn-primary btn-block" @click="resourceArusKas()">Coba Kembali</button>

                    </div>
                    <div v-show="!isLoading3">
                        <canvas id="chartArusKas" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>
                        Daftar Hutang Supplier
                    </h3>
                </div>
                <div class="ibox-content">
                    <div class="text-center" v-if="isLoading4">
                        Sedang Mengambil Data..
                    </div>
                    <div v-else-if="isError4" class="text-center">
                        
                        <i class="fa fa-info-circle" style="font-size: 20pt"></i>
                        <p>Sedang terjadi kesalahan, silahkan coba kembali</p>

                        <button class="btn btn-primary btn-block" @click="resourceHutang()">Coba Kembali</button>

                    </div>
                    <div v-show="!isLoading4">
                        <input type="text" class="form-control" v-model="filterHutang" placeholder="Cari Data Hutang Disini Yaa...">
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="1%">No.</th>
                                        <th>Nama Supplier</th>
                                        <th>Tanggal Invoice</th>
                                        <th>Sisa Hutang</th>
                                        <th>Tgl. Jatuh Tempo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="listHutang.length == 0">
                                        <td colspan="5" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                    <tr v-else-if="listHutang.length != 0 && listHutangFiltered.length == 0">
                                        <td colspan="5" class="text-center">Data Yang Dicari Tidak Ditemukan</td>
                                    </tr>
                                    <tr v-else v-for="(data, index) in listHutangFiltered">
                                        <td class="text-center">@{{index + 1}}</td>
                                        <td>@{{data.payable?.supplier?.s_name ?? '-'}}</td>
                                        <td>@{{humanizeDate(data.date)}}</td>
                                        <td class="text-right">@{{humanizePrice(data.remaining_debt)}}</td>
                                        <td>@{{humanizeDate(data.due_date)}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total Hutang</th>
                                        <th class="text-right">@{{humanizePrice(totalSubCustom(listHutang, 'remaining_debt'))}}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>
                        Daftar Piutang Customer
                    </h3>
                </div>
                <div class="ibox-content">
                    <div class="text-center" v-if="isLoading5">
                        Sedang Mengambil Data..
                    </div>
                    <div v-else-if="isError5" class="text-center">
                        
                        <i class="fa fa-info-circle" style="font-size: 20pt"></i>
                        <p>Sedang terjadi kesalahan, silahkan coba kembali</p>

                        <button class="btn btn-primary btn-block" @click="resourceHutang()">Coba Kembali</button>

                    </div>
                    <div v-show="!isLoading5">
                        <input type="text" class="form-control" v-model="filterPiutang" placeholder="Cari Data Piutang Disini Yaa...">
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="1%">No.</th>
                                        <th>Nama Customer</th>
                                        <th>Tanggal Invoice</th>
                                        <th>Sisa Piutang</th>
                                        <th>Tgl. Jatuh Tempo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="listPiutang.length == 0">
                                        <td colspan="5" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                    <tr v-else-if="listPiutang.length != 0 && listPiutangFiltered.length == 0">
                                        <td colspan="5" class="text-center">Data Yang Dicari Tidak Ditemukan</td>
                                    </tr>
                                    <tr v-else v-for="(data, index) in listPiutangFiltered">
                                        <td class="text-center">@{{index + 1}}</td>
                                        <td>@{{data.payable?.customer?.cs_name ?? '-'}}</td>
                                        <td>@{{humanizeDate(data.date)}}</td>
                                        <td class="text-right">@{{humanizePrice(data.remaining_debt)}}</td>
                                        <td>@{{humanizeDate(data.due_date)}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total Piutang</th>
                                        <th class="text-right">@{{humanizePrice(totalSubCustom(listPiutang, 'remaining_debt'))}}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>
                        Daftar Stok Item Dibawah Minimal Stok
                    </h3>
                </div>
                <div class="ibox-content">
                    <div class="text-center" v-if="isLoading2">
                        Sedang Mengambil Data..
                    </div>
                    <div v-else-if="isError2" class="text-center">
                        
                        <i class="fa fa-info-circle" style="font-size: 20pt"></i>
                        <p>Sedang terjadi kesalahan, silahkan coba kembali</p>

                        <button class="btn btn-primary btn-block" @click="resourceMStok()">Coba Kembali</button>

                    </div>
                    <template v-else>

                        <div class="mb-2">
                            <input type="text" class="form-control" v-model="filterMinStok" placeholder="Cari Nama Item Disini Yaa...">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Item</th>
                                        <th width="">Stok</th>
                                        <th width="">Minimal Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="minimal_stok.length == 0">
                                        <td colspan="3" class="text-center">Tidak Ada Item Dibawah Minimal Stok</td>
                                    </tr>
                                    <tr v-if="minimal_stok.length != 0 && minimal_stok_filtered.length == 0">
                                        <td colspan="3" class="text-center">Item Yang Dicari Tidak Ada</td>
                                    </tr>
                                    
                                    <tr v-else v-for="(data, index) in minimal_stok_filtered">
                                        <td>@{{data.i_name}}</td>
                                        <td class="text-center" v-if="data.stocks.length != 0">@{{humanizePrice(data.stocks[0].qty)}}</td>
                                        <td class="text-center text-danger font-weight-bold">@{{humanizePrice(data.i_min_stock_qty)}}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
    </div>


</div>
@endsection

@section('extra_scripts')
<script src="{{asset('chart.js/dist/Chart.bundle.min.js')}}"></script>
<script>

    var vue = new Vue({
        el:'#vue',
        data:{
            isLoading:false,
            isError:false,

            isLoading2:false,
            isError2:false,

            isLoading3:false,
            isError3:false,
            
            isLoading4:false,
            isError4:false,

            isLoading5:false,
            isError5:false,

            isSendRequest:false,
            company_id:'{{Auth::user()->uc_company_id}}',
            company_name:'{{Auth::user()->company->c_name}}',
            
            date:[],
            date_temp:[],
            
            date2:[],
            date_temp2:[],

            penjualan:{
                outlet:[],
                cabang:[],
            },

            arus_kas:[],

            minimal_stok:[],

            filterMinStok:'',
            stok_minimal:[],

            filterHutang:'',

            listHutang:[],

            filterPiutang:'',
            listPiutang:[],
            
        },
        computed:{
            minimal_stok_filtered:function(){
                let reg = new RegExp(this.filterMinStok.toLowerCase());
                let l = this.minimal_stok.filter((e) => reg.test(e.i_name?.toLowerCase()));

                return l;
            },
            listHutangFiltered:function(){
                let reg = new RegExp(this.filterHutang.toLowerCase());

                let l = this.listHutang.filter((e) => reg.test(e.payable?.supplier?.s_name?.toLowerCase() ?? '') || reg.test(this.humanizeDate(e.date.toLowerCase())) || reg.test(this.humanizeDate(e.due_date.toLowerCase())) || reg.test(e.remaining_debt));

                return l;
            },
            listPiutangFiltered:function(){
                let reg = new RegExp(this.filterPiutang.toLowerCase());

                let l = this.listPiutang.filter((e) => reg.test(e.payable?.customer?.cs_name?.toLowerCase() ?? '') || reg.test(this.humanizeDate(e.date.toLowerCase())) || reg.test(this.humanizeDate(e.due_date.toLowerCase())) || reg.test(e.remaining_debt));

                return l;
            },
        },
        updated: function() {
            $('[data-toggle=tooltip]').tooltip();
            $('.slimscroll').slimScroll({
                height: '100%',
                start: 'top',
                alwaysVisible: false
            });
        },
        mounted:function(){
            let D = new Date();
            let y = D.getFullYear();
            let m = D.getMonth();// 0-11
            let d = D.getDate();// 0-31

            let Df = new Date(y, m , 1);
            let yf = Df.getFullYear();
            let mf = Df.getMonth();
            let df = Df.getDate();

            let De = new Date(y, m + 1 , 0);
            let ye = De.getFullYear();
            let me = De.getMonth();
            let de = De.getDate();

            let start_date = this.addPreZero(df) + '/' + this.addPreZero(mf + 1)  + '/' +  yf ;
            let start_temp = this.addPreZero(df) + '/' + this.addPreZero(mf + 1)  + '/' +  yf ;
            let end_date = this.addPreZero(de) + '/' + this.addPreZero(me + 1) + '/' + ye  ;
            let end_temp = this.addPreZero(de) + '/' + this.addPreZero(me + 1) + '/' + ye  ;

            this.date = [];
            this.date_temp = [];
            
            this.date2 = [];
            this.date_temp2 = [];

            this.date.push(start_date);
            this.date.push(end_date);

            this.date_temp.push(start_date);
            this.date_temp.push(end_date);

            this.date2.push(start_date);
            this.date2.push(end_date);

            this.date_temp2.push(start_date);
            this.date_temp2.push(end_date);

            this.resourcePCabang();
            this.resourceMStok();
            this.resourceArusKas();
            this.resourceHutang();
            this.resourcePiutang();
        },
        methods:{
            totalSubCustom:function(array, key){
                let t = 0;

                array.forEach(e => {
                    let angka = 0;
                    if(isFinite(e[key])){
                        angka = e[key];
                    }
                    t += angka;
                });

                return t;
            },
            filterPenjualan:function(){
                this.date_temp = this.date;
                
                $('#modal-filter-penjualan').modal('show');
            },
            filterArusKas:function(){
                this.date_temp2 = this.date2;
                
                $('#modal-filter-aruskas').modal('show');
            },
            addPreZero:function(angka){

                let ang = parseInt(angka);
                if(angka < 10){
                    ang = '0' + ang;
                }

                return ang;

            },
            resourcePiutang:function(){
                this.isLoading5 = true;
                this.isError5 = false;

                axios.all([
                    axios.get('{{url("api/finance/payment-management/invoicing/report")}}',{
                        params:{
                            'type':'receivable',
                            'status':'unpaid',
                        }
                    }),
                ]).then(
                    axios.spread((e1) => {
                        
                        this.listPiutang = e1.data.data;

                    })
                ).catch((error) => {

                    this.isError5 = true;

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

                    this.isLoading5 = false;

                });
            },
            resourceHutang:function(){
                this.isLoading4 = true;
                this.isError4 = false;

                axios.all([
                    axios.get('{{url("api/finance/payment-management/invoicing/report")}}',{
                        params:{
                            'type':'debt',
                        }
                    }),
                ]).then(
                    axios.spread((e1) => {
                        
                        this.listHutang = e1.data.data;

                    })
                ).catch((error) => {

                    this.isError4 = true;

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

                    this.isLoading4 = false;

                });
            },
            resourcePCabang:function(){
                this.isLoading = true;
                this.isError = false;
                $('#modal-filter-penjualan').modal('hide');
                this.date = this.date_temp;
                let sd = '', ed = '';

                for (let i = 0; i < this.date.length; i++) {
                    const el = this.date[i];

                    if(i == 0){
                        let temp = el.split('/');

                        sd = temp[2] + '-' + temp[1] + '-' + temp[0];
                    }

                    if(i == 1){
                        let temp = el.split('/');

                        ed = temp[2] + '-' + temp[1] + '-' + temp[0];

                    }

                }

                axios.all([
                    axios.get('{{url("api/sales/report/chart/daily-in-month")}}',{
                        params:{
                            'start_date':sd,
                            'end_date':ed,
                            'company_id':this.company_id,
                        }
                    }),
                    axios.get('{{url("api/sales/report/chart/daily-in-month")}}',{
                        params:{
                            'start_date':sd,
                            'end_date':ed,
                            'parent_company_id':this.company_id,
                        }
                    }),
                ]).then(
                    axios.spread((e1, e2) => {
                        
                        this.penjualan.cabang = e1.data.data;

                        this.penjualan.outlet = e2.data.data;

                        let dataSets1 = {
                            label:this.company_name,
                            data:[],
                            backgroundColor:'rgba(243, 245, 39, 0.8)',
                            borderColor:'rgba(145, 146, 39, 0.8)',
                            
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointRadius: 2,
                            pointHitRadius: 5,
                            pointBorderWidth: 1,
                            lineTension: 0.3,
                            pointStyle: 'circle'
                        }, 
                        dataSets2 = {
                            label:'Seluruh Outlet',
                            data:[],
                            backgroundColor:'rgba(223, 152, 84, 0.8)',
                            borderColor:'rgba(146, 91, 39, 0.8)',
                            
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointRadius: 2,
                            pointHitRadius: 5,
                            pointBorderWidth: 1,
                            lineTension: 0.3,
                            pointStyle: 'circle'

                        };

                        let label = [],data1 = [], data2 = [];

                        for(let i = 0; i<(this.penjualan.cabang?.sales_daily?.length ?? 0);i++){
                            let d = this.penjualan.cabang.sales_daily[i];

                            label.push(this.humanizeDate(d.full_date));
                            data1.push(d.total_sales);
                        }

                        for(let i = 0; i<(this.penjualan.outlet?.sales_daily?.length ?? 0 );i++){
                            let d = this.penjualan.outlet.sales_daily[i];
                            
                            data2.push(d.total_sales);
                        }

                        dataSets1.data = data1;

                        dataSets2.data = data2;

                        console.log(dataSets1);
                        console.log(dataSets2);
                                    
                    let chartKu = document.getElementById('chartPenjualan');
                        let myChart = new Chart(chartKu, {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [
                                    dataSets1,
                                    dataSets2
                                ]
                            },
                            options: {
                                responsive: true,
                                tooltips: {
                                    mode: 'index',
                                    intersect: true,
                                    callbacks: {
                                        label:  (tooltipItem, data) => {
                                            // var val = data.datasets[tooltipItem.datasetIndex].label;
                                            return 'Total ' + this.humanizePrice(tooltipItem.yLabel);
                                        },
                                    },
                                },
                                legend: {
                                    position: 'top',
                                },
                                hover: {
                                    mode: 'nearest',
                                    intersect: true
                                },
                                scales: {
                                    y: {
                                        ticks: {
                                            // Include a dollar sign in the ticks
                                            callback: function(value, index, values) {
                                                return '$' + value;
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        

                    })
                ).catch((error) => {

                    this.isError = true;

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

                    this.isLoading = false;

                });
            },
            
            resourceArusKas:function(){
                this.isLoading3 = true;
                this.isError3 = false;
                $('#modal-filter-aruskas').modal('hide');
                this.date2 = this.date_temp2;
                let sd = '', ed = '';

                for (let i = 0; i < this.date2.length; i++) {
                    const el = this.date2[i];

                    if(i == 0){
                        let temp = el.split('/');

                        sd = temp[2] + '-' + temp[1] + '-' + temp[0];
                    }

                    if(i == 1){
                        let temp = el.split('/');

                        ed = temp[2] + '-' + temp[1] + '-' + temp[0];

                    }

                }

                axios.all([
                    axios.get('{{url("api/keuangan/laporan-keuangan/arus-kas/report")}}',{
                        params:{
                            'start_date':sd,
                            'end_date':ed,
                            // 'company_id':this.company_id,
                        }
                    }),
                ]).then(
                    axios.spread((e1) => {
                        
                        this.arus_kas = e1.data.data;

                        let dataSets1 = {
                            label:'Masuk',
                            data:[],
                            backgroundColor:'rgba(0, 8, 255, 0.8)',
                            borderColor:'rgba(0, 5, 148, 0.8)',
                            
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointRadius: 2,
                            pointHitRadius: 5,
                            pointBorderWidth: 1,
                            lineTension: 0.3,
                            pointStyle: 'circle'
                        }, 
                        dataSets2 = {
                            label:'Keluar',
                            data:[],
                            backgroundColor:'rgba(255, 0, 0, 0.8)',
                            borderColor:'rgba(148, 0, 0, 0.8)',
                            
                            fill: true,
                            pointBackgroundColor: '#fff',
                            pointRadius: 2,
                            pointHitRadius: 5,
                            pointBorderWidth: 1,
                            lineTension: 0.3,
                            pointStyle: 'circle'

                        };

                        let label = [],data1 = [], data2 = [];

                        for(let i = 0; i<this.arus_kas.length;i++){
                            let d = this.arus_kas[i];

                            label.push(this.humanizeDate(d.full_date));
                            data1.push(d.total_debit);
                            data2.push(d.total_kredit);
                        }

                        dataSets1.data = data1;

                        dataSets2.data = data2;

                        console.log(dataSets1);
                        console.log(dataSets2);
                                    
                        let chartKu = document.getElementById('chartArusKas');
                        let myChart = new Chart(chartKu, {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [
                                    dataSets1,
                                    dataSets2
                                ]
                            },
                            options: {
                                responsive: true,
                                tooltips: {
                                    mode: 'index',
                                    intersect: true,
                                    callbacks: {
                                        label:  (tooltipItem, data) => {
                                            // var val = data.datasets[tooltipItem.datasetIndex].label;
                                            return 'Total ' + this.humanizePrice(tooltipItem.yLabel);
                                        },
                                    },
                                },
                                legend: {
                                    position: 'top',
                                },
                                hover: {
                                    mode: 'nearest',
                                    intersect: true
                                },
                                scales: {
                                    y: {
                                        ticks: {
                                            // Include a dollar sign in the ticks
                                            callback: function(value, index, values) {
                                                return '$' + value;
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        

                    })
                ).catch((error) => {

                    this.isError3 = true;

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

                    this.isLoading3 = false;

                });
            },
                     
            resourceMStok:function(){
                this.isLoading2 = true;
                this.isError2 = false;

                axios.all([
                    axios.get('{{url("api/inventory/stock/current-stock")}}',{
                        params:{
                            'under_safety':true,
                        }
                    }),
                ]).then(
                    axios.spread((e1) => {

                        this.minimal_stok = e1.data.data;

                    })
                ).catch((error) => {

                    this.isError2 = true;

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

                    this.isLoading2 = false;

                });
            },
            humanizePrice:function(ini, decimal = false){
                return humanizePrice(ini, decimal);
            },
            humanizeDate:function(date){
                return humanizeDate(date);
            }
        },
        
    })

</script>
    
@endsection
