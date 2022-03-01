<template>
    <div id="layout-config" :class="containerClass">
        <a
            href="#"
            class="layout-config-button"
            id="layout-config-button"
            @click="toggleChatContainer"
        >
            <i class="pi pi-user"></i>
        </a>
        <div class="grid">
            <div class="col flex align-content-center m-3">
                <div class="col">
                    <b class="flex align-items-center text-xl">Contacts</b>
                </div>
                <div>
                    <Button icon="pi pi-search" />
                </div>
            </div>

            <div class="col-12">
                <Button
                    label="Primary"
                    class="p-button-text w-full"
                    @click="openPosition('bottom')"
                >
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                    <p class="m-0 p-0">Joshua Henry G. Diamos</p>
                </Button>
                <div class="p-inputgroup mb-2"></div>
            </div>
            <div class="col-12">
                <Button
                    label="Primary"
                    class="p-button-text w-full"
                    @click="openPosition('bottom')"
                >
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                    <p class="m-0 p-0">Joshua Henry G. Diamos</p>
                </Button>
                <div class="p-inputgroup mb-2"></div>
            </div>
            <div class="col-12">
                <Button
                    label="Primary"
                    class="p-button-text w-full"
                    @click="openPosition('bottom')"
                >
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                    <p class="m-0 p-0">Joshua Henry G. Diamos</p>
                </Button>
                <div class="p-inputgroup mb-2"></div>
            </div>
        </div>
        <Dialog
            v-model:visible="displayPosition"
            style="width: 350px; height: 500px"
            :position="position"
        >
            <template #header>
                <div class="col-11 p-0 m-0">
                    <Button
                        label="Primary"
                        class="p-button-text p-0 m-0 w-full"
                        @click="openPosition('bottom')"
                    >
                        <Avatar
                            image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                            class="mr-2"
                            size="large"
                            shape="circle"
                        />
                        <p class="m-0 p-0">Joshua Henry G. Diamos</p>
                    </Button>
                    <div class="p-inputgroup mb-2"></div>
                </div>
            </template>
            <div class="grid">
                <div class="col-12 pt-2 p-0 m-0">
                    <div class="p-inputgroup pt-1 pb-0 my-0">
                        <div>
                            <Avatar
                                image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                class="mr-2"
                                size="large"
                                shape="circle"
                            />
                        </div>

                        <div
                            class="card pb-0 pt-1 px-2 mb-0 mt-1"
                            style="background-color: var(--blue-50)"
                        >
                            <div class="grid grid-nogutter">
                                <div class="col-12">
                                    <b> Joshua Henry G. Diamos</b>
                                </div>
                                <div
                                    class="col-12 pb-1"
                                    v-tooltip="'8 hrs ago'"
                                >
                                    Lorem ipsum dolor sit amet consectetur
                                    adipisicing elit. Fuga aspernatur ducimus
                                    odio consequatur libero, excepturi pariatur
                                    est! Impedit eum dolores repudiandae fugiat
                                    minus voluptatum, animi accusamus sequi quae
                                    nulla saepe.
                                </div>
                            </div>
                        </div>
                        <div>
                            <Button
                                class="p-button-text"
                                icon="pi pi-ellipsis-v"
                                @click="toggle"
                                aria-haspopup="true"
                                aria-controls="overlay_menu"
                            />
                            <Menu
                                id="overlay_menu"
                                ref="menu"
                                :model="items"
                                :popup="true"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-12 pt-2 p-0 m-0">
                    <div class="p-inputgroup pt-1 pb-0 my-0">
                        <div>
                            <Button
                                class="p-button-text"
                                icon="pi pi-ellipsis-v"
                                @click="toggle"
                                aria-haspopup="true"
                                aria-controls="overlay_menu"
                            />
                            <Menu
                                id="overlay_menu"
                                ref="menu"
                                :model="items"
                                :popup="true"
                            />
                        </div>

                        <div
                            class="card pb-0 pt-1 px-2 mb-0 mt-1"
                            style="background-color: var(--blue-50)"
                        >
                            <div class="grid grid-nogutter">
                                <div class="col-12">
                                    <b> Guila Bagolor</b>
                                </div>
                                <div
                                    class="col-12 pb-1"
                                    v-tooltip="'8 hrs ago'"
                                >
                                    Lorem ipsum dolor sit amet consectetur
                                    adipisicing elit. Fuga aspernatur ducimus
                                    odio consequatur libero, excepturi pariatur
                                    est! Impedit eum dolores repudiandae fugiat
                                    minus voluptatum, animi accusamus sequi quae
                                    nulla saepe.
                                </div>
                            </div>
                        </div>
                        <div>
                            <Avatar
                                image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                class="mr-2"
                                size="large"
                                shape="circle"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <template #footer>
                <div class="col-12">
                    <Textarea
                        v-model="message"
                        :autoResize="true"
                        rows="1"
                        class="w-full"
                    >
                    </Textarea>
                </div>
            </template>
        </Dialog>
    </div>
</template>

<script>
export default {
    props: {
        layoutMode: {
            type: String,
            default: null,
        },
        layoutColorMode: {
            type: String,
            default: null,
        },
    },
    data() {
        return {
            message: null,
            position: null,
            displayPosition: false,
            active: false,
            d_layoutMode: this.layoutMode,
            d_layoutColorMode: this.layoutColorMode,
            scale: 16,
            scales: [12, 13, 14, 15, 16],
            items: [
                {
                    label: "Remove",
                    icon: "pi pi-trash",
                    command: () => {
                        this.editModal = true;
                        this.content = this.post.content;
                    },
                },
            ],
        };
    },
    watch: {
        $route() {
            if (this.active) {
                this.active = false;
                this.unbindOutsideClickListener();
            }
        },
        layoutMode(newValue) {
            this.d_layoutMode = newValue;
        },
        layoutColorMode(newValue) {
            this.d_layoutColorMode = newValue;
        },
    },
    outsideClickListener: null,
    methods: {
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        openPosition(position) {
            this.position = position;
            this.displayPosition = true;
        },
        toggleChatContainer(event) {
            this.active = !this.active;
            event.preventDefault();

            if (this.active) this.bindOutsideClickListener();
            else this.unbindOutsideClickListener();
        },
        hideConfigurator(event) {
            this.active = false;
            this.unbindOutsideClickListener();
            event.preventDefault();
        },
        changeInputStyle(value) {
            this.$primevue.config.inputStyle = value;
        },
        changeRipple(value) {
            this.$primevue.config.ripple = value;
        },
        changeLayout(event, layoutMode) {
            this.$emit("layout-change", layoutMode);
            event.preventDefault();
        },
        changeLayoutColor(event, layoutColor) {
            this.$emit("layout-color-change", layoutColor);
            event.preventDefault();
        },
        bindOutsideClickListener() {
            if (!this.outsideClickListener) {
                this.outsideClickListener = (event) => {
                    if (this.active && this.isOutsideClicked(event)) {
                        this.active = false;
                    }
                };
                document.addEventListener("click", this.outsideClickListener);
            }
        },
        unbindOutsideClickListener() {
            if (this.outsideClickListener) {
                document.removeEventListener(
                    "click",
                    this.outsideClickListener
                );
                this.outsideClickListener = null;
            }
        },
        isOutsideClicked(event) {
            return !(
                this.$el.isSameNode(event.target) ||
                this.$el.contains(event.target)
            );
        },
        decrementScale() {
            this.scale--;
            this.applyScale();
        },
        incrementScale() {
            this.scale++;
            this.applyScale();
        },
        applyScale() {
            document.documentElement.style.fontSize = this.scale + "px";
        },
        changeTheme(event, theme, dark = false) {
            let themeElement = document.getElementById("theme-link");
            themeElement.setAttribute(
                "href",
                themeElement
                    .getAttribute("href")
                    .replace(this.$appState.theme, theme)
            );
            this.$appState.theme = theme;
            this.$appState.darkTheme = dark;

            if (theme.startsWith("md")) {
                this.$primevue.config.ripple = true;
            }
        },
    },
    computed: {
        containerClass() {
            return ["layout-config", { "layout-config-active": this.active }];
        },
        rippleActive() {
            return this.$primevue.config.ripple;
        },
        inputStyle() {
            return this.$appState.inputStyle;
        },
    },
};
</script>
<style scoped>
div.p-dialog-header {
    padding: 10px !important;
}
</style>
