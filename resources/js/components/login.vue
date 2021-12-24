<template>
  <form @submit.prevent="createUser" class="text-right">
    <b-input-group class="mb-3">
      <b-form-input type="text" required v-model="form.name" placeholder="Name">
      </b-form-input>
    </b-input-group>

    <b-input-group class="mb-3">
      <b-form-input
        type="email"
        required
        v-model="form.email"
        placeholder="Email"
      >
      </b-form-input>
    </b-input-group>
    <b-input-group class="mb-3">
      <b-form-input required v-model="listener" placeholder="Listener id">
      </b-form-input>
    </b-input-group>
    <small
      >Listener id: This temporary field is for listener, by default users 1,2,3
      are already created. as a first user you should use one of these user's
      id. If you choose an id out of these 3 IDs you may face error. You can
      modify the code and customize as your need.</small
    >

    <div class="d-flex justify-content-end mt-3">
      <b-button
        type="submit"
        class="d-flex justify-content-center text-center w-25"
        variant="primary"
      >
        <b-spinner
          v-if="isSubmitting"
          variant="light"
          type="grow"
          small
        ></b-spinner>
        <svg
          v-else
          viewBox="0 0 20 20"
          enable-background="new 0 0 20 20"
          class="w-3 h-3 inline-block mr-1"
        >
          <path
            fill="#FFFFFF"
            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"
          />
        </svg>

        <span>Start</span>
      </b-button>
    </div>
  </form>
</template>

<script>
import axios from "axios";

export default {
  data: function () {
    return {
      form: {
        name: "",
        email: "",
      },
      isSubmitting: false,
      listener: null,
    };
  },

  methods: {
    createUser() {
      if (
        (this.form.name == "" || this.form.email == "", this.listener == "")
      ) {
        return;
      }
      this.isSubmitting = true;
      axios
        .post("/api/signin", this.form)
        .then((response) => {
          console.log("user logedIn: ", response.data);
          localStorage.setItem("token", response.data);
          if (response.status == 201 || response.status == 200) {
            this.createRoom(response.data);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    createRoom(token) {
      axios
        .post(
          "/api/chat/room",
          {
            listener: this.listener,
          },
          {
            headers: {
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => {
          if (response.status == 201 || response.status == 200) {
            console.log("room created: ", response.data);
            localStorage.setItem("user", JSON.stringify(response.data));
            this.isSubmitting = false;
            if (
              response.data.role == "Support" ||
              response.data.role == "Admin"
            ) {
              this.$router.push("/admin");
            } else {
              this.$router.push("/chat");
            }
          }
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
<style scoped>
button {
  align-items: center;
  text-align: center;
}
svg {
  max-width: 20px;
  transform: rotate(90deg);
}
</style>