<template>
    <div :class="containerClass" @click="onWrapperClick">
        <AppTopBar @menu-toggle="onMenuToggle" />
        <div class="layout-sidebar" @click="onSidebarClick">
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
        <AppConfig :layoutMode="layoutMode" />
        <transition name="layout-mask">
            <div
                class="layout-mask p-component-overlay"
                v-if="mobileMenuActive"
            ></div>
        </transition>
    </div>
</template>

<script>
import AppTopBar from "../AppTopbar.vue";
import AppMenu from "../AppMenu.vue";
import AppConfig from "../AppConfig.vue";
import AppFooter from "../AppFooter.vue";

export default {
    name: "HomeComponent",
    data() {
        return {
            layoutMode: "static",
            layoutColorMode: "light",
            staticMenuInactive: false,
            overlayMenuActive: false,
            mobileMenuActive: false,
            menu: [
                {
                    items: [
                        {
                            label: "Home",
                            icon: "pi pi-fw pi-home",
                            to: "/resident/dashboard",
                        },
                        {
                            label: "Neighbourhood",
                            icon: "pi pi-fw pi-map",
                            to: "/resident/neighbourhood",
                        },
                    ],
                },

                {
                    label: "GROUPS",
                    items: [
                        {
                            label: "General",
                            icon: "pi pi-fw pi-users",
                            items: [
                                {
                                    label: "Group 1",
                                    to: "/resident/test",
                                },
                                {
                                    label: "Group 2",
                                    to: "/resident/test2",
                                },
                            ],
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
        AppConfig: AppConfig,
        AppFooter: AppFooter,
    },
    created() {
        this.$store.dispatch("news/getAll");
        this.$store.dispatch("posts/getAll");
    },
};
</script>

<style>
/* @import "./App.scss"; */
</style>
