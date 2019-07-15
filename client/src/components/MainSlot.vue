<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <ul class="navbar-nav m-auto">
        <li class="nav-item">
          <router-link :to="{ name: 'BookList' }" class="nav-link">
            Books
          </router-link>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" @click.prevent="SignOut">
            Sign out (<strong>{{ username }}</strong
            >)
          </a>
        </li>
        <li class="nav-item">
          <span class="navbar-text">
            Team hash: <strong>{{ team }}</strong>
          </span>
        </li>
      </ul>
    </nav>

    <div class="container">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  name: 'MainSlot',
  computed: {
    jwt() {
      return this.$store.getters['auth/jwtDecoded']
    },
    username() {
      return this.jwt.name
    },
    team() {
      return this.jwt.team
    }
  },
  methods: {
    SignOut() {
      this.$store.dispatch('auth/logout')
    }
  }
}
</script>
