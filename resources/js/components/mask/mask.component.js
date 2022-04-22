import mask from 'jquery-mask-plugin';

export default {

    props: ['placeholder', 'name', 'id', 'disabled', 'css', 'value', 'mask'],

    mounted: function () {
      var vm = this
      $(this.$el).mask(vm.mask, {
         
         placeholder: vm.placeholder

      }).on('keyup', function(e){
        vm.$emit('input', $(e.target).val());
      });
    },

    template: `
        <input type="text" :name="name" class="form-control modul-keuangan" :id="id" :disabled="disabled" :style="css" :value="(value) ? value : ''">
    `,
};