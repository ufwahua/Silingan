<template>
    <!-- post and comment -->
    <div>
        <div class="card">
            <div class="card-header" style="background-color: var(--blue-50)">
                <div class="p-inputgroup mb-2">
                    <Avatar
                        image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                    <div class="grid grid-nogutter">
                        <div class="col-12">
                            <b class="p-0 m-0">
                                {{ post.user.first_name }}
                                {{ post.user.last_name }}</b
                            >
                        </div>
                        <div class="col-12">
                            <p>{{ post.updated_at }}</p>
                        </div>
                    </div>
                    <Button
                        class="p-button-lg-primary"
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
            <div class="card-body mx-0 px-0">
                <p>{{ post.content }}</p>

                <Galleria
                    :value="images"
                    :responsiveOptions="responsiveOptions"
                    :numVisible="7"
                    class="w-full"
                >
                    <template #item="slotProps">
                        <img
                            :src="slotProps.item.itemImageSrc"
                            :alt="slotProps.item.alt"
                            preview
                            style="object-fit: fit; height: 500px"
                            class="w-full"
                        />
                    </template>
                    <template #thumbnail="slotProps">
                        <Image
                            :src="slotProps.item.thumbnailImageSrc"
                            :alt="slotProps.item.alt"
                            width="100"
                        />
                    </template>
                </Galleria>
            </div>
            <hr />
            <Button
                label="Comment"
                class="p-button-outlined p-button-primary m-2"
                @click="commentShow"
            />
            <hr />
            <div v-if="comment_show">
                <div class="p-inputgroup mb-2">
                    <Avatar
                        image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                    <Textarea :autoResize="true" rows="1" class="w-full">
                    </Textarea>
                </div>
                <div v-for="comment in post.comment" :key="comment.id">
                    <CommentComponent
                        v-if="comment.id"
                        v-bind:comment="comment"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CommentComponent from "./CommentComponent.vue";
export default {
    props: {
        post: {
            type: Object,
        },
    },
    components: {
        CommentComponent,
    },
    data() {
        return {
            comment_show: false,
            responsiveOptions: [
                {
                    breakpoint: "1700px",
                    numVisible: 6,
                },
                {
                    breakpoint: "1600px",
                    numVisible: 5,
                },
                {
                    breakpoint: "1500px",
                    numVisible: 4,
                },
                {
                    breakpoint: "1400px",
                    numVisible: 3,
                },
                {
                    breakpoint: "1300px",
                    numVisible: 2,
                },
            ],
            images: [
                {
                    itemImageSrc:
                        "https://img.freepik.com/free-photo/scene-with-minimal-blue-podium_23-2149269983.jpg?w=826",
                    thumbnailImageSrc:
                        "https://img.freepik.com/free-photo/scene-with-minimal-blue-podium_23-2149269983.jpg?w=826",
                    alt: "Description for Image 1",
                    title: "Title 1",
                },
                {
                    itemImageSrc:
                        "https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png?",
                    thumbnailImageSrc:
                        "https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png?",
                    alt: "Description for Image 2",
                    title: "Title 2",
                },
                {
                    itemImageSrc:
                        "https://img.freepik.com/free-photo/scene-with-minimal-blue-podium_23-2149269983.jpg?",
                    thumbnailImageSrc:
                        "https://img.freepik.com/free-photo/scene-with-minimal-blue-podium_23-2149269983.jpg?w=826",
                    alt: "Description for Image 3",
                    title: "Title 3",
                },
            ],
        };
    },

    methods: {
        commentShow() {
            this.comment_show = !this.comment_show;
        },
    },
};
</script>
