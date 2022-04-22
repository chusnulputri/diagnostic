import VueTagsInput from '@johmun/vue-tags-input';

export default {
  components: {
    VueTagsInput,
  },

  props: {
    model: {
      type: String,
    },
  },

  data() {
    return {
      tag : '',
      tags: [],
    };
  },

  watch: {
    model: function(e){
      this.tag = e;
    }
  },

  methods: {
    tagsChange: function(e){
      let result = [];

      e.forEach((z, index) => {
        result.push(z.text);
      })

      this.$emit('tags-change', result);
      // console.log(e);
    }
  },

  template: `
    <div>
      <vue-tags-input v-model="tag" :tags="tags" @tags-changed="tagsChange" :addOnKey="[13, 186, 188]"/>
    </div>
  `
};