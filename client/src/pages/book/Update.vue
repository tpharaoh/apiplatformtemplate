<template>
  <div>
    <h1>Update book</h1>

    <book-form :handle-submit="onSendForm" :item="item" />
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import BookForm from './BookForm'
import Mercure from '../../mixins/Mercure'

export default {
  components: {
    BookForm
  },
  mixins: [Mercure],
  computed: {
    ...mapGetters({
      item: 'book/item'
    })
  },
  created() {
    this.getItem(this.$route.params.id)
    this.mercureOpen(data => {
      if (data['@type'] === 'Book' && this.item['@id'] === data['@id']) {
        this.$store.commit('book/SET_ITEM', data)
      }
    })
  },
  beforeDestroy() {
    this.mercureClose()
  },
  methods: {
    ...mapActions({
      getItem: 'book/getItem',
      update: 'book/update'
    }),
    onSendForm() {
      this.update()
        .then(() => {
          this.$router.push({ name: 'BookList' })
        })
        .catch(() => {})
    }
  }
}
</script>
