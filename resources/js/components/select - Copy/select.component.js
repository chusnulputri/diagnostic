import select2 from 'select2';
import 'select2/dist/css/select2.min.css';
// import 'select2-bootstrap-theme/dist/select2-bootstrap.min.css';

export default {

	props: ['name', 'id', 'title', 'options', 'disabled', 'value', 'styles', 'classes', 'placeholder'],

    mounted: function(){
        var vm = this;

        this.$select2 = $(this.$el).select2({
            placeholder: this.placeholder,
            data: this.options,
            loading: true
        }).on('change', function(e){
            vm.$emit('option-change', $(e.target).val())
        }).on('select2:open', function(e){
            vm.$emit('option-open')
        })

        $(this.$el).val(this.value).trigger('change.select2');
    },

    watch: {
    	options: function(newOpts){
            // this.$select2.select2({
            //     placeholder: this.placeholder,
            //     loading: true,
            //     data: newOpts
            // })

            // $(this.$el).val(this.value).trigger('change.select2');
    	}
    },
    methods: {
        closed: function(e){
            alert('aa');
        }
    },
    template: `
      	<select :class="'form-control'" :name="name" :id="id" :title="title" :disabled="disabled" :style="styles"></select>
    `,
};