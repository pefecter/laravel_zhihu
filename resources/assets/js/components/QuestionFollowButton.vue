<template>
  <div id="content">
    <button class="btn btn-default" v-text="text" 
    :class="{'btn-success':followed}" 
    @click="follow" style="'color: #999;border: solid 1px #999;">
    </button>
  </div>
</template>
<script>
  import axios from "axios";
  export default {
    data() {
      return {
        followed: false
      };
    },
    props: ["question"],
    computed: {
      text() {
        return this.followed ? "已关注" : "关注该问题";
      }
    },
    mounted() {
      axios
        .post("/api/question/follower", {
          question: this.question
        })
        .then(response => {
          this.followed = response.data.followed;
        });
    },
    methods: {
      follow() {
        axios
          .post("/api/question/follow", {
            question: this.question
          })
          .then(response => {
            this.followed = response.data.followed;
          });
      }
    }
  };
</script>
<style lang="scss" scoped>
  #content {
    display: inline-block;
    margin-right: 10px;
  }

</style>



