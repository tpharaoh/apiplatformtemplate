<template>
  <div class="text-center">
    <form class="form-signin" @submit.prevent="signIn">
      <h1 class="h3 mb-3 font-weight-normal">Sign in</h1>

      <label for="username" class="sr-only">Email address</label>
      <input
        id="username"
        v-model="credentials.username"
        type="text"
        class="form-control mb-1"
        placeholder="email"
        required
        autofocus
      />

      <label for="password" class="sr-only">Password</label>
      <input
        id="password"
        v-model="credentials.password"
        type="password"
        class="form-control mb-3"
        placeholder="password"
      />

      <div v-if="error" class="invalid">
        {{ error }}
      </div>

      <button class="btn btn-lg btn-primary btn-block mb-3" type="submit">
        Sign in
      </button>

      <p>
        Don't have account yet?
        <router-link :to="{ name: 'SignUp' }">Sign up</router-link>
      </p>
    </form>
  </div>
</template>

<script>
export default {
  name: 'SignIn',
  data() {
    return {
      credentials: {
        username: '',
        password: ''
      }
    }
  },
  computed: {
    error() {
      return this.$store.getters['auth/error']
    }
  },
  methods: {
    signIn() {
      this.$store
        .dispatch('auth/login', this.credentials)
        .then(() => {
          this.$router.push({ name: 'BookList' })
        })
        .catch(() => {
          this.$toastr.s('Please check the form')
        })
    }
  }
}
</script>

<style>
.text-center {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 80px 0;
}
</style>
