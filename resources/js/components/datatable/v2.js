import './style.css';
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;

export default {
  data(){
    return {
        // page variable
          page          : 1,
          showPerPage   : 10,
          totalPages    : 1,
          search        : '',

        // table variable
          head          : [],
          data          : [],

        // sort
          sortBy: 'none',
          order: 'asc',

    }
  },
  props:{
    download:{
        type: Boolean,
        default: true,
    },
    config: {
      type: Object,
      required: true,
    },

    on_ajax : {
      type: Boolean,
      required: true,
    }
  },
  created: function(){

  },
  mounted: function(){
    this.head   = this.config.feeder.column;

    if(this.config.feeder.data.length){
      this.setTotalPages(this.data_computed);
      this.setDataTable(this.data_computed);
    }
  },
  watch: {
    data_computed: {
        handler: function (e) {
            this.setTotalPages(e);
            this.setDataTable(e);
        },
        deep: true
    },

    search : function(e){
        this.setDataTable(this.data_computed);
    },

    showPerPage: function(){
      this.setTotalPages(this.data_computed);
      this.setDataTable(this.data_computed);
    },

    page: function(){
      this.setDataTable(this.data_computed);
    }
  },
  computed:{
      data_computed: function(){
          let response = [];
          let conteks = [];

          this.config.feeder.data.forEach((data, idx) => {
            let dta = [];
            this.config.feeder.column.forEach((column, idx) => {
              if(column.overide){
                dta.push(column.overide(data[column.conteks]))
                // console.log(data[column.conteks]);
              }else{
                if(typeof data[column.conteks] === 'string'){
                  dta.push(data[column.conteks])
                }else{
                  dta.push('[Object object]')
                }
              }
            });

            response.push(dta)
          });

          // response.forEach((tr, idx) => {
          //   if(idx == 4){
          //     let tmp = document.createElement("DIV");
          //     tmp.innerHTML = tr;
          //   }
          // })


          // search data
            response = response.filter((o) => {
                let tmp = document.createElement("DIV");
                tmp.innerHTML = o;

                let word = tmp.textContent.replace(/ +(?= )/g,'').replace(/(\r\n|\n|\r)/gm, "") || tmp.innerText.replace(/ +(?= )/g,'').replace(/(\r\n|\n|\r)/gm, "") || ""

                if(o && word.toString().toUpperCase().includes(this.search.toUpperCase())){
                    return o;
                }
            })

          // sort data
            if(this.order != ''){
              if(this.order == 'asc'){
                response = response.sort((a, b) =>  {
                    var x = a[this.sortBy]; var y = b[this.sortBy];
                    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
                });
              }else{
                response = response.sort((a, b) => {
                    var x = a[this.sortBy]; var y = b[this.sortBy];
                    return ((x > y) ? -1 : ((x < y) ? 1 : 0));
                });
              }
            }
          
          return response;
      }
  },
  methods:{
    setTotalPages: function(data){
      let numberOfPages = Math.ceil(data.length / this.showPerPage);

      this.totalPages = numberOfPages;
    },

    setDataTable: function(data){
      let page = this.page;
      let showPerPage = this.showPerPage;
      let from = (page * showPerPage) - showPerPage;
      let to = (page * showPerPage);

      this.data = data.slice(from, to);
    },

    sortMe: function(key){

      if(key == this.sortBy){
        if(this.order == 'asc'){
          this.order = 'desc';
        }
        else if(this.order == 'desc'){
          this.order = '';
        }else{
          this.order = 'asc';
        }

      }else{
        this.order = 'asc';
        this.sortBy = key;
      }
    },

    nextPage: function(data){
      if(this.page == this.totalPages)
        return false;

      this.page++;
    },

    previousPage: function(data){
      if(this.page <= 1)
        return false;

      this.page--;
    },

    exportExcel: function(evt) {
      evt.preventDefault();
      evt.stopImmediatePropagation();

      let CsvString = "";
      let x = document.createElement("A");
      let title = (this.config.config.title) ? this.config.config.title+'.csv' : 'data.csv';

      this.config.feeder.column.forEach((header, alpha) => {
          if(header.printable !== false){
            CsvString += header.text + ',';
          }
      });

      CsvString += '\r\n';

      this.config.feeder.data.forEach((data, alpha) => {
        this.config.feeder.column.forEach((head, beta) => {
          // console.log(head.conteks+" = "+data[head.conteks]);
          if(head.overide && head.printable !== false){

            if(typeof head.conteks != 'array' && typeof head.conteks != 'object'){
              if(head.printable === false){
                $('#bucketPrint').html('');
              }else{
                $('#bucketPrint').html(head.overide(data[head.conteks]));
              }

              const bulk = $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '');

              if(bulk != ''){
                CsvString += bulk + ',';
              }else{
                CsvString += (head.printable !== false) ? data[head.conteks] + ',' : ',';
              }
            }else{
              let bucket = [];
              head.conteks.forEach((gamma, idx) => {
                bucket.push(data[gamma]);
              });

              if(head.printable === false){
                $('#bucketPrint').html('');
              }else{
                $('#bucketPrint').html(head.overide(bucket));
              }

              const bulk = $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '');

              if(bulk != ''){
                CsvString += bulk + ',';
              }else{
                CsvString += (head.printable !== false) ? data[bucket[0]] + ',' : ',';
              }
            }
          }else{
            if(head.printable === false){
              $('#bucketPrint').html('');
            }else{
              $('#bucketPrint').html(data[head.conteks]);
            }

            const bulk = $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '');

            if(bulk != ''){
              CsvString += bulk + ',';
            }else{
              CsvString += (head.printable !== false) ? data[head.conteks] + ',' : ',';
            }
          }
        })

        CsvString += "\r\n";
      });

      // console.log(CsvString);

      CsvString = "data:application/csv," + encodeURIComponent(CsvString);
      x.setAttribute("href", CsvString );
      x.setAttribute("download", title);
      document.body.appendChild(x);

      x.click();
    },

    exportPdf: function(evt) {
      evt.preventDefault();
      evt.stopImmediatePropagation();

      const title = (this.config.config.title) ? this.config.config.title : 'data';

      const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
          "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

      const dateObj = new Date();
      const month = monthNames[dateObj.getMonth()];
      const day = String(dateObj.getDate()).padStart(2, '0');
      const year = dateObj.getFullYear();
      const output =  day+' '+month+' '+year;

      let dd = {
        pageOrientation: 'landscape',
        content: [
          {text: title, style: 'header', alignment: 'left', margin: [0, 0, 0, 5]},
          {text: 'Sesuai dengan data terakhir tanggal '+output+'', style: 'subheader', alignment: 'left', margin: [0, 0, 0, 20]},
          {
            style: 'tableExample',
            table: {
              widths: [80, '*', '*', '*', '*'],
              body: [
                []
              ]
            }
          },
        ],
        styles: {
          header: {
            fontSize: 14,
            bold: true,
          },
          subheader: {
            fontSize: 10
          },
          tableHeader: {
            bold: true,
            fontSize: 13,
            color: 'black'
          }
        }
      }

      this.config.feeder.column.forEach((header, alpha) => {
          if(header.printable !== false){
            dd.content[2].table.body[0].push(header.text);
          }
      });

      this.config.feeder.data.forEach((data, alpha) => {
        var temporary = [];
        this.config.feeder.column.forEach((head, beta) => {
          if(head.overide && head.printable !== false){
            if(typeof head.conteks != 'array' && typeof head.conteks != 'object'){
              if(head.printable === false){
                $('#bucketPrint').html('');
              }else{
                $('#bucketPrint').html(head.overide(data[head.conteks]));
                const bulk = $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '');

                if(bulk != ''){
                  temporary.push(bulk);
                }else{
                  temporary.push(data[head.conteks]);
                }

              }

            }else{
              let bucket = [];
              head.conteks.forEach((gamma, idx) => {
                bucket.push(data[gamma]);
              });

              if(head.printable === false){
                $('#bucketPrint').html('');
              }else{
                $('#bucketPrint').html(head.overide(bucket));

                const bulk = $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '');

                if(bulk != ''){
                  temporary.push(bulk);
                }else{
                  temporary.push(data[bucket[0]]);
                }
              }

            }
          }else{
            if(head.printable === false){
              $('#bucketPrint').html('');
            }else{
              $('#bucketPrint').html(data[head.conteks]);

              const bulk = $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '');

                if(bulk != ''){
                  temporary.push(bulk);
                }else{
                  temporary.push(data[head.conteks]);
                }
            }

          }

        })

        dd.content[2].table.body.push(temporary);
      });

      pdfMake.createPdf(dd).download(title+'.pdf');
    },

    genOveride: function(data, index){
      // console.log(data);
      if(typeof data === 'string'){
        return this.data[index][data];
      }else if(typeof data === 'array' || typeof data === 'object'){
        let returnes = [];

        $.each(data, (idx, dts) => {
          if(this.data[index][dts] || this.data[index][dts] == 0){
            returnes.push(this.data[index][dts]);
          }else{
            returnes.push(null);
          }
        })

        return returnes;
      }

      return typeof data;
    },
  },
  template: `
      <div class="row swamsid-vue-datatable">
        <div class="col-md-12 navigation-bar">
          <div class="row">
            <div class="col-md-5 left-navigation">
              <table style="width: 100%; border:0px solid black;">
                <tbody>
                  <tr>
                    <td width="10%" style="text-align: center; vertical-align: middle;" v-if="config.config.showRange !== false">
                      <span>Show</span>
                    </td>
                    <td width="25%" v-if="config.config.showRange !== false">
                      <select class="form-control" v-model="showPerPage">
                        <option value="5">5 Data</option>
                        <option value="10">10 Data</option>
                        <option value="20">20 Data</option>
                        <option value="30">30 Data</option>
                      </select>
                    </td>
                    <td style="padding-left: 0px;">
                      <input type="text" class="form-control" placeholder="Lakukan Pencarian ..." v-model="search"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-7 right-navigation">
              <ul id="swamsid-horizontal-list">
                <li>
                    <div class="btn-group">
                        <button data-toggle="dropdown" v-if="download" class="btn btn-white dropdown-toggle" style="padding: 8px 15px 10px 15px; font-weight: 600; font-size: 8pt !important;">
                            <i class="fa fa-download"></i> &nbsp;
                            Download
                        </button>
                        <ul class="dropdown-menu" v-if="download" style="border: 0px important; border-top: 1px solid #ccc; !important;">
                            <li style="padding: 0px;">
                                <a class="dropdown-item" href="#" style="padding: 0px 5px;" @click="exportExcel($event)">
                                    <i class="fa fa-file-excel fa-fw"></i> &nbsp;
                                    Format CSV
                                </a>
                            </li>

                            <li style="padding: 0px;">
                                <a class="dropdown-item" href="#" style="padding: 0px 5px;"  @click="exportPdf($event)">
                                    <i class="fa fa-file-pdf fa-fw"></i> &nbsp;
                                    Format PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li v-for="(button, idx) in config.addition.customButton" v-html="button.html">
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-12 table-bar">
          <table class="swamsid-vue-datatable">
            <thead>
              <tr>
                <!-- <th>
                  <i class="far fa-square" style="font-size: 12pt;"></i>
                </th> -->
                <th v-for="(head, idx) in head" :style="head.style" @click="sortMe(idx)">
                  {{ head.text }} &nbsp;

                  <template v-if="head.sortable !== false">
                    <i class="fa fa-fw fa-sort-amount-up" v-if="sortBy == idx && order =='asc'"></i>
                    <i class="fa fa-fw fa-sort-amount-down" v-else-if="sortBy == idx && order =='desc'"></i>
                    <i class="fa fa-fw fa-sort disabled" v-else></i>
                  </template>
                </th>
              </tr>
            </thead>

            <tbody>
              <template v-if="on_ajax">
                <tr>
                  <td :colspan="head.length" style="text-align: center; font-size: 9pt; color: #b5b5b5; padding: 40px 0px;">
                    <div class="loader"></div>
                    Sedang mengambil data . Harap tunggu ...
                  </td>
                </tr>
              </template>

              <template v-else-if="data.length">
                <tr v-for="(data, index) in data">
                  <td v-for="(column, idx) in head" v-html="data[idx]" :style="column.style"></td>
                </tr>
              </template>

              <template v-else>
                <tr>
                  <td :colspan="head.length" style="text-align: center; font-size: 9pt; color: #b5b5b5;">
                    <img src="${baseUrl}assets/default/empty.png" width="20%">
                    <div style="margin-top: 10px;">
                      Tidak ditemukan data apapun disini.
                      {{ data.length }}
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>

        <div class="col-md-12 footer-bar">
          <div class="row">
            <div class="col-md-6 left-footer">
              <i class="fa fa-sync-alt"></i> &nbsp;
              <span>
                Menampilkan {{ showPerPage * (page - 1) + 1 }} - {{ (showPerPage * page > config.feeder.data.length) ? config.feeder.data.length : showPerPage * page }},&nbsp; dari {{ config.feeder.data.length }} data
              </span>
            </div>
            <div class="col-md-6 right-footer">
              <span :class="(page <= 1) ? 'table-data-paginate disabled' : 'table-data-paginate'" @click="previousPage">
                <i class="fa fa-angle-left"></i> &nbsp;
                Sebelumnya
              </span> &nbsp;&nbsp;&nbsp;&nbsp;

              <span style="color: #b5b5b5;">
                Halaman {{ page }} / {{ totalPages }}
              </span>  &nbsp;&nbsp;&nbsp;&nbsp;

              <span :class="(page == totalPages) ? 'table-data-paginate disabled' : 'table-data-paginate'" @click="nextPage">
                Selanjutnya &nbsp;
                <i class="fa fa-angle-right"></i>
              </span>
            </div>
          </div>
        </div>
        <div id="bucketPrint"></div>
      </div>

  `
};