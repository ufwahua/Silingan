<template>
    <div class="layout-topbar">
        <router-link to="/home/dashboard" class="layout-topbar-logo">
            <img
                alt="Silingan-Logo"
                src="https://i.ibb.co/V3B8NBM/silingan-icon.png"
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
                    <i class="pi pi-bell"></i>
                    <span>Activity</span>
                </button>
            </li>
            <li>
                <button class="p-link layout-topbar-button">
                    <i class="pi pi-comment"></i>
                    <span>Chat</span>
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
            user: computed(() => store.state.user),
        };
    },
    data() {
        return {
            profile_menu: [
                {
                    label: this.user.first_name + " " + this.user.last_name,
                    items: [
                        {
                            label: "Profile",
                            icon: "pi pi-pencil",
                            command: () => {
                                this.$toast.add({
                                    severity: "success",
                                    summary: "Updated",
                                    detail: "Data Updated",
                                    life: 3000,
                                });
                            },
                        },
                        {
                            label: "Settings",
                            icon: "pi pi-cog",
                        },
                        {
                            label: "Logout",
                            icon: "pi pi-sign-out",
                            command: async () => {
                                await axios({
                                    method: "post",
                                    url: "/api/logout",
                                })
                                    .then((response) => {
                                        this.$router.push("/login");
                                        this.$store.dispatch("getUser", null);
                                    })
                                    .catch((error) => {
                                        console.log(error);
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
        topbarImage() {
            return "images/silingan-icon.png";
        },
    },

    components: {
        Image,
    },
};
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

#overlay_menu {
    font-family: "Poppins", sans-serif;
}
</style>
