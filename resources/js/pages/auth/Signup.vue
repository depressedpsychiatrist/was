<template>
  <form @submit.prevent="signup()" class="text-dark" autocomplete="off">
    <h5 class="text-dark">Sign Up</h5>
    <template v-if="!signedUp">
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="form-outline">
            <input type="text" id="fname" class="form-control" v-model="user.first_name" />
            <label class="form-label" for="fname">First name</label>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="form-outline">
            <input type="text" id="lname" class="form-control" v-model="user.last_name" />
            <label class="form-label" for="lname">Last name</label>
          </div>
        </div>
      </div>

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
      <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>

      <!-- Register buttons -->
      <div class="text-center">
        <p>
          Already have an acount?
          <router-link :to="{name: 'login'}">Log In.</router-link>
        </p>
      </div>
    </template>
    <template v-else>
      <span>
        You have signed up successfully. Confirm your email to
        <router-link :to="{name: 'login'}">Log In.</router-link>
      </span>
    </template>
  </form>
</template>

<script>
export default {
  data() {
    return {
      user: {
        first_name: "",
        last_name: "",
        email: "",
        password: "",
      },
      signedUp: false,
    };
  },
  methods: {
    signup() {
      this.$store.dispatch("signUp", this.user).then(() => {
        this.signedUp = true;
        this.$toast.info(
          "You have successfully signed up! Confirm your email to log in."
        );
      });
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
