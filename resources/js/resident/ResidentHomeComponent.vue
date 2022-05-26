<template>
    <div :class="containerClass" @click="onWrapperClick">
        <AppTopBar
            v-if="userLogged.status != 'inactive'"
            @menu-toggle="onMenuToggle"
        />
        <AppTopBar v-else @menu-toggle="onMenuToggle" />
        <div
            v-if="userLogged.status != 'inactive'"
            class="layout-sidebar"
            @click="onSidebarClick"
        >
            <AppMenu :model="menu" @menuitem-click="onMenuItemClick" />
        </div>

        <div class="layout-main-container">
            <div class="layout-main">
                <router-view
                    name="contents"
                    :key="$route.fullPath"
                ></router-view>
            </div>
            <AppFooter />
        </div>
        <ChatComponent
            v-if="userLogged.status != 'inactive'"
            :layoutMode="layoutMode"
        />
        <transition name="layout-mask">
            <div
                class="layout-mask p-component-overlay"
                v-if="mobileMenuActive"
            ></div>
        </transition>
    </div>
</template>

<script>
import AppTopBar from "../components/AppTopbar.vue";
import AppMenu from "../components/AppMenu.vue";
import ChatComponent from "../components/ChatComponent.vue";
import AppFooter from "../components/AppFooter.vue";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "ResidentHomeComponent",
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
        };
    },
    data() {
        return {
            layoutMode: "static",
            layoutColorMode: "light",
            staticMenuInactive: false,
            overlayMenuActive: false,
            mobileMenuActive: false,
            menu: [
                {
                    label: "Resident",
                    items: [
                        {
                            label: "Timeline",
                            icon: "pi pi-fw pi-home",
                            to: "/resident/timeline",
                        },
                        {
                            label: "Marketplace",
                            icon: "pi pi-fw pi-shopping-cart",
                            to: "/resident/marketplace",
                        },
                        {
                            label: "Announcement",
                            icon: "pi pi-fw pi-calendar",
                            to: "/resident/view-announcement",
                        },
                        {
                            label: "View Billing",
                            icon: "pi pi-fw pi-calendar",
                            to: "/resident/invoices",
                        },
                        {
                            label: "Election",
                            icon: "pi pi-fw pi-calendar",
                            to: "/resident/election",
                        },
                        {
                            label: "Map",
                            icon: "pi pi-compass",
                            to: "/resident/map",
                        },
                        {
                            label: "Log",
                            icon: "pipi pi-fw pi-calendar",
                            to: "/resident/log",
                        },
                    ],
                },
            ],
        };
    },
    watch: {
        $route() {
            this.menuActive = false;
            this.$toast.removeAllGroups();
        },
    },
    methods: {
        onWrapperClick() {
            if (!this.menuClick) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }

            this.menuClick = false;
        },
        onMenuToggle() {
            this.menuClick = true;

            if (this.isDesktop()) {
                if (this.layoutMode === "overlay") {
                    if (this.mobileMenuActive === true) {
                        this.overlayMenuActive = true;
                    }

                    this.overlayMenuActive = !this.overlayMenuActive;
                    this.mobileMenuActive = false;
                } else if (this.layoutMode === "static") {
                    this.staticMenuInactive = !this.staticMenuInactive;
                }
            } else {
                this.mobileMenuActive = !this.mobileMenuActive;
            }

            event.preventDefault();
        },
        onSidebarClick() {
            this.menuClick = true;
        },
        onMenuItemClick(event) {
            if (event.item && !event.item.items) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }
        },

        onLayoutColorChange(layoutColorMode) {
            this.layoutColorMode = layoutColorMode;
        },
        addClass(element, className) {
            if (element.classList) element.classList.add(className);
            else element.className += " " + className;
        },
        removeClass(element, className) {
            if (element.classList) element.classList.remove(className);
            else
                element.className = element.className.replace(
                    new RegExp(
                        "(^|\\b)" + className.split(" ").join("|") + "(\\b|$)",
                        "gi"
                    ),
                    " "
                );
        },
        isDesktop() {
            return window.innerWidth >= 1200;
        },
        isSidebarVisible() {
            if (this.isDesktop()) {
                if (this.layoutMode === "static")
                    return !this.staticMenuInactive;
                else if (this.layoutMode === "overlay")
                    return this.overlayMenuActive;
            }

            return true;
        },
    },
    computed: {
        containerClass() {
            return [
                "layout-wrapper",
                {
                    "layout-overlay": this.layoutMode === "overlay",
                    "layout-static": this.layoutMode === "static",
                    "layout-static-sidebar-inactive":
                        this.staticMenuInactive && this.layoutMode === "static",
                    "layout-overlay-sidebar-active":
                        this.overlayMenuActive && this.layoutMode === "overlay",
                    "layout-mobile-sidebar-active": this.mobileMenuActive,
                    "p-input-filled":
                        this.$primevue.config.inputStyle === "filled",
                    "p-ripple-disabled": this.$primevue.config.ripple === false,
                },
            ];
        },
        logo() {
            return this.layoutColorMode === "dark"
                ? "images/logo-white.svg"
                : "images/logo.svg";
        },
    },
    beforeUpdate() {
        if (this.mobileMenuActive)
            this.addClass(document.body, "body-overflow-hidden");
        else this.removeClass(document.body, "body-overflow-hidden");
    },
    components: {
        AppTopBar: AppTopBar,
        AppMenu: AppMenu,
        ChatComponent: ChatComponent,
        AppFooter: AppFooter,
    },
    created() {
        // this.$store.dispatch("news/getAll");
        this.$store.dispatch(
            "getUsersNotBlocked",
            this.$store.state.userLogged.id
        );
        this.$store.dispatch("getAllUsers");
        this.$store.dispatch("getBlockUsers", this.$store.state.userLogged.id);
        this.$store.dispatch(
            "userVehicles/getAll",
            this.$store.state.userLogged.id
        );
        this.$store.dispatch(
            "notifications/getSpecific",
            this.$store.state.userLogged.id
        );
    },
};
</script>

<style>
/* @import "./App.scss"; */
</style>
