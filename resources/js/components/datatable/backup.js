import './style.css';
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;

export default {
  data(){
    return {
      dataTab: [],
      _backup: [],
      _recursive: [],
      search: '',
      fullPage: 1,
      page: 1,
      firstIndex: 0,
      lastIndex: 0,
      dataPage: 10,
      sortBy: 'none',
      order: 'asc',
      export: ['excel'],
    }
  },
  props:{
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
    this.$data._recursive = JSON.parse(JSON.stringify(this.config.feeder.data));
    // this.sortBy = (typeof this.config.feeder.column[0].conteks == 'string') ? this.config.feeder.column[0].conteks : this.config.feeder.column[0].conteks[0];
  },
  mounted: function(){
    console.log("Datatables v2 Ready...");
    this.renderData();
  },
  methods:{
    pageIncrease: function(e){
      e.preventDefault();
      this.page++;
    },

    pageDecrease: function(e){
      e.preventDefault();
      this.page--;
    },

    renderData: function(){
      // alert('e');
      var that = this;
      this.dataPage = (this.config.config && this.config.config.dataPerPage) ? this.config.config.dataPerPage : this.dataPage;

      if(this.$data._recursive.length / this.dataPage < 1){
        this.fullPage = Math.floor(this.$data._recursive.length / this.dataPage) + 1;
        // alert('a')
      }else if((this.$data._recursive.length / this.dataPage) % 1 == 0){
        this.fullPage = Math.floor(this.$data._recursive.length / this.dataPage);
        // alert('b')
      }else if(this.$data._recursive.length / this.dataPage > 1){
        this.fullPage = Math.floor(this.$data._recursive.length / this.dataPage) + 1;
        // alert('c')
      }

      this.firstIndex = 0;
      this.page = 1;
      this.lastIndex = this.firstIndex + (this.dataPage - 1);

      this.sortManual(this.$data._recursive, this.sortBy, this.order);
      this.dataTab = $.grep(this.$data._recursive, function(n, i){ return i >= that.firstIndex && i <= that.lastIndex});
    },

    sortMe: function(key){
      
      if(typeof key != 'string')
          key = key[0];

      var array = this.$data._recursive;

      if(key == this.sortBy){
        if(this.order == 'asc'){
          this.order = 'desc';
        }
        else{
          this.order = 'asc';
        }

      }else{
        this.order = 'asc';
        this.sortBy = key;
      }
      
      // this.$data._recursive = [];

      this.renderData();

      // console.log(this.config.feeder.data);
      // alert('sortBy: '+this.sortBy+' & order: '+this.order);
    },

    sortManual: function(array, sortBy, key) {
      if(key == 'asc'){
        this.$data._recursive = this.$data._recursive.sort(function (a, b) {
            var x = a[sortBy]; var y = b[sortBy];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
      }else{
        this.$data._recursive = this.$data._recursive.sort(function (a, b) {
            var x = a[sortBy]; var y = b[sortBy];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
      }
    },

    genOveride: function(data, index){
      // console.log(this.dataTab[index]);
      if(typeof data === 'string'){
        return this.dataTab[index][data];
      }else if(typeof data === 'array' || typeof data === 'object'){
        let returnes = [];

        $.each(data, (idx, dts) => {
          if(this.dataTab[index][dts]){
            returnes.push(this.dataTab[index][dts]);
          }else{
            returnes.push(null);
          }
        })

        return returnes;
      }

      return typeof data;
    },

    // exporter
      exportExcel: function(evt) {

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
            if(head.overide && head.printable !== false){
              
              if(typeof head.conteks != 'array' && typeof head.conteks != 'object'){
                if(head.printable === false){
                  $('#bucketPrint').html('');
                }else{
                  $('#bucketPrint').html(head.overide(data[head.conteks]));
                }

                CsvString += $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '') + ',';
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

                CsvString += $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '') + ',';
              }
            }else{
              if(head.printable === false){
                $('#bucketPrint').html('');
              }else{
                $('#bucketPrint').html(data[head.conteks]);
              }

              CsvString += $('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, '') + ',';
            }
          })
        
          CsvString += "\r\n";
        });

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
                  temporary.push($('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, ''));
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
                  temporary.push($('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, ''));
                }

              }
            }else{
              if(head.printable === false){
                $('#bucketPrint').html('');
              }else{
                $('#bucketPrint').html(data[head.conteks]);
                temporary.push($('#bucketPrint').text().replaceAll(',', '').replace(/^\s+/g, ''));
              }

            }
            
          })

          dd.content[2].table.body.push(temporary);
        });
        
        pdfMake.createPdf(dd).download(title+'.pdf');
      },

    dataChange: function(e){
      this.$data._recursive = JSON.parse(JSON.stringify(e));
      this.renderData();
    }
  },

  watch: {
    'config.feeder.data': {
        handler: function (e) {
            this.dataChange(e);
        },
        deep: true
    },

    page: function(e){
      var that = this;

      this.firstIndex = 0 + ((this.dataPage * this.page) - this.dataPage);
      this.lastIndex = this.firstIndex + (this.dataPage - 1);
      // alert(this.firstIndex+' - '+this.lastIndex);
      this.dataTab = $.grep(this.$data._recursive, function(n, i){ return i >= that.firstIndex && i <= that.lastIndex});
    },

    search: function(e){
      this.$data._recursive = JSON.parse(JSON.stringify(this.config.feeder.data));
      this.sortBy = this.config.feeder.column[0].conteks;
      this.order = 'asc';

      if(e == '') { this.renderData(); return };
      var that = this;

      let conteks = [];

      that.config.feeder.column.forEach((p, idx) => {
        if(typeof p.conteks === 'string'){
          conteks.push(p.conteks);
        }else{
          p.conteks.forEach((z, index) => {
            conteks.push(z);
          })
        }
      });

      var data = this.$data._recursive.filter(function(o){
        for(let d = 0; d < conteks.length; d++){
          if(o[conteks[d]] && o[conteks[d]].toString().toUpperCase().includes(e.toUpperCase())){
              return o; 
          }
        }
      })

      this.$data._recursive = data;

      this.renderData();
    },
  },
  computed:{
    tableData: function(){
      console.log(this.config.feeder.data);
      return this.config.feeder.data;
    } 
  },
  template: `
      <div id="datatable-vue" class="row" style="padding: 0px; margin-top: 10px;">
        <div class="col-md-6">
            <div class="input-group" :style="(config.config.searchBar && config.config.searchBar.style) ? config.config.searchBar.style : ''">
              <div class="input-group-prepend">
                  <span class="input-group-addon" style="font-weight: 600; color: var(--sidebarColor)">
                    <i class="fa fa-search" style="font-size: 9pt;"></i>  
                  </span>
              </div>
              <input type="text" class="form-control search" placeholder="Lakukan Pencarian ..." v-model="search">
          </div>
        </div>

          <div class="col-md-6 button-wrapper text-right" style="padding-top: 3px;"> 
            <div class="btn-group mb-2">
              <template v-if="config.addition && config.addition.export">
                <template v-for="btn in config.addition.export">
                    <button type="button" :class="'btn '+btn.class" v-html="btn.html" @click="exportExcel" v-if="btn.type == 'excel'" style="font-size: 9pt;"></button>
                    <button type="button" :class="'btn '+btn.class" v-html="btn.html" @click="exportPdf" v-if="btn.type == 'pdf'" style="font-size: 9pt;"></button>
                </template>
              </template>

              <template v-if="config.addition.buttonCustom && config.addition.buttonCustom">
                <template v-for="btn in config.addition.buttonCustom">
                    <button type="button" :class="'btn '+btn.class" v-html="btn.html" @click="(btn.click) ? btn.click($event) : ''" style="font-size: 9pt;"></button>
                </template>
              </template>
            </div>
          </div>

          <div class="col-md-12 table-wrapper" style="margin-top: 15px;">

            <table class="table table-bordered table-stripped vue-datatable-swamsid" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                      <th :class="data.class" v-for="(data, index) in config.feeder.column" :style="data.style" @click="sortMe(data.conteks)">
                        {{ data.text }} &nbsp;

                        <template v-if="data.allowSearch !== false">
                          <template v-if="typeof data.conteks == 'string'">
                            <i class="fa fa-exchange-alt fa-rotate-90" v-if="sortBy != data.conteks" style="color: white"></i>
                            <i class="fa fa-sort-amount-up" v-if="sortBy == data.conteks && order =='asc'" style="color: white"></i>
                            <i class="fa fa-sort-amount-down" v-if="sortBy == data.conteks && order =='desc'" style="color: white"></i>
                          </template>

                          <template v-else>
                            <i class="fa fa-exchange-alt fa-rotate-90" v-if="sortBy != data.conteks[0]" style="color: white"></i>
                            <i class="fa fa-sort-amount-up" v-if="sortBy == data.conteks[0] && order =='asc'" style="color: white"></i>
                            <i class="fa fa-sort-amount-down" v-if="sortBy == data.conteks[0] && order =='desc'" style="color: white"></i>
                          </template>
                        </template>
                      </th>
                    </tr>
                </thead>

                <tbody>
                  <template v-if="on_ajax">
                    <tr>
                      <td class="text-muted" :colspan="config.feeder.column.length" style="text-align: center;">
                        <i class="fa fa-hourglass-half"></i> &nbsp; Sedang mengambil data, harap tunggu ...
                      </td>
                    </tr>
                  </template>

                  <template v-if="!on_ajax && config.feeder.data.length">
                    <tr v-for="(data, index) in dataTab">
                      <td :class="column.class" v-for="(column, alpha) in config.feeder.column"
                          v-html="(!column.overide) ? data[column.conteks] : column.overide(genOveride(column.conteks, index))"
                          :style="column.style">
                      </td>
                    </tr>
                  </template>

                  <template v-if="!on_ajax && !dataTab.length">
                    <tr>
                      <td class="text-muted" :colspan="config.feeder.column.length" style="text-align: center;">
                        <i class="fa fa-frown"></i> &nbsp;ups ! maaf, kami tidak bisa menemukan data apapun.
                      </td>
                    </tr>
                  </template>
                </tbody>
            </table>

            
          </div>

          <div class="col-md-12 bottom-wrap" style="padding-left: 20px; margin-top: 15px;">
            <div class="row">
              <div class="col-md-6 info-wrap" style="color: rgba(0,0,0,0.5); font-size: 9.5pt;">
                  <span v-if="!config.config.legend || config.config.legend.visibility">Menampilkan {{ dataPage }} data setiap 1 halaman</span>  
              </div>

              <div class="col-md-6" style="padding: 5px 20px 0px 0px; text-align: right;">
                <div class="btn-group" role="group" aria-label="...">
                  <button type="button" class="btn btn-xs" style="background: rgba(76, 175, 80, 0.8); border: 1px solid rgba(76, 175, 80, 0.2); color: white;" :disabled="page == 1" @click="pageDecrease">Sebelumnya</button>
                  <button type="button" class="btn btn-xs" style="background: rgba(76, 175, 80, 0.8); border: 1px solid rgba(76, 175, 80, 0.2); color: white;" :disabled="page == fullPage" @click="pageIncrease">Selanjutnya</button>
                </div>
              </div>
            </div>
          </div>

          <div id="bucketPrint"></div>
      </div>
  `
};