<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">Product Detail</li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color: white !important">
                            <div style="margin-bottom: 20px; padding-top: 20px" class="d-flex justify-content-between align-items-center header-actions  mx-2 row mt-75 ">
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <h4 class="card-title">Search & Filter</h4>
                                </div>
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class=" dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top: 5px">
                                                <label>
                                                    <input autocomplete="off" v-model="name" id="name" name="name" @change="search_by_name()" type="text" class="form-control" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="dt-buttons d-inline-flex mt-50">
                                            <a    v-if="hasPermission('Inventory Products create-product') " style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect">Create New Product</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Product Code</th>
                                            <th class="sticky-th-center">Product Type</th>
                                            <th class="sticky-th-center">Product Name</th>
                                            <th class="sticky-th-center">Category</th>
                                            <th class="sticky-th-center">Type</th>
                                            <th class="sticky-th-center">Unit</th>
                                            <th class="sticky-th-center">BarCode</th>
                                            <th class="sticky-th-center">Status</th>
                                            <th class="sticky-th-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="adsdata1 in adsdata.data">
                                            <td class="td-center" >{{adsdata1.ItemCode}}</td>
                                            <td class="td-center">{{adsdata1.ItemType}}</td>
                                            <td class="td-center">{{adsdata1.Name}}<br /><span v-if="adsdata1.LinkedDept!=null" style="font-size:8px;">({{adsdata1.LinkedDept}})</span></td>
                                            <td class="td-center">{{adsdata1.CategoryName}}</td>
                                            <td class="td-center">{{adsdata1.ItemType}}</td>
                                            <td class="td-center">{{adsdata1.unit}}</td>
                                            <td class="td-center">
                                                <barcode :value="'www./'+adsdata1.ID" :formet="pharmacode" :displayValue="false" :width="0.7" :height="30">
                                                    No barcode available
                                                </barcode>
                                            </td>
                                            <td class="td-center">
                                                <span v-if="adsdata1.Status=='Active'" class="badge badge-glow bg-primary">Active</span>
                                                <span v-else class="badge badge-glow bg-secondary">{{adsdata1.Status}}</span>
                                            </td>
                                            <td class="td-center" style="vertical-align: middle; text-align: center">
                                                <div class="btn-group">
                                                    <a  v-if="hasPermission('Inventory Products edit-product') " class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a data-bs-toggle="modal" class="dropdown-item" @click="fetch_product_detail(adsdata1.ID)" data-bs-target="#viewProduct">
                                                            <i class="fa-solid fa-eye"></i>
                                                            View Detail
                                                        </a>
                                                        <a @click="fetch_product_detail(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#editproduct" class="dropdown-item">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                            Edit Product
                                                        </a>
                                                        <a v-if="adsdata1.Status=='Disable'" @click="changeStatus(adsdata1.ID, 'Active')" class="dropdown-item">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            Activate
                                                        </a>
                                                        <a v-else @click="changeStatus(adsdata1.ID, 'Disable')" class="dropdown-item">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            Disable
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div style="text-align:center;padding-top:20px">
                                <pagination v-if='pageNo==1' :limit="limit1" :data="adsdata" @pagination-change-page="getResult"></pagination>
                                <pagination v-else-if='pageNo==2' :limit="limit1" :data="adsdata" @pagination-change-page="search_by_name"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                    <div class="row" v-if="this.$helpers.hasPermission('Inventory Products inventory-link')">
                        <div class="col-md-6">
                            <section class="app-user-list">
                                <div clas="card" style="background-color: white !important">
                                    <div style="margin-bottom: 20px; padding-top: 20px" class="d-flex justify-content-between align-items-center header-actions  mx-2 row mt-75 ">
                                        <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                            <h4 class="card-title">Inventory Link</h4>
                                        </div>
                                        <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                            <div class=" dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                                <div class="me-1">
                                                    <div class="dataTables_filter" style="margin-top: 5px">
                                                        <label>
                                                            <input autocomplete="off" v-model="keyword1" name="keyword1" @change="search_by_inventory()" type="text" class="form-control" placeholder="Search By Name" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="dt-buttons d-inline-flex mt-50">
                                                    <a   v-if="hasPermission('Inventory Products inventory-link') " style="float: left" data-bs-toggle="modal" data-bs-target="#leavetype2" class="btn btn-outline-primary waves-effect">Multiple</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="overflow-x: initial !important; overflow-x: initial !important;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sticky-th-center">Product Name</th>
                                                    <th class="sticky-th-center">Coa ID</th>
                                                    <th class="sticky-th-center">AccountName</th>
                                                    <th class="sticky-th-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="inventory1 in inventory.data">
                                                    <td>{{inventory1.Name}}</td>
                                                    <td>{{inventory1.CoaID}}</td>
                                                    <td>{{inventory1.CoaName}}</td>
                                                    <td>
                                                        <a @click=fetch_inventoryid(inventory1.ItemId,inventory1.Name) data-bs-toggle="modal" data-bs-target="#leavetype9" class=""><i class="fa-solid fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="text-align: center; padding-top: 20px">
                                        <pagination :limit="limit2" :data="inventory" @pagination-change-page="getResult2"></pagination>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-6" v-if="this.$helpers.hasPermission('Inventory Products asset-link')">
                            <section class="app-user-list">
                                <div clas="card" style="background-color: white !important">
                                    <div style="margin-bottom: 20px; padding-top: 20px" class="d-flex justify-content-between align-items-center header-actions  mx-2 row mt-75 ">
                                        <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                            <h4 class="card-title">Assets Link</h4>
                                        </div>
                                        <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                            <div class=" dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                                <!--<div class="me-1">
                                                    <div class="dataTables_filter" style="margin-top: 5px">
                                                        <label>
                                                            <input autocomplete="off" v-model="keyword2" id="keyword2" name="keyword2" @change="search_by_assets()" type="text" class="form-control" placeholder="Search By Name" />
                                                        </label>
                                                    </div>
                                                </div>-->
                                                <div class="dt-buttons d-inline-flex mt-50">
                                                    <a   v-if="hasPermission('Inventory Products asset-link') " style="float: left" data-bs-toggle="modal" data-bs-target="#leavetype4" class="btn btn-outline-primary waves-effect">Multiple</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="overflow-x: initial !important">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sticky-th-center">Asset Name</th>
                                                    <th class="sticky-th-center">Coa ID</th>
                                                    <th class="sticky-th-center">AccountName</th>
                                                    <th class="sticky-th-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="assets1 in assets.data">
                                                    <td>{{assets1.Name}}</td>
                                                    <td>{{assets1.CoaID}}</td>
                                                    <td>{{assets1.CoaName}}</td>
                                                    <td>
                                                        <a @click=fetch_assetsid(assets1.AssetId,assets1.Name) data-bs-toggle="modal" data-bs-target="#leavetype5" class=""><i class="fa-solid fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="text-align: center; padding-top: 20px">
                                        <pagination :limit="limit3" :data="assets" @pagination-change-page="getassets"></pagination>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="viewProduct" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="mb-2">
                            <div class="col-md-12" v-for="product1 in product">
                                <table style="width:100%;">
                                    <thead style="float: left; width: 100%;">
                                        <h2 style="text-align:center;">Product detail</h2>
                                        <tr>
                                            <th style="width:25%">Product ID: </th>
                                            <td style="width:28%">{{product1.ID}}</td>
                                            <th>Product Name: </th>
                                            <td>{{product1.Name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Type: </th>
                                            <td>{{product1.ItemType}}</td>
                                            <th>Catagory: </th>
                                            <td>{{product1.CategoryName}}</td>
                                        </tr>
                                        <tr>
                                            <th>Purchase cost: </th>
                                            <td>{{product1.PurchaseCost}}</td>
                                            <th>Sale Value: </th>
                                            <td>{{product1.SaleCost}}</td>
                                        </tr>
                                        <tr>
                                            <th>Part number: </th>
                                            <td>{{product1.PartNumber}}</td>
                                            <th>Unit: </th>
                                            <td>{{product1.unit}}</td>
                                        </tr>
                                        <tr>
                                            <th>Linked department: </th>
                                            <td>{{product1.LinkedDept}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <div class="col-12 col-sm-12 mb-1">
                                                    <div class="mb-1">
                                                        <div class="demo-inline-spacing">
                                                            <div class="form-check form-check-inline" style="margin-top: 0px">
                                                                <input disabled class="form-check-input" type="checkbox" v-model="e_purhcased" name="inlineRadioOptions" id="inlineRadio1" checked="" />
                                                                <label class="form-check-label" for="inlineRadio1">Can Be Purchased</label>
                                                            </div>
                                                            <div class="form-check form-check-inline" style="margin-top: 0px">
                                                                <input disabled class="form-check-input" checked="" type="checkbox" v-model="e_sold" name="inlineRadioOptions" id="inlineRadio2" value="" />
                                                                <label class="form-check-label" for="inlineRadio2">Can Be Sold</label>
                                                            </div>
                                                            <div class="form-check form-check-inline" style="margin-top: 0px">
                                                                <input disabled class="form-check-input" checked="" type="checkbox" v-model="e_consumable" name="inlineRadioOptions" id="inlineRadio2" value="" />
                                                                <label class="form-check-label" for="inlineRadio2">Can Be Consumable</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Barcode:</th>
                                            <td colspan="3">
                                                <div style="height:50px !important; ">
                                                    <barcode :value="'www.google.com.com/'+product1.ID" :displayValue="false" :width="1" :height="40">
                                                        No barcode available
                                                    </barcode>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <div class="text-center" style="text-align:center; margin-top:30px;">
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editproduct" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1">Edit Product</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  @click="closeModal"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form class="row gy-1 gx-2 mt-75">
                            <div class="col-md-12 col-12">
                                <label class="form-label">Product Name<label style="color: #d93025">*</label></label>
                                <input type="text" v-model="e_productName" class="form-control" placeholder="Type Product Name" />
                                <span style="color: #db4437; " v-if="e_productName == ''">{{ e_product_error }}</span>
                            </div>
                            <div class="col-12 col-sm-12 mb-1">
                                <div class="mb-1">
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline" style="margin-top: 0px">
                                            <input class="form-check-input" type="checkbox" v-model="e_purhcased" name="inlineRadioOptions" id="inlineRadio1" checked="" />
                                            <label class="form-check-label" for="inlineRadio1">Can Be Purchased<label style="color: #d93025">*</label></label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-top: 0px">
                                            <input class="form-check-input" checked="" type="checkbox" v-model="e_sold" name="inlineRadioOptions" id="inlineRadio2" value="Company" />
                                            <label class="form-check-label" for="inlineRadio2">Can Be Sold<label style="color: #d93025">*</label></label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-top: 0px">
                                            <input class="form-check-input" checked="" type="checkbox" v-model="e_consumable" name="inlineRadioOptions" id="inlineRadio2" value="Company" />
                                            <label class="form-check-label" for="inlineRadio2">Can Be Consumable<label style="color: #d93025">*</label></label>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">General Information</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">

                                <div class="col-12">
                                    <label class="form-label">Unit<label style="color: #d93025">*</label></label>
                                    <select v-model="ed_unit" class="form-select">
                                        <option value="">Select Unit</option>
                                        <option v-for='fetch_units1 in fetch_units' :value='fetch_units1.UnitName'>{{ fetch_units1.UnitName}}</option>
                                    </select>
                                    <span style="color: #db4437; " v-if="ed_unit == ''">{{ e_ed_unit }}</span>
                                </div>
                                <div style="margin-top: 10px" >
                                    <span style="color:red !important" v-if="product_type == '' ">
                                        First Need To Select Product Type.Otherwise You Can Not Select Product Category.
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Department Linked With</label>
                                    <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" :multiple="false" v-model="e_prod_dept" :options="options3">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Purchase Cost<label style="color: #d93025">*</label></label>
                                    <input type="number" placeholder="Type Purchase Cost" v-model="e_purchase_cost" class="form-control" value="0" />
                                    <span style="color: #db4437; " v-if="e_purchase_cost == ''">{{ e_purchase_cost_error }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Part Number</label>
                                    <input type="text" v-model="e_partnumber" class="form-control" placeholder="Type Product Name" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Sale Value<label style="color: #d93025">*</label></label>
                                    <input type="number" placeholder="Type Sale Cost" v-model="e_sale_value" class="form-control" />
                                    <span style="color: #db4437; " v-if="e_sale_value == ''">{{ e_sale_value_error }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Category<label style="color: #d93025">*</label></label>
                                    <select v-model="e_category" class="form-select">
                                        <option v-for='cate_detail1 in cate_detail' :value='cate_detail1.ID'>{{ cate_detail1.CategoryName}}</option>
                                        <option v-for='category_detail1 in category_detail' :value='category_detail1.ID'>{{ category_detail1.CategoryName}}</option>
                                    </select>
                                    <span style="color: #db4437;" v-if="e_category == ''">{{ e_category_error }}</span>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center">
                                <button :disabled="disabled" @click="delay()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Save Product Detail</button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1">Create New Product</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-md-12 col-12">
                                <label class="form-label">Product Name<label style="color: #d93025">*</label></label>
                                <input type="text" v-model="productName" class="form-control" placeholder="Type Product Name" />
                                <span style="color: #db4437;" v-if="productName == ''">{{ product_error }}</span>
                            </div>
                            <div class="col-12 col-sm-12 mb-1">
                                <div class="mb-1">
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline" style="margin-top: 0px">
                                            <input class="form-check-input" type="checkbox" v-model="purhcased" name="inlineRadioOptions" id="inlineRadio1" checked="" />
                                            <label class="form-check-label" for="inlineRadio1">Can Be Purchased</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-top: 0px">
                                            <input class="form-check-input" checked="" type="checkbox" v-model="sold" name="inlineRadioOptions" id="inlineRadio2" value="" />
                                            <label class="form-check-label" for="inlineRadio2">Can Be Sold</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-top: 0px">
                                            <input class="form-check-input" checked="" type="checkbox" v-model="consumable" name="inlineRadioOptions" id="inlineRadio2" value="" />
                                            <label class="form-check-label" for="inlineRadio2">Can Be Consumable</label>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">General Information</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="col-12">
                                    <label class="form-label">Product Type<label style="color: #d93025">*</label></label>
                                    <select @change="get_category_data()" v-model="product_type" class="form-select">
                                        <option value="">Select Type</option>
                                        <option value="Goods">Goods</option>
                                        <option value="Assets">Assets</option>
                                    </select>
                                    <span style="color: #db4437;" v-if="product_type == ''">{{ product_type_error }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Unit<label style="color: #d93025">*</label></label>
                                    <select v-model="unit" class="form-select">
                                        <option value="">Select Unit</option>
                                        <option v-for='fetch_units1 in fetch_units' :value='fetch_units1.UnitName'>{{ fetch_units1.UnitName}}</option>
                                    </select>
                                    <span style="color: #db4437;" v-if="unit == ''">{{ e_unit }}</span>
                                </div>
                                <div style="margin-top: 10px" >
                                    <span style="color:red !important" v-if="product_type == '' ">
                                        First you need To Select Product Type.Otherwise You Can Not Select Product Category.
                                    </span>
                                </div>
                                <div v-if="product_type=='Goods'" class="invoice-customer">
                                    <label class="form-label">Select Link Account</label>
                                    <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" v-model="p_account_idname" :options="options2">
                                    </multiselect>
                                </div>
                                <div v-else-if="product_type=='Assets'" class="invoice-customer">
                                    <label class="form-label">Select Link Account</label>
                                    <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" v-model="p_account_idname" :options="options8">
                                    </multiselect>
                                </div>
                                <span style="color: #db4437;" v-if="p_account_idname == ''">{{ e_p_account_idname }}</span>

                                <div class="form-group">
                                    <label class="form-label">Department Linked With</label>
                                    <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" :multiple="false" v-model="prod_dept" :options="options3">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label">Purchase Cost<label style="color: #d93025">*</label></label>
                                    <input type="number" placeholder="Type Purchase Cost" v-model="purchase_cost" class="form-control" value="0" />
                                    <span style="color: #db4437;" v-if="purchase_cost == ''">{{purchase_cost_error }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Part Number</label>
                                    <input type="text" v-model="partnumber" class="form-control" placeholder="Type Product Name" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Sale Value<label style="color: #d93025">*</label></label>
                                    <input type="number" placeholder="Type Sale Cost" v-model="sale_value" class="form-control" />
                                    <span style="color: #db4437;" v-if="sale_value == ''">{{ sale_value_error }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Category<label style="color: #d93025">*</label></label>
                                    <select v-model="category" class="form-select">
                                        <option value="">Select Category</option>
                                        <option v-for='category_detail1 in category_detail' :value='category_detail1.ID'>{{ category_detail1.CategoryName}}</option>
                                    </select>
                                    <span style="color: #db4437;" v-if="category == ''">{{ category_error }}</span>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center">
                                <button :disabled="disabled1" @click="delay1()" type="button" class=" btn btn-primary mt-1 me-1 waves-effect waves-float waves-light ">
                                    Create Product
                                </button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close" @click="closeModal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leavetype2" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1">Link Multiple Inventory</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                            <div class="invoice-customer">
                                <label class="form-label">Select Item Name</label>
                                <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" :multiple="true" v-model="item_idname" :options="options">
                                </multiselect>
                            </div>
                            <div class="invoice-customer">
                                <label class="form-label">Select Link Account</label>
                                <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" v-model="account_idname" :options="options2">
                                </multiselect>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled3" @click="delay3()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leavetype4" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1">Link Multiple Assets</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                            <div class="invoice-customer">
                                <label class="form-label">Select Assets Name</label>
                                <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" :multiple="true" v-model="asset_idname" :options="options7">
                                </multiselect>
                            </div>
                            <div class="invoice-customer">
                                <label class="form-label">Select Link Account</label>
                                <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" v-model="a_account_idname" :options="options8">
                                </multiselect>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled7" @click="delay7()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leavetype9" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1">Link Multiple Inventory</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                            <div class="invoice-customer">
                                <label class="form-label">Select Item Name</label>
                                <input type="text" v-model="item_ide" hidden />
                            </div>
                            <input type="text" v-model="item_nam" class="form-control" readonly />
                        </div>
                        <div class="invoice-customer">
                            <label class="form-label">Select Link Account</label>
                            <multiselect style="margin-right: 10px; font-size: 12px;" :show-labels="false" v-model="account_idname_sep" :options="options2">
                            </multiselect>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" :disabled="disabled4" @click="delay4()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
    import VueBarcode from 'vue-barcode';
    import MaskedInput from "vue-masked-input";
    import Multiselect from 'vue-multiselect'
    export default {
        data() {
            return {

                prod_dept: '',
                e_prod_dept: '',
                departments: {},

                inventory: {},
                assets: {},
                keyword1: '',
                keyword2: '',

                limit1: 10,
                limit2: 4,
                limit3: 4,
                item_idname: null,
                account_idname: '',
                options: [],
                options2: [],
                options3: [],
                pageNo: 1,
                options7: [],
                options8: [],
                asset_idname: null,
                a_account_idname: '',

                allassets: {},
                allitems: {},
                agnstpayment: {},
                disabled3: false,
                timeout3: null,

                adsdata: {},
                success: "",

                name: "",

                productName: '',
                consumable: 'true',
                purhcased: "true",
                sold: "true",
                product_type: "",
                purchase_cost: "",
                sale_value: "",
                partnumber: '',
                category: '',
                category_detail: {},
                product: {},
                fetch_units: {},
                unit: '',
                e_unit: '',

                ed_unit: '',
                e_ed_unit: '',
                pharmacode: '',
                product_error: "",
                product_type_error: "",
                purchase_cost_error: "",
                purchase_tax_error: "",
                sale_value_error: "",
                e_sold: '',
                e_purhcased: '',
                category_error: '',

                disabled: false,
                timeout: null,
                disabled1: false,
                timeout1: null,

                ed_productid: '',
                e_productName: '',
                e_product_type: "",
                e_partnumber: "",
                e_consumable: 'true',
                e_purhcased: "true",
                e_sold: "true",
                e_sale_value: "",
                e_purchase_cost: "",
                e_category: '',

                e_product_error: "",
                e_product_type_error: "",
                e_purchase_cost_error: "",
                e_sale_value_error: "",
                e_product_error: '',
                e_category_error: '',


                item_ide: '',
                item_nam: '',
                account_idname_sep: null,
                agnstpayment2: {},
                agnstpayment6: {},
                disabled4: false,
                timeout4: null,

                disabled7: false,
                timeout7: null,
                p_account_idname: '',
                e_p_account_idname: '',
                cate_detail: {},
            };
        },
        components: {
            MaskedInput,
            'barcode': VueBarcode,
            Multiselect,
        },
        watch: {
            name(after, before) {
                this.search_by_name();
            },
            keyword1(after, before) {
                this.getResults();
            }
        },
        methods: {
            closeModal() {
      this.productName ='',
      this.product_type='',
      this.purhcased ='',
      this.sold ='',
       this.consumable =' ',
       this.product_type ='',
       this.unit =' ',
       this.p_account_idname ='',
       this.prod_dept =' ',
       this.purchase_cost =' ',
       this.partnumber='',
       this.sale_value='',
       this.category='',

      // Close the modal
      this.$emit('close');
            },
            getResults() {

                axios.get('./search_inv', { params: { keyword1: this.keyword1 } })
                    .then(response => this.inventory = response.data)
                    .catch(error => console.log(error));
            },
            fetch_assetsid(id, nam) {

            },
            submit_assetslink() {
                if (this.a_account_idname == '' || this.asset_idname == null) {
                    this.$toastr.e("Please fill required fields!", "Caution!");

                } else {
                    axios.post("accounts/submit_assetslink", {
                        a_account_idname: this.a_account_idname,
                        asset_idname: this.asset_idname,
                    })
                        .then((data) => {
                            if (data.data == 'error') {
                                this.$toastr.e("Error!", "Cautions!");
                            } else {
                                this.assets = data.data;
                                this.asset_idname = null;
                                this.a_account_idname = '',
                                    this.$toastr.s("Asset Link Accounts Successfully!", "Congratulations!");
                            }
                        })
                }
            },
            fetch_inventoryid(id, nam) {
                this.item_ide = id;
                this.item_nam = nam;
                axios.get('accounts/get_itemsdetail1/' + this.item_ide)
                    .then(response => {
                        this.agnstpayment2 = response.data;
                        this.account_idname_sep = [];
                        var $this = this;
                        for (var j = 0; j < $this.agnstpayment2.length; j++) {
                            this.account_idname_sep.push($this.agnstpayment2[j].CoaID + '_' + $this.agnstpayment2[j].CoaName);
                        }
                    })
            },
            update_sepinventory() {

                if (this.item_ide == '' || this.account_idname_sep == null) {
                    this.$toastr.e("Please fill required fields!", "Caution!");

                } else {
                    axios.post("accounts/submit_sepinventorylink", {
                        account_idname_sep: this.account_idname_sep,
                        item_ide: this.item_ide,
                    })
                        .then((data) => {
                            if (data.data == 'error') {
                                this.$toastr.e("Error!", "Cautions!");
                            } else {
                                this.inventory = data.data;
                                this.account_idname_sep = null;
                                this.item_ide = '',
                                    this.item_nam = '',
                                    this.$toastr.s("Inventory Link Accounts Successfully!", "Congratulations!");
                            }


                        })
                }

            },
            submit_inventorylink() {
                if (this.account_idname == '' || this.item_idname == null) {
                    this.$toastr.e("Please fill required fields!", "Caution!");

                } else {
                    axios.post("accounts/submit_inventorylink", {
                        account_idname: this.account_idname,
                        item_idname: this.item_idname,
                    })
                        .then((data) => {
                            if (data.data == 'error') {
                                this.$toastr.e("Error!", "Cautions!");

                            } else {
                                this.inventory = data.data;
                                this.item_idname = null;
                                this.account_idname = '',
                                    this.$toastr.s("Inventory Link Accounts Successfully!", "Congratulations!");
                            }


                        })

                }


            },
            delay7() {
                this.disabled7 = true
                this.timeout7 = setTimeout(() => {
                    this.disabled7 = false
                }, 5000)
                this.submit_assetslink();
            },
            delay4() {
                this.disabled4 = true
                this.timeout4 = setTimeout(() => {
                    this.disabled4 = false
                }, 5000)
                this.update_sepinventory();
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.update_product();
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.submit_product();
            },
            delay3() {
                this.disabled3 = true
                this.timeout3 = setTimeout(() => {
                    this.disabled3 = false
                }, 5000)
                this.submit_inventorylink();
            },
            search_by_name(page = 1) {
                this.pageNo = 2
                axios.get('./accounts_products_byname/?page=' + page, { params: { name: this.name } })
                    .then(data => this.adsdata = data.data)
                    .catch(error => { });
            },
            fetch_product_detail(id) {
                axios.get('accounts_fetch_products/' + id)
                    .then(responce => {
                        this.product = responce.data;
                        this.ed_productid = responce.data[0].ID;
                        this.e_productName = responce.data[0].Name;
                        this.e_purhcased = responce.data[0].Purchase;
                        this.e_sold = responce.data[0].Sold;
                        this.e_consumable = responce.data[0].Consumed;
                        this.e_product_type = responce.data[0].ItemType;
                        this.e_purchase_cost = responce.data[0].PurchaseCost;
                        this.e_partnumber = responce.data[0].PartNumber;
                        this.e_sale_value = responce.data[0].SaleCost;
                        this.e_category = responce.data[0].ItemCategory;
                        this.e_prod_dept = responce.data[0].LinkedDept;
                        axios.get('./accounts_category_products/' + responce.data[0].ItemCategory)
                            .then(response => {
                                this.cate_detail = response.data;
                            })
                        axios.get("./accounts/category_detail/" + this.e_product_type)
                            .then((response) => (this.category_detail = response.data));

                        this.ed_unit = responce.data[0].unit;
                        if (this.e_sold == "0") {
                            this.e_sold = false;
                        } else {
                            this.e_sold = true;
                        }

                        if (this.e_consumable == "0") {
                            this.e_consumable = false;
                        } else {
                            this.e_consumable = true;
                        }

                        if (this.e_purhcased == "0") {
                            this.e_purhcased = false;
                        } else {
                            this.e_purhcased = true;
                        }
                    })
                    .catch(error => { });
            },
            update_product() {
                if (this.e_sale_value == "" || this.e_purchase_cost == "" || this.e_productName == "" || this.e_product_type == "" || this.e_category == "" || this.ed_unit == "") {
                    if (this.e_sale_value == "") {
                        this.e_sale_value_error = "Please enter sale cost";
                    }
                    if (this.e_sale_tax == "") {
                        this.e_sale_tax_error = "Please select sale tax";
                    }
                    if (this.e_purchase_cost == "") {
                        this.e_purchase_cost_error = "Please enter purchase cost";
                    }
                    if (this.e_product_type == "") {
                        this.e_product_type_error = "Please enter product type";
                    }
                    if (this.e_productName == "") {
                        this.e_product_error = "Please eneter product name";
                    }
                    if (this.ed_unit == "") {
                        this.e_ed_unit = "Select unit";
                    }
                    if (this.e_category == "") {
                        this.e_category_error = "Select category";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");

                } else {
                    axios.post('./accounts_update_product', {
                        ed_productid: this.ed_productid,
                        e_productName: this.e_productName,
                        e_purhcased: this.e_purhcased,
                        e_sold: this.e_sold,
                        e_consumable: this.e_consumable,
                        e_product_type: this.e_product_type,
                        e_purchase_cost: this.e_purchase_cost,
                        e_partnumber: this.e_partnumber,
                        e_sale_value: this.e_sale_value,
                        category: this.e_category,
                        ed_unit: this.ed_unit,
                        ed_unit: this.ed_unit,
                        e_prod_dept: this.e_prod_dept,
                    })
                        .then(data => {
                            if (data.data == 'Product updated!') {
                                this.$toastr.s("Product updated Successfully", "Congratulations!");
                                this.ed_productid = "";
                                this.e_productName = "";
                                this.e_purhcased = "";
                                this.e_sold = "";
                                this.e_consumable = "";
                                this.e_product_type = "";
                                this.e_purchase_cost = "";
                                this.e_partnumber = "";
                                this.e_sale_value = "";
                                this.category = "";
                                this.ed_unit = "";
                                this.e_prod_dept = "";
                                this.getResult2();
                                this.getassets();
                                this.getResult();
                            }
                        })
                        .catch(error => this.error = error.responce.data.errors)
                }
            },
            changeStatus(id, sts) {
                axios.post('./accounts_update_proSts', {
                    ed_proid: id,
                    status: sts,
                })
                    .then(data => {
                        if (data.data == 'Status updated!') {
                            this.$toastr.s("Status updated Successfully!", "Congratulations!");
                            this.getResult();
                        }
                    })
                    .catch(error => this.error = error.responce.data.errors)
            },
            submit_product() {
                if (this.sale_value == "" || this.purchase_cost == "" || this.productName == "" || this.product_type == "" || this.unit == "" || this.p_account_idname == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.sale_value == "") {
                        this.sale_value_error = "Please enter sale cost";
                    }
                    if (this.sale_tax == "") {
                        this.sale_tax_error = "Please select sale tax";
                    }
                    if (this.purchase_cost == "") {
                        this.purchase_cost_error = "Please enter purchase cost";
                    }

                    if (this.product_type == "") {
                        this.product_type_error = "Please enter product type";
                    }
                    if (this.productName == "") {
                        this.product_error = "Please Enter product name";
                    }
                    if (this.category == "") {
                        this.category_error = "Please Enter Category name";
                    }
                    if (this.unit == "") {
                        this.e_unit = "Please select unit";
                    }
                    if (this.p_account_idname == '') {
                        this.e_p_account_idname = "Please Link Chart Of Account";
                    }

                } else {

                    axios.post("./accounts/submit_product", {
                        productName: this.productName,
                        consumable: this.consumable,
                        purhcased: this.purhcased,
                        sold: this.sold,
                        product_type: this.product_type,
                        purchase_cost: this.purchase_cost,
                        partnumber: this.partnumber,
                        sale_value: this.sale_value,
                        category: this.category,
                        unit: this.unit,
                        p_account_idname: this.p_account_idname,
                        prod_dept: this.prod_dept,
                    })
                        .then((data) => {

                            if (data.data == 'Product exist') {
                                this.$toastr.e("Product Already exist", "Caution!");
                            } else {
                                this.adsdata = data.data
                                this.$toastr.s("Updated Record Successfully!", "Congratulations!");
                                this.productName = "";
                                this.consumable = "";
                                this.purhcased = "";
                                this.sold = "";
                                this.product_type = "";
                                this.purchase_cost = "";
                                this.partnumber = "";
                                this.sale_value = "";
                                this.category = "";
                                this.unit = "";
                                this.p_account_idname = "";
                                this.getResult2();
                                this.assets();
                            }
                        })

                }
            },
            get_category_data() {
                axios.get("./accounts/category_detail/" + this.product_type)
                    .then((response) => (this.category_detail = response.data));
            },
            get_category_data1() {
                axios.get("./accounts/category_detail/" + this.e_product_type)
                    .then((response) => (this.category_detail = response.data));
            },
            getassets(page = 1) {
                axios.get('./accounts/fetch_assetsdata/?page=' + page)
                    .then((response) => (this.assets = response.data));
            }
        },

        mounted() {
            this.search_by_name();
            this.getResults();
            this.getassets();

            axios.get('department_detail2')
                .then(data => {
                    this.departments = data.data
                    this.options3 = [];

                    var $this = this;
                    for (var i = 0; i < $this.departments.length; i++) {
                        this.options3.push($this.departments[i].department_name);
                    }
                })
                .catch(error => { });

            axios.get('accounts/fetch_itemlist')
                .then(data => {
                    this.allitems = data.data
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.allitems.length; i++) {
                        this.options.push($this.allitems[i].ItemId + '_' + $this.allitems[i].Name);
                    }
                })
                .catch(error => { });
            axios.get('accounts/fetch_inventory_head')
                .then(response => {
                    this.agnstpayment = response.data
                    this.options2 = [];

                    var $this = this;
                    for (var i = 0; i < $this.agnstpayment.length; i++) {
                        this.options2.push($this.agnstpayment[i].ID + '_' + $this.agnstpayment[i].AccountName);
                    }
                })

            axios.get('accounts/fetch_assetlist')
                .then(data => {
                    this.allassets = data.data
                    this.options7 = [];

                    var $this = this;
                    for (var i = 0; i < $this.allassets.length; i++) {
                        this.options7.push($this.allassets[i].AssetId + '_' + $this.allassets[i].Name);
                    }
                })
                .catch(error => { });

            axios.get('accounts/fetch_assets_head')
                .then(response => {
                    this.agnstpayment6 = response.data
                    this.options8 = [];

                    var $this = this;
                    for (var i = 0; i < $this.agnstpayment6.length; i++) {
                        this.options8.push($this.agnstpayment6[i].ID + '_' + $this.agnstpayment6[i].AccountName);
                    }
                })

            axios.get("./accounts/get_units")
                .then((response) => (this.fetch_units = response.data));

        },
    };

</script>
