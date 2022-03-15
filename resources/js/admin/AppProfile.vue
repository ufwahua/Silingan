<template>
	<div class="layout-profile">
		<div class="grid">
			<div class="col-12 title-form">
				<label><h3>Profile Settings</h3></label>
			</div>

			<div class="p-fluid formgrid grid">
				<div class="field col-12 md:col-6">
					<label for="first_name">Firstname</label>
					<label
						style="color: red"
						for="first_name"
						v-if="!first_name"
						>*</label
					>
					<InputText
						id="firstname"
						type="text"
						v-model="first_name"
					/>
					<label
						style="color: red"
						for="first_name"
						v-if="error_first_name"
						>{{ error_first_name }}</label
					>
				</div>

				<div class="field col-12 md:col-6">
					<label for="last_name">Lastname</label>
					<label
						style="color: red"
						for="last_name"
						v-if="!last_name"
						>*</label
					>
					<InputText
						id="last_name"
						type="text"
						v-model="last_name"
					/>
					<label
						style="color: red"
						for="lastname"
						v-if="error_last_name"
						>{{ error_last_name }}</label
					>
				</div>

				<div class="field col-12 md:col-6">
					<div>
						<label for="gender">Gender</label>
						<label
							style="color: red"
							for="gender"
							v-if="!gender"
							>*</label
						>
					</div>

					<div>
						<div class="field-radiobutton mb-0">
							<RadioButton
								name="gender"
								value="male"
								v-model="gender"
								@keydown.enter="onRegisterClick"
							/>
							<label
								class="mb-0 ml-1 mr-5"
								for="gender"
								>Male</label
							>
							<RadioButton
								name="gender"
								value="female"
								v-model="gender"
								@keydown.enter="onRegisterClick"
							/>
							<label
								class="mb-0 ml-1"
								for="gender"
								>Female</label
							>
						</div>
						<div>
							<label
								style="color: red"
								for="first_name"
								v-if="error_gender"
								>{{ error_gender }}</label
							>
						</div>
					</div>
				</div>
				<div
					class="formgroup-inline flex justify-content-around"
				>
					<label
						style="color: red"
						for="first_name"
						v-if="error_gender"
						>{{ error_gender }}</label
					>
				</div>
<!-- 				<div class="field col-12 md:col-6">
					<label>Role</label>
					<label
						style="color: red"
						v-if="!selected_role"
						>*</label
					>
					<Dropdown
						v-model="selected_role"
						:options="role"
						optionLabel="type"
						optionValue="value"
						placeholder="Select Role"
					/>
					<label
						style="color: red"
						for="first_name"
						v-if="error_role"
						>{{ error_role }}</label
					>
				</div> -->

				<div class="field col-12 md:col-12">
					<label for="age">Age</label
					><label style="color: red" v-if="!age"
						>*</label
					>
					<InputText
						id="age"
						type="number"
						min="0"
						step="1"
						onfocus="this.previousValue = this.value"
						onkeydown="this.previousValue = this.value"
						oninput="validity.valid || (value = this.previousValue)"
						v-model="age"
					/>
					<label
						style="color: red"
						for="age"
						v-if="error_age"
						>{{ error_age }}</label
					>
				</div>

				<div class="field col-12 md:col-12">
					<label for="contact_num"
						>Contact Number</label
					><label
						style="color: red"
						for="contact_num"
						v-if="!contact_num"
						>*</label
					>
					<InputText
						id="contact_num"
						type="text"
						onkeyup="if(this.value<0){this.value= this.value * -1}"
						v-model="contact_num"
					/>
					<label
						style="color: red"
						for="contact_num"
						v-if="error_contact_num"
						>{{ error_contact_num }}</label
					>
				</div>

				<div class="field col-12 md:col-6">
					<label for="selected_block">Block</label>
					<label
						style="color: red"
						for="selected_block"
						v-if="!selected_block"
						>*</label
					>
					<Dropdown
						v-model="selected_block"
						:options="blocks"
						optionLabel="number"
						optionValue="id"
						placeholder="Select Block"
						@change="getBlockLot"
					/>
					<label
						style="color: red"
						for="selected_block"
						v-if="error_selected_block"
						>{{ error_selected_block }}</label
					>
				</div>

				<div class="field col-12 md:col-6">
					<label for="selected_block_lot">Lot</label>
					<label
						style="color: red"
						for="selected_block_lot"
						v-if="!selected_block_lot"
						>*</label
					>
					<Dropdown
						v-model="selected_block_lot"
						:options="filteredLots"
						optionLabel="number"
						optionValue="id"
						placeholder="Select Lot"
					/>
					<label
						style="color: red"
						for="selected_block_lot"
						v-if="error_selected_lot"
						>{{ error_selected_lot }}</label
					>
				</div>
				<div class="field col-12 md:col-12">
					<label for="email">Email</label
					><label
						style="color: red"
						for="email"
						v-if="!email"
						>*</label
					>
					<InputText
						type="text"
						name="email"
						v-model="email"
					/>
					<label
						style="color: red"
						for="email"
						v-if="error_email"
						>{{ error_email }}</label
					>
				</div>
			</div>
		</div>
		<div align="right">
			<Button
			label="Cancel"
			icon="pi pi-times"
			class="p-button-text"
			@click="updateUserDialog = false"
			/>
			<Button
				label="Update"
				icon="pi pi-check"
				class="p-button-text p-button-warning"
				@click="confirmUpdateUser"
			/>
		</div>
	</div>
</template>


<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "AppProfile",
    setup() {
        const store = useStore();
        return {
			blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            lots: computed(() => store.state.lots.lots),
            userLogged: computed(() => this.$store.state.userLogged.id,),
        };
		
    },
    data() {
        return {
            isInvalid: false,
            filters: {},
            process: false,
            registerUserDialog: false,
            deleteUserDialog: false,
            updateUserDialog: false,
            first_name: null,
            last_name: null,
            gender: null,
            block_lot_id: null,
            email: null,
            password: null,
            confirm_password: null,
            verified: 1,
            has_voted: 0,
            age: null,
            contact_num: null,
            selected_role: null,
			role: [
                { type: "officer", value: "officer" },
                { type: "resident", value: "resident" },
                { type: "security_officer", value: "security_officer" },
                { type: "admin", value: "admin" },
            ],

			selected_block:  null,
            selected_block_lot:  null,

            error_first_name: "",
            error_last_name: "",
            error_gender: "",
            error_selected_block: "",
            error_selected_lot: "",
            error_email: "",
            error_password: "",
            error_confirm_password: "",
            error_age: "",
            error_contact_num: "",
            error_role: "",
        };
		
    },
    methods: {
        showSuccess() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Message Content",
                life: 3000,
            });
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        deleteUser(first_name, last_name, id) {
            this.id = id;
            this.name = first_name + " " + last_name;
            this.deleteUserDialog = true;
        },
        async confirmDeleteItem() {
            try {
                this.deleteUserDialog = false;
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/user/" + this.id,
                });
                this.$store.dispatch("registeredUsers/getAll");
                this.process = false;
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Deleted User",
                    life: 3000,
                });
            } catch (err) {
                this.process = false;
                console.log(err.response);
            }
        },
        updateUser(data) {
            /* console.log(data);
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.updateUserDialog = true;
            this.first_name = data.first_name;
            this.last_name = data.last_name;
            this.gender = data.gender;
            this.selected_block = data.block_lot.block.id;
            this.getBlockLot();
            this.selected_block_lot = data.block_lot.id;
            this.email = data.email;
            this.age = data.age;
            this.contact_num = data.contact_num;
            this.selected_role = data.role; */

			this.id = data.id;
			this.selected_block = data.block_lot.block.id;
            this.getBlockLot();
            this.selected_block_lot = data.block_lot.id;

        },
        async confirmUpdateUser() {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    gender: this.gender,
                    block_lot_id: this.selected_block_lot,
                    email: this.email,
                    verified: 1,
                    has_voted: 0,
                    age: this.age,
                    contact_num: this.contact_num,
                    role: this.selected_role,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated User",
                        life: 3000,
                    });
                    this.$store.dispatch("registeredUsers/getAll");
                    this.resetFields();
                    this.updateUserDialog = false;
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.validate(err);
                    this.process = false;
                });
        },
        async verify(data) {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id: data.selected_block_lot,
                    email: data.email,
                    verified: 1,
                    has_voted: 0,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Resident Verified",
                        life: 3000,
                    });
                    this.$store.dispatch("registeredUsers/getAll");
                    this.resetFields();
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.validate(err);
                    this.process = false;
                });
        },
        resetFields() {
            this.selected_block = null;
            this.selected_block_lot= null;
            this.form = {
                first_name: "",
                last_name: "",
                gender: "",
                selected_block: "",
                selected_block_lot: "",
                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                selected_role: "resident",
            };
        },
        resetErrors() {
            this.error_first_name = "";
            this.error_last_name = "";
            this.error_gender = "";
            this.error_selected_block = "";
            this.error_selected_lot = "";
            this.error_email = "";
            this.error_password = "";
            this.error_confirm_password = "";
            this.error_age = "";
            this.error_contact_num = "";
            this.error_role = "";
        },
        validate(error) {
            if (error.response.data.errors.first_name)
                this.error_first_name =
                    error.response.data.errors.first_name[0];
            if (error.response.data.errors.last_name)
                this.error_last_name = error.response.data.errors.last_name[0];
            if (error.response.data.errors.gender)
                this.error_gender = error.response.data.errors.gender[0];
            if (error.response.data.errors.selected_block)
                this.error_selected_block =
                    error.response.data.errors.selected_block[0];
            if (error.response.data.errors.selected_block_lot)
                this.error_selected_lot =
                    error.response.data.errors.selected_block_lot[0];
            if (error.response.data.errors.email)
                this.error_email = error.response.data.errors.email[0];
            if (error.response.data.errors.password)
                this.error_password = error.response.data.errors.password[0];
            if (error.response.data.errors.confirm_password)
                this.error_confirm_password =
                    error.response.data.errors.confirm_password[0];
            if (error.response.data.errors.age)
                this.error_age = error.response.data.errors.age[0];
            if (error.response.data.errors.contact_num)
                this.error_contact_num =
                    error.response.data.errors.contact_num[0];
            if (error.response.data.errors.role)
                this.error_role = error.response.data.errors.role[0];
        },

        getBlockLot() {
            this.$store.dispatch("lots/getBlockLots", this.selected_block);
        },
		populateData() {
			//this.id = ;
			//console.log(this.$store.state.userLogged);
			this.first_name = this.$store.state.userLogged.first_name;
            this.last_name = this.$store.state.userLogged.last_name;
            this.gender = this.$store.state.userLogged.gender;
            this.block_lot_id = null;
            this.email = this.$store.state.userLogged.email;
            this.password = null;
            this.confirm_password = null;
            this.verified = 1;
            this.has_voted = 0;
            this.age = this.$store.state.userLogged.age;
            this.contact_num = this.$store.state.userLogged.contact_num;
            this.selected_role = this.$store.state.userLogged.role;
			//this.selected_block =  this.$store.state.blocks.blocks.id;
			//console.log(this.$store.state.userLogged.block_lot_id);
			//this.getBlockLot();
            this.selected_block_lot =  this.$store.state.userLogged.block_lot_id;

			//this.updateUser(this.$store.state.userLogged);
			console.log(this.$store.state.userLogged);
		}
    },
    created() {
        this.initFilters();
		this.populateData();
    },
};
</script>

<style></style>
