<template>
    <div class="layout-topbar">
        <router-link to="/home/dashboard" class="layout-topbar-logo">
            <span>Silingan</span>
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
import Menu from "primevue/menu";
export default {
    data() {
        return {
            profile_menu: [
                {
                    items: [
                        {
                            label: "Profiles",
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
                            label: "Logout",
                            icon: "pi pi-sign-out",
                            command: async () => {
                                await axios({
                                    method: "get",
                                    url: "api/logout",
                                })
                                    .then((response) => {
                                        this.$router.push("/");
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
    },
};
</script>
