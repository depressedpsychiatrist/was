<template>
  <div class="container">
    <header>
      <nav class="navbar navbar-expand-lg text-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">WAS</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarColor03"
            aria-controls="navbarColor03"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <span class="me-2">{{user.first_name + ' ' + user.last_name}}</span>
            <button class="btn btn-outline-secondary" type="button" @click="logout()">Log Out</button>
          </div>
        </div>
      </nav>
    </header>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$store.dispatch("logout").then(() => {
        this.$router.push("/login");
      });
    },
  },
  computed: {
    user() {
      return this.$store.getters.user ? this.$store.getters.user.user : {};
    },
  },
  mounted() {
    this.$store.dispatch("initialize");
  },
};
</script>

<style>
.nav-link,
.navbar-brand {
  color: white !important;
}
</style>
