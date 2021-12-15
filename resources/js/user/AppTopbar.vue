<template>
    <div class="layout-topbar">
        <router-link to="/home/dashboard" class="layout-topbar-logo">
            <img
                alt="Silingan-Logo"
                src="https://lh3.googleusercontent.com/-7CmG6rtPXRbXhTFmglVLBNBWdAcX0OgVGwmpef06SdNd-BYy6i076zwmzNJaR0vi5_LRKEVTJJgmXoKpYKQZCI-jJkuENOJSBHT80QeT7ThBILf97rSRQqXnWS4A1qbp7kGyTd00vt4s6PNvi6BpxHQsZhW2IzohLqhkBek3XLTDEM5rA3iXjOuX-XyvqtgqFm0KkiCHSzCThEpVul5AYVB0LxkJ31NCfZ4mQh298P0R38QmpHj6EDZfV8vm_y6qVD0YVQsJIuVJi79kjjaj6k_IkRnhmdxw6oNNJgFIe_9LpL2a20xCSb2PB7IXpHJCMdMzCx3TKMwkRuK3yK5-YsLhmiLqsi92yzf76lhHuqlV3S17CY54y4knHuDcDltS1hyQ6tFwRpD0X73iTydFxHGSg9sDhzBIbROUkT5yFR02nwAEg0MwF9qdM-7Ak0ufkGOC1xebc6PZZT7AHy5-cK0tBn_3dHJDwan_kt-UidPy3Xxmz4T85hKS9yoGFDjoWTvc4FEVG6cv_2iUG7whRWghh3AcjCYS8iFNm86CoEoEOnvyTQJFa8_1IRcAn4Rr61tDAxfVjjHxU3SMrbFxpF2pAuhqkLEe3tN0BJANL3SVWHCXlaeNGwlhqkjeUt32BrjcTmwy8zV9-YDGLKBkAqdvKDkEfCM0bU4210G4yZyjIzDpcavjZw5ZtpJVVjo4LAWJSi-eprtuf4pIiIzGdA=w350-h100-no?authuser=0"
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
import Image from "primevue/image";
export default {
    data() {
        return {
            profile_menu: [
                {
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
                            label: "Logout",
                            icon: "pi pi-sign-out",
                            command: async () => {
                                await axios({
                                    method: "get",
                                    url: "api/logout",
                                })
                                    .then((response) => {
                                        this.$router.push({
                                            name: "index",
                                        });
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
