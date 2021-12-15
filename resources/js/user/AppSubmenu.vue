<template>
    <ul v-if="items">
        <template v-for="(item, i) of items">
            <li
                v-if="visible(item) && !item.separator"
                :key="item.label || i"
                :class="[
                    {
                        'layout-menuitem-category': root,
                        'active-menuitem':
                            activeIndex === i && !item.to && !item.disabled,
                    },
                ]"
                role="none"
            >
                <template v-if="root">
                    <div class="layout-menuitem-root-text">
                        {{ item.label }}
                    </div>
                    <appsubmenu
                        :items="visible(item) && item.items"
                        @menuitem-click="$emit('menuitem-click', $event)"
                    ></appsubmenu>
                </template>
                <template v-else>
                    <router-link
                        v-if="item.to"
                        :to="item.to"
                        :class="[
                            item.class,
                            'p-ripple',
                            { 'p-disabled': item.disabled },
                        ]"
                        :style="item.style"
                        @click="onMenuItemClick($event, item, i)"
                        :target="item.target"
                        exact
                        role="menuitem"
                        v-ripple
                    >
                        <i :class="item.icon"></i>
                        <span>{{ item.label }}</span>
                        <i
                            v-if="item.items"
                            class="pi pi-fw pi-angle-down menuitem-toggle-icon"
                        ></i>
                        <span v-if="item.badge" class="menuitem-badge">{{
                            item.badge
                        }}</span>
                    </router-link>
                    <a
                        v-if="!item.to"
                        :href="item.url || '#'"
                        :style="item.style"
                        :class="[
                            item.class,
                            'p-ripple',
                            { 'p-disabled': item.disabled },
                        ]"
                        @click="onMenuItemClick($event, item, i)"
                        :target="item.target"
                        role="menuitem"
                        v-ripple
                    >
                        <i :class="item.icon"></i>
                        <span>{{ item.label }}</span>
                        <i
                            v-if="item.items"
                            class="pi pi-fw pi-angle-down menuitem-toggle-icon"
                        ></i>
                        <span v-if="item.badge" class="menuitem-badge">{{
                            item.badge
                        }}</span>
                    </a>
                    <transition name="layout-submenu-wrapper">
                        <appsubmenu
                            v-show="activeIndex === i"
                            :items="visible(item) && item.items"
                            @menuitem-click="$emit('menuitem-click', $event)"
                        ></appsubmenu>
                    </transition>
                </template>
            </li>
            <li
                class="p-menu-separator"
                :style="item.style"
                v-if="visible(item) && item.separator"
                :key="'separator' + i"
                role="separator"
            ></li>
        </template>
    </ul>
</template>
<script>
export default {
    name: "appsubmenu",
    props: {
        items: Array,
        root: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            activeIndex: null,
        };
    },
    methods: {
        onMenuItemClick(event, item, index) {
            if (item.disabled) {
                event.preventDefault();
                return;
            }

            if (!item.to && !item.url) {
                event.preventDefault();
            }

            //execute command
            if (item.command) {
                item.command({ originalEvent: event, item: item });
            }

            this.activeIndex = index === this.activeIndex ? null : index;

            this.$emit("menuitem-click", {
                originalEvent: event,
                item: item,
            });
        },
        visible(item) {
            return typeof item.visible === "function"
                ? item.visible()
                : item.visible !== false;
        },
    },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

span {
    font-family: "Poppins", sans-serif;
}
</style>
