<template>
    <!-- receiver -->
    <div class="col-12">
        <div
            v-if="chat.user_id !== this.$store.state.userLogged.id"
            class="p-inputgroup pt-1 pb-0 my-0"
        >
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
                    <b>{{ chat.user.first_name }} {{ chat.user.last_name }}</b>
                </div>
                <div
                    class="h-auto card pb-0 pt-1 px-2 mb-0 mt-1"
                    style="background-color: var(--blue-50); max-width: 200px"
                    v-tooltip="`${chat.created_at}`"
                >
                    <p class="p-1">{{ chat.message }}</p>
                </div>
            </div>
        </div>

        <!-- sender -->

        <div v-else class="p-inputgroup pt-1 pb-0 my-0 flex-row-reverse">
            <div>
                <div
                    class="h-auto card pb-0 pt-1 px-2 mb-0 mt-1"
                    style="background-color: var(--blue-100); max-width: 200px"
                    v-tooltip="`${chat.created_at}`"
                >
                    <p class="p-1">{{ chat.message }}</p>
                </div>
            </div>
            <div>
                <Button
                    class="p-button-text"
                    icon="pi pi-ellipsis-v"
                    @click="toggle"
                    aria-haspopup="true"
                    aria-controls="overlay_menu"
                />
            </div>
        </div>
        <Dialog
            v-model:visible="removeModal"
            :style="{ width: '450px' }"
            header="Delete chat?"
            :modal="true"
        >
            <div class="confirmation-content">
                <div class="grid">
                    <div
                        class="col-12 flex align-items-center justify-content-center"
                    >
                        <i
                            class="pi pi-exclamation-triangle mr-3"
                            style="font-size: 2rem"
                        />
                        <span>Are you sure you want to delete this chat?</span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="removeModal = false"
                />
                <Button
                    label="Remove"
                    class="p-button p-button-danger"
                    @click="deleteChat"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="loading"
            :style="{ width: '450px' }"
            :modal="true"
            :closable="false"
            :closeOnEscape="true"
        >
            <div class="grid">
                <div class="col-12 text-center">
                    <ProgressSpinner
                        class="block mb-4"
                        style="width: 100px; height: 100px"
                        strokeWidth="4"
                        fill="#EEEEEE"
                        animationDuration="1s"
                    />
                </div>
            </div>
        </Dialog>
        <Menu id="overlay_menu" ref="menu" :model="items" :popup="true" />
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
            removeModal: false,
            loading: false,
            items: [
                {
                    label: "Delete Chat",
                    icon: "pi pi-trash",
                    command: () => {
                        this.removeModal = true;
                    },
                },
            ],
        };
    },
    methods: {
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        async deleteChat() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/chat/" + this.chat.id,
                data:{
                    chat_room_id: this.chat.chat_room_id,
                }
            })
                .then((res) => {
                    this.removeModal = false;
                    console.log('delete chat',res.data[0].chats);
                    this.$store.commit("getChats", res.data[0].chats);
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;

                });
        },
    },
};
</script>
