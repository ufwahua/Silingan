<template>
    <div class="grid">
        <div class="col-12 pb-0 mb-0">
            <div class="p-inputgroup pt-1 pb-0 my-0">
                <Avatar
                    image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                    class="mr-2"
                    size="large"
                    shape="circle"
                />
                <div
                    class="card w-full pb-0 pt-1 px-2 mb-0 mt-1"
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
            {{ comment.updated_at }}
        </div>
        <div class="col-11 col-offset-1">
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
};
</script>
