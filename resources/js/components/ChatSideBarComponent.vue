<template>
    <div>
        <Button label="Primary" class="p-button-text w-full">
            <div
                v-if="user.profile_pic"
                class="col-fixed p-0 m-0"
                style="width: 48px; height: 48px"
            >
                <Avatar
                    :image="`http://127.0.0.1:8000${user.profile_pic}`"
                    class="mr-2"
                    size="large"
                    shape="circle"
                    alt="Image"
                />
            </div>
            <div
                v-else
                class="col-fixed p-0 m-0"
                style="width: 48px; height: 48px"
            >
                <Avatar
                    image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                    class="mr-2"
                    size="large"
                    shape="circle"
                    alt="Image"
                />
            </div>
            <div class="col p-0 m-0">
                {{ user.first_name }} {{ user.last_name }}
            </div>
        </Button>
    </div>
</template>
<script>
export default {
    name: "ChatSideBarComponent",
    props: {
        user: {
            type: Object,
        },
    },
};
</script>
