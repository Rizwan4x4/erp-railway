<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/recruitment/recDashboard"
                                        style="text-decoration: none;">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Register Member
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- <div class="card-body  "> -->
                        <div class="row">
                            <div class="col-12 col-md-6 card tm-6">
                                <div class="card-body ">
                                    <label class="form-label">
                                        <h4>Select Club</h4>
                                    </label>
                                    <!--  <span style="color: #DB4437; font-size: 11px;">*</span> -->

                                    <multiselect style="margin-right: 10px; background-color: #37addb;"
                                        v-model="selected_club" :show-labels="false" placeholder="Select"
                                        :options="club_name" >
                                    </multiselect>
                                    <span style="color: #DB4437; font-size: 11px;" v-if="selected_club == ''">{{
                                        selected_club_error }}</span>
                                </div>
                                <div v-if="!receipt" style="margin-bottom:20px;"
                        class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                        <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                            <div v-if="hasPermission('Admin Club Management Register Member AddNewMember')"  style="float:right;">
                                <router-link to="" class="dt-button add-new btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addcandidate" tabindex="0" type="button"><span>+ Add new
                                        Member</span></router-link>
                            </div>
                        </div>
                    </div>
                            </div>
                            <div class="col-12 col-md-6 card">
                                <div class="card-body ">
                                    <h4 class="card-title">Search & Filter</h4>

                                    <div class="row">
                                        <div class="col-md-5">

                                            <label class="form-label">Member Name OR Cnic</label>
                                            <input type="text" v-model="search_name" class="form-control"
                                                placeholder="Member Name OR CNIC " />

                                        </div>


                                        <div class="col-md-3">
                                            <div style="height:27px;"></div>
                                            <button @click="search_member()" class="dt-button add-new btn btn-primary"
                                                tabindex="0" type="button"><span>Search</span></button>

                                        </div>
                                        <div class="col-md-3">
                                            <div style="height:27px;"></div>
                                            <button @click="reset_filters()" class="dt-button add-new btn btn-secondary" tabindex="0"
                                    type="button">
                                    <span>Reset</span>
                                </button>

                                        </div>

                                        <span v-if="receipt" class="text-center" style="margin-top: 30px;">
                                        </span>

                                    </div>
                                </div>
                            </div>



                    <!-- </div> -->
                    </div>


                    <div class="card p-1">

                        <table class="user-list-table table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:200px; text-align:center;">Member Name</th>
                                    <th style="width:180px; text-align:center;">Cnic</th>
                                    <th style="width:180px; text-align:center;">Email</th>
                                    <th style="width:20px; text-align:center;">Phone no</th>
                                    <th style="width:20px; text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="member in member_data">
                                    <th scope="row" class="text-center">{{ member.employee_code == null ? member.Name :
                                        member.Name }}</th>
                                    <td class="text-center">{{ 
                                        member.Cnic }}
                                    </td>
                                    <td class="text-center">{{
                                        member.Email}}
                                    </td>
                                    <td class="text-center">{{ 
                                        member.PhoneNo }}</td>

                                    <td class="text-center">
                                        <a  to="" @click="nameValue_id(member)" data-bs-toggle="modal"
                                            data-bs-target="#view_receipt" tabindex="0" type="button">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <span v-if="receipt" @click="nameValue(member)" class="text-center">
                                            <a to="" data-bs-toggle="modal" data-bs-target="#fee_receipt" tabindex="0"
                                                type="button">

                                                <i class="fas fa-money-bill-wave" style="font-size: 24px;"></i>
                                            </a>

                                        </span>
                                    </td>

                                </tr>
                            </tbody>

                        </table>
                        <div class="col-md-12" style="text-align:center;padding-top:20px">
                            <pagination :data="pagination" :limit="limit" @pagination-change-page="getResults1">
                            </pagination>
                        </div>
                    </div>
                    <!-- view reciept modal -->
                    <div class="modal fade" id="view_receipt" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="modal-title text-center" style="width: 100%; margin: 0 auto;">Member Receipts Detail</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0"  v-for="Emp_Data1 in Emp_data">
                                    <div  style="margin-left:30px">
                                        <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{Emp_Data1.ClubName}}</h3>
                                        </div>
                                        <p v-if="Emp_Data1.m_type =='Employee' " class="card-text mb-25">Employee Code : {{ Emp_Data1.employee_code}} </p>
                                        <p v-if="Emp_Data1.m_type =='Employee' " class="card-text mb-25">Designation : {{ Emp_Data1.Designation}} </p>
                                        <p v-if="Emp_Data1.m_type =='Employee' " class="card-text mb-25">Department: {{ Emp_Data1.Department}} </p>
                                        <p v-if="Emp_Data1.m_type =='Resident'" class="card-text mb-25">Block : {{ Emp_Data1.EmployeeCNIC }}</p>
                                        <p v-if="Emp_Data1.m_type =='Resident' " class="card-text mb-0">Plot No :{{ Emp_Data1.EmployeePhone }}</p>
                                        <p v-if="Emp_Data1.m_type =='Resident'" class="card-text mb-0">Street No :{{ Emp_Data1.EmployeePhone }}</p>
                                        <p v-if="Emp_Data1.m_type =='Outsider'" class="card-text mb-0">Name :{{ Emp_Data1.EmployeeName }}</p>
                                        <p v-if="Emp_Data1.m_type =='Outsider'" class="card-text mb-0">Email :{{ Emp_Data1.EmployeeEmail }}</p>
                                        <p v-if="Emp_Data1.m_type =='Outsider'" class="card-text mb-0">Address :{{ Emp_Data1.Address }}</p>
                                    </div>
                                    <div style="margin-left: 30px; margin-top: 40px;">
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width: 30%; font-weight: bold;">Status:</p>
                                            <p style="width: 70%;" class="invoice-date">
                                                <span v-if="Emp_Data1.Status == 'Register'" class="badge badge-light-warning">Registered</span>
                                            </p>
                                            <p class="invoice-date-title" style="width: 30%; font-weight: bold;">Type:</p>
                                            <p style="width: 70%;" class="invoice-date">{{ Emp_Data1.m_type }}</p>
                                        </div>
                                    </div>

                                </div>
                                <!-- Header ends -->
                            </div>
                                    <div class="text-center mb-2">
                                        <h4 class="mb-1">Receipts Details</h4>

                                    </div>
                                    <br />
                                    <div>
                                        <table style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; width: 200px; text-align: center;">
                                                        Fee Amount</th>
                                                    <th
                                                        style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; width: 180px; text-align: center;">
                                                        Date Paid</th>
                                                        <th
                                                        style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; width: 180px; text-align: center;">
                                                       Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
    <tr v-for="rec in receipts_data" :key="rec.id">
      <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
        {{ rec.FeeAmount }}
      </td>
      <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
        {{ rec.FeeDate }}
      </td>
      <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">
        {{ rec.Status }}
      </td>
    </tr>
    <tr v-if="!receipts_data || receipts_data.length === 0">
      <td colspan="3" style="text-align: center; font-size: 18px; padding-top: 20px;">
        No data
      </td>
    </tr>
  </tbody>
                                        </table>
                                    </div>
                                    <br />

                                    <div class="col-12 text-center mt-2 pt-50">

                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- view reciept modal end -->

                    <!-- pay receipt model -->
                    <div class="modal fade" id="fee_receipt" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Add Receipt Details</h1>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="selectedMemberName" readonly class="form-control" />
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Enter fee amount</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="date" v-model="receipt_fee.date" class="form-control"
                                                placeholder="Enter fee " />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="receipt_fee.date == ''">{{
                                                receipt_fee_error.date_error }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-2 pt-50">
                                        <button :disabled="disabled1" @click="delay1()"
                                            class="btn btn-primary me-1">Pay</button>
                                        <button type="reset" id="receipt_cancel" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- pay receipt model end -->
                    <!-- Add member model-->
                    <div class="modal fade" id="addcandidate" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Add Member Details</h1>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="mb-1">
                                            <label class="form-label" for="basicSelect">Select option below</label>
                                            <label style="color: #d93025">*</label>
                                            <div class="row demo-inline-spacing">
                                                <div class="col-md-2 form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="m_type"
                                                        name="inlineRadioOptions" id="inlineRadio1" value="emp">
                                                    <label class="form-check-label" for="inlineRadio1">If employee</label>
                                                </div>
                                                <div class="col-md-3 form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="m_type"
                                                        name="inlineRadioOptions" id="inlineRadio3" value="res">
                                                    <label class="form-check-label" for="inlineRadio3">If Resident</label>
                                                </div>
                                                <div class="col-md-3 form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="m_type"
                                                        name="inlineRadioOptions" id="inlineRadio2" value="out">
                                                    <label class="form-check-label" for="inlineRadio2">If Outsider</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- for resident -->
                                    <div v-if="this.m_type == 'res'">
                                        <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Name</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <input type="text" v-model="resident.m_name" class="form-control"
                                                    placeholder="Enter full name" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="resident.m_name == ''">{{ resident_error.name_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Mobile Number</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <masked-input v-model="resident.m_mobile"
                                                    class="form-control account-number-mask" mask="0311 -1111111"
                                                    placeholder="Mobile number"></masked-input>
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="resident.m_mobile == ''">{{ resident_error.mobile_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">CNIC</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <masked-input v-model="resident.cnic"
                                                    class="form-control account-number-mask" mask="11111 -1111111-1"
                                                    placeholder="CNIC"></masked-input>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="resident.cnic == ''">{{
                                                    resident_error.cnic_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" v-model="resident.m_email" class="form-control"
                                                    placeholder="abc@xyz.com" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="!validEmail(resident.m_email) || resident.m_email == ''">{{
                                                        resident_error.m_email_error }}</span>
                                            </div>
                                            <div></div>

                                            <!--
                                       <div class="col-12 col-md-6">
                                            <label class="form-label">Select Club</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>

                                            <multiselect style="margin-right: 10px;"

                                                         v-model="resident.club_n"
                                                         :show-labels="false"
                                                         placeholder="Select"
                                                         :options="club_name"
                                                         @input="setClubId_res">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="resident.club_n==''">{{resident_error.club_error}}</span>
                                        </div> -->
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Select Block</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>

                                                <multiselect style="margin-right: 10px;" v-model="resident.block"
                                                    :show-labels="false" placeholder="Select" :options="block">
                                                </multiselect>
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="resident.block == ''">{{ resident_error.block_error }}</span>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label class="form-label">Plot no</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <input type="text" v-model="resident.plot" class="form-control"
                                                    placeholder="Enter Plot number" />
                                                <span style="color: #DB4437; font-size: 11px;" v-if="resident.plot == ''">{{
                                                    resident_error.plot_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <label class="form-label">Street no</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <input type="text" v-model="resident.street" class="form-control"
                                                    placeholder="Enter street number" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="resident.street == ''">{{ resident_error.street_error }}</span>
                                            </div>

                                            




                                        </form>
                                    </div>
                                    <!-- for resident end -->
                                    <!-- for outsiders -->
                                    <div v-if="this.m_type == 'out'">
                                        <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Name</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <input type="text" v-model="outsider.m_name" class="form-control"
                                                    placeholder="Enter full name" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="outsider.m_name == ''">{{ outsider_error.name_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Mobile Number</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <masked-input v-model="outsider.m_mobile"
                                                    class="form-control account-number-mask" mask="0311 -1111111"
                                                    placeholder="Mobile number"></masked-input>
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="outsider.m_mobile == ''">{{ outsider_error.mobile_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">CNIC</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <masked-input v-model="outsider.cnic"
                                                    class="form-control account-number-mask" mask="11111 -1111111-1"
                                                    placeholder="CNIC"></masked-input>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="outsider.cnic == ''">{{
                                                    outsider_error.cnic_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" v-model="outsider.m_email" class="form-control"
                                                    placeholder="abc@xyz.com" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="!validEmail(outsider.m_email) || outsider.m_email == ''">{{
                                                        outsider_error.m_email_error }}</span>
                                            </div>
                                            <div></div>






                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Enter Address</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <input type="text" v-model="outsider.m_address" class="form-control"
                                                    placeholder="Enter complete address" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="outsider.m_address == ''">{{ outsider_error.address_error
                                                    }}</span>
                                            </div>


                                            <!-- <div class="col-12 col-md-6">
                                            <label class="form-label">Select Club</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>

                                            <multiselect style="margin-right: 10px;"

                                                         v-model="outsider.club_n"
                                                         :show-labels="false"
                                                         placeholder="Select"
                                                         :options="club_name"
                                                         @input="setClubId_out">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="outsider.club_n==''">{{outsider_error.club_error}}</span>
                                        </div> -->
                                        




                                        </form>
                                    </div>
                                    <!-- for outsiders end-->
                                    <!-- for employyeee -->
                                    <div v-if="this.m_type == 'emp'">
                                        <form id="empform" class="row gy-1 pt-75" onsubmit="return false">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Select Employee Code</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>

                                                <multiselect style="margin-right: 10px;" v-model="selectedEmployee"
                                                    :show-labels="false" placeholder="Select" :options="options4"
                                                    @input="updateEmpCode">
                                                </multiselect>
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="this.employee.emp_code_member == ''">{{employee_error.emp_error
                                                    }}</span>
                                            </div>


                                
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Mobile Number</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <masked-input v-model="employee.m_mobile"
                                                    class="form-control account-number-mask" mask="0311 -1111111"
                                                    placeholder="Mobile number"></masked-input>
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="employee.m_mobile == ''">{{employee_error.mobile_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">CNIC</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <masked-input v-model="employee.cnic"
                                                    class="form-control account-number-mask" mask="11111 -1111111-1"
                                                    placeholder="CNIC"></masked-input>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="employee.cnic == ''">{{
                                                    employee_error.cnic_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" v-model="employee.m_email" class="form-control"
                                                    placeholder="abc@xyz.com" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="!validEmail(employee.m_email) || employee.m_email == ''">{{
                                                        employee_error.m_email_error }}</span>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label">Enter Address</label>
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                                <input type="text" v-model="employee.m_address" class="form-control"
                                                    placeholder="Enter complete address" />
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="employee.m_address == ''">{{ employee_error.address_error
                                                    }}</span>
                                            </div>




                                        </form>
                                    </div>
                                    <!-- for employyeee end-->
                                    <!-- data-bs-dismiss="modal" aria-label="Close" -->
                                    <div class="col-12 text-center mt-2 pt-50">
                                        <button :disabled="disabled" @click="delay()"
                                            class="btn btn-primary me-1">Add</button>
                                        <button type="reset" id="cancelButton1" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import MaskedInput from 'vue-masked-input'
import Multiselect from 'vue-multiselect'
const image = "";

export default {
    components: {
        MaskedInput,
        Multiselect
    },
    props: ['receipt'],
    data() {
        return {
            page: 1,
            limit: 10,
            pageN: '',
            pagination: {},
            search_cnic: '',
            search_name: '',
            receipts_data: [],
            selectedMemberName: '',
            selectedMemberId: '',
            selectedMemberId_Receipts: '',

            receipt_fee: {

                date: '',
            },
            receipt_fee_error: {

                date_error: ''
            },
            isModalVisible: false,
            Emp_data :[],
            member_data: [],
            selectedEmployee: null,
            formdata: [],
            formdata1: [],
            club_id_map: {},
            selected_club: '',
            selected_club_id:'',
            selected_club_error: '',
            employee: {
                m_name: "",
                m_mobile: "",
                cnic: "",
                m_email: "",
                club_n: "",
                club_id:'',
                emp_code_member: "",
                m_address: "",
            },

            resident: {
                m_name: "",
                m_mobile: "",
                cnic: "",
                m_email: "",
                club_n: "",
                club_id: "",
                block: "",
                plot: "",
                street: "",

                
            },
            outsider: {
                m_name: '',
                m_mobile: "",
                cnic: "",
                m_email: "",
                m_address: "",
                club_id:'',
                club_n: "",
               
            },
            outsider_error: {
                name_error: '',
                mobile_error: '',
                cnic_error: "",
                m_email_error: '',
                club_error: "",
                address_error: '',
                fee_error: "",
                
            },
            employee_error: {
                address_error: "",
                emp_error: "",
                club_error: "",
                mobile_error: '',
                cnic_error: "",
                m_email_error: '',
                fee_error: "",
            },
            resident_error: {
                name_error: '',
                mobile_error: '',
                cnic_error: "",
                m_email_error: '',
                club_error: "",
                block_error: "",
                plot_error: "",
              
                fee_error: "",
              
            },
            find_emp: [],
            options4: [],
            club_data1: [],
            club_name: [],
            block: ["test"],
            m_type: "",
            options: [],
            options_status: ["Register", "Not Registered"],
            emp_code: [],
            s_post: '',
            s_name: '',
            s_address: '',
            disabled: false,
            timeout: null,

            disabled1: false,
            timeout1: null,

            disabled2: false,
            timeout2: null,
            pagination: {}
        }
    },

    methods: {
        nameValue(member) {
            this.selectedMemberName = member.employee_code == null ? member.Name : member.EmployeeName;
            this.selectedMemberId = member.id;
        },
        nameValue_id(member) {

            this.selectedMemberId_Receipts = member.id;
            axios.get('get_receipt_data' + '/' + this.selectedMemberId_Receipts).then(res => {
                console.log("Employee recpt data ",res.data.data.original)
                this.receipts_data = res.data.data.original;
            })
                .catch(error => {
                    console.error("Error during getting Receipts data:", error);

                });
//
                axios.get('get_member_DetailById' + '/' + this.selectedMemberId_Receipts).then(res => {
                console.log("Employee Detai;l  data ",res.data.data)
                this.Emp_data = res.data.data;
            })
                .catch(error => {
                    console.error("Error during getting Receipts data:", error);

                });

        },

        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        setClubId_employee(selectedClubName) {
            this.employee.club_id = this.club_id_map[selectedClubName];
        },
        setClubId_res(selectedClubName) {
            this.resident.club_id = this.club_id_map[selectedClubName];
        },
        setClubId_out(selectedClubName) {
            this.outsider.club_id = this.club_id_map[selectedClubName];
        },
        updateEmpCode(selectedValue) {
            if (selectedValue) {
                // Split the selected value by "_" to separate EmployeeCode and Name
                const [empCode, name] = selectedValue.split("_");

                // Update the v-model with only the EmployeeCode
                this.employee.emp_code_member = empCode;
                this.employee.m_name = name;
                console.log(this.employee.emp_code_member);
            } else {
                // If no value is selected, reset the v-model to an empty string or null
                this.employee.emp_code_member = "";
            }
        },


        delay() {

            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.add_member()
        },
        add_member() {

            if (this.m_type == '') {
                this.$toastr.e("Please Select one option!", "Caution!");
                return
            }

            else if (this.m_type === 'emp') {
                if (this.employee.emp_code_member == ''  ||  this.employee.m_mobile == '' || this.employee.cnic == '' || !this.validEmail(this.employee.m_email) || this.employee.m_email == '' || this.employee.m_address == '') {
                    if (this.employee.emp_code_member == '') {
                        this.employee_error.emp_error = 'Select Emp code'
                    }
                    if (this.employee.m_address == '') {
                        this.employee_error.address_error = 'Select Emp Address'
                    }
                    if (this.employee.m_mobile == '') {
                        this.employee_error.mobile_error = 'Enter Number'

                    }
                    if (this.employee.cnic == '') {
                        this.employee_error.cnic_error = 'Enter Cnic'

                    }
                    if (!this.validEmail(this.employee.m_email)) {
                        this.employee_error.m_email_error = 'Enter Valid Email'
                    }
                    if (this.employee.m_email == '') {
                        this.employee_error.m_email_error = 'Enter Email'

                    }
                    this.formdata = []
                    this.$toastr.e("Please Fill the fields!", "Caution!");
                    return
                }
            }
            else if (this.m_type === 'res') {
                if (this.resident.m_name == '' || this.resident.m_mobile == '' || this.resident.cnic == '' || this.resident.m_email == '' || this.resident.club_n == '' || this.resident.block == '' || this.resident.plot == '' || this.resident.street == ''  || !this.validEmail(this.resident.m_email)) {
                    if (this.resident.m_name == '') {
                        this.resident_error.name_error = 'Enter Name'

                    }
                    if (this.resident.m_mobile == '') {
                        this.resident_error.mobile_error = 'Enter Number'

                    }
                    if (this.resident.cnic == '') {
                        this.resident_error.cnic_error = 'Enter Cnic'

                    }
                    if (!this.validEmail(this.resident.m_email)) {
                        this.resident_error.m_email_error = 'Enter Valid Email'
                    }
                    if (this.resident.m_email == '') {
                        this.resident_error.m_email_error = 'Enter Email'

                    }
                    if (this.resident.club_n == '') {
                        this.resident_error.club_error = 'Select Club'

                    }

                    if (this.resident.block == '') {
                        this.resident_error.block_error = 'Select Block'

                    }
                    if (this.resident.plot == '') {
                        this.resident_error.plot_error = 'write plot no'

                    }
                    if (this.resident.street == '') {
                        this.resident_error.street_error = 'Write Street no'

                    }


                 
                    this.formdata = []
                    this.$toastr.e("Please Fill the Fields!", "Caution!");
                    return
                }
            }
            else if (this.m_type === 'out') {
                if (this.outsider.m_name == '' || this.outsider.m_mobile == '' || this.outsider.cnic == '' || this.outsider.m_email == '' || this.outsider.club_n == ''    || this.outsider.m_address == '' || !this.validEmail(this.outsider.m_email)) {
                    if (this.outsider.m_name == '') {
                        this.outsider_error.name_error = 'Enter Name'

                    }
                    if (this.outsider.m_mobile == '') {
                        this.outsider_error.mobile_error = 'Enter Number'

                    }
                    if (this.outsider.cnic == '') {
                        this.outsider_error.cnic_error = 'Enter Cnic'

                    }
                    if (!this.validEmail(this.outsider.m_email)) {
                        this.outsider_error.m_email_error = 'Enter Valid Email'
                    }
                    if (this.outsider.m_email == '') {
                        this.outsider_error.m_email_error = 'Enter Email'


                    }
                    if (this.outsider.club_n == '') {
                        this.outsider_error.club_error = 'Select Club'

                    }

                    if (this.outsider.m_address == '') {
                        this.outsider_error.address_error = 'Enter Address'

                    }
                    this.formdata = []
                    this.$toastr.e("Please Fill the fields!", "Caution!");
                    return
                }
            }


            if (this.m_type == 'emp') {
                this.formdata.push(this.employee);
            }
            if (this.m_type == 'res') {
                this.formdata.push(this.resident);
            }
            if (this.m_type == 'out') {
                this.formdata.push(this.outsider);
            }

            axios.post('create_new_member', {
                "member detail": this.formdata[0],
                "m_type": this.m_type,
            })
                .then(data => {
                    if (data.status === 200) {
                        this.$toastr.s("Member added successfully!", "Congratulations!");
                        this.resetdata();
                        this.getResults1();
                        const cancelButton = document.getElementById('cancelButton1');
                        cancelButton.click();
                    }
                })
                .catch(error => {

                    this.formdata = [];
                    if (error.response) {
                        const errors = error.response.data.errors;
                        // Display errors using Toastr or other notification library
                        for (const key in errors) {
                            this.$toastr.e(errors[key][0]);
                        }
                    } else {
                        // Handle other errors or show a generic error message
                        this.$toastr.e('An unexpected error occurred.');
                    }
                });
            // }


        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.pay_fee()
        },
        pay_fee() {
            if ( this.receipt_fee.date == '') {
                this.$toastr.e("Please Fill all fields!", "Caution!");

                if (this.receipt_fee.date == '') {
                    this.receipt_fee_error.date_error = "please select date"
                }
                this.formdata = []
                return
            } else {
                axios.post('create_Member_Receipt', {
                    'receipt_fee': this.receipt_fee,
                    'selectedMemberId': this.selectedMemberId
                }).then(data => {
                    if (data.status === 200) {
                        this.$toastr.s("Fee added successfully!", "Congratulations!");
                        for (let key in this.receipt_fee) {
                            this.receipt_fee[key] = '';
                        }
                        for (let key in this.receipt_fee_error) {
                            this.receipt_fee_error[key] = '';
                        }
                        const cancelButton = document.getElementById('receipt_cancel');
                        cancelButton.click();
                    }

                }).catch(error => {
                    console.log(error);
                    if (error.response) {
                        console.log("Error Response ",error.response)
                        const errors = error.response.data.errors;
                        console.log('Test Error',error.response.data.errors.date);
                        // Display errors using Toastr or other notification library
                        if(error.response.data.errors.date =='You were not registered then.')
                            {
                                this.$toastr.e('You were not registered then');
                            }
                        for (const key in errors) {
                          
                            if(errors[key][0] =='record already exists.')
                            {
                                this.$toastr.e('This month fee has already been paid');
                            } 
                        }
                    } else {
                        // Handle other errors or show a generic error message
                        this.$toastr.e('An unexpected error occurred.');
                    }
                });
            }
        },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)
            this.update_status()
        },
        reset_filters(){
            this.search_name='';
            this.getResults1();
        },
        search_member(page = 1) {
            if(this.search_name!='')
           { axios.post('searchClubmember', {
                'name': this.search_name,
                'club_id':this.selected_club_id,

            }).then(res => {
                this.member_data=[];
                console.log()
                this.member_data = res.data.data.data;
                this.pagination = res.data.data;

                this.page = page;
            }).catch(error => this.error = error.response.data.errors)}
            else{
                this.getResults1();
            }
        },

        getResults1(page = 1) {
                axios.get('get_member_data/' + this.selected_club_id+'?page=' + page).then(res => {
                this.member_data = res.data.data.data;
                this.pagination = res.data.data;
                this.page = page;


            })
                .catch(error => {
                    console.error("Error during getting member data:", error);
                    this.pageN = 3;
                });

        },

        resetdata(){
// Resetting selectedEmployee and employee fields
this.employee.m_email ='',
this.employee.m_mobile='',
this.employee.cnic ='',
            this.selectedEmployee = null;
              this.employee.member_status = '';
              this.employee.club_n = this.selected_club;
              this.employee.club_id = this.selected_club_id;
              this.employee.emp_code_member = '';
              // Resetting resident fields
              this.employee.m_address='';
              this.resident.m_name = '';
              this.resident.m_mobile = '';
              this.resident.cnic = '';
              this.resident.m_email = '';
              this.resident.club_n =this.selected_club;
              this.resident.club_id = this.selected_club_id;
              this.resident.block = '';
              this.resident.plot = '';
              this.resident.street = '';
            
              // Resetting outsider fields
              this.outsider.m_name = '';
              this.outsider.m_mobile = '';
              this.outsider.cnic = '';
              this.outsider.m_email = '';
              this.outsider.m_address = '';
              this.outsider.club_n = this.selected_club;
              this.outsider.club_id = this.selected_club_id;
         
              // Resetting outsider_error fields to empty strings
              this.outsider_error.name_error = '';
              this.outsider_error.mobile_error = '';
              this.outsider_error.cnic_error = '';
              this.outsider_error.m_email_error = '';
              this.outsider_error.club_error = '';
              this.outsider_error.address_error = '';
              this.outsider_error.fee_error = '';
        
              // Resetting employee_error fields to empty strings
              this.employee_error.emp_error = '';
              this.employee_error.address_error='';
              this.employee_error.club_error = '';
              this.employee_error.status_error = '';
              this.employee_error.fee_error = '';
              this.employee_error.m_email_error='';
              this.employee_error.mobile_error ='';
              this.employee_error.cnic_error ='';

              // Resetting resident_error fields to empty strings
              this.resident_error.name_error = '';
              this.resident_error.mobile_error = '';
              this.resident_error.cnic_error = '';
              this.resident_error.m_email_error = '';
              this.resident_error.club_error = '';
              this.resident_error.block_error = '';
              this.resident_error.plot_error = '';
              this.resident_error.street_error = '';
              this.resident_error.fee_error = '';
            

              this.formdata = [];
},

    },
    watch: {
        m_type(newMType, oldMType) {
            if (newMType !== oldMType) {
                this.resetdata();            }
        },
        selected_club(newMselected_club, oldselected_club) {
            if(newMselected_club !== oldselected_club  )
            {
                if(this.selected_club == null){
                this.selected_club = this.club_name[0];
            }
            this.employee.club_n =this.selected_club;
                this.resident.club_n =this.selected_club;
                this.outsider.club_n =this.selected_club;
                this.outsider.club_id=this.club_id_map[this.selected_club];
                this.resident.club_id=this.club_id_map[this.selected_club];
                this.employee.club_id=this.club_id_map[this.selected_club];
               this.selected_club_id=this.club_id_map[this.selected_club];
               this.getResults1();
            }

        }
    },


    mounted() {
        axios.get('./get_club_data').then(res => {
            this.club_data1 = res.data.data;
            this.club_name = [];
            this.club_id_map = {};
            for (var i = 0; i < this.club_data1.length; i++) {
                this.club_name.push(this.club_data1[i].Name);
                this.club_id_map[this.club_data1[i].Name] = this.club_data1[i].id;
            }
            this.selected_club = this.club_name[0];
        })
            .catch(error => {
                console.error("Error during getting club data:", error);
            });
        axios.get('registered_empcode')
            .then(data => {
                this.find_emp = data.data;
                this.options4 = [];
                this.options4 = this.find_emp.map((obj) => `${obj.EmployeeCode}_${obj.Name}`);
            })
            .catch(error => {
                console.log(error);
            });

    },

}
</script>

