<template>
    <div class="grid">
        <div class="col-12 pb-0 mb-0">
            <div class="p-inputgroup pt-1 pb-0 my-0">
                <div>
                    <Avatar
                        image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                </div>

                <div
                    class="card pb-0 pt-1 px-2 mb-0 mt-1"
                    style="background-color: var(--blue-50)"
                >
                    <div class="grid grid-nogutter">
                        <div class="col-12">
                            <b>
                                {{ comment.user.first_name }}
                                {{ comment.user.last_name }}</b
                            >
                        </div>
                        <div class="col-12 pb-1">
                            {{ comment.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 pl-7 p-0 m-0">
            <ul class="m-0 p-0" style="list-style-type: none">
                <li style="display: inline">
                    <Button
                        label="Reply"
                        class="p-button-secondary p-button-text m-0 p-0 mr-2"
                        @click="showReply"
                    />
                </li>
                <li style="display: inline">
                    <span>{{ comment.updated_at }}</span>
                </li>
            </ul>
        </div>

        <div v-if="show_reply" class="col-11 col-offset-1 pt-2 mt-2">
            <div class="p-inputgroup mb-2">
                <div>
                    <Avatar
                        image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                </div>
                <Textarea
                    @keypress.enter="replyPost"
                    v-model="message"
                    :autoResize="true"
                    rows="1"
                    class="w-full"
                >
                </Textarea>
            </div>
        </div>
        <div v-if="show_reply" class="col-11 col-offset-1 py-0 my-0">
            <div v-for="reply in comment.reply" :key="reply.id">
                <ReplyComponent v-if="reply.id" v-bind:reply="reply" />
            </div>
        </div>
    </div>
</template>
<script>
import ReplyComponent from "./ReplyComponent.vue";
export default {
    props: {
        comment: {
            type: Object,
        },
    },
    components: {
        ReplyComponent,
    },
    data() {
        return {
            show_reply: false,
            message: null,
        };
    },
    methods: {
        async replyPost() {
            await axios({
                method: "post",
                url: "/api/reply",
                data: {
                    comment_id: this.comment.id,
                    user_id: this.$store.state.userLogged.id,
                    message: this.message,
                },
            })
                .then((res) => {
                    this.$store.dispatch("posts/getAll");
                    this.message = null;
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
        showReply() {
            this.show_reply = !this.show_reply;
        },
    },
};
</script>
