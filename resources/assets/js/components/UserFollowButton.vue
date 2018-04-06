<template>
    <div id="content">
        <button class="btn btn-default" v-text="text" :class="{'btn-success':followed}" @click="follow" style="'color: #999;border: solid 1px #999;">
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
        props: ["user"],
        computed: {
            text() {
                return this.followed ? "已关注" : "关注Ta";
            }
        },
        mounted() {
            axios.get("/api/user/followers/" + this.user).then(response => {
                this.followed = response.data.followed;
            });
        },
        methods: {
            follow() {
                axios
                    .post("/api/user/follow", {
                        user: this.user
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