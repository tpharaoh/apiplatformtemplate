<template>
  <div>
    <h1>Book {{ item.title }}</h1>

    <table class="table">
      <tr>
        <th>Title</th>
        <td>{{ item.title }}</td>
      </tr>
      <tr>
        <th>Author</th>
        <td>{{ item.author }}</td>
      </tr>
      <tr>
        <th>Owner</th>
        <td>
          <template v-if="item.owner">{{ item.owner.name }}</template>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Mercure from '../../mixins/Mercure'

export default {
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
      getItem: 'book/getItem'
    })
  }
}
</script>
