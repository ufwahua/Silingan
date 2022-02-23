<template>
    <div class="grid grid-nogutter">
        <div class="col-12 md:col-12 lg:col-6">
            <div class="row justify-content-center">
                <div class="col">
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
                        <div class="row justify-content-center mb-1">
                            <div class="col-12 m-0">
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
                                        similique impedit quae ex quas vel
                                        recusandae? Qui exercitationem, corrupti
                                        provident laudantium consectetur rem
                                        quibusdam ratione tempore assumenda
                                        dignissimos.
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
                                        explicabo voluptatum ratione sunt ex
                                        facere a consequuntur quasi. Impedit eum
                                        iste laboriosam ipsam voluptate
                                        molestias molestiae in modi?
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
                                        explicabo voluptatum ratione sunt ex
                                        facere a consequuntur quasi. Impedit eum
                                        iste laboriosam ipsam voluptate
                                        molestias molestiae in modi?
                                    </div>
                                </div>
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
        <div class="col-12 md:col-12 lg:col-3 min-w-5">
            <div class="card mx-4">
                <h2>Announcement</h2>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                Architecto saepe, amet fugiat obcaecati minima doloremque
                expedita debitis facilis at laboriosam dicta odio ducimus quas
                perspiciatis. Iste, tempore magni. Officia,
                <nostrum class="Lorem"
                    >Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    libero perspiciatis similique, accusamus inventore se sint
                    adipisci asperiores qui praesentium itaque at quibusdam.
                    Aliquid eligendi itaque perspiciatis laborum, consequatur
                    expedita suscipit! Sequi commodi dolorum ad! Suscipit animi
                    alias iste, consectetur accusamus quaerat debitis provident
                    laborum sunt facere, quia modi asperiores. Amet molestiae
                    aspernatur, dolorem vero officiis repudiandae non voluptatum
                    sit dolorum eligendi, saepe ea omnis sed. Unde quisquam
                    nihil non sint ea blanditiis totam eligendi quae! Aut
                    similique omnis quam tempore maxime quos aspernatur eligendi
                    nam ut odio maiores natus quaerat, beatae facere deleniti
                    ratione et? Assumenda mollitia expedita eius dicta eveniet
                    enim, quaerat eligendi. Placeat dolorem quis quia veniam
                    doloremque excepturi maxime. Quaerat nulla quisquam ullam
                    optio ipsam sunt perferendis, amet deleniti, illum sapiente
                    reprehenderit a laborum voluptatibus nemo ab fugit! Animi
                    doloremque magnam voluptatibus, fugiat reiciendis porro
                    quasi inventore ullam! Ducimus minus expedita quis, et totam
                    mollitia nesciunt, voluptatibus repellendus sed quae
                    exercitationem!
                </nostrum>
            </div>
            <div class="card mx-4">
                <h2>News</h2>
                <img
                    src="https://img.freepik.com/free-photo/scene-with-minimal-blue-podium_23-2149269983.jpg?w=826"
                    alt="Image"
                    class="w-full p-0 m-0 h-20rem"
                />
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                Architecto saepe, amet fugiat obcaecati minima doloremque
                expedita debitis facilis at laboriosam dicta odio ducimus quas
                perspiciatis. Iste, tempore
                <magni class="Lorem">Lorem</magni>Lorem ipsum dolor sit amet
                consectetur, adipisicing elit. Inventore non modi rem laboriosam
                laudantium cumque obcaecati optio veritatis, quibusdam corporis
                reiciendis iste cum culpa nemo quis, delectus laborum voluptas
                <qui class="Lorem"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Distinctio veniam cupiditate, dicta labore accusamus aperiam
                    modi commodi iste qui ea minus exercitationem vel. Natus
                    repudiandae, laboriosam modi velit corrupti architecto?Lorem
                    ipsum dolor sit amet consectetur adipisicing elit. Incidunt
                    maxime iste laborum nobis accusantium ipsa harum similique
                    error, ipsum dolores debitis illum, alias sapiente beatae
                    rem a earum, cumque exercitationem aperiam dolor. Illo
                    magnam, architecto beatae tenetur minus facilis iusto eos
                    repudiandae in consequuntur at. Quo nesciunt vero, quasi
                    aliquid tempora dolorum et! Dicta odit impedit animi
                    praesentium sunt aliquam maxime, repellendus officiis porro
                    voluptatibus ad quibusdam alias assumenda cumque,
                    perspiciatis deleniti provident aut numquam, eum placeat
                    iste sit! Accusantium, consequatur sit adipisci aliquam
                    quidem deserunt quia vitae impedit autem veniam dolorem
                    optio, itaque eum?</qui
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "UserDashboardComponent",

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
