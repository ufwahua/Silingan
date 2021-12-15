<template>
    <div class="layout-topbar">
        <router-link to="/" class="layout-topbar-logo">
            <img alt="Silingan-Logo" src="images/silingan-icon.png" />
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

        <ul class="layout-topbar-menu hidden lg:flex origin-top">
            <router-link to="login">
                <li>
                    <Button label="Log in" class="mr-2 mb-2 p-button"></Button>
                </li>
            </router-link>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    methods: {
        onMenuToggle(event) {
            this.$emit("menu-toggle", event);
        },
        onTopbarMenuToggle(event) {
            this.$emit("topbar-menu-toggle", event);
        },
    },
};
</script>
