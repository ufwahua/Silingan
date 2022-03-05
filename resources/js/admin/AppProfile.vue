<template>
	<div class="layout-profile">
		<div class="grid">
			<div class="col-12 title-form">
				<Badge
					:value="1"
					severity="info"
					class="mr-2 mb-2"
					size="large"
				></Badge>
				<label><h6>Basic Information</h6></label>
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
				<div class="field col-12 md:col-6">
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
				</div>

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
		<template >
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
		</template>
		
	</div>
</template>

<script>
	export default {
		data() {
			return {
				expanded: false
			}
		},
		methods: {
			onClick(event){
				this.expanded = !this.expanded;
				event.preventDefault();
			}
		}
	}
</script>

<style scoped>

</style>