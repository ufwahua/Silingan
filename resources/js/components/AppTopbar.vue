<template>
    <div class="layout-topbar">
        <router-link to="/admin/timeline" class="layout-topbar-logo">
            <img
                alt="Silingan-Logo"
                src="http://localhost:8000/storage/images/silingan-icon.png"
            />
        </router-link>
        <button
            v-if="userLogged.status != 'inactive'"
            class="p-link layout-menu-button layout-topbar-button"
            @click="onMenuToggle"
        >
            <i class="pi pi-bars"></i>
        </button>

        <button
            v-if="userLogged.status != 'inactive'"
            class="p-link layout-topbar-menu-button layout-topbar-button"
            v-styleclass="{
                selector: '@next',
                enterClass: 'hidden',
                enterActiveClass: 'scalein',
                leaveToClass: 'hidden',
                leaveActiveClass: 'fadeout',
                hideOnOutsideClick: true,
            }"
        >
            <i class="pi pi-ellipsis-v"></i>
        </button>
        <ul
            v-if="userLogged.status != 'inactive'"
            class="layout-topbar-menu hidden lg:flex origin-top"
        >
            <div v-if="notif_count > 0">
                <li
                    v-badge.danger="notif_count > 10 ? '10+' : notif_count"
                    @click="updateNotif"
                >
                    <Button
                        type="button"
                        label="Toggle"
                        @click="toggleNotification"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                        class="p-link layout-topbar-button"
                    >
                        <i class="pi pi-bell"></i>
                        <span>Notification</span>
                    </Button>
                    <OverlayPanel
                        ref="menu2"
                        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
                        :style="{ width: '450px' }"
                        :dismissable="true"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                    >
                        <ScrollPanel
                            style="width: 100%; height: 200px"
                            class="custombar1"
                            :popup="true"
                        >
                            <div v-if="notifications.length == 0" class="grid">
                                <div class="col-12">
                                    <p>No Notifications</p>
                                </div>
                            </div>
                            <div v-else>
                                <div
                                    v-for="notif in notifications"
                                    class="grid grid-nogutter"
                                    :key="notif.id"
                                >
                                    <div
                                        @click="toggleNotification"
                                        class="col-12 m-1"
                                    >
                                        <Button
                                            class="p-button-text p-button-secondary w-full"
                                            @click="
                                                notif.chat_room_id
                                                    ? openChatRoom(
                                                          notif.from_user
                                                      )
                                                    : notif.post_id
                                                    ? getSpecificPost(
                                                          notif.post_id
                                                      )
                                                    : notif.election_id
                                                    ? openElection()
                                                    : getAnnouncementPage()
                                            "
                                        >
                                            <div class="p-inputgroup">
                                                <div
                                                    v-if="
                                                        notif.from_user
                                                            .profile_pic
                                                    "
                                                >
                                                    <Avatar
                                                        :image="`http://127.0.0.1:8000${notif.from_user.profile_pic}`"
                                                        class="mr-2"
                                                        size="large"
                                                        shape="circle"
                                                        alt="Image"
                                                    />
                                                </div>
                                                <div v-else>
                                                    <Avatar
                                                        image="http://127.0.0.1:8000/storage/images/avatar.png"
                                                        class="mr-2"
                                                        size="large"
                                                        shape="circle"
                                                        alt="Image"
                                                    />
                                                </div>

                                                <div class="grid grid-nogutter">
                                                    <div class="col-12">
                                                        <b class="p-0 m-0">
                                                            {{
                                                                notif.from_user
                                                                    .first_name
                                                            }}
                                                            {{
                                                                notif.from_user
                                                                    .last_name
                                                            }}</b
                                                        >
                                                        <b class="p-0 m-0">
                                                            [{{
                                                                notif.from_user
                                                                    .role
                                                            }}]
                                                        </b>
                                                    </div>
                                                    <div class="col-12">
                                                        <p>
                                                            {{ notif.message }}
                                                        </p>
                                                        <p class="text-right">
                                                            {{
                                                                notif.created_at
                                                            }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </Button>
                                    </div>
                                    <div class="col-12">
                                        <Divider align="right" class="ml-4">
                                        </Divider>
                                    </div>
                                </div>
                            </div>
                        </ScrollPanel>
                    </OverlayPanel>
                </li>
            </div>
            <div v-else>
                <li>
                    <Button
                        type="button"
                        label="Toggle"
                        @click="toggleNotification"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                        class="p-link layout-topbar-button"
                    >
                        <i class="pi pi-bell"></i>
                        <span>Notification</span>
                    </Button>
                    <OverlayPanel
                        ref="menu2"
                        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
                        :style="{ width: '450px' }"
                        :dismissable="true"
                    >
                        <ScrollPanel
                            style="width: 100%; height: 200px"
                            class="custombar1"
                            :popup="true"
                        >
                            <div v-if="notifications.length == 0" class="grid">
                                <div class="col-12">
                                    <p>No Notifications</p>
                                </div>
                            </div>
                            <div v-else>
                                <div
                                    v-for="notif in notifications"
                                    class="grid grid-nogutter"
                                    :key="notif.id"
                                >
                                    <div
                                        @click="toggleNotification"
                                        class="col-12 m-1"
                                    >
                                        <Button
                                            v-if="
                                                notif.chat_room_id ||
                                                notif.post_id ||
                                                notif.election_id ||
                                                notif.announcement_id
                                            "
                                            class="p-button-text p-button-secondary w-full"
                                            @click="
                                                notif.chat_room_id
                                                    ? openChatRoom(
                                                          notif.from_user
                                                      )
                                                    : notif.post_id
                                                    ? getSpecificPost(
                                                          notif.post_id
                                                      )
                                                    : notif.election_id
                                                    ? openElection()
                                                    : getAnnouncementPage()
                                            "
                                        >
                                            <div class="p-inputgroup">
                                                <div
                                                    v-if="
                                                        notif.from_user
                                                            .profile_pic
                                                    "
                                                >
                                                    <Avatar
                                                        :image="`http://127.0.0.1:8000${notif.from_user.profile_pic}`"
                                                        class="mr-2"
                                                        size="large"
                                                        shape="circle"
                                                        alt="Image"
                                                    />
                                                </div>
                                                <div v-else>
                                                    <Avatar
                                                        image="http://127.0.0.1:8000/storage/images/avatar.png"
                                                        class="mr-2"
                                                        size="large"
                                                        shape="circle"
                                                        alt="Image"
                                                    />
                                                </div>

                                                <div class="grid grid-nogutter">
                                                    <div class="col-12">
                                                        <b class="p-0 m-0">
                                                            {{
                                                                notif.from_user
                                                                    .first_name
                                                            }}
                                                            {{
                                                                notif.from_user
                                                                    .last_name
                                                            }}</b
                                                        >
                                                        <b class="p-0 m-0">
                                                            [{{
                                                                notif.from_user
                                                                    .role
                                                            }}]
                                                        </b>
                                                    </div>
                                                    <div class="col-12">
                                                        <p>
                                                            {{ notif.message }}
                                                        </p>
                                                        <p class="text-right">
                                                            {{
                                                                notif.created_at
                                                            }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </Button>
                                        <div v-else>
                                            <div class="p-inputgroup">
                                                <div
                                                    v-if="
                                                        notif.from_user
                                                            .profile_pic
                                                    "
                                                >
                                                    <Avatar
                                                        :image="`http://127.0.0.1:8000${notif.from_user.profile_pic}`"
                                                        class="mr-2"
                                                        size="large"
                                                        shape="circle"
                                                        alt="Image"
                                                    />
                                                </div>
                                                <div v-else>
                                                    <Avatar
                                                        image="http://127.0.0.1:8000/storage/images/avatar.png"
                                                        class="mr-2"
                                                        size="large"
                                                        shape="circle"
                                                        alt="Image"
                                                    />
                                                </div>

                                                <div class="grid grid-nogutter">
                                                    <div class="col-12">
                                                        <b class="p-0 m-0">
                                                            {{
                                                                notif.from_user
                                                                    .first_name
                                                            }}
                                                            {{
                                                                notif.from_user
                                                                    .last_name
                                                            }}</b
                                                        >
                                                        <b class="p-0 m-0">
                                                            [{{
                                                                notif.from_user
                                                                    .role
                                                            }}]
                                                        </b>
                                                    </div>
                                                    <div class="col-12">
                                                        <p>
                                                            {{ notif.message }}
                                                        </p>
                                                        <p class="text-right">
                                                            {{
                                                                notif.created_at
                                                            }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <Divider> </Divider>
                                    </div>
                                </div>
                            </div>
                        </ScrollPanel>
                    </OverlayPanel>
                </li>
            </div>

            <li>
                <button
                    class="p-link layout-topbar-button"
                    label="Toggle"
                    @click="toggleProfile"
                    aria-haspopup="true"
                    aria-controls="overlay_menu"
                >
                    <i class="pi pi-user"></i>
                    <span>Profile</span>
                </button>
                <Menu
                    id="overlay_menu"
                    ref="menu"
                    :model="profile_menu"
                    :popup="true"
                />
            </li>
        </ul>
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
                class="flex flex-column-reverse chat_container"
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
                        @keypress.enter="sendMessage"
                        autofocus
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
import ChatMessagesComponent from "./ChatMessagesComponent.vue";

export default {
    components: {
        ChatMessagesComponent,
    },
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
            chats: computed(() => store.state.chats),
            notifications: computed(() => {
                if (store.state.notifications.specific_notifications != null) {
                    return store.state.notifications.specific_notifications;
                }
            }),
            notif_count: computed(() => {
                if (store.state.notifications.specific_notifications != null) {
                    return store.state.notifications.specific_notifications.filter(
                        (n) => n.viewed == 0
                    ).length;
                }
            }),
        };
    },
    data() {
        return {
            profile_pic: false,
            items: [],
            profile_menu: null,

            chatRoomModal: false,
            message: null,
            user: null,
        };
    },
    watch: {
        "$store.state.chat_room_id"(val, oldVal) {
            if (oldVal) {
                this.disconnect(oldVal);
            }
        },
        chats() {
            const chatCont =
                document.querySelector(".chat_container").parentNode;
            chatCont.scrollTop = chatCont.scrollHeight;
        },
    },
    methods: {
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
                                url: "/api/notification",
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
            let vm = this;
            window.Echo.private(
                "chat." + this.$store.state.chat_room_id
            ).listen(".message.new", (e) => {
                vm.openChatRoom(this.user);
            });
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
                    this.connect();
                })
                .catch((error) => {
                    this.$store.commit("getChats", null);
                    this.loading = false;
                });
        },
        async updateNotif() {
            await axios({
                method: "put",
                url: "/api/notification/" + this.$store.state.userLogged.id,
            })
                .then(() => {
                    console.log("success");
                    this.$store.dispatch(
                        "notifications/getSpecific",
                        this.$store.state.userLogged.id
                    );
                })
                .catch((e) => {
                    console.log(e.response);
                });
        },
        toggleProfile(event) {
            this.$refs.menu.toggle(event);
        },
        toggleNotification(event) {
            this.$store.dispatch(
                "notifications/getSpecific",
                this.$store.state.userLogged.id
            );
            this.items = [];
            if (this.notifications) {
                this.notifications.forEach((elem) => {
                    if (elem.chat_room_id) {
                        this.items.push({
                            label: "",
                            items: [
                                {
                                    label: elem.message,

                                    icon: "pi pi-comment",
                                    command: () => {},
                                },
                            ],
                        });
                    } else {
                        this.items.push({
                            label: elem.message,
                            icon: "pi pi-",
                            items: [
                                {
                                    label: elem.created_at,
                                    command: () => {},
                                },
                            ],
                        });
                    }
                });
            } else {
                this.items.push({
                    label: "no notifcation",
                });
            }

            this.$refs.menu2.toggle(event);
        },
        onMenuToggle(event) {
            this.$emit("menu-toggle", event);
        },
        onTopbarMenuToggle(event) {
            this.$emit("topbar-menu-toggle", event);
        },
        getAnnouncementPage() {
            if (this.userLogged.role == "security officer") {
                return this.$router.push("/security-officer/view-announcement");
            } else {
                return this.$router.push(
                    `/${this.userLogged.role}` + "/view-announcement"
                );
            }
        },
        openElection() {
            return this.$router.push(`/${this.userLogged.role}` + "/election");
        },
        getSpecificPost(post_id) {
            this.$store.dispatch("posts/getSpecificPost", post_id);
            if (this.userLogged.role == "security officer") {
                return this.$router.push("/security-officer/post/" + post_id);
            } else {
                return this.$router.push(
                    `/${this.userLogged.role}` + "/post/" + post_id
                );
            }
        },
    },
    mounted() {
        this.$store.dispatch(
            "notifications/getSpecific",
            this.$store.state.userLogged.id
        );

        if (this.$store.state.userLogged.status != "active") {
            this.profile_menu = [
                {
                    label:
                        this.$store.state.userLogged.first_name +
                        " " +
                        this.$store.state.userLogged.last_name,
                    items: [
                        {
                            label: "Logout",
                            icon: "pi pi-sign-out",
                            command: async () => {
                                await axios({
                                    method: "get",
                                    url: "/api/logout",
                                })
                                    .then((response) => {
                                        console.log(response);
                                        this.$store.dispatch("logout", null);
                                        this.$router.push("/login");
                                    })
                                    .catch((error) => {
                                        console.log(error.response);
                                    });
                            },
                        },
                    ],
                },
            ];
        } else if (
            this.$store.state.userLogged.role === "admin" ||
            this.$store.state.userLogged.role === "officer"
        ) {
            this.profile_menu = [
                {
                    label:
                        this.userLogged.first_name +
                        " " +
                        this.userLogged.last_name,
                    items: [
                        {
                            label: "Profile",
                            icon: "pi pi-pencil",
                            command: () => {
                                if (this.userLogged.role === "officer") {
                                    this.$router.push("/admin/profile");
                                } else if (
                                    this.userLogged.role === "security officer"
                                ) {
                                    this.$router.push(
                                        "/security-officer/profile"
                                    );
                                } else {
                                    this.$router.push(
                                        `/${this.userLogged.role}` + "/profile"
                                    );
                                }
                            },
                        },
                        {
                            label: "Setting",
                            icon: "pi pi-cog",
                            command: () => {
                                if (
                                    this.userLogged.role === "security officer"
                                ) {
                                    this.$router.push(
                                        "/security-officer/setting"
                                    );
                                } else {
                                    this.$router.push(
                                        `/${this.userLogged.role}` + "/setting"
                                    );
                                }
                            },
                        },
                        {
                            label: "Logout",
                            icon: "pi pi-sign-out",
                            command: async () => {
                                await axios({
                                    method: "get",
                                    url: "/api/logout",
                                })
                                    .then((response) => {
                                        console.log(response);

                                        this.$store.dispatch("logout", null);
                                        this.$router.push("/login");
                                    })
                                    .catch((error) => {
                                        console.log(error.response);
                                    });
                            },
                        },
                    ],
                },
            ];
        } else {
            this.profile_menu = [
                {
                    label:
                        this.userLogged.first_name +
                        " " +
                        this.userLogged.last_name,
                    items: [
                        {
                            label: "Profile",
                            icon: "pi pi-pencil",
                            command: () => {
                                if (this.userLogged.role === "officer") {
                                    this.$router.push("/admin/profile");
                                } else if (
                                    this.userLogged.role === "security officer"
                                ) {
                                    this.$router.push(
                                        "/security-officer/profile"
                                    );
                                } else {
                                    this.$router.push(
                                        `/${this.userLogged.role}` + "/profile"
                                    );
                                }
                            },
                        },

                        {
                            label: "Setting",
                            icon: "pi pi-cog",
                            command: () => {
                                if (
                                    this.userLogged.role === "security officer"
                                ) {
                                    this.$router.push(
                                        "/security-officer/setting"
                                    );
                                } else {
                                    this.$router.push(
                                        `/${this.userLogged.role}` + "/setting"
                                    );
                                }
                            },
                        },

                        {
                            label: "Logout",
                            icon: "pi pi-sign-out",
                            command: async () => {
                                await axios({
                                    method: "get",
                                    url: "/api/logout",
                                })
                                    .then((response) => {
                                        console.log(response);

                                        this.$store.dispatch("logout", null);
                                        this.$router.push("/login");
                                    })
                                    .catch((error) => {
                                        console.log(error.response);
                                    });
                            },
                        },
                    ],
                },
            ];
        }
    },
};
</script>
