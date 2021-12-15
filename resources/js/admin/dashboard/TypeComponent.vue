<template>
    <div>
        <Toast/>  
        <div class="grid">
            <div class="col-12">
                <h1>Type</h1>
            </div>
        </div>

            <div class="card">
                <div class="grid mb-4">
                    <div class="col-12">
                        
                        <!-- Toolbar -->
                        <Toolbar>
                            <template #left>
                            <span class="p-input-icon-left inline-block">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global'].value" placeholder="Search" />
                            </span>
                            </template>

                            <template #right>
                                <div class="mr-2">
                                    <Button label="New" icon="pi pi-plus" class="p-button-success p-mr-2" @click="addType()" />
                                </div>
                            </template>
                        </Toolbar>

                    </div>
                </div>

                <div class="grid">
                    <!-- Types Table -->
                    <div class="col-12">
                        <DataTable :value="data" v-model:filters="filters">
                                <template #empty>
                                    No types found
                                </template>
                                <template #loading>
                                    Loading Types
                                </template>
                            <Column field="id" header="ID" style="min-width: 14rem">
                                <template #body="{data}">
                                    {{data.id}}
                                </template>
                            </Column>
                            <Column field="name" header="Name" style="min-width: 14rem">
                                <template #body="{data}">
                                    {{data.name}}
                                </template>
                            </Column>
                            <Column field="actions" header="Actions">
                                <template #body="{data}">
                                    <Button icon="pi pi-pencil" class="p-button-rounded p-button-primary mr-2" @click="editType(data.name,data.id)" />
                                    <Button icon="pi pi-trash" class="p-button-rounded p-button-danger" @click="deleteType(data.name,data.id)" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>


                    <!-- Add Type Modal -->
                    <Dialog v-model:visible="addTypeModal" :style="{width: '450px'}" header="Add" :modal="true">
                        <div class="grid">
                            <div class="col-12">
                                <div class="p-fluid">
                                    <h5>Name</h5>
                                    <InputText v-model="name"/>
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="addTypeModal = false"/>
                            <Button label="Add" icon="pi pi-check" class="p-button-text p-button-success" @click="submitType()" />
                        </template>
                    </Dialog>

                    <!-- Edit Modal -->
                    <Dialog v-model:visible="editTypeModal" :style="{width: '50vw'}" header="Edit Type" :modal="true">
                        <div class="p-fluid p-formgrid p-grid">
                            <div class="p-field p-col-12 p-md-6">
                                <div class="p-fluid">
                                    <h5>Name</h5>
                                    <InputText v-model="name"/>
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="editTypeModal = false"/>
                            <Button label="Edit" icon="pi pi-check" class="p-button-text p-button-warning" @click="confirmEditType(id)" />
                        </template>
                    </Dialog>

                    <!-- Delete Modal -->
                    <Dialog v-model:visible="deleteTypeModal" :style="{width: '50vw'}" header="Confirm" :modal="true">
                        <div class="p-fluid p-formgrid p-grid">
                            <div class="p-field p-col-12 p-md-6">
                                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                                <span>Are you sure you want to delete <b>{{name}}</b>?</span>
                            </div>
                        </div>
                        <template #footer>
                            <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="deleteTypeModal = false"/>
                            <Button label="Delete" icon="pi pi-check" class="p-button-text p-button-danger" @click="confirmDeleteType(id)" />
                        </template>
                    </Dialog>

                    <!-- Proccessing Overlay -->
                    <Dialog v-model:visible="process" :style="{width: '450px'}" :modal="true" :closeOnEscape="true">
                        <div class="grid">
                            <div class="col-12 text-center">
                                <ProgressSpinner class="block mb-4" style="width:100px;height:100px" strokeWidth="4" fill="#EEEEEE" animationDuration="1s"/>
                                <span class="block">Processeing Request...</span>
                            </div>
                        </div>
                    </Dialog>

                </div>
            </div>
    </div>
</template>

<script>
import axios from 'axios';
import { FilterMatchMode } from 'primevue/api';
export default {
    name: "TypeComponent",
    data() {
        return {
            filters: {},
            addTypeModal: false,
            editTypeModal: false,
            deleteTypeModal: false,
            process: false,
            id: null,
            name: null,
            data:[]
            }
    },
    methods: {
        showSuccess() {
            this.$toast.add({severity:'success', summary: 'Success Message', detail:'Message Content', life: 3000});
        },
        addType() {
            this.addTypeModal = true;
        },
        editType(name,id){
            this.id=id;
            this.name=name;
            this.editTypeModal = true;
        },
        deleteType(name,id){
            this.id=id;
            this.name=name;
            this.deleteTypeModal = true;
        },
        initFilters(){
            this.filters = {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            }
        },
        async get(){
            try{
                const {data} = await axios({
                    method:'get',
                    url:'/api/type/'
                 })
                this.data = data;
            }catch(err){
                console.log(err)
            }
        },
        async submitType() {
            this.addTypeModal=false;
            this.process=true;
            await axios({
                method: 'post',
                url: '/api/type',
                data:{
                    name:this.name,
                }
            }).then((res)=>{
                this.get();
                this.process=false;
                this.$toast.add({severity:'success', summary: 'Successful Request', detail:'Added new condition', life: 3000});
            }).catch((err)=>{
                this.process=false;
                console.log(err.response)
                this.$toast.add({severity:'error', summary: 'Invalid Request', detail:err.response.data.errors.name[0], life: 3000})
            })
        },
        async confirmEditType(id){ 
            try{
                this.editTypeModal = false;
                this.process=true;
                await axios({
                    method:"put",
                    url:'/api/type/'+id,
                    data:{
                        name:this.name
                    }
                })
                this.get();
                this.process=false;
                this.$toast.add({severity:'success', summary: 'Successful Request', detail:'Edited Condition', life: 3000});
            }catch(err){
                this.process=false;
                console.log(err.response)
                this.$toast.add({severity:'error', summary: 'Invalid Request', detail:err.response.data.errors.name[0], life: 3000});
            }
        },
        async confirmDeleteType(id){
            try {
                this.deleteTypeModal = false;
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/type/" + id,
                });
                this.get();
                this.process = false;
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Deleted Condition",
                    life: 3000,
                });
            } catch (err) {
                this.process = false;
                console.log(err.response);
                this.$toast.add({
                    severity: "error",
                    summary: "Invalid Request",
                    detail: err.response.data.errors.name[0],
                    life: 3000,
                });
            }
        },
    },
    created() {
        this.initFilters();
    },
    mounted() {
        this.get();
    },
}
</script>

<style>

</style>
