<template>
    <div :class="containerClass" @click="onWrapperClick">
        <AppTopBar @menu-toggle="onMenuToggle" />
        <div class="layout-sidebar" @click="onSidebarClick">
            <AppMenu :model="menu" @menuitem-click="onMenuItemClick" />
        </div>

        <div class="layout-main-container">
            <div class="layout-main">
                <router-view name="contents"></router-view>
            </div>
            <AppFooter />
        </div>
        <!-- <AppConfig :layoutMode="layoutMode" @layout-change="onLayoutChange" @change-theme="changeTheme" /> -->
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
import AppFooter from "../AppFooter.vue";
// import AppConfig from "../AppConfig.vue";

export default {
    name: "HomeComponent",
    components: {
        AppTopBar,
        AppMenu,
        // AppConfig: AppConfig,
        AppFooter,
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
                    label: "Home",
                    items: [
                        {
                            label: "Dashboard",
                            icon: "pi pi-fw pi-home",
                            to: "/admin/dashboard",
                        },
                        {
                            label: "Timeline",
                            icon: "pi pi-fw pi-send",
                            to: "/admin/timeline",
                        },
                        {
                            label: "Marketplace",
                            icon: "pi pi-shopping-cart",
                            to: "/admin/marketplace",
                        },
                    ],
                },
                {
                    items: [
                        {
                            label: "Maintain",
                            icon: "pi pi-fw pi-sitemap",
                            items: [
                                {
                                    label: "Users",
                                    icon: "pi pi-users",
                                    items: [
                                        {
                                            label: "Residents",
                                            icon: "pi pi-user-edit",
                                            to: "/admin/residents",
                                        },
                                        {
                                            label: "Security Officers",
                                            icon: "pi pi-user-edit",
                                            to: "/admin/security-officers",
                                        },
                                        {
                                            label: "Officers",
                                            icon: "pi pi-user-edit",
                                            to: "/admin/officers",
                                        },
                                        {
                                            label: "All Users",
                                            icon: "pi pi-user-edit",
                                            to: "/admin/registered-users",
                                        },
                                    ],
                                },
                                {
                                    label: "Block and Lot",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/block-lot",
                                },
                                {
                                    label: "Positions",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/position",
                                },
                                {
                                    label: "Candidates",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/candidate",
                                },
                                {
                                    label: "Announcement",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/announcement",
                                },
                                {
                                    label: "Emergency Details",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/emergency-contact-detail",
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
        onLayoutChange(layoutMode) {
            this.layoutMode = layoutMode;
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

    created() {
        this.$store.dispatch("blocks/getAll");
        this.$store.dispatch("lots/getAll");
        this.$store.dispatch("registeredUsers/getAll");
        this.$store.dispatch("announcements/getAll");
        this.$store.dispatch("positions/getAll");
        this.$store.dispatch("emergency_contact_details/getAll");
        this.$store.dispatch("candidates/getAll");
        this.$store.dispatch("registeredUsersFname/getAll");
    },
};
</script>

<style lang="scss">
@import "../App.scss";
</style>
