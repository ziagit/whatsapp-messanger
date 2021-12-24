<template>
  <div class="">
    
    <div class="input-container">
      <input
        type="text"
        v-model="message"
        @keyup.enter="sendMessage()"
        placeholder="Message..."
        class="p-1"
      />
      <b-button @click="sendMessage()" class="p-1 rounded" variant="light">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 rotate-90"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"
          />
        </svg>
      </b-button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["room"],
  data: function () {
    return {
      message: "",
      token: "",
    };
  },
  methods: {
    sendMessage() {
      if (this.message == "") {
        return;
      }
      axios
        .post(
          "/api/admin/room/" + this.room.id + "/message",
          {
            message: this.message,
          },
          {
            headers: {
              Authorization: "Bearer " + this.token,
            },
          }
        )
        .then((response) => {
          if (response.status == 200) {
            console.log("sms sent: ",response.data)
            this.message = "";
            this.$emit("messagesent");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.token = localStorage.getItem("token");
  },
};
</script>
<style scoped>
.input-container{
  border-top: 1px solid #e6e6e6;
  padding-top: 10px;
  display: flex;
  justify-content: space-between;
  flex-wrap: nowrap;
}
input {
  border: none;
  width: 95%;
}
input:focus {
  outline-style: none !important;
  outline: none !important;
}
button {
  min-width: 35px;
}
button:hover{
  color: #ffa500;
}
svg {
  transform: rotate(90deg);
}
</style>