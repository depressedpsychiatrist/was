<template>
    <!-- Auth Section -->
    <section class="background-radial-gradient overflow-hidden d-flex align-items-center" style="height:100vh">

    <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
        <div class="row gx-lg-5 align-items-center mb-5">
        <div class="col-lg-6 mb-md-5 mb-lg-0" style="z-index: 10">
            <h1 class="mt-5 display-5 ls-tight font-bold" style="color: hsl(218, 81%, 95%)">
            WAS <br />
            </h1>
            <h3 class="font-medium" style="color: hsl(218, 81%, 75%)">Workplace Accommodation System</h3>
            <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
            To access the WAS, please log in or sign up.
            </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
            <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
            <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

            <div class="card bg-glass">
            <div class="card-body px-4 py-5 px-md-5">
                <router-view></router-view>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <!-- Auth Section End -->
</template>

<script>
export default {

}
</script>

<style>
.background-radial-gradient {
      background-color: hsl(218, 41%, 15%);
      background-image: radial-gradient(650px circle at 0% 0%,
          hsl(218, 41%, 35%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
          hsl(218, 41%, 45%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%);
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
