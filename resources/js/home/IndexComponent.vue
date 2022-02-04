<template>
    <div>
        <AppTopBar />

        <div class="layout-main-container">
            <div class="layout-main">
                <div class="grid">
                    <div class="col-12 md:col-6 headline l:col-6">
                        <br /><br />
                        <p class="logo-name">Silingan</p>
                        <h1 class="headline header1">
                            Solution For a Better Community Living
                        </h1>
                        <p class="headline header2">
                            Transform your way of connecting and collaborating
                            <span>with your neighborhood.</span>
                        </p>
                        <router-link to="login">
                            <Button
                                label="Get started"
                                class="mr-2 mb-2 p-button-lg"
                            ></Button
                        ></router-link>
                    </div>
                    <div class="col-12 md:col-6 l:col-6">
                        <img
                            class="bgimage"
                            src="https://i.ibb.co/XWbv4xB/background.png"
                            alt="background"
                        />
                    </div>
                </div>
            </div>
            <AppFooter />
        </div>
    </div>
</template>

<script>
import AppTopBar from "./AppTopbar.vue";
import AppFooter from "./AppFooter.vue";
import Image from "primevue/image";

export default {
    components: {
        AppTopBar: AppTopBar,
        AppFooter: AppFooter,
        Image,
    },
};
</script>

<style>
@import "./App.scss";
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

.bgimage {
    margin: 0 px;
    max-width: 100%;
    height: 100%;
    object-fit: cover;
}

.headline {
    font-family: "Poppins", sans-serif;
}

.logo-name {
    font-family: "Poppins", sans-serif;
    font-weight: 700;
    font-size: 25px;
    color: #0098ec;
    margin-bottom: -20px;
}

.header1 {
    font-weight: 700;
    font-size: 45px;
    color: #3d4460;
}

.header2 {
    display: block;
    font-weight: 400;
    font-size: 20px;
    color: rgba(105, 123, 145, 0.73);
}
</style>
