<template>
    <div class="layout-topbar">
        <router-link to="/" class="layout-topbar-logo">
            <img
                alt="Silingan-Logo"
                src="https://i.ibb.co/V3B8NBM/silingan-icon.png"
            />
        </router-link>
        <button
            class="p-link layout-menu-button layout-topbar-button"
            @click="onMenuToggle"
            hidden
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

        <ul
            class="layout-topbar-menu hidden lg:flex align-items-center justify-content-center origin-top"
        >
            <li>
                <router-link to="login">
                    <Button
                        label="Login"
                        class="p-button-text p-button-rounded border-none font-light line-height-2 text-blue-500"
                    ></Button>
                </router-link>
            </li>

            <li>
                <router-link to="register">
                    <Button
                        label="Register"
                        class="p-button-rounded border-none ml-2 font-light text-white line-height-2 bg-blue-500"
                    ></Button>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {};
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
            return "silingan-icon.png";
        },
    },
};
</script>
