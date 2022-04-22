import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {

  props: ['value', 'format', 'type', 'range', 'id', 'name', 'disabled', 'placeholders', 'disabledate'],
  components: { DatePicker },

  data() {
    return {
      time : this.value,
      lang: {
        days: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        months: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
        pickers: ['7 Hari Lagi', '30 Hari Lagi', '7 Hari Kemarin', '30 Hari Kemarin'],
        placeholder: {
          date: 'Pilih Tanggal',
          dateRange: 'Pilih Rentang Tanggal'
        }
      },
    }
  },

  mounted: function(){
  },

  computed: {
    selectedData: {
      get() {
        return this.value;
      },
      set(val) {
          this.$emit('input', val);
      }
    },

    dataComputed: function(){
      const data = moment(this.value, this.format);
      
      if(data.isValid())
          return data.format('YYYY-MM-DD');

      return data;
    }
  },

  watch: {
    value: function(e){
      this.time = e;
    },

    time: function(e){
      this.$emit('value-change', e);
    }
  },

  template: `
    <div id="select-vue-component" class="custom-file">
      <input type="hidden" v-model="dataComputed" :name="name" readonly="true">
      
      <date-picker
        range
        style="width:100%; cursor: pointer !important; border-top: 0px !important; box-shadow: none !important; -webkit-box-shadow: none !important;"
        v-if="range"
        v-model="selectedData" 
        value-type="format" 
        :lang="lang" 
        :clearable="false" 
        :type="type" 
        :format="format"
        :input-attr="{id: id, name: ''}"
        :disabled="disabled"
        :disabled-date="disabledate"
        :placeholder="placeholders ? placeholders: 'Pilih Tanggal'"
        >

      </date-picker>
      
      <date-picker
        style="width:100%; cursor: pointer !important; border-top: 0px !important; box-shadow: none !important; -webkit-box-shadow: none !important;"
        v-else-if="!range"
        v-model="selectedData" 
        value-type="format"
        :lang="lang" 
        :clearable="false" 
        :type="type" 
        :format="format"
        :input-attr="{id: id, name: ''}"
        :disabled="disabled"
        :disabled-date="disabledate"
        :placeholder="placeholders ? placeholders: 'Pilih Tanggal'"
        >

      </date-picker>
    </div>
  `,
};