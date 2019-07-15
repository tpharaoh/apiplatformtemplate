<template>
  <form @submit.prevent="handleSubmit(item)">
    <form-input
      label="Title"
      :item="item"
      property="title"
      :errors="errors"
      @input="updateValue"
    ></form-input>
    <form-input
      label="Author"
      :item="item"
      property="author"
      :errors="errors"
      @input="updateValue"
    ></form-input>

    <button class="btn btn-lg btn-primary mb-3" type="submit">Save</button>
  </form>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import FormInput from '../../components/FormInput'

export default {
  components: { FormInput },
  props: {
    handleSubmit: {
      type: Function,
      required: true
    },
    item: {
      type: Object,
      required: true
    }
  },
  computed: {
    ...mapGetters({
      errors: 'book/errors'
    })
  },
  beforeDestroy() {
    this.resetState()
  },
  methods: {
    ...mapActions({
      resetState: 'book/resetState'
    }),
    updateValue(property, value) {
      this.$store.commit('book/UPDATE_ITEM', { [property]: value })
    }
  }
}
</script>
