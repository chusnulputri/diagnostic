  import {Money} from 'v-money'

  export default {
    components: {Money},
    
    data () {
      return {
        price   : '0',
        money: {
          decimal: this.radix,
          thousands: this.separator,
          prefix: this.prefix,
          suffix: this.suffix,
          precision: this.precision,
          masked: this.masked
        }
      }
    },

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
    },

    computed: {
      selectedData: {
        get() {
          return this.value;  
        },
        set(val) {
          this.$emit('input', val);
        }
      }
    },

    watch: {
      value: function(e){
        this.price = e;
      },
    },

    methods: {
      fixFocus: function(evt){
        const target    = (evt.target) ? evt.target : evt.srcElement;
        const strLen    = target.value.indexOf(this.radix);

        console.log(strLen);

        setTimeout(() => {
          this.setCaretPosition(target, (strLen+1));
        }, 0);
      },

      setCaretPosition: function(ctrl, pos) {
        // Modern browsers
        if (ctrl.setSelectionRange) {
          ctrl.focus();
          ctrl.setSelectionRange(pos, pos-1);
        
        // IE8 and below
        } else if (ctrl.createTextRange) {
          var range = ctrl.createTextRange();
          range.collapse(true);
          range.moveEnd('character', pos);
          range.moveStart('character', pos);
          range.select();
        }
      }
    },

    template: `
      <money 
        class="form-control" 
        v-model="selectedData" 
        v-bind="money" 
        style="text-align: right;" 
        @focus.native="fixFocus($event)"
      >{{ selectedData }}</money> 
    `
  }
