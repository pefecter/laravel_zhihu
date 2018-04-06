<template>
    <div id="content">
        <button class="btn btn-default" v-text="text" :class="{'btn-info':voted}" @click="vote" style="'color: #999;border: solid 1px #999;">
                                </button>
    </div>
</template>
<script>
    import axios from "axios";
    export default {
        data() {
            return {
                voted: false,
                count: 0
            };
        },
        props: ["answer", 'count'],
        computed: {
            text() {
                return this.count;
            }
        },
        mounted() {
            axios.post("/api/answer/" + this.answer + "/votes/user").then(response => {
                this.voted = response.data.voted;
            });
        },
        methods: {
            vote() {
                axios
                    .post("/api/answer/vote", {
                        answer: this.answer
                    })
                    .then(response => {
                        this.voted = response.data.voted;
                        response.data.voted ? this.count++ : this.count--;
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