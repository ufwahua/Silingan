<template>
    <div class="layout-topbar">
        <router-link to="/resident/dashboard" class="layout-topbar-logo">
            <img
                alt="Silingan-Logo"
                src="http://127.0.0.1:8000/storage/images/silingan-icon.png"
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
                <button class="p-link layout-topbar-button">
                    <i class="pi pi-calendar"></i>
                    <span>Events</span>
                </button>
            </li>
            <li>
                <button class="p-link layout-topbar-button">
                    <i class="pi pi-cog"></i>
                    <span>Settings</span>
                </button>
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
                            to: "/security/profile",
                            command: () => {},
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
        onMenuToggle(event) {
            this.$emit("menu-toggle", event);
        },
        onTopbarMenuToggle(event) {
            this.$emit("topbar-menu-toggle", event);
        },
    },
};
</script>
