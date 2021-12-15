<template>
    <div>
        <Toast/>  
        <div class="grid">
            <div class="col-12">
                <h1>Device Master List</h1>
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
                                    <Button label="New" icon="pi pi-plus" class="p-button-success p-mr-2" @click="newDevice()" />
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
                                     No data found
                                </template>
                                <template #loading>
                                    Loading Data
                                </template>
                            <Column field="id" header="ID" style="min-width: 3rem">
                                <template #body="{data}">
                                    {{data.id}}
                                </template>
                            </Column>
                            <Column field="type" header="Type" style="min-width: 5rem">
                                <template #body="{data}">
                                    {{data.type}}
                                </template>
                            </Column>
                            <Column field="make" header="Make" style="min-width: 5rem">
                                <template #body="{data}">
                                    {{data.make}}
                                </template>
                            </Column>
                            <Column field="model" header="Model" style="min-width: 5rem">
                                <template #body="{data}">
                                    {{data.model_name}}
                                </template>
                            </Column>
                            <Column field="status" header="Status" style="min-width: 5rem">
                                <template #body="{data}">
                                    {{data.status}}
                                </template>
                            </Column>
                            <Column field="vendor" header="Vendor" style="min-width: 5rem">
                                <template #body="{data}">
                                    {{data.vendor}}
                                </template>
                            </Column>
                            <Column field="serial" header="Serial Number" style="min-width: 5rem">
                                <template #body="{data}">
                                    {{data.serial_num}}
                                </template>
                            </Column>
                            <Column field="condition" header="Device Condition" style="min-width: 4rem">
                                <template #body="{data}">
                                    {{data.condition}}
                                </template>
                            </Column>
                            <Column field="remarks" header="Remarks" style="min-width: 8rem">
                                <template #body="{data}">
                                    {{data.remarks}}
                                </template>
                            </Column>
                            <Column field="actions" header="Actions">
                                <template #body="{data}">
                                    <Button icon="pi pi-pencil" class="p-button-rounded p-button-primary mr-2" @click="updateDevice(data.id, data.type, data.status, data.condition, data.serial_num, data.tag, data.make, data.model_name, data.release_year, data.warranty_date, data.delivery_date, data.vendor, data.memory, data.storage, data.cpu, data.remarks)" />
                                    <Button icon="pi pi-trash" class="p-button-rounded p-button-danger" @click="deleteDevice(data.id)" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>


                    <!-- Add Device Modal -->
                    <Dialog v-model:visible="addDevice" :style="{width: '1000px'}" header="New Device" :modal="true">
                        <div class="grid">
                            <div class="col-12">
                                <div class="p-fluid mb-2">
                                    <h6>Device Type</h6>
                                    <Dropdown v-model="deviceType" :options="type" optionLabel="name" optionValue="code" placeholder="Select Type" @change="selectType()"/>
                                </div>
                            </div>
                        </div>
                        <div v-if="hasSelected">
                            <div class="grid">
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Device Status</h6>
                                        <Dropdown :class="{'p-invalid':add.state.device_status_id}" v-model="deviceStatus" :options="status" optionLabel="name" optionValue="code" placeholder="Select Status" />
                                        <small v-if="add.state.device_status_id" class="p-error">{{add.msg.device_status_id}}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Device Condition</h6>
                                        <Dropdown :class="{'p-invalid':add.state.device_condition_id}" v-model="deviceCondition" :options="condition" optionLabel="name" optionValue="code" placeholder="Select Status" />
                                        <small v-if="add.state.device_condition_id" class="p-error">{{add.msg.device_condition_id}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Serial Number</h6>
                                        <InputText :class="{'p-invalid':add.state.serial_num}" v-model="deviceSN" type="text" placeholder="Serial Number"/>
                                        <small v-if="add.state.serial_num" class="p-error">{{add.msg.serial_num}}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Lanex Inventory Tag</h6>
                                        <InputText :class="{'p-invalid':add.state.tag}" v-model="deviceTag" type="text" />
                                        <small v-if="add.state.tag" class="p-error">{{add.msg.tag}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Make</h6>
                                        <Dropdown :class="{'p-invalid':add.state.make_id}" v-model="deviceMake" :options="make" optionLabel="name" optionValue="code" placeholder="Select Make" />
                                        <small v-if="add.state.make_id" class="p-error">{{add.msg.make_id}}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Model</h6>
                                        <InputText :class="{'p-invalid':add.state.model_name}" v-model="deviceModel" type="text" />
                                        <small v-if="add.state.model_name" class="p-error">{{add.msg.model_name}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Release Year</h6>
                                        <InputNumber :class="{'p-invalid':add.state.release_year}" id="withoutgrouping" v-model="release" mode="decimal" :useGrouping="false" />
                                        <small v-if="add.state.release_year" class="p-error">{{add.msg.release_year}}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Warranty Date</h6>
                                        <Calendar :class="{'p-invalid':add.state.warranty_date}" id="range" v-model="warranty" :yearNavigator="true" :monthNavigator="true" yearRange="2000:2050" autocomplete="off" dateFormat="yy-mm-dd"/>
                                        <small v-if="add.state.warranty_date" class="p-error">{{add.msg.warranty_date}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Delivery Date</h6>
                                        <Calendar :class="{'p-invalid':add.state.delivery_date}" id="range" v-model="delivery" :yearNavigator="true" :monthNavigator="true" yearRange="2000:2050" autocomplete="off" dateFormat="yy-mm-dd"/>
                                        <small v-if="add.state.delivery_date" class="p-error">{{add.msg.delivery_date}}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Vendor</h6>
                                        <Dropdown :class="{'p-invalid':add.state.vendor_id}" v-model="deviceVendor" :options="vendor" optionLabel="name" optionValue="code" placeholder="Select a Vendor" />
                                        <small v-if="add.state.vendor_id" class="p-error">{{add.msg.vendor_id}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="col-6">
                                    <div class="p-fluid mb-2">
                                        <h6>Quantity</h6>
                                        <InputNumber :class="{'p-invalid':add.state.quantity}" id="withoutgrouping" v-model="quantity" mode="decimal" :min="1" :useGrouping="false" />
                                        <small v-if="add.state.quantity" class="p-error">{{add.msg.quantity}}</small>
                                    </div>
                                </div>
                            </div>
                            <div v-if="isLaptop">
                                <div class="grid">
                                    <div class="col-12">
                                        <h5>Specs</h5>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Memory</h6>
                                            <InputText type="text" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Storage</h6>
                                            <InputText type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Others</h6>
                                            <Textarea v-model="deviceRemarks" :autoResize="true" rows="1" cols="30" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>CPU</h6>
                                            <InputText type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="col-12">
                                    <div class="p-fluid mb-2">
                                        <h6>Remarks</h6>
                                        <Textarea v-model="deviceRemarks" :autoResize="true" rows="5" cols="30" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <template #footer>
                            <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="addDevice = false"/>
                            <Button label="Add" icon="pi pi-check" class="p-button-text p-button-success" :class="{'p-disabled':addBtn}" @click="submit()"/>
                        </template>
                    </Dialog>

                    <!-- Edit Modal -->
                    <Dialog v-model:visible="editDevice" :style="{width: '1000px'}" header="Update Device" :modal="true">
                        <!-- <template #body="{data}"> -->
                            <div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Device Type</h6>
                                            <Dropdown v-model="data.type" disabled :options="type" optionLabel="name" optionValue="code"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Device Status</h6>
                                            <Dropdown v-model="data.status" :options="status" optionLabel="name" optionValue="code"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Device Condition</h6>
                                            <Dropdown v-model="data.condition" :options="condition" optionLabel="name" optionValue="code" />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Serial Number</h6>
                                            <InputText v-model="data.serial_num" type="text" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Lanex Inventory Tag</h6>
                                            <InputText v-model="data.tag" disabled type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Make</h6>
                                            <Dropdown v-model="deviceMake" :placeholder="data.make" disabled :options="make" optionLabel="name" optionValue="code"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Model</h6>
                                            <InputText v-model="data.model_name" disabled type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Release Year</h6>
                                            <InputNumber id="withoutgrouping" v-model="data.release_year" disabled mode="decimal" :useGrouping="false" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Warranty Date</h6>
                                            <Calendar id="range" v-model="data.warranty_date" disabled :yearNavigator="true" :monthNavigator="true" yearRange="2000:2050" autocomplete="off" dateFormat="yy-mm-dd"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Delivery Date</h6>
                                            <Calendar id="range" v-model="data.delivery_date" disabled :yearNavigator="true" :monthNavigator="true" yearRange="2000:2050" autocomplete="off" dateFormat="yy-mm-dd"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Vendor</h6>
                                            <Dropdown v-model="data.vendor" disabled :options="vendor" optionLabel="name" optionValue="code"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-12">
                                        <h5>Specs</h5>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Memory</h6>
                                            <InputText v-model="data.memory" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Storage</h6>
                                            <InputText v-model="data.storage" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>Operating System</h6>
                                            <InputText type="text" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-fluid mb-2">
                                            <h6>CPU</h6>
                                            <InputText v-model="data.rcpu" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid">
                                    <div class="col-12">
                                        <div class="p-fluid mb-2">
                                        <h6>Remarks</h6>
                                            <Textarea v-model="remarks" :autoResize="true" rows="5" cols="30" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </template> -->
                        <template #footer>
                            <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="editDevice = false"/>
                            <Button label="Update" icon="pi pi-check" class="p-button-text p-button-success" @click="update(data.id)"/>
                        </template>
                    </Dialog>
                    
                    <!-- Delete Modal -->
                    <Dialog v-model:visible="destroyDevice" :style="{width: '50vw'}" header="Confirm" :modal="true">
                        <div class="p-fluid p-formgrid p-grid">
                            <div class="p-field p-col-12 p-md-6">
                                <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                                <span>Are you sure you want to delete <b>{{model_name}}</b>?</span>
                            </div>
                        </div>
                        <template #footer>
                            <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="destroyDevice = false"/>
                            <Button label="Delete" icon="pi pi-check" class="p-button-text p-button-danger" @click="destroy(id)" />
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
    name: "DeviceComponent",
    data() {
        return {
            hasSelected:false,
            addBtn:true,
            isLaptop: false,
            delivery: null,
            release: null,
            warranty: null,
            filters: {},
            deviceType: null,
            addDevice: false,
            editDevice: false,
            destroyDevice: false,
            process: false,
            id: null,
            type: null,
            status: null,
            condition: null,
            make: null,
            model: null,
            vendor: null,
            serial_num: null,
            tag: null,
            deviceRemarks:null,
            deviceMake: null,
            deviceModel: null,
            deviceStatus: null,
            deviceVendor: null,
            deviceCondition:null,
            deviceSN: null,
            deviceTag: null,
            condition: null,
            remarks: null,
            quantity:null,
            cpu: null,
            storage: null,
            memory: null,
            os: null,
            data:[],
            add:{
                state:{
                    make_id: false,
                    type_id: false,
                    model_name: false,
                    warranty_date: false,
                    vendor_id: false,
                    device_status_id: false,
                    device_condition_id: false,
                    release_year: false,
                    delivery_date: false,
                    serial_num: false,
                    tag: false,
                    quantity: false
                },
                msg:{
                    make_id: null,
                    type_id: null,
                    model_name: null,
                    warranty_date: null,
                    vendor_id: null,
                    device_status_id: null,
                    device_condition_id: null,
                    release_year: null,
                    delivery_date: null,
                    serial_num: null,
                    tag: null,
                    quantity: null
                }  
            }
        }
    },
    methods: {
        async submit(){
            console.log(
                [this.deviceType,
                this.deviceStatus,
                this.deviceCondition,
                this.deviceSN,
                this.deviceTag,
                this.deviceMake,
                this.deviceModel,
                this.release,
                this.warranty,
                this.delivery,
                this.deviceVendor,
                this.remarks
                ]
            )
            try{
                this.add = {
                    state:{
                        make_id: false,
                        type_id: false,
                        model_name: false,
                        warranty_date: false,
                        vendor_id: false,
                        device_status_id: false,
                        device_condition_id: false,
                        release_year: false,
                        delivery_date: false,
                        serial_num: false,
                        tag: false,
                        quantity: false
                    },
                    msg:{
                        make_id: null,
                        type_id: null,
                        model_name: null,
                        warranty_date: null,
                        vendor_id: null,
                        device_status_id: null,
                        device_condition_id: null,
                        release_year: null,
                        delivery_date: null,
                        serial_num: null,
                        tag: null,
                        quantity: null
                    }  
                }
                this.process = true
                await axios({
                    method: "post",
                    url: "/api/device",
                    data: {
                        make_id: this.deviceMake,
                        type_id: this.deviceType,
                        model_name: this.deviceModel,
                        warranty_date: (this.warranty==null)?null:this.warranty.getFullYear()+"-"+(((this.warranty.getMonth()+1).toString().split('').length==1)?"0"+(this.warranty.getMonth()+1):(this.warranty.getMonth()+1))+"-"+ ((this.warranty.getDate().toString().split('').length==1)?"0"+this.warranty.getDate():this.warranty.getDate()),
                        vendor_id: this.deviceVendor,
                        device_status_id: this.deviceStatus,
                        device_condition_id: this.deviceCondition,
                        release_year: this.release,
                        delivery_date: (this.delivery==null)?null:this.delivery.getFullYear()+"-"+(((this.delivery.getMonth()+1).toString().split('').length==1)?"0"+(this.delivery.getMonth()+1):(this.delivery.getMonth()+1))+"-"+ ((this.delivery.getDate().toString().split('').length==1)?"0"+this.delivery.getDate():this.delivery.getDate()),
                        serial_num: this.deviceSN,
                        tag: this.deviceTag,
                        quantity: this.quantity
                    }
                })
                this.process = false
                this.addDevice = false
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Added New Device",
                    life: 3000,
                });
                get()
            }catch(e){
                console.log(e)
                this.process = false
                if('make_id' in e.response.data.errors){
                    this.add.state.make_id= true
                    this.add.msg.make_id = "Device Make is required"
                }
                if('type_id' in e.response.data.errors){
                    this.add.state.type_id= true
                    this.add.msg.type_id = "Device Type is required"
                }
                if('model_name' in e.response.data.errors){
                    this.add.state.model_name = true
                    this.add.msg.model_name = "Device Model is required"
                }
                if('warranty_date' in e.response.data.errors){
                    this.add.state.warranty_date = true
                    this.add.msg.warranty_date = "Device Warranty is Required"
                }
                if('vendor_id' in e.response.data.errors){
                    this.add.state.vendor_id = true
                    this.add.msg.vendor_id = "Device Vendor required"
                }
                if('device_status_id' in e.response.data.errors){
                    this.add.state.device_status_id = true
                    this.add.msg.device_status_id = "Device Status is required"
                }
                if('device_condition_id' in e.response.data.errors){
                    this.add.state.device_condition_id = true
                    this.add.msg.device_condition_id = "Device Condition required"
                }
                if('release_year' in e.response.data.errors){
                    this.add.state.release_year = true
                    this.add.msg.release_year = "Device Release required"
                }
                if('delivery_date' in e.response.data.errors){
                    this.add.state.delivery_date = true
                    this.add.msg.delivery_date = "Device Delivery required"
                }
                if('serial_num' in e.response.data.errors){
                    this.add.state.serial_num = true
                    this.add.msg.serial_num = "Device Serial Number required"
                }
                if('tag' in e.response.data.errors){
                    this.add.state.tag = true
                    this.add.msg.tag = "Device Tag required"
                }
                if('quantity' in e.response.data.errors){
                    this.add.state.quantity = true
                    this.add.msg.quantity = "Device Quantity required"
                }
            }
            

        },
        selectType(){
            this.hasSelected = true
            this.addBtn = false;
            function id(arr){
                let id = null
                arr.forEach((elem)=>{
                    if("Laptop"==elem.name){
                        id = elem.code
                    }
                })
                return id
            }
            let  compId = id(this.type)
            if(this.deviceType == compId){
                this.isLaptop = true
            }else{
                this.isLaptop = false
            }
        },
        newDevice(){
            this.addDevice = true
        },
        updateDevice(id, type, status, condition, serial_num, tag, make, model_name, release_year, warranty_date, delivery_date, vendor, memory, storage, cpu, remarks){
            this.data.id = id;
            this.data.type = type;
            this.data.status = status;
            this.data.condition = condition;
            this.data.serial_num = serial_num;
            this.data.tag = tag;
            this.data.make = make;
            this.data.model_name = model_name;
            this.data.release_year = release_year;
            this.data.warranty_date = warranty_date;
            this.data.delivery_date = delivery_date;
            this.data.vendor = vendor;
            this.data.memory = memory;
            this.data.storage = storage;
            this.data.cpu = cpu;
            this.data.remarks = remarks;
            this.editDevice = true;
            console.log(this.data);
        },
        deleteDevice(id){
            this.id = id
            this.destroyDevice = true;
        },
        showSuccess() {
            this.$toast.add({severity:'success', summary: 'Success Message', detail:'Message Content', life: 3000});
        },
        initFilters(){
            this.filters = {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            }
        },
        async update(id){ 
            try{
                this.editDevice = false;
                this.process=true;
                await axios({
                    method:"put",
                    url:'/api/device/'+ id,
                    data:{
                        type: this.type,
                        status: this.status,
                        condition: this.condition,
                        serial_num: this.serial_num,
                        tag: this.tag,
                        make: this.make,
                        model_name: this.model_name,
                        release_year: this.release_year,
                        warranty_date: this.warranty_date,
                        delivery_date: this.delivery_date,
                        vendor: this.vendor,
                        memory: this.memory,
                        storage: this.storage,
                        cpu: this.cpu,
                        remarks: this.remarks,
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
        async destroy(id){
            try {
                this.destroyDevice = false;
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/device/" + id,
                });
                this.get();
                this.process = false;
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Deleted Device",
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
        async get(){
            let temp =  []
            try{
                const devices = await axios({
                    method:'get',
                    url:'/api/device/'
                 })
                this.data = devices.data;
                const type = await axios({
                    method: 'get',
                    url:'/api/type'
                })
                
                type.data.forEach(elem =>{
                    temp.push({name:elem.name,code:elem.id})
                })
                this.type = temp
                temp = []

                const condition = await axios({
                    method: 'get',
                    url:'/api/device-condition'
                })

                condition.data.forEach(elem =>{
                    temp.push({name:elem.name,code:elem.id})
                })
                this.condition = temp
                temp = []

                const status = await axios({
                    method: 'get',
                    url:'/api/device-status'
                })

                status.data.forEach(elem =>{
                    temp.push({name:elem.name,code:elem.id})
                })
                this.status = temp
                temp = []

                const make = await axios({
                    method: 'get',
                    url:'/api/make'
                })

                make.data.forEach(elem =>{
                    temp.push({name:elem.name,code:elem.id})
                })
                this.make = temp
                temp = []

                const vendor = await axios({
                    method: 'get',
                    url:'/api/vendor'
                })

                vendor.data.forEach(elem =>{
                    temp.push({name:elem.name,code:elem.id})
                })
                this.vendor = temp
                temp = []
            }catch(err){
                console.log(err)
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
