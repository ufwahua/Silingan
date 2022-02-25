<template>
    <!-- post and comment -->
    <div>
        <div class="card">
            <div class="card-header">
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
                class="p-button-outlined p-button-secondary m-2"
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
                    <Textarea class="w-full"> </Textarea>
                </div>
                <div class="p-inputgroup mb-2">
                    <Avatar
                        image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                    <div class="card w-full">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Aliquam doloremque quo explicabo voluptatum
                        ratione sunt ex facere a consequuntur quasi. Impedit eum
                        iste laboriosam ipsam voluptate molestias molestiae in
                        modi?
                    </div>
                </div>
                <div class="p-inputgroup mb-2">
                    <Avatar
                        image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                    <div class="card w-full">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Aliquam doloremque quo explicabo voluptatum
                        ratione sunt ex facere a consequuntur quasi. Impedit eum
                        iste laboriosam ipsam voluptate molestias molestiae in
                        modi?
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        post: {
            type: Object,
        },
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
                {
                    itemImageSrc: "demo/images/galleria/galleria4.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria4s.jpg",
                    alt: "Description for Image 4",
                    title: "Title 4",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria5.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria5s.jpg",
                    alt: "Description for Image 5",
                    title: "Title 5",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria6.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria6s.jpg",
                    alt: "Description for Image 6",
                    title: "Title 6",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria7.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria7s.jpg",
                    alt: "Description for Image 7",
                    title: "Title 7",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria8.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria8s.jpg",
                    alt: "Description for Image 8",
                    title: "Title 8",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria9.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria9s.jpg",
                    alt: "Description for Image 9",
                    title: "Title 9",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria10.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria10s.jpg",
                    alt: "Description for Image 10",
                    title: "Title 10",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria11.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria11s.jpg",
                    alt: "Description for Image 11",
                    title: "Title 11",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria12.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria12s.jpg",
                    alt: "Description for Image 12",
                    title: "Title 12",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria13.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria13s.jpg",
                    alt: "Description for Image 13",
                    title: "Title 13",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria14.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria14s.jpg",
                    alt: "Description for Image 14",
                    title: "Title 14",
                },
                {
                    itemImageSrc: "demo/images/galleria/galleria15.jpg",
                    thumbnailImageSrc: "demo/images/galleria/galleria15s.jpg",
                    alt: "Description for Image 15",
                    title: "Title 15",
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
