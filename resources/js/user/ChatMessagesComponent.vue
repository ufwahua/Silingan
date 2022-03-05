<template>
    <div>
        <!-- receiver -->
        <div
            v-if="chat.user_id !== this.$store.state.userLogged.id"
            class="col-12 pt-2 p-0 m-0"
        >
            <div class="p-inputgroup pt-1 pb-0 my-0">
                <div>
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                </div>
                <div class="grid grid-nogutter">
                    <div class="col-12">
                        <b
                            >{{ chat.user.first_name }}
                            {{ chat.user.last_name }}</b
                        >
                    </div>
                    <div
                        class="card pb-0 pt-1 px-2 mb-0 mt-1"
                        style="background-color: var(--blue-50)"
                    >
                        <div
                            class="col-12 pb-1"
                            v-tooltip="`${chat.created_at}`"
                        >
                            {{ chat.message }}
                        </div>
                    </div>
                </div>
                <div class="flex align-items-center">
                    <Button
                        class="p-button-text"
                        icon="pi pi-ellipsis-v"
                        @click="toggle"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                    />
                    <Menu
                        id="overlay_menu"
                        ref="menu"
                        :model="items"
                        :popup="true"
                    />
                </div>
            </div>
        </div>
        <!-- sender -->
        <div v-else class="col-12 pt-2 p-0 m-0">
            <div class="p-inputgroup pt-1 pb-0 my-0">
                <div class="flex align-items-center">
                    <Button
                        class="p-button-text"
                        icon="pi pi-ellipsis-v"
                        @click="toggle"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                    />
                    <Menu
                        id="overlay_menu"
                        ref="menu"
                        :model="items"
                        :popup="true"
                    />
                </div>

                <div class="grid grid-nogutter">
                    <div
                        class="card pb-0 pt-1 px-2 mb-0 mt-1"
                        style="background-color: var(--blue-100)"
                    >
                        <div
                            class="col-12 pb-1"
                            v-tooltip="`${chat.created_at}`"
                        >
                            {{ chat.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ChatMessagesComponent",
    props: {
        chat: {
            type: Object,
        },
    },
    data() {
        return {
            items: [
                {
                    label: "Remove",
                    icon: "pi pi-trash",
                    command: () => {
                        this.editModal = true;
                        this.content = this.post.content;
                    },
                },
            ],
        };
    },
    methods: {
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
    },
};
</script>
