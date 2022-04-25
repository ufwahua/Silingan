<template>
    <div id="layout-config" :class="containerClass">
        <a
            href="#"
            class="layout-config-button"
            id="layout-config-button"
            @click="toggleChatContainer"
            v-tooltip="'Chat'"
        >
            <i class="pi pi-user"></i>
        </a>
        <div class="grid">
            <div class="col flex align-content-center mt-3 mx-3">
                <div class="col">
                    <b class="flex align-items-center text-xl">{{
                        resident
                            ? "Residents"
                            : officer
                            ? "Officers"
                            : admin
                            ? "Admins"
                            : "Security Officers"
                    }}</b>
                </div>
                <div>
                    <Button
                        icon="pi pi-replay"
                        @click="toggle"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                    />
                    <Menu
                        id="overlay_menu"
                        ref="menu"
                        :model="items"
                        :popup="true"
                        v-tooltip="'Chat'"
                    />
                </div>
            </div>
            <div class="col-12 flex justify-content-center">
                <InputText
                    v-model="search"
                    placeholder="search"
                    style="width: 300px"
                />
            </div>
            <div class="col-12 layout-config-content">
                <div v-if="resident">
                    <div v-for="resident in users" :key="resident.id">
                        <ChatSideBarComponent
                            v-if="resident.role === 'resident'"
                            @click="openChatRoom(resident)"
                            :user="resident"
                        />
                    </div>
                </div>
                <div v-if="security_officer">
                    <div
                        v-for="security_officer in users"
                        :key="security_officer.id"
                    >
                        <ChatSideBarComponent
                            v-if="security_officer.role === 'security officer'"
                            @click="openChatRoom(security_officer)"
                            v-bind:user="security_officer"
                        />
                    </div>
                </div>
                <div v-if="officer">
                    <div v-for="officer in users" :key="officer.id">
                        <ChatSideBarComponent
                            v-if="officer.role === 'officer'"
                            @click="openChatRoom(resident)"
                            v-bind:user="officer"
                        />
                    </div>
                </div>
                <div v-if="admin">
                    <div v-for="admin in users" :key="admin.id">
                        <ChatSideBarComponent
                            v-if="admin.role === 'admin'"
                            @click="openChatRoom(admin)"
                            v-bind:user="admin"
                        />
                    </div>
                </div>
            </div>
        </div>
        <Dialog
            v-model:visible="chatRoomModal"
            style="height: 600px; width: 400px"
            position="bottom"
        >
            <template #header>
                <div class="col-11 p-0 m-0">
                    <Button
                        label="Primary"
                        class="p-button-text p-0 m-0 w-full"
                    >
                        <div
                            class="col-fixed p-0 m-0"
                            style="width: 48px; height: 48px"
                        >
                            <Avatar
                                image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                class="mr-2 w-full h-full"
                                shape="circle"
                            />
                        </div>
                        <div class="col p-0 m-0">
                            {{ user.first_name }} {{ user.last_name }}
                        </div>
                    </Button>
                </div>
            </template>
            <div
                ref="chat_container"
                class="flex flex-column-reverse"
                style="min-height: 370px"
            >
                <p v-if="!this.chats" class="text-right">Say Hi</p>
                <div
                    v-else
                    v-for="chat in this.chats"
                    :key="chat.id"
                    class="grid"
                >
                    <ChatMessagesComponent v-if="chat.id" :chat="chat" />
                </div>
            </div>

            <template #footer>
                <div class="col-12">
                    <Textarea
                        v-model="message"
                        :autoResize="true"
                        rows="1"
                        class="w-full"
                        autofocus
                        @keypress.enter="sendMessage"
                    >
                    </Textarea>
                </div>
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
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import ChatSideBarComponent from "../components/ChatSideBarComponent.vue";
import ChatMessagesComponent from "../components/ChatMessagesComponent.vue";
export default {
    name: "ChatComponent",
    setup() {
        const store = useStore();
        return {
            users: computed(() => store.state.users),

            chats: computed(() => store.state.chats),
            notifications: computed(
                () => store.state.notifications.specific_notifications
            ),
            notif_count: computed(() => {
                return store.state.notifications.specific_notifications.filter(
                    (n) => n.viewed == 0
                ).length;
            }),
        };
    },

    props: {
        layoutMode: {
            type: String,
            default: null,
        },
        layoutColorMode: {
            type: String,
            default: null,
        },
    },
    components: {
        ChatSideBarComponent,
        ChatMessagesComponent,
    },
    data() {
        return {
            chatRoomModal: false,
            chats: null,
            user: null,
            search: null,
            loading: false,
            message: null,
            position: null,
            active: false,
            //change chat
            resident: true,
            officer: false,
            security_officer: false,
            admin: false,
            items: [
                {
                    label: "Resident",
                    command: () => {
                        this.resident = true;
                        this.officer = false;
                        this.security_officer = false;
                        this.admin = false;
                    },
                },
                {
                    label: "Officer",
                    command: () => {
                        this.resident = false;
                        this.officer = true;
                        this.security_officer = false;
                        this.admin = false;
                    },
                },
                {
                    label: "Security Officers",
                    command: () => {
                        this.resident = false;
                        this.officer = false;
                        this.security_officer = true;
                        this.admin = false;
                    },
                },
                {
                    label: "Admin",
                    command: () => {
                        this.resident = false;
                        this.officer = false;
                        this.security_officer = false;
                        this.admin = true;
                    },
                },
            ],
        };
    },
    watch: {
        search(after, before) {
            this.searchUser();
        },
        $route() {
            if (this.active) {
                this.active = false;
                this.unbindOutsideClickListener();
            }
        },
        "$store.state.chat_room_id"(val, oldVal) {
            if (oldVal) {
                this.disconnect(oldVal);
                this.connect();
            } else {
                this.connect();
            }
        },
    },
    outsideClickListener: null,
    methods: {
        searchUser() {
            axios({
                method: "get",
                url: "/api/user/search/",
                params: { query: this.search },
            })
                .then((res) => {
                    this.$store.commit("getSearchUser", res.data);
                })
                .catch((e) => {
                    console.log(e.response);
                });
        },
        toggle() {
            this.$refs.menu.toggle(event);
        },
        async sendMessage() {
            if (this.message) {
                this.loading = true;
                await axios({
                    method: "post",
                    url: "/api/chat/",
                    data: {
                        user_id: this.user.id,
                        message: this.message,
                        read: 0,
                    },
                })
                    .then(async (res) => {
                        this.message = null;
                        console.log("post chats", res.data);
                        this.$store.commit("getChats", res.data[0].chats);
                        if (this.notif_count == 0) {
                            await axios({
                                method: "post",
                                url: "/api/notification/chat",
                                data: {
                                    from_user_id:
                                        this.$store.state.userLogged.id,
                                    to_user_id: this.user.id,
                                    chat_room_id:
                                        res.data[0].chats[0].chat_room_id,
                                    message: "sent you a message",
                                },
                            })
                                .then(() => {
                                    console.log("notify success ");
                                })
                                .catch((e) => {
                                    console.log(e.response);
                                });
                        }

                        this.loading = false;
                    })
                    .catch((error) => {
                        this.$store.commit("getChats", null);
                        console.log(error.response);
                        this.loading = false;
                    });
            }
        },
        connect() {
            if (this.$store.state.chat_room_id) {
                let vm = this;
                window.Echo.private(
                    "chat." + this.$store.state.chat_room_id
                ).listen(".message.new", (e) => {
                    vm.openChatRoom(this.user);
                });
            }
        },
        disconnect(chat_room_id) {
            window.Echo.leave("chat." + chat_room_id);
        },
        openChatRoom(user) {
            this.chatRoomModal = true;
            this.message = null;
            this.user = user;
            axios({
                method: "get",
                url: "/api/chat_room/" + this.user.id,
            })
                .then((res) => {
                    this.$store.commit("getChatRoomId", res.data[0].id);
                    console.log("chats", res.data);
                    this.$store.commit("getChats", res.data[0].chats);
                })
                .catch((error) => {
                    this.$store.commit("getChats", null);
                    this.loading = false;
                });
        },

        toggleChatContainer(event) {
            this.active = !this.active;
            event.preventDefault();

            if (this.active) this.bindOutsideClickListener();
            else this.unbindOutsideClickListener();
        },
        bindOutsideClickListener() {
            if (!this.outsideClickListener) {
                this.outsideClickListener = (event) => {
                    if (this.active && this.isOutsideClicked(event)) {
                        this.active = false;
                    }
                };
                document.addEventListener("click", this.outsideClickListener);
            }
        },
        unbindOutsideClickListener() {
            if (this.outsideClickListener) {
                document.removeEventListener(
                    "click",
                    this.outsideClickListener
                );
                this.outsideClickListener = null;
            }
        },
        isOutsideClicked(event) {
            return !(
                this.$el.isSameNode(event.target) ||
                this.$el.contains(event.target)
            );
        },
        scrollToEnd() {
            // var content = this.$refs.chat_container;
            // content.scrollTop = content.scrollHeight;
            // alert(
            //     "scroll height is " +
            //         content.scrollHeight +
            //         " scroll Top is " +
            //         content.scrollTop
            // );
        },
    },
    computed: {
        containerClass() {
            return ["layout-config", { "layout-config-active": this.active }];
        },
    },
    mounted() {
        // this.$nextTick(() => this.scrollToEnd());
    },
    created() {
        this.$store.dispatch(
            "notifications/getSpecific",
            this.$store.state.userLogged.id
        );
    },
};
</script>
<style scoped>
div.p-dialog-header {
    padding: 10px !important;
}
</style>
