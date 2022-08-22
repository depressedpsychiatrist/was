<template>
  <form @submit.prevent="login()" class="text-dark">
    <p
      class="text-success"
      v-if="emailVerified == 'true'"
    >Email successfully verified. You can log in now.</p>
    <p class="text-warning" v-if="emailVerified == 'already'">Email was already verified.</p>
    <h5 class="font-medium mb-3 text-dark">Log In</h5>
    <!-- Email input -->
    <div class="form-outline mb-4">
      <input type="email" id="email" class="form-control" v-model="user.email" />
      <label class="form-label" for="email">Email address</label>
    </div>

    <!-- Password input -->
    <div class="form-outline mb-4">
      <input type="password" id="password" class="form-control" v-model="user.password" />
      <label class="form-label" for="password">Password</label>
    </div>

    <!-- Submit button -->
    <button type="submit" class="btn btn-primary btn-block mb-4">Log In</button>

    <!-- Register buttons -->
    <div class="text-center">
      <p>
        Don't have an account?
        <router-link :to="{name: 'signup'}">Sign Up.</router-link>
      </p>
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    login() {
      this.$store
        .dispatch("login", this.user)
        .then((data) => {
          if (data.user.role == 1) {
            this.$router.push({ name: "employeeList" });
          } else {
            this.$router.push({ name: "employeeForm" });
          }
        })
        .catch((error) => {
          this.$toast.error(error.data.error);
        });
    },
  },
  computed: {
    emailVerified() {
      return this.$route.query.emailVerified;
    },
  },
};
</script>

<style>
.background-radial-gradient {
  background-color: hsl(218, 41%, 15%);
  background-image: radial-gradient(
      650px circle at 0% 0%,
      hsl(218, 41%, 35%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%
    ),
    radial-gradient(
      1250px circle at 100% 100%,
      hsl(218, 41%, 45%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%
    );
}

#radius-shape-1 {
  height: 220px;
  width: 220px;
  top: -60px;
  left: -130px;
  background: radial-gradient(#44006b, #ad1fff);
  overflow: hidden;
}

#radius-shape-2 {
  border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
  bottom: -60px;
  right: -110px;
  width: 300px;
  height: 300px;
  background: radial-gradient(#44006b, #ad1fff);
  overflow: hidden;
}

.bg-glass {
  background-color: hsla(0, 0%, 100%, 0.9) !important;
  backdrop-filter: saturate(200%) blur(25px);
}
</style>
