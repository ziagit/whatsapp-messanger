<template>
  <div v-if="chatRooms.length > 0">
    <div class="pr-3 pl-3">
      <b-navbar
        toggleable="sm"
        type="light"
        variant="light"
        class="shadow-none pr-3"
      >
        <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>
        <b-navbar-brand>Tingsapp</b-navbar-brand>
        <b-collapse id="nav-text-collapse" is-nav>
          <b-navbar-nav>
            <b-nav-text
              >{{ user.name }} :

              <span v-if="currentRoom.user_id == user.id">{{
                currentRoom.name
              }}</span>
              <span v-else>{{ currentRoom.user.name }}</span>
            </b-nav-text>
          </b-navbar-nav>
        </b-collapse>
        <b-navbar-nav class="ml-auto">
          <b-nav-form @submit.prevent="logout">
            <b-button
              variant="light"
              size="sm"
              class="my-2 my-sm-0"
              type="submit"
              >Leave</b-button
            >
          </b-nav-form>
        </b-navbar-nav>
      </b-navbar>
    </div>
    <div class="d-flex" style="padding: 0 45px">
      <div>
        <room-selection
          :rooms="chatRooms"
          :currentRoom="currentRoom"
          v-on:roomchanged="setRoom($event)"
        />
      </div>
      <div class="container px-0 pt-0">
        <b-card class="shadow-sm border-0">
          <message-container :messages="messages" />
          <input-message :room="currentRoom" v-on:messagesent="getMessages()" />
        </b-card>
      </div>
    </div>
  </div>
</template>
<script>
import MessageContainer from "./messageContainer.vue";
import InputMessage from "./inputMessage.vue";
import RoomSelection from "./roomSelection.vue";

export default {
  components: {
    MessageContainer,
    InputMessage,
    RoomSelection,
  },
  data: function () {
    return {
      chatRooms: [],
      currentRoom: [],
      messages: [],
      token: "",
      user: null,
    };
  },
  created() {
    this.token = localStorage.getItem("token");
    this.user = JSON.parse(localStorage.getItem("user"));
    this.getRooms();
    this.connect();
  },
  watch: {
    currentRoom(val, oldVal) {
      if (oldVal.id) {
        this.disconnect(oldVal);
      }
      this.connect();
    },
  },

  methods: {
    getRooms() {
      axios
        .get("/api/admin/rooms", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log("roooms: ",response.data)
          this.chatRooms = response.data;
          this.setRoom(response.data[0]);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    connect() {
      let vm = this;
      this.getMessages();
      Echo.private("chat." + this.currentRoom.id).listen(".chat-event", (e) => {
        console.log("event: ", e);
        vm.getMessages();
      });
      var user = JSON.parse(localStorage.getItem("user"));
      Echo.private("room." + user.id).listen(".room-event", (e) => {
        console.log("room event: ", e);
        vm.getRooms();
      });
    },

    disconnect(room) {
      window.Echo.leave("chat." + room.id);
    },

    setRoom(room) {
      this.currentRoom = room;
    },
    getMessages() {
      axios
        .get("/api/admin/room/" + this.currentRoom.id + "/messages", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.messages = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    logout() {
      axios
        .get("signout", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          if (response.status == 200) {
            localStorage.clear();
            this.$router.push("/");
          }
        });
    },
  },
};
</script>
<style scoped>
.container {
  height: calc(100vh - 141px);
  padding-top: 12px;
}
.navbar {
  padding-right: 30px;
  padding-left: 30px;
}
</style>
