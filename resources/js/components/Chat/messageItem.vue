<template>
  <div>
    <div v-bind:class="[message.user_id == me ? 'my-sms' : 'frind-sms']">
      <div>{{ message.message }}</div>
      <div class="time-container">
        <span class="time">{{ time(message.created_at) }}</span>
        <b-icon
          v-if="message.user_id == me"
          icon="check-all"
          variant="primary"
        ></b-icon>
      </div>
    </div>
  </div>
</template>

<script>
import formatter from '../../formatter';
export default {
  props: ["message", "me"],
  created() {
    console.log("first: ", this.me);
  },
  methods: {
    time(date){
      return formatter.formatTime(date);
    }
  },
};
</script>
<style scoped>
.my-sms {
  float: right;
  background-color: #dcf8c6;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  border-bottom-left-radius: 10px;
  margin-bottom: 5px;
  display: inline-block;
  padding: 3px 6px;
  font-size: 14px;
  -webkit-box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.15);
  box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.15);
}
.frind-sms {
  background-color: white;
  border-bottom-left-radius: 10px;
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
  margin-bottom: 5px;
  display: inline-block;
  padding: 3px 6px;
  font-size: 14px;
  -webkit-box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.15);
  box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.15);
}
.time-container {
  text-align: right;
}
.time {
  font-size: 9px;
  color: #827d7d;
}
</style>