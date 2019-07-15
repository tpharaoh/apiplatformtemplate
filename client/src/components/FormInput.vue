<template>
  <div>
    <label :for="property" class="sr-only">{{ label }}</label>
    <input
      :id="property"
      :value="item[property]"
      type="text"
      class="form-control mb-1"
      :placeholder="label"
      autofocus
      @input="$emit('input', property, $event.target.value)"
    />
    <div v-if="isInvalid(property)" class="invalid">
      {{ errors[property] }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    label: {
      type: String,
      required: true
    },
    item: {
      type: Object,
      required: true
    },
    property: {
      type: String,
      required: true
    },
    errors: {
      type: Object,
      required: true
    }
  },
  methods: {
    isInvalid(property) {
      return Object.keys(this.errors).length > 0 && this.errors[property]
    }
  }
}
</script>
