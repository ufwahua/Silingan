<template>
    <div class="layout-topbar">
        <router-link to="/admin/dashboard" class="layout-topbar-logo">
            <img
                alt="Silingan-Logo"
                src="http://localhost:8000/storage/images/silingan-icon.png"
            />
        </router-link>
        <button
            class="p-link layout-menu-button layout-topbar-button"
            @click="onMenuToggle"
        >
            <i class="pi pi-bars"></i>
        </button>

        <button
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
                <Menu
                    id="overlay_menu"
                    ref="menu2"
                    :model="items"
                    :popup="true"
                    class="overflow-auto"
                    style="max-height: 300px"
                />
            </li>

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
        };
    },
    data() {
        return {
            profile_pic: false,
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
            profile_menu: [
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
                                } else {
                                    this.$router.push(
                                        `/${this.userLogged.role}` + "/profile"
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
                                        this.$router.push("/login");
                                        this.$store.dispatch("logout", null);
                                    })
                                    .catch((error) => {
                                        console.log(error.response);
                                    });
                            },
                        },
                    ],
                },
            ],
        };
    },
    methods: {
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        toggleNotification(event) {
            this.$refs.menu2.toggle(event);
        },
        onMenuToggle(event) {
            this.$emit("menu-toggle", event);
        },
        onTopbarMenuToggle(event) {
            this.$emit("topbar-menu-toggle", event);
        },
    },
};
</script>
