import inputmask from 'inputmask';
import 'inputmask/dist/jquery.inputmask.js';

export default {

    props: {
        value: {
          type: [Number, String],
          required: false,
        },
  
        radix: {
          type: String,
          required: false,
          default : '.'
        },
  
        separator: {
          type: String,
          required: false,
          default : ','
        },
  
        prefix: {
          type: String,
          required: false,
          default : ''
        },
  
        suffix: {
          type: String,
          required: false,
          default : ''
        },
  
        precision: {
          type: Number,
          required: false,
          default : 2
        },
  
        masked: {
          type: Boolean,
          required: false,
          default : false
        },

        minus: {
            type: Boolean,
            required: false,
            default : false
          },
      },

    mounted: function () {
      var vm = this;

      $(this.$el).inputmask("currency", {
          radixPoint: this.radix,
          groupSeparator: this.separator,
          digits: this.precision,
          allowMinus: this.minus,
          autoGroup: true,
          prefix: this.prefix,
          rightAlign: false,
          oncleared: function () {  }
      }).on('keyup', function(e){
          vm.$emit('input', $(e.target).val());
      })
    },

    methods: {
      // handleInput (e) {
      //   this.$emit('input', 20000)
      // }
    },

    template: `
        <input type="text" class="form-control text-right" v-model="value" autocomplete="off">
    `,
};