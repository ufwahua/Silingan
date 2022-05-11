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
    name: "AdminHomeComponent",
    components: {
        AppTopBar,
        AppMenu,
        ChatComponent: ChatComponent,
        AppFooter,
    },
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
                    label: "Admin",
                    items: [
                        {
                            label: "Timeline",
                            icon: "pi pi-fw pi-home",
                            to: "/admin/timeline",
                        },
                        // {
                        //     label: "Announcement",
                        //     icon: "pi pi-info",
                        //     to: "/admin/view-announcement",
                        // },

                        {
                            label: "Marketplace",
                            icon: "pi pi-shopping-cart",
                            to: "/admin/marketplace",
                        },
                        {
                            label: "Announcement",
                            icon: "pi pi-volume-down",
                            to: "/admin/view-announcement",
                        },
                        {
                            label: "Cash Flow",
                            icon: "pi pi-dollar",
                            to: "/admin/cashflow",
                        },
                        {
                            label: "Verify Marketplace",
                            icon: "pi pi-info-circle",
                            to: "/admin/verify-marketplace",
                        },
                        {
                            label: "Invoice",
                            icon: "pi pi-send",
                            to: "/admin/invoice",
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
                                    label: "Manage Announcement",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/announcement",
                                },
                                {
                                    label: "Block and Lots",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/block-lot",
                                },
                                // {
                                //     label: "Vehicles",
                                //     icon: "pi pi-info-circle",
                                //     to: "/admin/vehicle",
                                // },
                                {
                                    label: "Cards",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/card",
                                },
                                {
                                    label: "Positions",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/position",
                                },
                                {
                                    label: "Collection Types",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/collection-type",
                                },
                                {
                                    label: "Expense Types",
                                    icon: "pi pi-info-circle",
                                    to: "/admin/expense-type",
                                },
                            ],
                        },
                    ],
                },
                {
                    items: [
                        {
                            label: "Logs",
                            icon: "pi pi-info-circle",
                            to: "/admin/log",
                        },
                        {
                            label: "Election",
                            icon: "pi pi-user-plus",
                            to: "/admin/election",
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

    mounted() {
        this.$store.dispatch("news/getAll");
        this.$store.dispatch("blocks/getAll");
        this.$store.dispatch("lots/getAll");
        this.$store.dispatch("announcements/getAll");
        this.$store.dispatch("positions/getAll");
        this.$store.dispatch("emergency_contact_details/getAll");

        this.$store.dispatch("getAllUsers");
        this.$store.dispatch("cards/getAllCards");
        this.$store.dispatch("logs/getAll");
        this.$store.dispatch("getBlockUsers", this.$store.state.userLogged.id);
        this.$store.dispatch("adminVehicles/getAll");
        this.$store.dispatch(
            "userVehicles/getAll",
            this.$store.state.userLogged.id
        );
        this.$store.dispatch("collectionType/getAll");
        this.$store.dispatch("collection/getAll");
        this.$store.dispatch("fund/getAll");
        this.$store.dispatch("expense/getAll");
        this.$store.dispatch(
            "notifications/getSpecific",
            this.$store.state.userLogged.id
        );
        this.$store.dispatch("expenseType/getAll");
    },
};
</script>

<style lang="scss">
@import "./assets/styles/App.scss";
</style>
