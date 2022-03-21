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
            <div class="col flex align-content-center m-3">
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
                    <Button icon="pi pi-replay" @click="toggle" />
                    <Menu
                        id="chat_menu"
                        ref="menu_chat"
                        :model="items"
                        :popup="true"
                        v-tooltip="'Chat'"
                    />
                </div>
            </div>

            <div class="col-12 layout-config-content">
                <div v-if="resident">
                    <div v-for="resident in residents" :key="resident.id">
                        <ChatSideBarComponent
                            @click="openChatRoom(resident)"
                            v-bind:user="resident"
                        />
                    </div>
                </div>
                <div v-if="security_officer">
                    <div
                        v-for="security_officer in security_officers"
                        :key="security_officer.id"
                    >
                        <ChatSideBarComponent
                            @click="openChatRoom(security_officer)"
                            v-bind:user="security_officer"
                        />
                    </div>
                </div>
                <div v-if="officer">
                    <div v-for="officer in officers" :key="officer.id">
                        <ChatSideBarComponent
                            @click="openChatRoom(resident)"
                            v-bind:user="officer"
                        />
                    </div>
                </div>
                <div v-if="admin">
                    <div v-for="admin in admins" :key="admin.id">
                        <ChatSideBarComponent
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
            <div class="flex flex-column-reverse" style="min-height: 370px">
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

            <template v-if="!loading" #footer>
                <div class="col-12">
                    <Textarea
                        v-model="message"
                        :autoResize="true"
                        rows="1"
                        class="w-full"
                        @keypress.enter="sendMessage"
                    >
                    </Textarea>
                </div>
            </template>
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
            residents: computed(() => store.state.registeredUsers.residents),
            officers: computed(() => store.state.registeredUsers.officers),
            admins: computed(() => store.state.registeredUsers.admins),
            security_officers: computed(
                () => store.state.registeredUsers.security_officers
            ),
            chats: computed(() => store.state.chats),
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
            chat_room_id: null,
            chatRoomModal: false,
            chats: null,
            user: null,

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
        $route() {
            if (this.active) {
                this.active = false;
                this.unbindOutsideClickListener();
            }
        },
    },
    outsideClickListener: null,
    watch: {
        chat_room_id(val, oldVal) {
            if (oldVal) {
                this.disconnect(oldVal);
            } else {
                this.connect();
            }
        },
    },
    methods: {
        toggle() {
            this.$refs.menu_chat.toggle(event);
        },
        async sendMessage() {
            await axios({
                method: "post",
                url: "/api/chat/",
                data: {
                    user_id: this.user.id,
                    message: this.message,
                },
            })
                .then((res) => {
                    this.message = null;
                    console.log(res.data[0].chats);
                    this.$store.commit("getChats", res.data[0].chats);
                })
                .catch((error) => {
                    this.$store.commit("getChats", null);
                    console.log(error.response);
                });
        },
        connect() {
            if (this.chat_room_id) {
                let vm = this;
                window.Echo.private("chat." + this.chat_room_id).listen(
                    ".message.new",
                    (e) => {
                        vm.openChatRoom(this.user);
                    }
                );
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
                    this.chat_room_id = res.data[0].id;
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
    },
    computed: {
        containerClass() {
            return ["layout-config", { "layout-config-active": this.active }];
        },
    },
};
</script>
<style scoped>
div.p-dialog-header {
    padding: 10px !important;
}
</style>
