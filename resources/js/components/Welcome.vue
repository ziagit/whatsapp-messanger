<template>
  <div class="container">
    <b-card class="shadow border-0">
      <div class="text-center">
        <img src="images/logo.svg" alt="No logo" width="100" class="m-auto mb-2" />
        <h5>Welcome to tingsapp chatroom</h5>
        <br>
        <Login />
      </div>
    </b-card>
  </div>
</template>

<script>
import Login from "./login.vue";
import Container from "./Chat/container.vue";
export default {
  components: {
    Login,
    Container,
  },
};
</script>
<style scoped lang="scss">
.container {
  height: 100vh;
  display: flex;
  .card {
    max-width: 600px;
    padding: 36px;
    margin: auto;
  }
}
</style>
