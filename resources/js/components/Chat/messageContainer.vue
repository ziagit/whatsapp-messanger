<template>
  <div class="container">
    <div class="msg-container h-full p-2 flex flex-col-reverse overflow-auto">
      <div v-for="(message, index) in messages" :key="index">
        <message-item :message="message" :me="myId" />
      </div>
    </div>
  </div>
</template>

<script>
import MessageItem from "./messageItem.vue";
export default {
  components: {
    MessageItem,
  },
  props: ["messages"],
  data: function () {
    return {
      myId: JSON.parse(localStorage.getItem('user')).id,
    };
  },
};
</script>
<style scoped>
.container {
  display: flex;
  background: #e5ddd5;
}
.msg-container {
  display: flex;
  width: 100%;
  flex-direction: column-reverse;
  overflow: auto;
  padding: 8px;
}
</style>