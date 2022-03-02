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
            style="max-height: 550px; width: 400px"
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

            <div v-if="!chat_room">Say Hi</div>
            <div v-else v-for="chat in chat_room.chats" :key="chat.id">
                <ChatMessagesComponent :chat="chat" />
            </div>

            <template v-if="!loading" #footer>
                <div class="col-12">
                    <Textarea
                        v-model="message"
                        :autoResize="true"
                        rows="1"
                        class="w-full"
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
import ChatSideBarComponent from "./ChatSideBarComponent.vue";
import ChatMessagesComponent from "./ChatMessagesComponent.vue";
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
            chosenRoom: null,
            chat_room: null,
            chats: null,
            user: null,
            loading: false,
            message: null,
            position: null,
            active: false,
            d_layoutMode: this.layoutMode,
            d_layoutColorMode: this.layoutColorMode,
            scale: 16,
            scales: [12, 13, 14, 15, 16],
        };
    },
    watch: {
        $route() {
            if (this.active) {
                this.active = false;
                this.unbindOutsideClickListener();
            }
        },
        layoutMode(newValue) {
            this.d_layoutMode = newValue;
        },
        layoutColorMode(newValue) {
            this.d_layoutColorMode = newValue;
        },
    },
    outsideClickListener: null,
    methods: {
        async openChatRoom(user) {
            this.chatRoomModal = true;
            this.loading = true;
            this.user = user;
            this.chosenRoom = this.$store.state.userLogged.id + " " + user.id;
            await axios({
                method: "get",
                url: "/api/chat_room/" + this.chosenRoom,
            })
                .then((res) => {
                    console.log(res.data[0]);
                    this.chat_room = res.data[0];
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.chats = [];
                    this.loading = false;
                });
        },

        toggleChatContainer(event) {
            this.active = !this.active;
            event.preventDefault();

            if (this.active) this.bindOutsideClickListener();
            else this.unbindOutsideClickListener();
        },
        hideConfigurator(event) {
            this.active = false;
            this.unbindOutsideClickListener();
            event.preventDefault();
        },
        changeInputStyle(value) {
            this.$primevue.config.inputStyle = value;
        },
        changeRipple(value) {
            this.$primevue.config.ripple = value;
        },
        changeLayout(event, layoutMode) {
            this.$emit("layout-change", layoutMode);
            event.preventDefault();
        },
        changeLayoutColor(event, layoutColor) {
            this.$emit("layout-color-change", layoutColor);
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
        decrementScale() {
            this.scale--;
            this.applyScale();
        },
        incrementScale() {
            this.scale++;
            this.applyScale();
        },
        applyScale() {
            document.documentElement.style.fontSize = this.scale + "px";
        },
        changeTheme(event, theme, dark = false) {
            let themeElement = document.getElementById("theme-link");
            themeElement.setAttribute(
                "href",
                themeElement
                    .getAttribute("href")
                    .replace(this.$appState.theme, theme)
            );
            this.$appState.theme = theme;
            this.$appState.darkTheme = dark;

            if (theme.startsWith("md")) {
                this.$primevue.config.ripple = true;
            }
        },
    },
    computed: {
        containerClass() {
            return ["layout-config", { "layout-config-active": this.active }];
        },
        rippleActive() {
            return this.$primevue.config.ripple;
        },
        inputStyle() {
            return this.$appState.inputStyle;
        },
    },
    mounted() {
        console.log(this.chat_room);
    },
};
</script>
<style scoped>
div.p-dialog-header {
    padding: 10px !important;
}
</style>
