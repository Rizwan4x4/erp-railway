<template>
    <div>
        <div class="app-content content ">
            <div class="noprint content-overlay"></div>
            <div class="noprint cheader-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="noprint content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="../purchase/demand_requisition" style="text-decoration: none;">Demand Requisitions</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                New Demand Requistion
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="invoice-add-wrapper">
                        <div class="row invoice-add">
                            <!-- Invoice Add Left starts -->
                            <div class="col-xl-10 col-md-10 col-12">
                                <div class="card invoice-preview-card">
                                    <!-- Header starts -->
                                    <div class="card-body  pb-0">
                                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0" style="margin-bottom:0px">
                                            <div v-for='companyDetail1 in companyDetail' style="margin-left:30px">
                                                <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                                    <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companyDetail1.company_name}}</h3>
                                                </div>
                                                <p class="card-text mb-25">Address: {{companyDetail1.company_address}}</p>
                                                <p class="card-text mb-25">City: {{companyDetail1.city}} - {{companyDetail1.country}}</p>
                                                <p class="card-text mb-0">Phone: {{companyDetail1.phone_number}}</p>
                                            </div>
                                            <div class="invoice-number-date mt-md-0 mt-2">
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="title">Date: </span>
                                                    <input readonly type="date" v-model="date" class="form-control invoice-edit-input " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Demand Requisition</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Project Name: <label style="color: #d93025">*</label></h6>
                                                <div class="invoice-customer">
                                                    <select @change="get_projectlist() " v-model="project_id" class="invoiceto form-select" ref="project" :class="{'is-invalid': !project_id && run, 'is-valid': project_id && run}">
                                                        <option value=''>Select Project Name</option>
                                                        <option v-for='get_project1 in get_project' :value='get_project1.ID'>{{ get_project1.ProjectName }}</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select project name
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Department/Company Name: <label style="color: #d93025">*</label></h6>
                                                <div class="invoice-customer">
                                                    <select v-model="dept_name" class="invoiceto form-select department" :class="{'is-invalid': !dept_name && run, 'is-valid': dept_name && run}" ref="department">
                                                        <option value="">
                                                            Select Department/Child Company
                                                        </option>
                                                        <option v-for='(get_dept1, index) in get_dept' :value='get_dept1.DepartmentName'>{{index+1}} - {{ get_dept1.DepartmentName}}</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select department for which demand is to be generated
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-1">
                                                <div class="demo-inline-spacing">
                                                    <div class="form-check form-check-inline" style="margin-top:0px">
                                                        <label class="form-label" for="basicSelect">Demand of:</label>
                                                    </div>
                                                    <div class="form-check form-check-inline" style="margin-top:0px">
                                                        <input class="form-check-input" type="radio" v-model="status" @change="find_services()" name="inlineRadioOptions" id="inlineRadio1" value="Goods">
                                                        <label class="form-check-label" for="inlineRadio1">Goods</label>
                                                    </div>
                                                    <div class="form-check form-check-inline" style="margin-top:0px">
                                                        <input class="form-check-input" type="radio" v-model="status" @change="find_services()" name="inlineRadioOptions" id="inlineRadio3" value="Assets">
                                                        <label class="form-check-label" for="inlineRadio3">Assets</label>
                                                    </div>
                                                    <div class="form-check form-check-inline" style="margin-top:0px">
                                                        <input class="form-check-input"  type="radio" v-model="status" @change="find_services()" name="inlineRadioOptions" id="inlineRadio2" value="Services">
                                                        <label class="form-check-label" for="inlineRadio2">Services</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please choose a username2.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-3" style="text-align: right; vertical-align:bottom !important;">
                                                <button class="btn btn-primary" @click="sum_total()" style="margin-top:21px;">Calculate Total</button>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Total Quantity</label>
                                                    <input readonly class="form-control" type="text" v-model="total_value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group xz_form row animated slideInDown" v-for="count in counter" :id="count" style="margin-top:40px">
                                            <div data-repeater-list="" class="col-lg-12">
                                                <slot class="source-item">
                                                    <div data-repeater-list="group-a">
                                                        <div class="repeater-wrapper" data-repeater-item>
                                                            <div class="row">
                                                                <div class="col-12 d-flex product-details-border position-relative pe-0">
                                                                    <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                        <div class="col-lg-5 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                            <p class="card-text col-title mb-md-50 mb-0">{{count}} - Item name <label style="color: #d93025">*</label></p>
                                                                            <multiselect v-if="status=='Goods'" style="margin-right: 10px;" :options="options" @input="Item_detail(first[count], count-1)" value="id" label="label" v-model="first[count]" placeholder="Select from Goods"></multiselect>
                                                                            <multiselect v-else-if="status=='Assets'" style="margin-right: 10px;" :options="options" @input="Item_detail(first[count], count-1)" value="id" label="label" v-model="first[count]" placeholder="Select Asset"></multiselect>
                                                                            <input hidden v-else type="text" name="first[]" value="empty">
                                                                            <input hidden type="text" name="second[]" value="empty">
                                                                            <input hidden type="number" class="form-control" name="third[]" value="1" />
                                                                            <div v-if="errorsBackEnd[count]">
                                                                                <p class="text-danger">{{ errorsBackEnd[count].ItemName }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div v-if="status=='Goods'||status=='Assets'" class="col-lg-3 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Item Code</p>
                                                                            <p style="border-radius: 2px; padding-left: 10px; width: 100%; height: 35px;" :id="'demo2_'+(count-1)" class="form-control card-text  mb-md-50 mb-0 codes"></p>
                                                                            <div v-if="errorsBackEnd[count]">
                                                                                <p class="text-danger">{{ errorsBackEnd[count].codes }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div v-if="status=='Goods'||status=='Assets'" class="col-lg-2 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Quantity <label style="color: #d93025">*</label></p>
                                                                            <input type="number" class="form-control" name="fourth[]" value="1" placeholder="Enter quantity" />
<!--                                                                            <p class="text-danger">{{ errorsBackEnd[count].Quantity }}</p>-->
<!--                                                                            <p class="text-danger">{{ errorsBackEnd[count] }}</p>-->
<!--                                                                            <p class="text-danger">{{ errorsBackEnd }}</p>-->

                                                                            <div v-if="errorsBackEnd[count]">
                                                                                <p class="text-danger">{{ errorsBackEnd[count].Quantity }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div v-else class="col-lg-3 col-12 my-lg-0 my-2">
                                                                            <input type="number" hidden class="form-control" name="fourth[]" value="1" placeholder="1" />
                                                                        </div>
                                                                        <div v-if="status=='Goods'||status=='Assets'" class="col-lg-2 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Unit</p>
                                                                            <p style="border-radius: 2px; padding-left: 10px; width: 100%; height: 35px;" :id="'demo_'+(count-1)" class="form-control card-text  mb-md-50 mb-0 units"></p>
<!--                                                                            <input hidden style="border-radius: 2px; padding-left: 10px; width: 100%; height: 35px;" :value="count" class="form-control card-text  mb-md-50 mb-0 count" />-->
                                                                            <div v-if="errorsBackEnd[count]">
                                                                                <p class="text-danger">{{ errorsBackEnd[count].unit }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <input hidden style="border-radius: 2px; padding-left: 10px; width: 100%; height: 35px;" :value="count" class="form-control card-text  mb-md-50 mb-0 count" />
                                                                        <div class="col-lg-8 col-12 my-lg-0 my-2">
                                                                            <p class="card-text mt-md-2 mb-0" v-if="status=='Goods'">Item Detail</p>
                                                                            <p class="card-text mt-md-2 mb-0" v-else-if="status=='Assets'">Asset Detail</p>
                                                                            <p class="card-text mt-md-2 mb-0" v-else>Service Detail</p>
                                                                            <textarea style="max-height:100px;" class="form-control mt-0" rows="1" name="fiveth[]" :placeholder="status === 'Goods' ? ['Item detail'] : (status === 'Assets' ? ['Asset detail'] : ['Service detail'])"></textarea>

                                                                            <div v-if="errorsBackEnd[count]">
                                                                                <p class="text-danger">{{ errorsBackEnd[count].detail }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div v-if="status=='Goods'||status=='Assets'" class="col-lg-4 col-12 my-lg-0 my-2">
                                                                            <p style="" class="card-text  mt-md-2 mb-0">Department</p>
                                                                            <p style="border-radius: 2px;padding-left: 10px;height: 35px;" :id="'demo3_'+(count-1)" class="form-control card-text  mb-md-50 mb-0"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div style="margin-left:10px" class="d-flex flex-column align-items-centerjustify-content-between border-start invoice-product-actions py-50 px-25">
                                                                        <div class="delete_btn" style="border-radius:14px;">
                                                                            <div style="margin-right: 6px;" v-on:click="delete_xz_form(count)">
                                                                                <span style="padding-top: 14px;padding-left: 7px;">
                                                                                    <i class="fa-solid fa-xmark"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </slot>

                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-12 px-0">
                                                <div data-repeater-create="" class="btn btn-primary btn-sm btn-add-new" v-on:click="add_xz_repeater();">
                                                    <span class="align-middle">+ Add Item</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Product Details ends -->
                                    <!-- Invoice Total starts -->
                                    <div class="card-body invoice-padding">
                                        <div class="row invoice-sales-total-wrapper">
                                            <div class="col-md-12 order-md-1 order-2 mt-md-0 mt-3">
                                                <label for="note" class="form-label fw-bold">Narration:</label>
                                                <textarea style="max-height:150px;" v-model="narration" class="form-control" rows="2" id="note"></textarea>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Invoice Total ends -->
                                    <hr class="invoice-spacing mt-0" />
                                    <div class="card-body invoice-padding py-0">
                                        <!-- Invoice Note starts -->
                                        <!-- Invoice Note ends -->
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Add Left ends -->
                            <!-- Invoice Add Right starts -->
                            <div class="col-xl-2 col-md-4 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">
                                            <span v-if="this.disabled === false">Post Demand</span>
                                            <span v-else>
                                                <div class="spinner-border text-secondary" role="status">
                                              <span class="sr-only">Loading...</span>
                                            </div></span>
                                        </button>
<!--                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">Post Demand</button>-->
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Add Right ends -->
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data() {
            return {
                first_dlt: [],
                var: 1,
                first: [],
                options: [],
                counter: 1,
                companyDetail: {},
                date: new Date().toJSON().slice(0, 10),
                dept_name: '',
                project_name: '',
                narration: "",
                status: 'Goods',
                run:false,
                disabled: false,
                timeout: null,
                project_id: '',
                get_unit: {},
                get_dept: {},
                get_project: {},
                get_items: {},
                total_value: '',
                item_unit: '',
                item_coded: '',
                item_LinkedDept: '',
                itemId: [],
                units: [],
                codes: [],
                est_costs: [],
                qties: [],
                details: [],
                items_data:[],
                errors:[],
                errorsBackEnd:[],
            }
        },
        methods: {
            Item_detail(value, id) {
                if(value){
                    axios.get('accounts/get_item_det/' + value.id)
                        .then(response => {
                            document.getElementById("demo_" + id).innerHTML = response.data[0].unit;
                            document.getElementById("demo2_" + id).innerHTML = response.data[0].ItemCode;
                            document.getElementById("demo3_" + id).innerHTML = response.data[0].LinkedDept;
                        })
                }
                else{
                    document.getElementById("demo_" + id).innerHTML = '';
                    document.getElementById("demo2_" + id).innerHTML = '';
                    document.getElementById("demo3_" + id).innerHTML = '';
                }
            },
            sum_total() {
                var fourth = document.getElementsByName('fourth[]');
                var m = 0;
                for (var g = 0; g < fourth.length; g++) {
                    var c = fourth[g];
                    m = Number(m) + Number(c.value);
                }
                this.total_value = m;
            },
            create_pr() {
                this.errorsBackEnd = [];//Clear errors array
                this.run  = true;
                if (!this.dept_name || !this.project_name) {
                    if (!this.dept_name) {
                        if (this.$refs.department) {
                            this.$refs.department.focus();
                        }
                    }
                    if (!this.project_name) {
                        if (this.$refs.project) {
                            this.$refs.project.focus();
                        }
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    this.disabled = true;
                    var k = 'zero';
                    var n = 0;
                    this.itemId = [];
                    this.codes = [];
                    this.est_costs = [];
                    this.units = [];
                    this.qties = [];
                    this.details = [];
                    this.errors = [];

                    this.est_costs = Array.from(document.getElementsByName('third[]'), c => c.value);
                    this.qties = Array.from(document.getElementsByName('fourth[]'), d => d.value);
                    this.details = Array.from(document.getElementsByName('fiveth[]'), fn => fn.value);
                    this.units = Array.from(document.getElementsByClassName('units'), element => element.textContent);
                    this.codes = Array.from(document.getElementsByClassName('codes'), element => element.textContent);
                    this.errors = Array.from(document.getElementsByClassName('count'), element => element.value);
                    if (this.status != 'Services') {
                        loop: for (var i = 1; i < this.first.length; i++) {
                            for (var j = 1; j < this.first_dlt.length; j++) {
                                if ((i) == this.first_dlt[j]) {
                                    continue loop;
                                }
                            }
                            if(this.first === null|| this.first[i] === undefined || this.first[i] === null ){
                                this.itemId.push("")
                            }
                            else{
                                var a = this.first[i];
                                k = k + "|" + a.id;
                                this.itemId.push(this.first[i])
                            }
                        }
                    }
                    else {
                        k = n;
                        this.itemId.push(k)
                    }
                    if(this.status != 'Services'){
                        this.items_data = this.errors.map((errors, index) => ({
                            itemId: this.itemId[index] === undefined || this.itemId[index].id === undefined  ?  '' : this.itemId[index].id,
                            ItemName: this.itemId[index] === undefined || this.itemId[index].label === undefined ?  '' : this.itemId[index].label,
                            codes: this.codes[index],
                            unit: this.units[index],
                            EstCost: this.est_costs[index],
                            Quantity: this.qties[index],
                            Detail: this.details[index],
                            errors: errors,
                        }));

                        const duplicateIndexes = [];
                        this.items_data.forEach((item, index) => {
                            const hasDuplicate = this.items_data.some((otherItem, otherIndex) => {
                                // Skip the current item
                                if (index === otherIndex) {
                                    return false;
                                }
                                // Check if the itemId values are equal
                                return item.itemId === otherItem.itemId;
                            });
                            if (hasDuplicate) {
                                duplicateIndexes.push(index+1);
                            }
                        });
                        if (duplicateIndexes.length > 0) {
                            const message = `Duplicate ` + this.status + ` found at ` + this.status + ` number: ${duplicateIndexes.join(', ')}`;
                            this.$toastr.e(message, "Caution!");
                            this.disabled = false;
                            return;
                        }
                    }
                    else{
                        this.items_data = this.errors.map((errors, index) => ({
                            Detail: this.details[index],
                            Quantity: this.qties[index],
                            errors: errors,
                        }));
                        const duplicateIndexes = [];
                        this.items_data.forEach((item, index) => {
                            const hasDuplicate = this.items_data.some((otherItem, otherIndex) => {
                                // Skip the current item
                                if (index === otherIndex) {
                                    return false;
                                }
                                // Check if the itemId values are equal
                                return item.Detail === otherItem.Detail;
                            });
                            if (hasDuplicate) {
                                duplicateIndexes.push(index+1);
                            }
                        });
                        if (duplicateIndexes.length > 0) {
                            const message = `Duplicate ` + this.status + ` found at ` + this.status + ` number: ${duplicateIndexes.join(', ')}`;
                            this.$toastr.e(message, "Caution!");
                            this.disabled = false;
                            return;
                        }
                    }

                    axios.post('./accounts/insert_requisition', {
                        date: this.date,
                        dept_name: this.dept_name,
                        project_name: this.project_name,
                        narration: this.narration,
                        status: this.status,
                        allItems: this.items_data
                    })
                        .then(data => {
                            this.disabled = false;
                            this.errorsBackEnd = [];
                            if (data.status === 200) {
                                this.$toastr.s("Demand requisition added Successfully!", "Congratulations!");
                                if (this.status == 'Goods') {
                                    this.$router.push({ name: 'demand_requisition' })
                                }
                                if (this.status == 'Assets') {
                                    this.$router.push({ name: 'demand_requisition_assets' })
                                }
                                if (this.status == 'Services') {
                                    this.$router.push({ name: 'demand_requisition_services' })
                                }
                            }
                            else if (data.data == "Empty field") {
                                this.$toastr.e("Some fields are empty or not filled properly!", "Caution!");
                            }
                            else {
                                this.$toastr.e(data.data, "Caution!");
                            }
                        })
                        .catch(err=>{
                            this.disabled = false;
                            try {
                                this.errorsBackEnd = err.response.data.errors;
                            }catch (e) {
                            }
                        })
                }
            },
            add_xz_repeater() {
                this.counter++;
            },
            delete_xz_form(id) {
                const r = confirm("Are you sure?");
                if (r == true) {
                    let node = document.getElementById(id);
                    node.remove();
                    this.first_dlt[this.var] = id;
                    this.var++;
                    this.sum_total();
                }
            },
            delay() {
                //this.disabled = true;
                 this.create_pr();
            },
            get_projectlist() {
                if(this.project_id){
                    axios.get('accounts/get_projects99/' + this.project_id)
                        .then(response => this.project_name = response.data[0].ProjectName)
                    axios.get('accounts/get_departmentcoa/' + this.project_id)
                        .then(response => this.get_dept = response.data)
                }
            },
            find_services() {
                this.first = [];
                if (this.status == 'Goods') {
                    axios.get('accounts/get_items/' + this.status)
                        .then(response => {
                            this.get_items = response.data;
                            this.options = [];
                            this.options = this.get_items.map((item) => ({
                                id: item.ID,
                                label: `${item.Name}`,
                            }));
                        }
                        )
                }
                else if (this.status == 'Assets') {
                    axios.get('accounts/get_itemsassets/' + this.status)
                        .then(response => {
                            this.get_items = response.data;
                            this.options = [];
                            this.options = this.get_items.map((item) => ({
                                id: item.ID,
                                label: `${item.Name}`,
                            }));
                        })
                }
            }
        },
        components: { Multiselect },
        mounted() {
            axios.get('accounts/get_projects9/')
                .then(response => this.get_project = response.data)
            axios.get('fetch_companyDetail')
                .then(response => this.companyDetail = response.data)
            axios.get('accounts/get_items/' + this.status)
                .then(response => {
                    this.get_items = response.data
                    this.options = [];
                    this.options = this.get_items.map((item) => ({
                        id: item.ID,
                        label: `${item.Name}`,
                    }));
                })
            axios.get('accounts/get_units')
                .then(response => this.get_unit = response.data)
        }
    }
</script>
<style scoped>
    @media print {
        .noprint {
            visibility: hidden;
        }
    }

    .invoice-preview .invoice-padding,
    .invoice-edit .invoice-padding,
    .invoice-add .invoice-padding {
        padding-left: 2.5rem;
        padding-right: 2.5rem;
    }

    .invoice-preview .table th:first-child,
    .invoice-preview .table td:first-child,
    .invoice-edit .table th:first-child,
    .invoice-edit .table td:first-child,
    .invoice-add .table th:first-child,
    .invoice-add .table td:first-child {
        padding-left: 2.5rem;
    }

    .invoice-preview .logo-wrapper,
    .invoice-edit .logo-wrapper,
    .invoice-add .logo-wrapper {
        display: flex;
        align-items: center;
        margin-bottom: 1.9rem;
    }

        .invoice-preview .logo-wrapper .invoice-logo,
        .invoice-edit .logo-wrapper .invoice-logo,
        .invoice-add .logo-wrapper .invoice-logo {
            font-size: 2.142rem;
            font-weight: bold;
            letter-spacing: -0.54px;
            margin-left: 1rem;
            margin-bottom: 0;
        }

    .invoice-preview .invoice-title,
    .invoice-edit .invoice-title,
    .invoice-add .invoice-title {
        font-size: 1.285rem;
        margin-bottom: 1rem;
    }

        .invoice-preview .invoice-title .invoice-number,
        .invoice-edit .invoice-title .invoice-number,
        .invoice-add .invoice-title .invoice-number {
            font-weight: 600;
        }

    .invoice-preview .invoice-date-wrapper,
    .invoice-edit .invoice-date-wrapper,
    .invoice-add .invoice-date-wrapper {
        display: flex;
        align-items: center;
    }

        .invoice-preview .invoice-date-wrapper:not(:last-of-type),
        .invoice-edit .invoice-date-wrapper:not(:last-of-type),
        .invoice-add .invoice-date-wrapper:not(:last-of-type) {
            margin-bottom: 0.5rem;
        }

        .invoice-preview .invoice-date-wrapper .invoice-date-title,
        .invoice-edit .invoice-date-wrapper .invoice-date-title,
        .invoice-add .invoice-date-wrapper .invoice-date-title {
            width: 7rem;
            margin-bottom: 0;
        }

        .invoice-preview .invoice-date-wrapper .invoice-date,
        .invoice-edit .invoice-date-wrapper .invoice-date,
        .invoice-add .invoice-date-wrapper .invoice-date {
            margin-left: 0.5rem;
            font-weight: 600;
            margin-bottom: 0;
        }

    .invoice-preview .invoice-spacing,
    .invoice-edit .invoice-spacing,
    .invoice-add .invoice-spacing {
        margin: 1.45rem 0;
    }

    .invoice-preview .invoice-number-date .title,
    .invoice-edit .invoice-number-date .title,
    .invoice-add .invoice-number-date .title {
        width: 115px;
    }

    .invoice-preview .invoice-total-wrapper,
    .invoice-edit .invoice-total-wrapper,
    .invoice-add .invoice-total-wrapper {
        width: 100%;
        max-width: 12rem;
    }

        .invoice-preview .invoice-total-wrapper .invoice-total-item,
        .invoice-edit .invoice-total-wrapper .invoice-total-item,
        .invoice-add .invoice-total-wrapper .invoice-total-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

            .invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-title,
            .invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-title,
            .invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-title {
                margin-bottom: 0.35rem;
            }

            .invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
            .invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
            .invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-amount {
                margin-bottom: 0.35rem;
                font-weight: 600;
            }

    @media (min-width: 768px) {
        .invoice-preview .invoice-title,
        .invoice-edit .invoice-title,
        .invoice-add .invoice-title {
            text-align: right;
            margin-bottom: 3rem;
        }
    }

    .invoice-edit .invoice-preview-card .invoice-title,
    .invoice-add .invoice-preview-card .invoice-title {
        text-align: left;
        margin-right: 3.5rem;
        margin-bottom: 0;
    }

    .invoice-edit .invoice-preview-card .invoice-edit-input,
    .invoice-edit .invoice-preview-card .invoice-edit-input-group,
    .invoice-add .invoice-preview-card .invoice-edit-input,
    .invoice-add .invoice-preview-card .invoice-edit-input-group {
        max-width: 11.21rem;
    }

    .invoice-edit .invoice-preview-card .invoice-product-details,
    .invoice-add .invoice-preview-card .invoice-product-details {
        background-color: #fcfcfc;
        padding: 3.75rem 3.45rem 2.3rem 3.45rem;
    }

        .invoice-edit .invoice-preview-card .invoice-product-details .product-details-border,
        .invoice-add .invoice-preview-card .invoice-product-details .product-details-border {
            border: 1px solid #ebe9f1;
            border-radius: 0.357rem;
        }

    .invoice-edit .invoice-preview-card .invoice-to-title,
    .invoice-add .invoice-preview-card .invoice-to-title {
        margin-bottom: 1.9rem;
    }

    .invoice-edit .invoice-preview-card .col-title,
    .invoice-add .invoice-preview-card .col-title {
        position: absolute;
        top: -1.75rem;
    }

    .invoice-edit .invoice-preview-card .item-options-menu,
    .invoice-add .invoice-preview-card .item-options-menu {
        min-width: 20rem;
    }

    .invoice-edit .invoice-preview-card .repeater-wrapper:not(:last-child),
    .invoice-add .invoice-preview-card .repeater-wrapper:not(:last-child) {
        margin-bottom: 3rem;
    }

    .invoice-edit .invoice-preview-card .invoice-calculations .total-amt-title,
    .invoice-add .invoice-preview-card .invoice-calculations .total-amt-title {
        width: 100px;
    }

    @media (max-width: 769px) {
        .invoice-edit .invoice-preview-card .invoice-title,
        .invoice-add .invoice-preview-card .invoice-title {
            margin-right: 0;
            width: 115px;
        }

        .invoice-edit .invoice-preview-card .invoice-edit-input,
        .invoice-add .invoice-preview-card .invoice-edit-input {
            max-width: 100%;
        }
    }

    @media (max-width: 992px) {
        .invoice-edit .col-title,
        .invoice-add .col-title {
            position: unset !important;
            top: -1.5rem !important;
        }
    }
</style>
