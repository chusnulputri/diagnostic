import datepicker from '@chenfengyuan/datepicker';
import '@chenfengyuan/datepicker/dist/datepicker.min.css';

export default {

  props: ['name', 'id', 'title', 'value', 'disabled', 'readonly', 'styles', 'format'],

  mounted: function(){
    var vm = this;
      this.$datePicker = $(this.$el).datepicker({autoHide: true, format: (vm.format) ? vm.format : 'dd/mm/yyyy', zIndex: 99999})
      .on('change', function(e){
          vm.$emit('input', $(e.target).val())
      });

      
  },
  watch: {
    value: function(e){
      // alert('datepicker value change '+e);
    }
  },

  template: `
      <input type="text" :value="value" class="form-control" :name="name" :id="id" :title="title" :disabled="disabled" :readonly="true" :style="'cursor: pointer; background: white;'+styles" autocomplete="off">
  `,
};
