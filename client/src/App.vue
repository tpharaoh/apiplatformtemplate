<template>
  <div>
    <router-view />
    <loader />
  </div>
</template>

<script>
import Loader from './components/Loader'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import fontawesome from '@fortawesome/fontawesome'


export default {
  name: 'App',
  components: { Loader, FontAwesomeIcon }
}
</script>
