<template>
    <div class="grid">
        <div class="col-12 xl:col-8">
            <div class="card mb-0">
                <ul class="p-0 mx-0 mt-0 mb-0 list-none">
                    <li class="flex align-items-center py-2">
                        <Avatar
                            icon="pi pi-user"
                            size="large"
                            shape="circle"
                            class="w-3rem h-3rem flex align-items-center justify-content-center bg-stone-300 border-circle mr-3 flex-shrink-0"
                        ></Avatar>

                        <Button
                            label="Anything to share with your neighbours?"
                            class="p-button-rounded p-button-secondary mr-2 mb-2 btn-post"
                            @click="confirmDeleteSelected"
                        />
                    </li>
                </ul>
            </div>

            <!-- <Dialog
                v-model:visible="productDialog"
                :style="{ width: '720px' }"
                header="Edit Post"
                :modal="true"
                class="p-fluid"
            >
                <div class="field mt-2">
                    <div
                        class="flex align-items-center justify-content-between mb-4"
                    >
                        <div
                            class="flex align-items-center py-2 border-bottom-1 surface-border user-name"
                        >
                            <Avatar
                                icon="pi pi-user"
                                size="large"
                                shape="circle"
                                class="w-3rem h-3rem flex align-items-center justify-content-center bg-stone-300 border-circle mr-3 flex-shrink-0"
                            >
                            </Avatar>
                            <span class="text-900 line-height-3"
                                >Senyora Marites(you)
                            </span>
                        </div>
                    </div>
                    <Textarea
                        placeholder="Anything to share with your neighbours?"
                        :autoResize="true"
                        rows="3"
                        cols="20"
                    />
                    <FileUpload
                        name="demo[]"
                        url="./upload.php"
                        @upload="onUpload"
                        :multiple="true"
                        accept="image/*"
                        :maxFileSize="1000000"
                    />
                </div>

                <template #footer>
                    <Button
                        label="Cancel"
                        icon="pi pi-times"
                        class="p-button-text"
                        @click="hideDialog"
                    />
                    <Button
                        label="Save"
                        class="p-button-text"
                        @click="saveProduct"
                    />
                </template>
            </Dialog> -->
            <Dialog
                v-model:visible="deleteProductDialog"
                :style="{ width: '450px' }"
                header="Confirm"
                :modal="true"
            >
                <div class="flex align-items-center justify-content-center">
                    <i
                        class="pi pi-exclamation-triangle mr-3"
                        style="font-size: 2rem"
                    />
                    <span v-if="product"
                        >Are you sure you want to delete this post?</span
                    >
                </div>
                <template #footer>
                    <Button
                        label="No"
                        icon="pi pi-times"
                        class="p-button-text"
                        @click="deleteProductDialog = false"
                    />
                    <Button
                        label="Yes"
                        icon="pi pi-check"
                        class="p-button-text"
                        @click="deleteProduct"
                    />
                </template>
            </Dialog>

            <Dialog
                v-model:visible="deleteProductsDialog"
                :style="{ width: '450px' }"
                header="Confirm"
                :modal="true"
            >
                <div class="flex align-items-center justify-content-center">
                    <i
                        class="pi pi-exclamation-triangle mr-3"
                        style="font-size: 2rem"
                    />
                    <span v-if="product"
                        >Are you sure you want to delete this comment?</span
                    >
                </div>
                <template #footer>
                    <Button
                        label="No"
                        icon="pi pi-times"
                        class="p-button-text"
                        @click="deleteProductsDialog = false"
                    />
                    <Button
                        label="Yes"
                        icon="pi pi-check"
                        class="p-button-text"
                        @click="deleteSelectedProducts"
                    />
                </template>
            </Dialog>
        </div>
        <div class="col-12 xl:col-4">
            <div class="card">
                <h5>Deca Basak</h5>
                <span class="text-500">8 neighbours</span>
            </div>
        </div>

        <div class="col-12 xl:col-8">
            <div class="card">
                <div
                    class="flex align-items-center justify-content-between mb-4"
                >
                    <div
                        class="flex align-items-center py-2 border-bottom-1 surface-border user-name"
                    >
                        <Avatar
                            icon="pi pi-user"
                            size="large"
                            shape="circle"
                            class="w-3rem h-3rem flex align-items-center justify-content-center bg-stone-300 border-circle mr-3 flex-shrink-0"
                        >
                        </Avatar>
                        <span class="text-900 line-height-3"
                            >Senyora Marites(you)
                            <span class="block text-600">1 day ago</span></span
                        >
                    </div>

                    <div>
                        <Button
                            icon="pi pi-ellipsis-v"
                            class="p-button-text p-button-plain p-button-rounded"
                            @click="$refs.menu1.toggle($event)"
                        ></Button>
                        <Menu ref="menu1" :popup="true" :model="items"></Menu>
                    </div>
                </div>
                <span class="text-700">Red Romet bike. Who wants to buy? </span>
                <div class="flex justify-content-center">
                    <Image
                        src="https://www.cyclesolutions.co.uk/images/wagant2blackred2021.jpg"
                        alt="Image"
                        width="250"
                        preview
                    />
                    <Image
                        src="https://cdn.shopify.com/s/files/1/1627/7261/products/IMG_20210410_182158_530x@2x.jpg?v=1618134097"
                        alt="Image"
                        width="250"
                        preview
                    />
                </div>
                <div
                    class="flex align-items-center justify-content-end py-2 border-bottom-1 surface-border mb-4"
                >
                    <a class="text-500">2 Comments</a>
                </div>
                <div
                    class="flex align-items-center py-2 border-bottom-1 surface-border user-name"
                >
                    <Avatar
                        image="https://scontent.fceb6-1.fna.fbcdn.net/v/t39.30808-6/254714306_1325502721243642_6905703401363479251_n.jpg?_nc_cat=109&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeElxhjf8LsPkeFIUSJPh7sr1HpcjlOab0bUelyOU5pvRnzi_qODF24eUwr6X9JuPP1lqvqma9LH7lQ9pIxidhPH&_nc_ohc=FaPCvNr273cAX8yJuUW&tn=472IFzzg07cAkZeE&_nc_zt=23&_nc_ht=scontent.fceb6-1.fna&oh=00_AT-qH0nuAj8B7y0J287SXnZoXXSqrSjSjZuWdLd0Qjohjw&oe=61EC88DF"
                        size="large"
                        shape="circle"
                        class="w-3rem h-3rem flex align-items-center justify-content-center bg-stone-300 border-circle mr-3 flex-shrink-0"
                    >
                    </Avatar>
                    <Chip
                        ><span class="text-900 line-height-3 bg-post"
                            >Jan<span class="block text-600"
                                >I want to buy it and discuss it to you
                                personally. Is it okay with you?</span
                            ></span
                        ></Chip
                    >
                </div>
                <div
                    class="flex align-items-center py-2 border-bottom-1 surface-border user-name"
                >
                    <Avatar
                        icon="pi pi-user"
                        size="large"
                        shape="circle"
                        class="w-3rem h-3rem flex align-items-center justify-content-center bg-stone-300 border-circle mr-3 flex-shrink-0"
                    >
                    </Avatar>

                    <Chip
                        ><span class="text-900 line-height-3 bg-post"
                            >Senyora Marites(you)<span class="block text-600"
                                >Gladly. Let's meet up at the entrance exactly
                                3:00 pm.
                            </span></span
                        ></Chip
                    >
                    <!-- <div>
                        <Button
                            icon="pi pi-ellipsis-v"
                            class="p-button-text p-button-plain p-button-rounded"
                            @click="$refs.menu1.toggle($event)"
                        ></Button>
                        <Menu
                            ref="menu1"
                            :popup="true"
                            :model="items"
                            @click="confirmDeleteSelected"
                        ></Menu>
                    </div> -->
                </div>
                <div
                    class="flex align-items-center py-2 border-bottom-1 surface-border user-name"
                >
                    <Avatar
                        icon="pi pi-user"
                        size="large"
                        shape="circle"
                        class="w-3rem h-3rem flex align-items-center justify-content-center bg-stone-300 border-circle mr-3 flex-shrink-0"
                    >
                    </Avatar>

                    <Textarea
                        placeholder="Write a comment..."
                        :autoResize="true"
                        rows="1"
                        cols="60"
                    />
                    <Button label="Post"></Button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Image from "primevue/image";

export default {
    data() {
        return {
            value: 0,
            products: null,
            productDialog: false,
            deleteProductDialog: false,
            deleteProductsDialog: false,
            product: {},
            selectedProducts: null,
            filters: {},
            submitted: false,

            items: [
                { label: "Edit", icon: "pi pi-fw pi-pencil" },
                { label: "Delete", icon: "pi pi-fw pi-trash" },
            ],
        };
    },

    methods: {
        openPost() {
            this.product = {};
            this.submitted = false;
            this.productDialog = true;
        },
        hideDialog() {
            this.productDialog = false;
            this.submitted = false;
        },
        confirmDeleteSelected() {
            this.deleteProductsDialog = true;
        },
    },

    components: {
        Image,
    },
};
</script>
<style scoped>
.btn-post {
    width: 100%;
    text-align: left;
}

.user-name {
    width: 100%;
}
</style>
