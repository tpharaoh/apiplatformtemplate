<template>
  <div>
    <h1>Books</h1>

    <button type="button" class="btn btn-primary mt-3 mb-3" @click="create">
      Create
    </button>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Title</th>
          <th scope="col">Author</th>
          <th scope="col">Owner</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.author }}</td>
          <td>{{ item.owner.name }}</td>
          <td>
            <button
              type="button"
              class="btn btn-primary mr-1"
              @click="show(item.id)"
            >
              Show
            </button>

            <template v-if="item.owner.id == jwt.id">
              <button
                type="button"
                class="btn btn-primary mr-1"
                @click="update(item.id)"
              >
                Update
              </button>
              <button
                type="button"
                class="btn btn-primary mr-1"
                @click="remove(item.id)"
              >
                Remove
              </button>
            </template>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      items: 'book/items'
    }),
    jwt() {
      return this.$store.getters['auth/jwtDecoded']
    }
  },
  mounted() {
    this.getItems()
  },
  methods: {
    ...mapActions({
      getItems: 'book/getItems',
      removeItem: 'book/remove'
    }),
    create() {
      this.$router.push({ name: 'BookCreate' })
    },
    update(id) {
      this.$router.push({ name: 'BookUpdate', params: { id: id } })
    },
    show(id) {
      this.$router.push({ name: 'BookShow', params: { id: id } })
    },
    remove(id) {
      if (confirm('Are you sure?')) {
        this.removeItem(id).then(() => {
          this.getItems()
          this.$toastr.s('Successfully removed')
        })
      }
    }
  }
}
</script>
