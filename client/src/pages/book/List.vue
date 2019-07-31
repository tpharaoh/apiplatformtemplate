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
        <tr v-for="(item, index)  in items" :key="item.id">
          <td>{{index}}{{ item.id }}</td>
          <td>{{ item.title }} {{item.downloadCount}}</td>
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
                type="button" :id="'download-'+index"
                class="btn btn-primary mr-1"
                @click="download(index,item.id,$event)"
              >Download</button>
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
import axios from '../../interceptor'
import Mercure from '../../mixins/Mercure'

export default {
  data() {
    return {
      index: null
    }
  },
  mixins: [Mercure],
  computed: {
    ...mapGetters({
      items: 'book/items',
      item: 'book/item'
    }),
    jwt() {
      return this.$store.getters['auth/jwtDecoded']
    }
  },
    mounted() {
    this.getItems()
  },
  created() {
        this.mercureOpen(data => {
          if(data['@context'] ==='/contexts/Book'){
          document.getElementById('download-'+this.index).innerHTML='Download';
          document.getElementById('download-'+this.index).disabled = false;
          this.$toastr.s('Downloaded '+ data.downloadCount + 'times');
            this.$store.commit('book/SET_ITEM', data)
            this.getItems();
          }else{
            this.getItems();
          }
        });

  },
    beforeDestroy() {
    this.mercureClose()
  },
  methods: {
    ...mapActions({
      getItems: 'book/getItems',
      removeItem: 'book/remove'
    }),
    download(index,id,event) {
      this.index=index;
      const url = process.env.VUE_APP_API_URL + '/book_update_download_counts'
       return axios.post(url, '{"book_id": '+id+'}', {
       headers: {
          'Content-Type': 'application/json',
      }
    }).then((e) => {
        event.target.innerHTML='Please wait...';
        event.target.disabled = true;
        console.log(event);
        }).catch(e => {
          // dispatch('processErrors', e.response.data)
        })

    },
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
