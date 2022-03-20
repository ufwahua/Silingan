<template>
    <div id="layout-config" :class="containerClass">
        <a
            href="#"
            class="layout-config-button"
            id="layout-config-button"
            @click="toggleChatContainer"
        >
            <i class="pi pi-user"></i>
        </a>
        <div class="grid">
            <div class="col flex align-content-center m-3">
                <div class="col">
                    <b class="flex align-items-center text-xl">Contacts</b>
                </div>
                <div>
                    <Button icon="pi pi-search" />
                </div>
            </div>

            <div class="col-12">
                <TabView ref="tabview1" :scrollable="true" lazy>
                    <TabPanel header="Residents">
                        <div v-for="resident in residents" :key="resident.id">
                            <ChatSideBarComponent
                                @click="openChatRoom(resident)"
                                v-bind:user="resident"
                            />
                        </div>
                    </TabPanel>
                    <TabPanel header="Security Officers">
                        <div
                            v-for="security_officer in security_officers"
                            :key="security_officer.id"
                        >
                            <ChatSideBarComponent
                                @click="openChatRoom(security_officer)"
                                v-bind:user="security_officer"
                            />
                        </div>
                    </TabPanel>
                    <TabPanel header="Officers">
                        <div v-for="officer in officers" :key="officer.id">
                            <ChatSideBarComponent
                                @click="openChatRoom(resident)"
                                v-bind:user="officer"
                            />
                        </div>
                    </TabPanel>

                    <TabPanel header="Admins">
                        <div v-for="admin in admins" :key="admin.id">
                            <ChatSideBarComponent
                                @click="openChatRoom(admin)"
                                v-bind:user="admin"
                            />
                        </div>
                    </TabPanel>
                </TabView>
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
    },
    computed: {
        containerClass() {
            return ["layout-config", { "layout-config-active": this.active }];
        },
    },
    mounted() {
        console.log("residents", this.residents);
    },
};
</script>
<style scoped>
div.p-dialog-header {
    padding: 10px !important;
}
</style>
