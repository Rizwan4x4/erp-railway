<?php
namespace App\Http\Controllers\Recruitement;


use App\Http\Controllers\Controller;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\FileUpload;

class RecruitementController extends Controller
{
    //Post job
    public function post_job (Request $request)
    {
        $company_id = Session::get('company_id');
        $job_rec = $request->get('job_rec');
        $job_dept = $request->get('job_dept');
        $posting_title = $request->get('posting_title');
        $experiance = $request->get('experiance');
        $date_opened = $request->get('date_opened');
        $target_date = $request->get('target_date');
        $educational_requirements = $request->get('educational_requirements');
        $skill_set = $request->get('skill_set');
        $duties = $request->get('duties');
        $address = $request->get('address');
        DB::connection('sqlsrv2')->insert('INSERT INTO Post_Job(JobNumber, Department, PostTitle, Experience, StartDate, EndDate, Education, Skill, Duties, Address, CompanyID) values (?,?,?,?,?,?,?,?,?,?,?)', [$job_rec, $job_dept, $posting_title, $experiance, $date_opened, $target_date, $educational_requirements, $skill_set, $duties, $address, $company_id]);
        $data="Job Created Successfully!";
        return request()->json(200,$data);
    }
    //Add Candidate
    public function add_candidate(Request $request)
    {
        $company_id = Session::get('company_id');
        $username=Session::get('username');

        $a_c_name = $request->get('a_c_name');
        $a_c_father = $request->get('a_c_father');
        $a_c_mobile = $request->get('a_c_mobile');
        $a_c_email = $request->get('a_c_email');
        $a_c_address = $request->get('a_c_address');
        $a_c_job_title = $request->get('a_c_job_title');
        $a_c_job_id = $request->get('a_c_job_id');

        $a_c_experiance = $request->get('a_c_experiance');
        $star_value = $request->get('star_value');
        $a_c_crt_salary = $request->get('a_c_crt_salary');
        $a_c_qualification = $request->get('a_c_qualification');
        $a_c_skill = $request->get('a_c_skill');
        $a_c_exp_salary = $request->get('a_c_exp_salary');
        $stats="Applied";


        $add_date=date("Y-m-d h:i:s A");

        DB::connection('sqlsrv2')->insert('INSERT INTO Candidate_Detail(CandName, FatherHusband, stats, Mobile, Email, JobID, ExpectedSalary, CandAddress, Curr_Salary, Curr_Designation, Qualification, experience, Skill, Rating, CreatedOn, CreatedBy, CompanyID) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$a_c_name, $a_c_father, $stats, $a_c_mobile, $a_c_email, $a_c_job_id, $a_c_exp_salary, $a_c_address, $a_c_crt_salary, $a_c_job_title, $a_c_qualification, $a_c_experiance, $a_c_skill, $star_value, $add_date, $username, $company_id]);
        $data="Candidate added Successfully!";

        //Activity log
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');

            $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, "Candidate added", "Candidate ".$a_c_name." added.", $update_date]);
       //End activity log

        return request()->json(200,$data);
    }
    //schedule interview
    public function schedule_interview(Request $request)
    {
        $company_id = Session::get('company_id');
        $i_rating = $request->get('i_rating');

        $i_c_id = $request->get('i_c_id');
        $e_c_name = $request->get('e_c_name');

        $i_name = $request->get('i_name');
        $i_location = $request->get('i_location');
        $i_link=$request->get('i_link');
        $i_comment = $request->get('i_comment');
        $i_date = $request->get('i_date');
        $i_from = $request->get('i_from');
        $i_to = $request->get('i_to');

        $fstInter = $request->get('fstInter');
        $scInter = $request->get('scInter');
        $fnInter = $request->get('fnInter');

        $fstComm = $request->get('fstComm');
        $scComm = $request->get('scComm');
        $fnComm = $request->get('fnComm');


        DB::connection('sqlsrv2')->insert('INSERT INTO interview_detail(CandID, rating, InterviewerName, InterviewLocation, onlineLink, Remarks, DayDate, StartTime, EndTime, CompanyID, firstInterviewstatus, secondInterviewstatus, finalInterviewstatus, finalInterviewComments, secondInterviewComments, firstInterviewComments)values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$i_c_id, $i_rating, $i_name, $i_location, $i_link, $i_comment, $i_date, $i_from, $i_to, $company_id, $fstInter, $scInter, $fnInter, $fnComm, $scComm, $fstComm]);
        $data="Status updated!";
        //Activity log
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Candidate shortlisted";
            $Description = "Candidate ";

            $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$e_c_name." shortlisted.", $update_date]);
       //End activity log
        return request()->json(200,$data);
    }
    //View all jobs
    public function job_detail(){
        $company_id= Session::get('company_id');
        $job=DB::connection('sqlsrv2')
        ->table('Post_Job')->select('Post_Job.*')
        ->where('CompanyID','=',$company_id)->orderBy('PostTitle','asc')->get();
        return request()->json(200,$job);
    }
    //View all recruitment activities
    public function all_rec_act(){
        $company_id= Session::get('company_id');
        $job=DB::connection('sqlsrv')->table('Activity_Log')
        ->select('Activity_Log.*')
        ->where('CompanyID','=',$company_id)
        ->where('EventStatus','=',"Candidate added")
        ->orwhere('EventStatus','=',"Candidate updated")
        ->orwhere('EventStatus','=',"Candidate shortlisted")
        ->orwhere('EventStatus','=',"Candidate hired")
        ->orwhere('EventStatus','=',"Interview scheduled")
        ->orwhere('EventStatus','=',"Job updated")
        ->orwhere('EventStatus','=',"Status changed")
        ->orderBy('LogId','desc')->get();
        return request()->json(200,$job);
    }
    //View all interviews
    public function view_interviews(){
        $company_id= Session::get('company_id');
        $job=DB::connection('sqlsrv2')->table('interview_detail')
        ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
        ->orderBy('Candidate_Detail.CandName','asc')
        ->where('interview_detail.CompanyID','=',$company_id)->get();
        return request()->json(200,$job);
    }
    //View all candidate
    public function candidate_detail(){
        $company_id= Session::get('company_id');
        $can=DB::connection('sqlsrv2')->table('Candidate_Detail')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        ->orderBy('Candidate_Detail.CandName','asc')
        ->select('Candidate_Detail.*','Post_Job.PostTitle')
        ->where('Candidate_Detail.CompanyID','=',$company_id)->get();
        return request()->json(200,$can);
    }
    //Update job
    public function update_job (Request $request)
    {
        $id=$request->get('myid');
        $ed_job_number = $request->get('ed_job_number');
        $ed_posting_title = $request->get('ed_post_title');
        $ed_job_dept = $request->get('ed_job_dept');
        $ed_date_opened = $request->get('ed_date_opened');
        $ed_experiance = $request->get('ed_experiance');
        $ed_target_date = $request->get('ed_target_date');
        $ed_address = $request->get('ed_address');
        $ed_educational_requirements = $request->get('ed_educational_requirements');
        $ed_skill_set = $request->get('ed_skill_set');
        $ed_duties = $request->get('ed_duties');

        DB::connection('sqlsrv2')->update('update Post_Job set JobNumber=?, Department=?, PostTitle=?, Experience=?, StartDate=?, EndDate=?, Education=?, Skill=?, Duties=?, Address=? where JobID=?', [$ed_job_number, $ed_job_dept, $ed_posting_title, $ed_experiance, $ed_date_opened, $ed_target_date, $ed_educational_requirements, $ed_skill_set, $ed_duties, $ed_address, $id]);
        $data="Job Editted Successfully!";

        //Activity log
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Job updated";
            $Description = "updated job ";

            $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$ed_posting_title.".", $update_date]);
       //End activity log
         return request()->json(200,$data);
    }
    //Update candidate
    public function update_candidate (Request $request)
    {
        $cid = $request->get('mycid');
        $e_c_name = $request->get('e_c_name');
        $e_c_father = $request->get('e_c_father');
        $e_c_mobile = $request->get('e_c_mobile');
        $e_c_email = $request->get('e_c_email');
        $e_c_post_title = $request->get('e_c_post_title');
        $e_c_exp_salary = $request->get('e_c_exp_salary');
        $ed_rating = $request->get('ed_rating');
        $e_c_address = $request->get('e_c_address');
        $e_c_crt_salary = $request->get('e_c_crt_salary');
        $e_c_job_title = $request->get('e_c_job_title');
        $e_c_qualification = $request->get('e_c_qualification');
        $e_c_experiance = $request->get('e_c_experiance');
        $e_c_skill = $request->get('e_c_skill');

        DB::connection('sqlsrv2')->update('update Candidate_Detail set CandName=?, FatherHusband=?, Mobile=?, Email=?, JobID=?, ExpectedSalary=?, Rating=?, CandAddress=?, Curr_Salary=?, Curr_Designation=?, Qualification=?, experience=?, Skill=? where CandID=?', [$e_c_name, $e_c_father, $e_c_mobile, $e_c_email, $e_c_post_title, $e_c_exp_salary, $ed_rating, $e_c_address, $e_c_crt_salary, $e_c_job_title, $e_c_qualification, $e_c_experiance, $e_c_skill, $cid]);
        $data="Candidate editted Successfully!";

        //Activity log
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Candidate updated";
            $Description = "updated candidate ";

            $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$e_c_name.".", $update_date]);
       //End activity log

        return request()->json(200,$data);
    }
    //Update status
    public function update_status(Request $request)
    {
        $cid = $request->get('mycid');
        $e_c_status=$request->get('e_c_status');

        DB::connection('sqlsrv2')->update('update Candidate_Detail set stats=? where CandID=?', [$e_c_status, $cid]);
        $data="Status updated!";

        return request()->json(200,$data);
    }
    //Update status
    public function update_status_int (Request $request)
    {
        $cid = $request->get('mycidint');
        $e_c_status=$request->get('c_status');

        DB::connection('sqlsrv2')->update('update Candidate_Detail set stats=? where CandID=?', [$e_c_status, $cid]);
        $data="Status updated!";

        return request()->json(200,$data);
    }
    //Hire interview
   public function hire_interview (Request $request)
    {
        $iId = $request->get('myiId');
        $exp_salary = $request->get('exp_salary');
            $company_id = Session::get('company_id');
        $hire_sts= "1";
        $i_c_name = $request->get('ed_i_c_name');

            $upd_on=date("Y-m-d h:i:s A");
        DB::connection('sqlsrv2')->update('update interview_detail set hire_sts=?, updatedOn=? where InterviewID=?', [$hire_sts, $upd_on, $iId]);
        $candId_arr = DB::connection('sqlsrv2')->table('interview_detail')->where('InterviewID','=',$iId)->where('CompanyID','=',$company_id)->get();
        foreach ($candId_arr as $candId_arr1) {

        }
        $candId = $candId_arr1->CandID;
        DB::connection('sqlsrv2')->update('update Candidate_Detail set ExpectedSalary=? where CandID=? AND CompanyID=?', [$exp_salary, $candId, $company_id]);
        //Activity log
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, "Candidate hired", "Candidate ".$i_c_name." hired.", $upd_on]);
       //End activity log
       $data="Candidate hired";
        return request()->json(200,$data);
    }
    //Hire interview
    public function hire_interview1 (Request $request)
    {
        $iId = $request->get('myiId');

            $hire_sts= $request->get('hire_sts');


            $upd_on=date("Y-m-d h:i:s A");

        DB::connection('sqlsrv2')->update('update interview_detail set hire_sts=?, updatedOn=? where InterviewID=?', [$hire_sts, $upd_on, $iId]);
        $data="Status updated";
        return request()->json(200,$data);
    }
    //Update interview
    public function update_interview (Request $request)
    {
        $iId = $request->get('myiId');
            $asses = $request->get('asses');
            $which=$request->get('which');

            $ed_i_name = $request->get('ed_i_name');
            $ed_i_link = $request->get('ed_i_link');
            $ed_i_location = $request->get('ed_i_location');
            $ed_i_date = $request->get('ed_i_date');
            $ed_i_from = $request->get('ed_i_from');
            $ed_i_to = $request->get('ed_i_to');

            $firstStatus =$request->get('Status1');
            $secIntSts = $request->get('Status2');
            $finIntSts = $request->get('Status3');

        if ($which=="firstsdld"){
            $upsSts= $request->get('up_sts');
            $remarks= $request->get('ed_i_comment');
            DB::connection('sqlsrv2')->update('update interview_detail set firstInterviewstatus=?, firstInterviewComments=? where InterviewID=?', [$upsSts, $remarks, $iId]);
            $data="Interview updated successfully";
            //Activity log
                $ed_i_c_name=$request->get('ed_i_c_name');
                $company_id = Session::get('company_id');
                $username = Session::get('username');
                $UserFullName = Session::get('UserName');
                $Event_status = "Status changed";
                $Description = "First interview status and remarks of ";

                $update_date = date("Y-m-d h:i:s A");
                DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$ed_i_c_name." changed.", $update_date]);
                //End activity log
            return request()->json(200,$data);
        }
        elseif ($which=="secondsdld"){

            $upsSts= $request->get('up_sts');
            $remarks= $request->get('ed_i_comment');
            DB::connection('sqlsrv2')->update('update interview_detail set secondInterviewstatus=?, secondInterviewComments=? where InterviewID=?', [$upsSts, $remarks, $iId]);
            $data="Interview updated successfully";
            //Activity log
                $ed_i_c_name=$request->get('ed_i_c_name');
                $company_id = Session::get('company_id');
                $username = Session::get('username');
                $UserFullName = Session::get('UserName');
                $Event_status = "Status changed";
                $Description = "Second interview status and remarks of ";

                $update_date = date("Y-m-d h:i:s A");
                DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$ed_i_c_name." changed.", $update_date]);
                //End activity log
            return request()->json(200,$data);
        }
        elseif ($which=="finalsdld"){
            $upsSts= $request->get('up_sts');
            $remarks= $request->get('ed_i_comment');
            DB::connection('sqlsrv2')->update('update interview_detail set finalInterviewstatus=?, finalInterviewComments=? where InterviewID=?', [$upsSts, $remarks, $iId]);
            $data="Interview updated successfully";
            //Activity log
                $ed_i_c_name=$request->get('ed_i_c_name');
                $company_id = Session::get('company_id');
                $username = Session::get('username');
                $UserFullName = Session::get('UserName');
                $Event_status = "Status changed";
                $Description = "Final interview status and remarks of ";

                $update_date = date("Y-m-d h:i:s A");
                DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$ed_i_c_name." changed.", $update_date]);
                //End activity log
            return request()->json(200,$data);
        }
        else if($which=="firstns"){
            $firstStatus = "Scheduled";
            $secIntSts = "Not scheduled";
            $finIntSts = "Not scheduled";
            $remarks1 = $request->get('ed_i_comment');

            DB::connection('sqlsrv2')->update('update interview_detail set InterviewerName=?, onlineLink=?, InterviewLocation=?, firstInterviewComments=?, firstInterviewstatus=?, secondInterviewstatus=?, finalInterviewstatus=?, DayDate=?, StartTime=?, EndTime=? where InterviewID=?', [$ed_i_name, $ed_i_link, $ed_i_location, $remarks1, $firstStatus, $secIntSts, $finIntSts, $ed_i_date, $ed_i_from, $ed_i_to, $iId]);
            $data="Interview updated successfully";
                //Activity log
                $ed_i_c_name=$request->get('ed_i_c_name');
                $company_id = Session::get('company_id');
                $username = Session::get('username');
                $UserFullName = Session::get('UserName');
                $Event_status = "Interview scheduled";
                $Description = "First interview of ";

                $update_date = date("Y-m-d h:i:s A");
                DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$ed_i_c_name." scheduled.", $update_date]);
                //End activity log

            return request()->json(200,$data);
        }
        else if($which=="secondns"){
            $secIntSts = "Scheduled";
            $finIntSts = "Not scheduled";
            $remarks2 = $request->get('ed_i_comment');

            DB::connection('sqlsrv2')->update('update interview_detail set InterviewerName=?, onlineLink=?, InterviewLocation=?, secondInterviewComments=?, secondInterviewstatus=?, finalInterviewstatus=?, DayDate=?, StartTime=?, EndTime=? where InterviewID=?', [$ed_i_name, $ed_i_link, $ed_i_location, $remarks2, $secIntSts, $finIntSts, $ed_i_date, $ed_i_from, $ed_i_to, $iId]);
            $data="Interview updated successfully";

            //Activity log
                $ed_i_c_name=$request->get('ed_i_c_name');
                $company_id = Session::get('company_id');
                $username = Session::get('username');
                $UserFullName = Session::get('UserName');
                $Event_status = "Interview scheduled";
                $Description = "Second interview of ";

                $update_date = date("Y-m-d h:i:s A");
                DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$ed_i_c_name." scheduled.", $update_date]);
                //End activity log

            return request()->json(200,$data);
        }
        else if($which=="finalns"){

            $finIntSts = "Scheduled";
            $remarks3 = $request->get('ed_i_comment');

            DB::connection('sqlsrv2')->update('update interview_detail set InterviewerName=?, onlineLink=?, InterviewLocation=?, finalInterviewComments=?, finalInterviewstatus=?, DayDate=?, StartTime=?, EndTime=? where InterviewID=?', [$ed_i_name, $ed_i_link, $ed_i_location, $remarks3, $finIntSts, $ed_i_date, $ed_i_from, $ed_i_to, $iId]);
            $data="Interview updated successfully";
            //Activity log
                $ed_i_c_name=$request->get('ed_i_c_name');
                $company_id = Session::get('company_id');
                $username = Session::get('username');
                $UserFullName = Session::get('UserName');
                $Event_status = "Interview scheduled";
                $Description = "Final interview of ";

                $update_date = date("Y-m-d h:i:s A");
                DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description.$ed_i_c_name." scheduled.", $update_date]);
                //End activity log
            return request()->json(200,$data);
        }
    }
    //fetch job to edit
    public function edit_job_fetch($id){
        $company_id= Session::get('company_id');
        $job=DB::connection('sqlsrv2')->table('Post_Job')
        ->where('CompanyID','=',$company_id)->where('JobID','=',$id)
        ->orderBy('JobID','asc')->get();
        return request()->json(200,$job);
    }
    //fetch candidate to edit
    public function edit_candidate_fetch($id){
        $company_id= Session::get('company_id');
        $cand=DB::connection('sqlsrv2')->table('Candidate_Detail')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')

        ->orderBy('CandID','asc')
        ->select('Candidate_Detail.*','Post_Job.PostTitle', 'Post_Job.JobID')
        ->where('Candidate_Detail.CompanyID','=',$company_id)
        ->where('CandID','=',$id)->get();
        return request()->json(200,$cand);
    }
    //fetch rel candidate post
    public function fetch_can_post($cid){

        $company_id= Session::get('company_id');
        $cposts=DB::connection('sqlsrv2')->table('Candidate_Detail')
        ->where('CompanyID','=',$company_id)->where('CandName','=',$cid)
        ->orderBy('PostTitle','asc')->get();
        return request()->json(200,$cposts);
    }
    //fetch interview to edit
    public function edit_interview_fetch($ids){
        $company_id= Session::get('company_id');
        $inter=DB::connection('sqlsrv2')->table('interview_detail')
        ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')

        ->orderBy('interview_detail.InterviewID','asc')
        ->select('Candidate_Detail.*','interview_detail.*', 'Post_Job.*')
        ->where('interview_detail.CompanyID','=',$company_id)
        ->where('interview_detail.InterviewID','=',$ids)->get();
        return request()->json(200,$inter);
    }
    //Search interview
    public function searchinterviews (Request $request)
    {
        $company_id = Session::get('company_id');
        $srch_name = $request->get('srch_name');
        $designation = $request->get('designation');
        $status1 = $request->get('status1');
        $status2 = $request->get('status2');
        $status3 = $request->get('status3');
        $s_rate = $request->get('s_rate');

        /*if($srch_name=='' && $designation=='' && $status1=='' &&  $status2=='' && $status3=='' && $s_rate=='') //0000
        {
            $inter=DB::connection('sqlsrv2')
            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
        ->orderBy('Candidate_Detail.CandName','asc')
        ->where('interview_detail.CompanyID','=',$company_id)->get();
        }
        else
        {*/
            $inter=DB::connection('sqlsrv2')->table('interview_detail')

            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
            ->orderBy('Candidate_Detail.CandName','asc')
            ->where('Candidate_Detail.CandName','like','%'.$srch_name.'%')
            ->where('Post_Job.PostTitle','like','%'.$designation.'%')
            ->where('interview_detail.firstInterviewstatus','like',$status1.'%')
            ->where('interview_detail.secondInterviewstatus','like',$status2.'%')
            ->where('interview_detail.finalInterviewstatus','like',$status3.'%')
            ->where('interview_detail.rating','like','%'.$s_rate.'%')
            ->where('interview_detail.CompanyID','=',$company_id)->get();
       // }
            return request()->json(200,$inter);
    }
    //Search candidates
    public function searchcandidates (Request $request)
    {
        $company_id = Session::get('company_id');
        $name = $request->get('name');
        $post = $request->get('post');
        $address = $request->get('address');

        $result=DB::connection('sqlsrv2')->table('Candidate_Detail')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        ->select('Candidate_Detail.*','Post_Job.*')
        ->orderBy('Candidate_Detail.CandName','asc')
        ->where('Candidate_Detail.CandAddress','like','%'.$address.'%')
        ->where('Post_Job.PostTitle','like','%'.$post)
        ->where('Candidate_Detail.CandName','like','%'.$name.'%')
        ->where('Candidate_Detail.CompanyID', '=', $company_id)->get();
        return request()->json(200,$result);
    }
    //view individule job detail
    public function ind_job_detail($id){
        $company_id= Session::get('company_id');
        $job=DB::connection('sqlsrv2')->table('Post_Job')
        ->where('CompanyID','=',$company_id)->where('JobID','=',$id)->get();
        return request()->json(200,$job);
    }


    //Count top list of dashboard
    public function top_counters(){
        $company_id= Session::get('company_id');
        $sl_cand=DB::connection('sqlsrv2')->table('interview_detail')

        ->select('interview_detail.hire_sts')
        ->orderBy('interview_detail.InterviewID','asc')
        ->where('interview_detail.CompanyID','=',$company_id)
        ->where('interview_detail.hire_sts','!=','1')->get();
        $sl_cand_ct=Count($sl_cand);

         $ong_int=DB::connection('sqlsrv2')
        ->table('interview_detail')->select ('CompanyID', 'firstInterviewstatus', 'finalInterviewstatus', 'hire_sts')
        ->where('CompanyID','=',$company_id)
        ->where('hire_sts','!=','1')
        ->where('firstInterviewstatus','=','Scheduled')
        ->orwhere('secondInterviewstatus','=','Scheduled')
        ->orwhere('finalInterviewstatus','=','Scheduled')
        ->get();
        $ct_ong_int=Count($ong_int);

        $cand=DB::connection('sqlsrv2')
        ->table('Candidate_Detail')->select ('CompanyID', 'CandID')
        ->where('CompanyID','=',$company_id)->get();
        $candct=Count($cand);

         $job=DB::connection('sqlsrv2')
        ->table('Post_Job')->select ('CompanyID', 'JobNumber')
        ->where('CompanyID','=',$company_id)
        ->Sum('JobNumber');

        $counts =array(
          'short_listed' => $sl_cand_ct,
          'ongoing_interview' => $ct_ong_int,
          'applications' => $candct,
          'jobs_count' => $job,
          );

        return request()->json(200, $counts);
    }

    //Count relevent job candidates
    public function rel_cand_count(){
        $company_id= Session::get('company_id');
        $job=DB::connection('sqlsrv2')->table('interview_detail')
        ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
        ->orderBy('Candidate_Detail.CandName','asc')
        ->where('interview_detail.CompanyID','=',$company_id)
        ->where('interview_detail.firstInterviewstatus','=','Scheduled')
        ->orwhere('interview_detail.secondInterviewstatus','=','Scheduled')
        ->orwhere('interview_detail.finalInterviewstatus','=','Scheduled')
        ->get();
        return request()->json(200,$job);
    }



    //Get hired candidates of last 30 days
    public function mnth_hired(){
        $company_id= Session::get('company_id');

        $today=date("m");
        $mnt_hir=DB::connection('sqlsrv2')
        ->table('interview_detail')
        ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
        ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
        ->orderBy('interview_detail.updatedOn','asc')
        ->where('interview_detail.CompanyID','=',$company_id)
        ->where('interview_detail.hire_sts','=','1')
        ->whereMonth('interview_detail.updatedOn', '=', $today)->get();
        return request()->json(200,$mnt_hir);
    }
     //Count hired candidates
    public function cnd_hired(){
        $company_id= Session::get('company_id');
        $hir_int=DB::connection('sqlsrv2')
        ->table('interview_detail')->select ('CompanyID', 'hire_sts')
        ->where('CompanyID','=',$company_id)
        ->where('hire_sts','=','1')->get();
        $ct_hir_int=Count($hir_int);
        return request()->json(200,$ct_hir_int);
    }
   public function filter_jobs($id, $kew, $loc, $fresh, $exp, $internship, $partTime, $fullTime){
        if($kew == "All"){
            $kew = "";
        }
        if($loc == "All"){
            $loc = "";
        }
        if($fresh == "true" ){
            $fresh = "Fresher";
        }
        else {
            $fresh = "Dont fetch";
        }
        if($exp == "true" ){
            $exp = "year";
        }
        else {
            $exp = "Dont fetch";
        }
        if( $internship == "true"){
            $internship = "Internship";
        }
        else {
            $internship = "Dont fetch";
        }
        if( $partTime == "true"){
            $partTime = "Part Time";
        }
        else {
            $partTime = "Dont fetch";
        }
        if( $fullTime == "true"){
            $fullTime = "Full Time";
        }
        else {
            $fullTime = "Dont fetch";
        }
        $job = DB::connection('sqlsrv2')
        ->table('Post_Job')->select('Post_Job.*')
        ->where('CompanyID','=',$id)
        ->where('Address','like', '%'.$loc.'%')
        ->where('PostTitle','like', '%'.$kew.'%')
        ->where('Experience','like', '%'.$fresh.'%')
        ->orwhere('CompanyID','=',$id)
        ->where('Address','like', '%'.$loc.'%')
        ->where('PostTitle','like', '%'.$kew.'%')
        ->where('Experience','like', '%'.$exp.'%')
        ->orwhere('CompanyID','=',$id)
        ->where('Address','like', '%'.$loc.'%')
        ->where('PostTitle','like', '%'.$kew.'%')
        ->where('Experience','like', '%'.$internship.'%')
        ->orwhere('CompanyID','=',$id)
        ->where('Address','like', '%'.$loc.'%')
        ->where('PostTitle','like', '%'.$kew.'%')
        ->where('Experience','like', '%'.$partTime.'%')
        ->orwhere('CompanyID','=',$id)
        ->where('Address','like', '%'.$loc.'%')
        ->where('PostTitle','like', '%'.$kew.'%')
        ->where('Experience','like', '%'.$fullTime.'%')
        ->orderBy('PostTitle','asc')->get();
        return request()->json(200,$job);
    }
      public function company_id(){
        $company_id= Session::get('company_id');

        return request()->json(200, $company_id);
    }

    public function job_detail1($comid, $jobid){
        $company_id= Session::get('company_id');
        $job=DB::connection('sqlsrv2')
        ->table('Post_Job')->select('Post_Job.*')->where('JobID','=',$jobid)->where('CompanyID','=',$comid)->orderBy('PostTitle','asc')->get();
        return request()->json(200,$job);
    }

    public function candidate_public(Request $request)
    {
        $company_id = $request->get('a_c_companyID');
        $username="Appling online";

        $a_c_name = $request->get('a_c_name');
        $a_c_father = $request->get('a_c_father');
        $a_c_mobile = $request->get('a_c_mobile');
        $a_c_email = $request->get('a_c_email');
        $a_c_address = $request->get('a_c_address');
        $a_c_job_title = $request->get('a_c_job_title');
        $a_c_job_id = $request->get('a_c_job_id');

        $a_c_experiance = $request->get('a_c_experiance');
        $star_value = $request->get('star_value');
        $a_c_crt_salary = $request->get('a_c_crt_salary');
        $a_c_qualification = $request->get('a_c_qualification');
        $a_c_skill = $request->get('a_c_skill');
        $a_c_exp_salary = $request->get('a_c_exp_salary');
        $stats="Applied";


        $add_date=date("Y-m-d h:i:s A");

        DB::connection('sqlsrv2')->insert('INSERT INTO Candidate_Detail(CandName, FatherHusband, stats, Mobile, Email, JobID, ExpectedSalary, CandAddress, Curr_Salary, Curr_Designation, Qualification, experience, Skill, Rating, CreatedOn, CreatedBy, CompanyID) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$a_c_name, $a_c_father, $stats, $a_c_mobile, $a_c_email, $a_c_job_id, $a_c_exp_salary, $a_c_address, $a_c_crt_salary, $a_c_job_title, $a_c_qualification, $a_c_experiance, $a_c_skill, $star_value, $add_date, $username, $company_id]);
        $data="Candidate added Successfully!";

        //Activity log

            $UserFullName = $a_c_name;

            $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, "Candidate applied", "Candidate ".$a_c_name." Applie online.", $update_date]);
        //End activity log

        return request()->json(200,$data);
    }
}
