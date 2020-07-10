<template>
  <div class="home">
    <h1>Login</h1>
    <form @submit.prevent="onSubmitLogin">
      <input type="text" v-model="form.user" class="custom-input" placeholder="Login"/>
      <input type="password" v-model="form.password" class="custom-input"  placeholder="Password"/>
      <button class="custom-button">Sign in</button>
    </form>
    <div class='error'>{{error}}</div>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      form: {
        user: '',
        password: '',
      },
      error: '',
    }
  },
  methods: {
    onSubmitLogin() {
      fetch('login.php', {
        method: 'POST',
        body: JSON.stringify(this.form),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      .then(response => {
        if (response.ok) return response.json()
        else {
          this.error = 'Login failed'
          return {}
        }
      })
      .then(json => {
        if (json.token) {
          localStorage.setItem('jwt', json.token)
          this.$router.push('/search')
        }
      })
    }
  }
}
</script>

<style scoped>

.home {
  width: 300px;
  display: flex;
  flex-direction: column;
  margin: 0 auto;
}

h1 {
  text-align: center;
  margin: 0px 0px 100px 0px;
}

input {
  margin-bottom: 30px;
}

.error {
  margin-top: 1em;
  color: red;
  font-weight: bold;
}

</style>
