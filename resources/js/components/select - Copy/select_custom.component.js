import './style.css';

export default {
    data(){
        return {
            searchParams    : '',
        }
    },
    props:{
        options: {
            type: Array,
            required: true,
        },

        loading : {
            type: Boolean,
            required: false,
        },

        value : {
            type: Object,
            required: false,
        },

        placeholder : {
            type: String,
            required: false,
        },

        name : {
            type: String,
            required: false,
        },

        direction : {
            type: String,
            required: false,
        },

        disabled : {
            type: Boolean,
            required: false,
            default: false
        }
    },
    created: function(){
    
    },
    mounted: function(){
        window.onclick = function(event) {
            if (!event.target.classList.contains('dissalow-vue-select-option')) {
                var dropdowns = document.getElementsByClassName("dropdown-vue-content");
                var i;
                
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    },
    watch: {
        
    },
    computed:{
        data_computed: function(){
            let response = [];

            this.options.forEach((z, idx) => {
                if(this.searchParams == ''){
                    response.push(z)
                }else if(z.text.toLowerCase().includes(this.searchParams.toLowerCase())){
                    response.push(z)
                }
            })

            return response;
        },

        selectedData: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    methods:{
        openDropdown: function(evt){
            evt.preventDefault();
            evt.stopImmediatePropagation();

            if(this.disabled)
                return;

            const target    = (evt.target) ? evt.target : evt.srcElement;
            const conteks   = this.findAncestor(target, 'dropdown-vue-wrapper');

            for (var i = 0; i < conteks.childNodes.length; i++) {
                if (conteks.childNodes[i].classList && conteks.childNodes[i].classList.contains("dropdown-vue-content")) {                
                    if (conteks.childNodes[i].classList.contains('show')) {
                        conteks.childNodes[i].classList.remove('show');
                    }else{
                        this.toggleOff()
                        conteks.childNodes[i].classList.toggle("show");

                        this.$emit('option-open', target)
                    }

                break;
                }        
            }
        },

        findAncestor: function(el, cls) {
            while ((el = el.parentElement) && !el.classList.contains(cls));
            return el;
        },

        toggleOff: function(){
            var dropdowns = document.getElementsByClassName("dropdown-vue-content"); var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        },

        selectItem: function(evt, option){
            evt.preventDefault();
            evt.stopImmediatePropagation();
            
            const lastVal = this.selectedData;
                
            this.selectedData    = option;

            const conteks   = this.findAncestor(evt.target, 'dropdown-vue-content');
            conteks.classList.remove('show');

            if(lastVal.id != option.id)
                this.$emit('option-change', {value: option, lastValue: lastVal});
        },
    },
    template: `
        <div id="select-vue-component" class="custom-file">
            <div class="dropdown-vue-wrapper">
                <input type="text" :class="(!disabled) ? 'dropdown-vue-conteks form-control' : 'dropdown-vue-conteks form-control disabled'" readonly="true" :placeholder="placeholder ? placeholder : '-- Pilih Data'" v-model="selectedData.text" @click="openDropdown" style="padding-right: 33px;">
                <input type="hidden" :name="name" readonly="true" v-model="selectedData.id">
                <div :class="direction == 'up' ? 'dropdown-vue-content dissalow-vue-select-option up' : 'dropdown-vue-content dissalow-vue-select-option'">
                    <div class="dropdown-vue-search-wrap dissalow-vue-select-option">
                        <input class="form-control dissalow-vue-select-option" placeholder="Cari Sesuatu..." v-model="searchParams">
                    </div>

                    <div style="padding-right: 5px;">
                        <div class="dropdown-vue-content-item">
                            <template v-if="loading">
                                <a class="disabled">
                                    Harap Tunggu...
                                </a>
                            </template>

                            <template v-else>
                                <a :class="(option.id == selectedData.id) ? 'active' : ''" v-for="(option, idx) in data_computed" @click="selectItem($event, option)">{{ option.text }}</a>
                                <a class="disabled" v-if="data_computed.length == 0">Tidak Ada Data</a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `
};