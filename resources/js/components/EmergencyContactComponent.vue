<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <div class="col justify-content-center pt-0">
                <Fieldset class="mb-3" legend="Emergency Contacts">
                    <DataTable
                        :value="emergency_contact_details"
                        responsiveLayout="scroll"
                    >
                        <Column field="code" header="Code"></Column>
                        <Column field="name" header="Name"></Column>
                    </DataTable>
                </Fieldset>
            </div>
        </div>
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-4 lg:col-offset-1 xl:col-4 xl:col-offset-1"
        >
            <Fieldset class="mb-3" legend="Local News">
                <NewsComponent />
            </Fieldset>
        </div>
        <Dialog
            v-model:visible="openPostModal"
            :style="{ width: '500px' }"
            header="Create Post"
            :modal="true"
            :closeOnEscape="true"
        >
            <div class="grid">
                <div class="col-12">
                    <Textarea
                        v-model="content"
                        :autoResize="true"
                        class="w-full"
                        placeholder="What's on you mind?"
                    >
                    </Textarea>
                    <FileUpload
                        name="demo[]"
                        accept="image/*"
                        :multiple="true"
                        :customUpload="true"
                        @uploader="onUpload"
                        :auto="true"
                        :maxFileSize="2000000"
                        :showUploadButton="false"
                        :showCancelButton="false"
                    >
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                </div>
            </div>

            <template #footer>
                <div v-if="content || images">
                    <Button
                        label="Post"
                        icon="pi pi-check"
                        class="p-button-text p-button-post"
                        @click="enterPost"
                    />
                </div>
            </template>
        </Dialog>
        <Dialog
            v-model:visible="loading"
            :style="{ width: '450px' }"
            :modal="true"
            :closable="false"
            :closeOnEscape="true"
        >
            <div class="grid">
                <div class="col-12 text-center">
                    <ProgressSpinner
                        class="block mb-4"
                        style="width: 100px; height: 100px"
                        strokeWidth="4"
                        fill="#EEEEEE"
                        animationDuration="1s"
                    />
                </div>
            </div>
        </Dialog>
        <Toast />
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import NewsComponent from "./NewsComponent.vue";
export default {
    name: "EmergencyContactComponent",
    components: {
        NewsComponent,
    },
    setup() {
        const store = useStore();
        return {
            emergency_contact_details: computed(
                () =>
                    store.state.emergency_contact_details
                        .emergency_contact_details
            ),
        };
    },
    data() {
        return {
            loading: null,
            user_id: null,
            groud_id: null,
        };
    },
    methods: {},
};
</script>

<style></style>
