<script>
import { mapGetters } from 'vuex'
import EventSourcePolyfill from 'eventsource'

export default {
  data() {
    return {
      es: null
    }
  },
  computed: {
    ...mapGetters({
      mercureToken: 'auth/mercureToken'
    })
  },
  methods: {
    mercureOpen(callback) {
      const url = new URL(process.env.VUE_APP_MERCURE_URL)
      url.searchParams.append('topic', '{+anything}')

      this.es = new EventSourcePolyfill(url.toString(), {
        headers: { Authorization: 'Bearer ' + this.mercureToken }
      })
      this.es.onmessage = e => {
        console.log(e);
        callback(JSON.parse(e.data))
      }
    },
    mercureClose() {
      this.es.close()
    }
  }
}
</script>
