<template>
  <b-card class="border-0 shadow-sm mt-0">
    <b-list-group>
      <b-list-group-item
        class="border-0 d-flex align-items-center"
        button
        v-for="(room, index) in rooms"
        :key="index"
        @click="select(room)"
      >
        <b-avatar class="mr-5 avatar"></b-avatar>
        <div
          v-if="room.user_id == user.id"
          class="d-flex align-items-center justify-content-between w-100"
        >
          <span class="mr-auto"> {{ room.name }}</span>
          <span class="time">{{ time(room.created_at) }}</span>
        </div>
        <div
          v-else
          class="d-flex align-items-center justify-content-between w-100"
        >
          <span> {{ room.user.name }}</span>
          <span class="time">{{ time(room.created_at) }}</span>
        </div>
      </b-list-group-item>
    </b-list-group>
  </b-card>
</template>

<script>
import axios from "axios";
import formatter from "../../formatter";
export default {
  props: ["rooms", "currentRoom"],
  data: function () {
    return {
      selected: "",
      username: "",
      room: "",
      user: null,
    };
  },
  methods: {
    select(room) {
      this.selected = room;
      this.$emit("roomchanged", this.selected);
    },
    out() {
      axios
        .get("/api/chat/room/logout", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          if (response.status == 200) {
            localStorage.clear();
            this.$router.push("/");
          }
        });
    },
    time(date) {
      return formatter.formatDate(date);
    },
  },
  created() {
    this.selected = this.currentRoom;
    console.log("current room: ", this.currentRoom);
    this.user = JSON.parse(localStorage.getItem("user"));
  },
};
</script>
<style scoped>
.card {
  width: 300px;
  height: calc(100vh - 62px);
  margin-top: 4px;
}
.avatar {
  background: #dfe5e7;
  color: white;
  margin-right: 4px;
}

.time {
  font-size: 9px;
  color: #827d7d;
}
</style>