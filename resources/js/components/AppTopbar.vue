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
        <ul class="layout-topbar-menu hidden lg:flex origin-top">
            <div v-if="notif_count > 0">
                <li
                    @click="updateNotif()"
                    v-badge.danger="notif_count > 10 ? '10+' : notif_count"
                    v-if="userLogged.status != 'inactive'"
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
                        ref="op"
                        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
                        :style="{ width: '450px' }"
                        :dismissable="false"
                    >
                        <ScrollPanel
                            style="width: 100%; height: 200px"
                            class="custombar1"
                        >
                            <div v-if="notifications.length == 0" class="grid">
                                <div class="col-12">
                                    <p>No Notifications</p>
                                </div>
                            </div>
                            <div v-else>
                                <div
                                    v-for="notif in notifications"
                                    class="grid"
                                >
                                    <div class="col-12">
                                        <div
                                            v-if="
                                                notif.device_type ===
                                                    'Laptop' ||
                                                notif.device_type === 'Monitor'
                                            "
                                            class="inline"
                                        >
                                            <div class="inline mr-3">
                                                <Button
                                                    icon="pi pi-desktop"
                                                    class="p-button-rounded p-button-outlined"
                                                    disabled
                                                />
                                            </div>
                                        </div>
                                        <div v-else class="inline">
                                            <div class="inline mr-3">
                                                <Button
                                                    icon="pi pi-inbox"
                                                    class="p-button-rounded p-button-outlined"
                                                    disabled
                                                />
                                            </div>
                                        </div>
                                        <p class="inline">
                                            {{ notif.message }}
                                        </p>
                                        <Divider align="right" class="ml-4">
                                            <div
                                                class="inline-flex align-items-center"
                                            >
                                                <small>{{
                                                    notif.created_at
                                                }}</small>
                                            </div>
                                        </Divider>
                                    </div>
                                </div>
                            </div>
                        </ScrollPanel>
                    </OverlayPanel>
                </li>
            </div>
            <div v-else>
                <li
                    @click="updateNotif()"
                    v-if="userLogged.status != 'inactive'"
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
                        ref="op"
                        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
                        :style="{ width: '450px' }"
                        :dismissable="false"
                    >
                        <ScrollPanel
                            style="width: 100%; height: 200px"
                            class="custombar1"
                        >
                            <div v-if="notifications.length == 0" class="grid">
                                <div class="col-12">
                                    <p>No Notifications</p>
                                </div>
                            </div>
                            <div v-else>
                                <div
                                    v-for="notif in notifications"
                                    class="grid"
                                >
                                    <div class="col-12">
                                        <div
                                            v-if="
                                                notif.device_type ===
                                                    'Laptop' ||
                                                notif.device_type === 'Monitor'
                                            "
                                            class="inline"
                                        >
                                            <div class="inline mr-3">
                                                <Button
                                                    icon="pi pi-desktop"
                                                    class="p-button-rounded p-button-outlined"
                                                    disabled
                                                />
                                            </div>
                                        </div>
                                        <div v-else class="inline">
                                            <div class="inline mr-3">
                                                <Button
                                                    icon="pi pi-inbox"
                                                    class="p-button-rounded p-button-outlined"
                                                    disabled
                                                />
                                            </div>
                                        </div>
                                        <p class="inline">
                                            {{ notif.message }}
                                        </p>
                                        <Divider align="right" class="ml-4">
                                            <div
                                                class="inline-flex align-items-center"
                                            >
                                                <small>{{
                                                    notif.created_at
                                                }}</small>
                                            </div>
                                        </Divider>
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
                    @click="toggle"
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
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
            notifications: computed(() => {
                let temp = [];
                let user = store.state.userLogged;
                store.state.notifications.notifications.forEach((elem) => {
                    if (elem.user_id === user.id) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
            notif_count: computed(() => {
                let temp = [];
                let user = store.state.userLogged;
                store.state.notifications.notifications.forEach((elem) => {
                    if (elem.user_id === user.id) {
                        temp.push(elem);
                    }
                });
                return temp.filter((n) => n.viewed === 0).length;
            }),
        };
    },
    data() {
        return {
            profile_pic: false,
            notif_click: false,
            items: [
                {
                    label: "Notification",
                    items: [
                        {
                            label: "",
                            icon: "",
                            command: () => {},
                        },
                        {
                            label: "",
                            icon: "s",
                            command: () => {},
                        },
                    ],
                },
            ],
            profile_menu: null,
        };
    },
    methods: {
        updateNotif() {
            this.notif_click = !this.notif_click;
            let temp = this.notifications.filter((n) => n.viewed === 0);
            if (temp.length > 0) {
                temp.forEach((elem) => {
                    axios({
                        method: "put",
                        url: "/api/notification/" + elem.id,
                    }).catch((e) => {
                        console.log(e);
                    });
                });
            }
        },

        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        toggleNotification(event) {
            this.$refs.op.toggle(event);
            this.$store.dispatch("notifications/getAll");
        },
        onMenuToggle(event) {
            this.$emit("menu-toggle", event);
        },
        onTopbarMenuToggle(event) {
            this.$emit("topbar-menu-toggle", event);
        },
    },
    mounted() {
        window.addEventListener("scroll", (event) => {
            if (this.notif_click == true) {
                this.$store.dispatch("notifications/getAll");
                this.notif_click = !this.notif_click;
            }
            this.$refs.op.hide(event);
            this.$refs.menu.hide(event);
        });
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
