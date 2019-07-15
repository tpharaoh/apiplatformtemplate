<template>
  <div class="text-center">
    <form class="form-signin" @submit.prevent="signUp">
      <h1 class="h3 mb-3 font-weight-normal">Sign up</h1>

      <form-input
        label="Team hash"
        :item="item"
        property="team"
        :errors="errors"
        @input="updateValue"
      ></form-input>
      <form-input
        label="Name"
        :item="item"
        property="name"
        :errors="errors"
        @input="updateValue"
      ></form-input>
      <form-input
        label="Username"
        :item="item"
        property="username"
        :errors="errors"
        @input="updateValue"
      ></form-input>
      <form-input
        label="Password"
        :item="item"
        property="plainPassword"
        :errors="errors"
        @input="updateValue"
      ></form-input>

      <button class="btn btn-lg btn-primary btn-block mb-3" type="submit">
        Sign up
      </button>

      <p>
        Already have account?
        <router-link :to="{ name: 'SignIn' }">Sign in</router-link>
      </p>
    </form>
  </div>
</template>

<script>
import FormInput from '../components/FormInput'
export default {
  components: { FormInput },
  computed: {
    item() {
      return this.$store.getters['user/item']
    },
    errors() {
      return this.$store.getters['user/errors']
    }
  },
  methods: {
    signUp() {
      this.$store
        .dispatch('user/register')
        .then(() => {
          this.$router.push('/signin')
          this.$toastr.s('You are successfully registered')
        })
        .catch(() => {
          this.$toastr.e('Please check the form')
        })
    },
    updateValue(property, value) {
      this.$store.commit('user/UPDATE_ITEM', { [property]: value })
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

.invalid {
  color: red;
  margin-bottom: 10px;
  text-align: left;
  font-size: 12px;
}
</style>
