<template>
  <b-card class="border-0 shadow-sm">
    <b-list-group>
      <b-list-group-item class="border-0" button v-for="(room, index) in rooms" :key="index" @click="select(room)">{{
        room.name
      }}
      </b-list-group-item>
    </b-list-group>
  </b-card>
</template>

<script>
export default {
  props: ["rooms", "currentRoom"],
  data: function () {
    return {
      selected: "",
      username: "",
      room: "",
    };
  },
  methods: {
    select(room) {
      this.selected = room;
      this.$emit("roomchanged", this.selected);
    },
  },
  created() {
    this.selected = this.currentRoom;
    console.log("rooms:", this.rooms);
  },
};
</script>
<style scoped lang="scss">
.card {
  width: 300px;
  height: calc(100vh - 62px);
  margin-top: 4px;
}
</style>