<template>
      <div>
          <!-- <Container /> -->
<!-- <Welcome /> -->
          <router-view></router-view>
      </div>
</template>

<script>
import Container from './Chat/container.vue'
import Welcome from './Welcome.vue'
    export default {
        components:{
             Container,
           Welcome
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
