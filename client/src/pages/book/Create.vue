<template>
  <div>
    <h1>Add book</h1>

    <book-form :handle-submit="onSendForm" :item="item" />
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import BookForm from './BookForm'

export default {
  components: {
    BookForm
  },
  computed: {
    ...mapGetters({
      item: 'book/item'
    })
  },
  methods: {
    ...mapActions({
      create: 'book/create'
    }),
    onSendForm() {
      this.create()
        .then(() => {
          this.$router.push({ name: 'BookList' })
        })
        .catch(() => {})
    }
  }
}
</script>
