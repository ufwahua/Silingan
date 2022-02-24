<template>
    <div class="grid">
        <div class="sm:col-12 md:col-8 lg:col-9">
            <div class="row justify-content-center">
                <div class="col">
                    <Fieldset class="mb-3" legend="Announcement">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat. Duis aute irure dolor in
                            reprehenderit in voluptate velit esse cillum dolore
                            eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia
                            deserunt mollit anim id est laborum.
                        </p>
                    </Fieldset>
                    <div class="card">
                        <div class="p-inputgroup mb-2">
                            <Avatar
                                image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                                class="mr-2"
                                size="xlarge"
                                shape="circle"
                            />
                            <Textarea class="w-full"> </Textarea>
                        </div>
                        <FileUpload
                            name="demo[]"
                            mode="basic"
                            url="./upload.php"
                            accept="image/*"
                            :customUpload="true"
                            @uploader="myUploader"
                            :maxFileSize="2000000"
                            :fileLimit="3"
                            :showUploadButton="false"
                            :showCancelButton="false"
                        >
                            <template #empty>
                                <p>Drag and drop files to here to upload.</p>
                            </template>
                        </FileUpload>
                    </div>

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
                                            Joshua Henry G. Diamos
                                        </b>
                                    </div>
                                    <div class="col-12">
                                        <p>Today 9:06pm</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>
                                Lorem ipsum dolor sit amet consectetur,
                                adipisicing elit. Facere nobis officiis
                                similique impedit quae ex quas vel recusandae?
                                Qui exercitationem, corrupti provident
                                laudantium consectetur rem quibusdam ratione
                                tempore assumenda dignissimos.
                            </p>
                            <img
                                src="https://img.freepik.com/free-photo/scene-with-minimal-blue-podium_23-2149269983.jpg?w=826"
                                alt="Image"
                                class="w-full p-0 m-0 h-20rem"
                            />
                        </div>
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
                                Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Aliquam doloremque quo
                                explicabo voluptatum ratione sunt ex facere a
                                consequuntur quasi. Impedit eum iste laboriosam
                                ipsam voluptate molestias molestiae in modi?
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
                                Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Aliquam doloremque quo
                                explicabo voluptatum ratione sunt ex facere a
                                consequuntur quasi. Impedit eum iste laboriosam
                                ipsam voluptate molestias molestiae in modi?
                            </div>
                        </div>

                        <!-- <add-comment
                                :userid="{{Auth::user()->id}}"
                                :postid="{{$post->id}}"
                            ></add-comment> -->
                        <hr />
                    </div>
                </div>
            </div>
        </div>
        <div class="sm:col-12 md:col-4 lg:col-3">
            <NewsComponent />
        </div>
    </div>
</template>

<script>
import NewsComponent from "./NewsComponent.vue";
export default {
    name: "UserDashboardComponent",
    components: {
        NewsComponent,
    },
    data() {
        return {
            data: [
                {
                    name: "Jayson Cadiz",
                    date: "January 1, 2021",
                    type: "Laptop",
                    model: "Aspire-15",
                    brand: "Acer",
                },
                {
                    name: "Gio Alfanta",
                    date: "January 2, 2021",
                    type: "Desktop",
                    model: "Aspire-15",
                    brand: "Acer",
                },
                {
                    name: "Godfrey Español",
                    date: "January 3, 2021",
                    type: "Mouse",
                    model: "Abyssus",
                    brand: "Razer",
                },
            ],
        };
    },
    methods: {
        myUploader() {},
    },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

.container {
    margin-left: 5%;
    margin-right: 5%;
}
.lanex-font {
    font-family: "Poppins", sans-serif;
}
.lanex-font-title {
    font-size: 24px;
}
.lanex-font-content {
    font-size: 14px;
}
</style>
