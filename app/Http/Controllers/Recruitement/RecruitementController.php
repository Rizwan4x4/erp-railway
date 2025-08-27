<?php

namespace App\Http\Controllers\Recruitement;


use App\Http\Controllers\Controller;
// use Session;
// use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\FileUpload;
use Illuminate\Support\Facades\Mail;
use App\Mail\CandidateMail;
use Termwind\Components\Dd;
use App\Http\Controllers\HRMS\HrController;

class RecruitementController extends Controller
{
    public function sendCandidateMail(Request $request)
    {
        $contact_email = Session::get('username');
        $company_id = Session::get('company_id');
        // dd($company_id);
        // $contact_phone = Session::get('user_mobile');
        $candidateId = $request->get('mycid');
        $post_id = $request->post_title;
        $update_date = date("Y-m-d h:i:s A");
        $existingStatus = DB::connection('sqlsrv2')
            ->table('Candidate_Detail')
            ->where('CandID', $candidateId)
            ->value('stats');
        if ($existingStatus === 'Shortlisted') {
            return response()->json(['message' => 'Candidate already shortlisted!'], 200);
        } else {
            $rating = DB::connection('sqlsrv2')->table('Candidate_Detail')
                ->where('CandID', $candidateId)
                ->value('Rating');

            DB::connection('sqlsrv2')->table('Candidate_Detail')
                ->where('CandID', $candidateId)
                ->update([
                    'stats'     => 'Shortlisted',

                ]);

            // 3. Update interview_detail table with rating and statuses/comments
            // DB::connection('sqlsrv2')->table('interview_detail')
            //     ->where('CandID', $candidateId)
            //     ->update([
            //         'rating'                 => $rating,
            //         'firstInterviewstatus'   => 'Not scheduled',
            //         'secondInterviewstatus'  => 'Not scheduled',
            //         'finalInterviewstatus'   => 'Not scheduled',
            //         'firstInterviewComments' => '',
            //         'secondInterviewComments' => '',
            //         'finalInterviewComments' => '',
            //         'updatedOn'              => now(),
            //     ]);
            DB::connection('sqlsrv2')->insert('
    INSERT INTO interview_detail
    (CandID, rating, firstInterviewstatus, secondInterviewstatus, finalInterviewstatus, firstInterviewComments, secondInterviewComments, finalInterviewComments, updatedOn, CompanyID)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $candidateId,
                $rating,
                'Not scheduled',
                'Not scheduled',
                'Not scheduled',
                '',
                '',
                '',
                now(),
                $company_id
            ]);
        }

        $post = DB::connection('sqlsrv2')->table('Post_Job')
            ->where('JobID', $post_id)
            ->value('PostTitle');

        $interview = DB::connection('sqlsrv2')
            ->table('interview_detail')
            ->where('CandID', $candidateId)
            ->orderBy('InterviewID', 'desc')
            ->first();
        // dd($candidateId,$interview);

        if (!$interview) {
            return response()->json(['message' => 'Interview not found'], 404);
        }
        $iId = $interview->InterviewID;
        // $update_date = now();


        // 1. Update Interview Details (like 'firstns')
        DB::connection('sqlsrv2')->update('
        UPDATE interview_detail
        SET InterviewerName = ?,
            onlineLink = ?,
            InterviewLocation = ?,
            firstInterviewComments = ?,
            firstInterviewstatus = ?,
            secondInterviewstatus = ?,
            finalInterviewstatus = ?,
            DayDate = ?,
            StartTime = ?,
            EndTime = ?,
            updatedOn = ?
        WHERE InterviewID = ?', [
            $request->contact_person,
            null,
            $request->location,
            $request->comments,
            'Scheduled',
            'Not scheduled',
            'Not scheduled',
            $request->date,
            $request->from,
            $request->to,
            $update_date,
            $iId
        ]);

        $candidateData = [
            'name'           => $request->name,
            'email'          => $request->email,
            'post_title'     => $post,
            'contact_person' => $request->contact_person,
            'location'       => $request->location,
            'comments'       => $request->comments,
            'date'           => $request->date,
            'from'           => $request->from,
            'to'             => $request->to,
            'instructions'   => $request->instructions,
            'contact_email' => $contact_email,
        ];

        Mail::to($candidateData['email'])->send(new CandidateMail($candidateData));
        DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->where('CandID', $candidateId)
            ->update(['stats' => 'Shortlisted']);

        // 3. Insert into Activity Log
        $company_id   = Session::get('company_id');
        $username     = Session::get('username');
        $UserFullName = Session::get('UserName');
        $Event_status = "Interview scheduled";
        $Description  = "First interview of " . $request->name . " scheduled.";

        DB::insert('
        INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime)
        VALUES (?, ?, ?, ?, ?, ?)', [
            $company_id,
            $username,
            $UserFullName,
            $Event_status,
            $Description,
            $update_date
        ]);

        return response()->json(['message' => 'Mail sent & interview scheduled successfully']);
    }

    // public function sendCandidateMail(Request $request)
    // {
    //     $candidateData = [
    //         'name'            => $request->name,
    //         'email'           => $request->email,
    //         'post_title'      => $request->post_title,
    //         'contact_person'  => $request->contact_person,
    //         'location'        => $request->location,
    //         'comments'        => $request->comments,
    //         'date'            => $request->date,
    //         'from'            => $request->from,
    //         'to'              => $request->to,
    //         'instructions'    => $request->instructions,
    //     ];

    //     Mail::to($candidateData['email'])->send(new CandidateMail($candidateData));

    //     return response()->json(['message' => 'Mail sent successfully']);
    // }
    //Post job
    public function post_job(Request $request)
    {
        $company_id = Session::get('company_id');
        $username = Session::get('username');
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
        DB::connection('sqlsrv2')->insert('INSERT INTO Post_Job(JobNumber, Department, PostTitle, Experience, StartDate, EndDate, Education, Skill, Duties, Address, CompanyID, CreatedBy) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$job_rec, $job_dept, $posting_title, $experiance, $date_opened, $target_date, $educational_requirements, $skill_set, $duties, $address, $company_id, $username]);
        $data = "Job Created Successfully!";
        return request()->json(200, $data);
    }
    //Add Candidate
    // public function add_candidate(Request $request)
    // {
    //     $company_id = Session::get('company_id');
    //     $username = Session::get('username');

    //     $a_c_name = $request->get('a_c_name');
    //     $a_c_father = $request->get('a_c_father');
    //     $a_c_mobile = $request->get('a_c_mobile');
    //     $a_c_email = $request->get('a_c_email');
    //     $a_c_address = $request->get('a_c_address');
    //     $a_c_job_title = $request->get('a_c_job_title');
    //     $a_c_job_id = $request->get('a_c_job_id');
    //     $a_c_experiance = $request->get('a_c_experiance');
    //     $star_value = $request->get('star_value');
    //     $a_c_crt_salary = $request->get('a_c_crt_salary');
    //     $a_c_qualification = $request->get('a_c_qualification');
    //     $a_c_skill = $request->get('a_c_skill');
    //     $a_c_exp_salary = $request->get('a_c_exp_salary');
    //     $applied_via = $request->get('applied_via');
    //     $stats = "Applied";
    //     $add_date = date("Y-m-d h:i:s A");

    //     $a_c_dob = $request->get('a_c_dob');
    //     $a_c_gender = $request->get('a_c_gender');
    //     $a_c_university = $request->get('a_c_university');
    //     $a_c_country = $request->get('a_c_country');
    //     $a_c_city = $request->get('a_c_city');

    //     DB::connection('sqlsrv2')->insert(
    //         'INSERT INTO Candidate_Detail
    // (CandName, FatherHusband, stats, Mobile, Email, JobID, ExpectedSalary, CandAddress, Curr_Salary, Curr_Designation, Qualification, experience, Skill, Rating, CreatedOn, CreatedBy, CompanyID, AppliedVia, DOB, Gender, University, City, Country)
    // VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
    //         [
    //             $a_c_name,
    //             $a_c_father,
    //             $stats,
    //             $a_c_mobile,
    //             $a_c_email,
    //             $a_c_job_id,
    //             $a_c_exp_salary,
    //             $a_c_address,
    //             $a_c_crt_salary,
    //             $a_c_job_title,
    //             $a_c_qualification,
    //             $a_c_experiance,
    //             $a_c_skill,
    //             $star_value,
    //             $add_date,
    //             $username,
    //             $company_id,
    //             $applied_via,
    //             $a_c_dob,
    //             $a_c_gender,
    //             $a_c_university,
    //             $a_c_city,
    //             $a_c_country
    //         ]
    //     );

    //     $UserFullName = Session::get('UserName');
    //     $update_date = date("Y-m-d h:i:s A");
    //     DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime)
    // VALUES (?,?,?,?,?,?)', [
    //         $company_id,
    //         $username,
    //         $UserFullName,
    //         "Candidate added",
    //         "Candidate " . $a_c_name . " added.",
    //         $update_date
    //     ]);
    //     return response()->json("Candidate added Successfully!", 200);
    // }

    public function add_candidate(Request $request)
    {
        $company_id = Session::get('company_id');
        $username = Session::get('username');

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
        $applied_via = $request->get('applied_via');
        $stats = "Applied";
        $add_date = date("Y-m-d h:i:s A");

        $a_c_dob = $request->get('a_c_dob');
        $a_c_gender = $request->get('a_c_gender');
        $a_c_university = $request->get('a_c_university');
        $a_c_country = $request->get('a_c_country');
        $a_c_city = $request->get('a_c_city');

        // ✅ Image Upload Handling
        $photo_filename = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photo_filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/candidate_photos'), $photo_filename);
        }

        // ✅ Insert into DB
        DB::connection('sqlsrv2')->insert(
            'INSERT INTO Candidate_Detail
        (CandName, FatherHusband, stats, Mobile, Email, JobID, ExpectedSalary, CandAddress, Curr_Salary, Curr_Designation, Qualification, experience, Skill, Rating, CreatedOn, CreatedBy, CompanyID, AppliedVia, DOB, Gender, University, City, Country, Photo)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            [
                $a_c_name,
                $a_c_father,
                $stats,
                $a_c_mobile,
                $a_c_email,
                $a_c_job_id,
                $a_c_exp_salary,
                $a_c_address,
                $a_c_crt_salary,
                $a_c_job_title,
                $a_c_qualification,
                $a_c_experiance,
                $a_c_skill,
                $star_value,
                $add_date,
                $username,
                $company_id,
                $applied_via,
                $a_c_dob,
                $a_c_gender,
                $a_c_university,
                $a_c_city,
                $a_c_country,
                $photo_filename // ✅ Save image filename to DB
            ]
        );

        // ✅ Log activity
        $UserFullName = Session::get('UserName');
        $update_date = date("Y-m-d h:i:s A");
        DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime)
        VALUES (?,?,?,?,?,?)', [
            $company_id,
            $username,
            $UserFullName,
            "Candidate added",
            "Candidate " . $a_c_name . " added.",
            $update_date
        ]);

        return response()->json("Candidate added Successfully!", 200);
    }


    public function add_candidate_old(Request $request)
    {
        $company_id = Session::get('company_id');
        $username = Session::get('username');

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
        $applied_via = $request->get('applied_via');
        $stats = "Applied";


        $add_date = date("Y-m-d h:i:s A");

        DB::connection('sqlsrv2')->insert('INSERT INTO Candidate_Detail(CandName, FatherHusband, stats, Mobile, Email, JobID, ExpectedSalary, CandAddress, Curr_Salary, Curr_Designation, Qualification, experience, Skill, Rating, CreatedOn, CreatedBy, CompanyID, AppliedVia) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$a_c_name, $a_c_father, $stats, $a_c_mobile, $a_c_email, $a_c_job_id, $a_c_exp_salary, $a_c_address, $a_c_crt_salary, $a_c_job_title, $a_c_qualification, $a_c_experiance, $a_c_skill, $star_value, $add_date, $username, $company_id, $applied_via]);
        $data = "Candidate added Successfully!";

        //Activity log
        $company_id = Session::get('company_id');
        $username = Session::get('username');
        $UserFullName = Session::get('UserName');

        $update_date = date("Y-m-d h:i:s A");
        DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, "Candidate added", "Candidate " . $a_c_name . " added.", $update_date]);
        //End activity log

        return request()->json(200, $data);
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
        $i_link = $request->get('i_link');
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
        $data = "Status updated!";
        //Activity log
        $username = Session::get('username');
        $UserFullName = Session::get('UserName');
        $Event_status = "Candidate shortlisted";
        $Description = "Candidate ";

        $update_date = date("Y-m-d h:i:s A");
        DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $e_c_name . " shortlisted.", $update_date]);
        //End activity log
        return request()->json(200, $data);
    }
    //View all jobs
    public function job_detail()
    {
        $company_id = Session::get('company_id');
        $job = DB::connection('sqlsrv2')
            ->table('Post_Job')->select('Post_Job.*')
            ->where('CompanyID', '=', $company_id)
            ->orderBy('PostTitle', 'asc')->get();
        return request()->json(200, $job);
    }
    public function job_detail21(Request $request)
    {
        // $company_id = Session::get('company_id');
        $company_id = $request->get('company_id');
        $job = DB::connection('sqlsrv2')
            ->table('Post_Job')->select('Post_Job.*')
            ->where('CompanyID', '=', $company_id)
            // ->where('JobID', '=', 18)
            ->orderBy('PostTitle', 'asc')->get();
            // dd($job);
        return response()->json($job);
    }
    //View all recruitment activities
    public function all_rec_act()
    {
        $company_id = Session::get('company_id');
        $job = DB::connection('sqlsrv')->table('Activity_Log')
            ->select('Activity_Log.*')
            ->where('CompanyID', '=', $company_id)
            ->where('EventStatus', '=', "Candidate added")
            ->orwhere('EventStatus', '=', "Candidate updated")
            ->orwhere('EventStatus', '=', "Candidate shortlisted")
            ->orwhere('EventStatus', '=', "Candidate hired")
            ->orwhere('EventStatus', '=', "Interview scheduled")
            ->orwhere('EventStatus', '=', "Job updated")
            ->orwhere('EventStatus', '=', "Status changed")
            ->orderBy('LogId', 'desc')->get();
        return request()->json(200, $job);
    }
    //View all interviews
    public function view_interviews()
    {
        $company_id = Session::get('company_id');
        $job = DB::connection('sqlsrv2')->table('interview_detail')
            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
            // ->orderBy('Candidate_Detail.CandName', 'desc')
            ->orderBy('Candidate_Detail.CreatedOn', 'desc')
            ->where('interview_detail.CompanyID', '=', $company_id)
            ->paginate(5);
        return request()->json(200, $job);
    }
    //View all candidate
    public function candidate_detail(Request $request)
    {
        $company_id = Session::get('company_id');
        $can = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->orderBy('Candidate_Detail.CreatedOn', 'desc')
            // ->orderBy('Candidate_Detail.CandName', 'asc')
            ->select('Candidate_Detail.*', 'Post_Job.PostTitle')
            ->where('Candidate_Detail.CompanyID', '=', $company_id)
            ->paginate(10);
        return request()->json(200, $can);
    }
    //Update job
    public function update_job(Request $request)
    {
        $id = $request->get('myid');
        $ed_job_number = $request->get('ed_job_number');
        $ed_posting_title = $request->get('ed_post_title');
        $ed_job_dept = $request->get('ed_job_dept');
        $ed_date_opened = $request->get('ed_date_opened');
        $ed_experiance = $request->get('ed_experiance');
        $ed_target_date = $request->get('ed_target_date');
        $ed_address = $request->get('ed_address');
        // dd($ed_address);
        $ed_educational_requirements = $request->get('ed_educational_requirements');
        $ed_skill_set = $request->get('ed_skill_set');
        $ed_duties = $request->get('ed_duties');

        DB::connection('sqlsrv2')->update('update Post_Job set JobNumber=?, Department=?, PostTitle=?, Experience=?, StartDate=?, EndDate=?, Education=?, Skill=?, Duties=?, Address=? where JobID=?', [$ed_job_number, $ed_job_dept, $ed_posting_title, $ed_experiance, $ed_date_opened, $ed_target_date, $ed_educational_requirements, $ed_skill_set, $ed_duties, $ed_address, $id]);
        $data = "Job Editted Successfully!";

        //Activity log
        $company_id = Session::get('company_id');
        $username = Session::get('username');
        $UserFullName = Session::get('UserName');
        $Event_status = "Job updated";
        $Description = "updated job ";

        $update_date = date("Y-m-d h:i:s A");
        DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $ed_posting_title . ".", $update_date]);
        //End activity log
        return request()->json(200, $data);
    }
    //Update candidate
    public function update_candidate(Request $request)
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
        $applied_via = $request->get('applied_via');
        // dd($applied_via);
        $e_c_dob = $request->get('e_c_dob');
        // dd($e_c_dob);
        $e_c_gender = $request->get('e_c_gender');
        $e_c_university = $request->get('e_c_university');
        $e_c_city = $request->get('e_c_city');
        $e_c_country = $request->get('e_c_country');

        DB::connection('sqlsrv2')->update('UPDATE Candidate_Detail
        SET
            CandName = ?,
            FatherHusband = ?,
            Mobile = ?,
            Email = ?,
            JobID = ?,
            ExpectedSalary = ?,
            Rating = ?,
            CandAddress = ?,
            Curr_Salary = ?,
            Curr_Designation = ?,
            Qualification = ?,
            experience = ?,
            Skill = ?,
            AppliedVia = ?,
            DOB = ?,
            Gender = ?,
            University = ?,
            City = ?,
            Country = ?
        WHERE CandID = ?', [
            $e_c_name,
            $e_c_father,
            $e_c_mobile,
            $e_c_email,
            $e_c_post_title,
            $e_c_exp_salary,
            $ed_rating,
            $e_c_address,
            $e_c_crt_salary,
            $e_c_job_title,
            $e_c_qualification,
            $e_c_experiance,
            $e_c_skill,
            $applied_via,
            $e_c_dob,
            $e_c_gender,
            $e_c_university,
            $e_c_city,
            $e_c_country,
            $cid
        ]);

        $company_id = Session::get('company_id');
        $username = Session::get('username');
        $UserFullName = Session::get('UserName');
        $Event_status = "Candidate updated";
        $Description = "updated candidate ";
        $update_date = date("Y-m-d h:i:s A");

        DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime)
        VALUES (?,?,?,?,?,?)', [
            $company_id,
            $username,
            $UserFullName,
            $Event_status,
            $Description . $e_c_name . ".",
            $update_date
        ]);

        return request()->json(200, "Candidate editted Successfully!");
    }

    public function update_candidate_old(Request $request)
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
        $applied_via = $request->get('applied_via');

        DB::connection('sqlsrv2')->update('update Candidate_Detail set CandName=?, FatherHusband=?, Mobile=?, Email=?, JobID=?, ExpectedSalary=?, Rating=?, CandAddress=?, Curr_Salary=?, Curr_Designation=?, Qualification=?, experience=?, Skill=?, AppliedVia=? where CandID=?', [$e_c_name, $e_c_father, $e_c_mobile, $e_c_email, $e_c_post_title, $e_c_exp_salary, $ed_rating, $e_c_address, $e_c_crt_salary, $e_c_job_title, $e_c_qualification, $e_c_experiance, $e_c_skill, $applied_via, $cid]);
        $data = "Candidate editted Successfully!";

        //Activity log
        $company_id = Session::get('company_id');
        $username = Session::get('username');
        $UserFullName = Session::get('UserName');
        $Event_status = "Candidate updated";
        $Description = "updated candidate ";

        $update_date = date("Y-m-d h:i:s A");
        DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $e_c_name . ".", $update_date]);
        //End activity log

        return request()->json(200, $data);
    }
    //Update status
    public function update_status(Request $request)
    {
        $cid = $request->get('mycid');
        $e_c_status = $request->get('e_c_status');

        Log::info('CID: ' . $cid);
        Log::info('Status: ' . $e_c_status);

        $updated = DB::connection('sqlsrv2')->update(
            'update Candidate_Detail set stats=? where CandID=?',
            [$e_c_status, $cid]
        );

        if ($updated) {
            $data = "Status updated!";
        } else {
            $data = "Failed to update status!";
        }

        return response()->json($data, 200);
    }

    // public function update_status(Request $request)
    // {
    //     // dd($request);
    //     $cid = $request->get('mycid');
    //     $e_c_status=$request->get('e_c_status');

    //     DB::connection('sqlsrv2')->update('update Candidate_Detail set stats=? where CandID=?', [$e_c_status, $cid]);
    //     $data="Status updated!";

    //     return request()->json(200,$data);
    // }
    //Update status
    public function update_status_int(Request $request)
    {
        $cid = $request->get('mycidint');
        $e_c_status = $request->get('c_status');

        DB::connection('sqlsrv2')->update('update Candidate_Detail set stats=? where CandID=?', [$e_c_status, $cid]);
        $data = "Status updated!";

        return request()->json(200, $data);
    }
    //Hire interview
    public function hire_interview(Request $request)
    {
        // dd($request,"ok");
        $iId = $request->get('i_Id');
        $candId = $request->get('m_id');
        $CandName = $request->get('cand_name');
        $Email = $request->get('cand_mail');
        // $hire_sts = $request->get('hire_sts');
        $hire_sts = "0";
        $exp_salary = $request->get('exp_salary');
        $start_date = $request->get('start_date');
        $response_deadline = $request->get('response_deadline');
        $post_id = $request->get('post');
        $department = $request->get('post_depart');
        $company_id = Session::get('company_id');
        $admin_emp_code = Session::get('emp_code');
        // dd(Session::all());
        // $user_name = Session::get('UserName');
        $upd_on = now()->format('Y-m-d h:i:s A');


        // Update interview_detail table
        // DB::connection('sqlsrv2')->update(
        //     'UPDATE interview_detail SET hire_sts = ?, updatedOn = ? WHERE InterviewID = ?',
        //     [$hire_sts, $upd_on, $iId]
        // );

        // Update expected salary in Candidate_Detail
        DB::connection('sqlsrv2')->update(
            'UPDATE Candidate_Detail SET ExpectedSalary = ? WHERE CandID = ? AND CompanyID = ?',
            [$exp_salary, $candId, $company_id]
        );

        // Get candidate data
        $candidate = DB::connection('sqlsrv2')->table('Candidate_Detail')->where('CandID', $candId)->first();
        $post = DB::connection('sqlsrv2')->table('Post_Job')->where('JobID', $candidate->JobID)->first();

        // Get user info (email, role)
        $user = DB::connection('sqlsrv')->table('tb_users')->where('emp_code', $admin_emp_code)->first();
        // dd($user);
        // dd($user);

        // Get company info
        $company = DB::connection('sqlsrv')->table('tb_create_company')->where('company_id', $company_id)->first();
        // dd($company);
        // Build offer letter data
        $offerData = [
            'candidate_name'     => $CandName ?? '',
            'email'              => $Email ?? '',
            'post_title'         => $post->PostTitle ?? '',
            'department'         => $department ?? '',
            'salary'             => $exp_salary,
            'start_date'         => $start_date,
            'response_deadline'  => $response_deadline,
            'hire_date'          => now()->format('F d, Y'),

            'reporting_person'   => $user->user_role ?? 'HR Manager',
            'contact_email'      => $user->email ?? '',
            'contact_phone'      => $user->phone_number ?? 'N/A',

            'company_name'       => $company->company_name ?? '',
            'company_address'    => $company->company_address ?? '',
            'company_city'       => $company->city . ', ' . $company->country,
            'company_phone'      => $company->phone_number ?? '',
            'date'               => now()->format('F d, Y'),

            'sender_name'        => $user->first_name . " " . $user->last_name,
            'sender_title'       => $user->user_role ?? 'HR Manager',
        ];
        // dd($offerData);

        // Send mail to candidate

        try {
            Mail::to($offerData['email'])->send(new \App\Mail\OfferLetterMail($offerData));
            // Mail::to($offerData['email'])
            //     ->cc('cc_email@example.com')
            //     ->send(new \App\Mail\OfferLetterMail($offerData));

            // Insert into Candidate_Offer_Letters
            DB::connection('sqlsrv2')->table('Candidate_Offer_Letters')->insert([
                'CandID'           => $candId,
                'Email'            => $offerData['email'],
                'PostTitle'        => $offerData['post_title'],
                'Department'       => $offerData['department'],
                'Salary'           => $offerData['salary'],
                'StartDate'        => $start_date,
                'ResponseDeadline' => $response_deadline,
                'HireDate'         => now()->format('Y-m-d'),
                'ReportingPerson'  => $offerData['reporting_person'],
                'ContactEmail'     => $offerData['contact_email'],
                'ContactPhone'     => $offerData['contact_phone'],
                'CompanyName'      => $offerData['company_name'],
                'CompanyAddress'   => $offerData['company_address'],
                'CompanyCity'      => $offerData['company_city'],
                'CompanyPhone'     => $offerData['company_phone'],
                'SentDate'         => now(),
                'SenderName'       => $offerData['sender_name'],
                'SenderTitle'      => $offerData['sender_title'],
                'CompanyID'        => $company_id, // ✅ corrected variable
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email', 'error' => $e->getMessage()], 500);
        }


        DB::connection('sqlsrv2')->update(
            'UPDATE interview_detail SET hire_sts = ?, updatedOn = ? WHERE InterviewID = ?',
            [$hire_sts, $upd_on, $iId]
        );

        // Insert into activity log
        $username = $user->first_name . " " . $user->last_name;
        DB::insert('INSERT INTO Activity_Log (CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime)
        VALUES (?, ?, ?, ?, ?, ?)', [
            $company_id,
            $username,
            $CandName,
            "Candidate offer letter sent",
            "Candidate " . $offerData['candidate_name'] . " hired.",
            $upd_on
        ]);
        return response()->json(['message' => 'Candidate offer letter sent.'], 200);
    }

    // public function hire_interview(Request $request)
    // {
    //     $iId = $request->get('myiId');
    //     $exp_salary = $request->get('exp_salary');
    //     $company_id = Session::get('company_id');
    //     $hire_sts = "1";
    //     $i_c_name = $request->get('ed_i_c_name');

    //     $upd_on = date("Y-m-d h:i:s A");
    //     DB::connection('sqlsrv2')->update('update interview_detail set hire_sts=?, updatedOn=? where InterviewID=?', [$hire_sts, $upd_on, $iId]);
    //     $candId_arr = DB::connection('sqlsrv2')->table('interview_detail')->where('InterviewID', '=', $iId)->where('CompanyID', '=', $company_id)->get();
    //     foreach ($candId_arr as $candId_arr1) {
    //     }
    //     $candId = $candId_arr1->CandID;
    //     DB::connection('sqlsrv2')->update('update Candidate_Detail set ExpectedSalary=? where CandID=? AND CompanyID=?', [$exp_salary, $candId, $company_id]);

    //     $username = Session::get('username');
    //     $UserFullName = Session::get('UserName');
    //     DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, "Candidate hired", "Candidate " . $i_c_name . " hired.", $upd_on]);

    //     $data = "Candidate hired";
    //     return request()->json(200, $data);
    // }
    //Hire interview
    public function hire_interview1(Request $request)
    {
        $iId = $request->get('myiId');
        $hire_sts = $request->get('hire_sts');
        $upd_on = date("Y-m-d h:i:s A");
        $updated = DB::connection('sqlsrv2')->update(
            'UPDATE interview_detail SET hire_sts = ?, updatedOn = ? WHERE InterviewID = ?',
            [$hire_sts, $upd_on, $iId]
        );

        if ($updated > 0) {
            $hr = new HrController();
            $hr->create_employee_byid($iId);

            return response()->json(['message' => 'Status updated and employee creation triggered.']);
        } else {
            return response()->json(['message' => 'Status not updated, employee creation skipped.'], 400);
        }
    }
    // public function hire_interview1(Request $request)
    // {
    //     $iId = $request->get('myiId');
    //     $hire_sts = $request->get('hire_sts');
    //     $upd_on = date("Y-m-d h:i:s A");
    //     DB::connection('sqlsrv2')->update('update interview_detail set hire_sts=?, updatedOn=? where InterviewID=?', [$hire_sts, $upd_on, $iId]);
    //     $data = "Status updated";
    //     $hr = new HrController();
    //     $hr->create_employee_byid($iId);
    //     return request()->json(200, $data);
    // }
    //Update interview
    public function update_interview(Request $request)
    {
        $iId = $request->get('myiId');
        // dd($iId);
        $asses = $request->get('asses');
        $which = $request->get('which');

        $ed_i_name = $request->get('ed_i_name');
        $ed_i_link = $request->get('ed_i_link');
        $ed_i_location = $request->get('ed_i_location');
        $ed_i_date = $request->get('ed_i_date');
        $ed_i_from = $request->get('ed_i_from');
        $ed_i_to = $request->get('ed_i_to');

        $firstStatus = $request->get('Status1');
        $secIntSts = $request->get('Status2');
        $finIntSts = $request->get('Status3');
        $update_date = date("Y-m-d h:i:s A");

        if ($which == "firstsdld") {
            $upsSts = $request->get('up_sts');
            $remarks = $request->get('ed_i_comment');
            DB::connection('sqlsrv2')->update('update interview_detail set firstInterviewstatus=?, firstInterviewComments=?, updatedOn=? where InterviewID=?', [$upsSts, $remarks, $update_date, $iId]);
            $data = "Interview updated successfully";
            //Activity log
            $ed_i_c_name = $request->get('ed_i_c_name');
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Status changed";
            $Description = "First interview status and remarks of ";

            // $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $ed_i_c_name . " changed.", $update_date]);
            //End activity log
            return response()->json($data, 200);
        } elseif ($which == "secondsdld") {

            $upsSts = $request->get('up_sts');
            $remarks = $request->get('ed_i_comment');
            DB::connection('sqlsrv2')->update('update interview_detail set secondInterviewstatus=?, secondInterviewComments=?, updatedOn=? where InterviewID=?', [$upsSts, $remarks, $update_date, $iId]);
            $data = "Interview updated successfully";
            //Activity log
            $ed_i_c_name = $request->get('ed_i_c_name');
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Status changed";
            $Description = "Second interview status and remarks of ";

            // $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $ed_i_c_name . " changed.", $update_date]);
            //End activity log
            return response()->json($data, 200);
        } elseif ($which == "finalsdld") {
            $upsSts = $request->get('up_sts');
            $remarks = $request->get('ed_i_comment');
            DB::connection('sqlsrv2')->update('update interview_detail set finalInterviewstatus=?, finalInterviewComments=?, updatedOn=? where InterviewID=?', [$upsSts, $remarks, $update_date, $iId]);
            $data = "Interview updated successfully";
            //Activity log
            $ed_i_c_name = $request->get('ed_i_c_name');
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Status changed";
            $Description = "Final interview status and remarks of ";

            // $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $ed_i_c_name . " changed.", $update_date]);
            //End activity log
            return response()->json($data, 200);
        } else if ($which == "firstns") {
            $firstStatus = "Scheduled";
            $secIntSts = "Not scheduled";
            $finIntSts = "Not scheduled";
            $remarks1 = $request->get('ed_i_comment');

            DB::connection('sqlsrv2')->update('update interview_detail set InterviewerName=?, onlineLink=?, InterviewLocation=?, firstInterviewComments=?, firstInterviewstatus=?, secondInterviewstatus=?, finalInterviewstatus=?, DayDate=?, StartTime=?, EndTime=?, updatedOn=? where InterviewID=?', [$ed_i_name, $ed_i_link, $ed_i_location, $remarks1, $firstStatus, $secIntSts, $finIntSts, $ed_i_date, $ed_i_from, $ed_i_to, $update_date, $iId]);
            $data = "Interview updated successfully";
            //Activity log
            $ed_i_c_name = $request->get('ed_i_c_name');
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Interview scheduled";
            $Description = "First interview of ";

            // $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $ed_i_c_name . " scheduled.", $update_date]);
            //End activity log

            return response()->json($data, 200);
        } else if ($which == "secondns") {
            $secIntSts = "Scheduled";
            $finIntSts = "Not scheduled";
            $remarks2 = $request->get('ed_i_comment');

            DB::connection('sqlsrv2')->update('update interview_detail set InterviewerName=?, onlineLink=?, InterviewLocation=?, secondInterviewComments=?, secondInterviewstatus=?, finalInterviewstatus=?, DayDate=?, StartTime=?, EndTime=?, updatedOn=? where InterviewID=?', [$ed_i_name, $ed_i_link, $ed_i_location, $remarks2, $secIntSts, $finIntSts, $ed_i_date, $ed_i_from, $ed_i_to, $update_date, $iId]);
            $data = "Interview updated successfully";

            //Activity log
            $ed_i_c_name = $request->get('ed_i_c_name');
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Interview scheduled";
            $Description = "Second interview of ";

            // $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $ed_i_c_name . " scheduled.", $update_date]);
            //End activity log

            return response()->json($data, 200);
        } else if ($which == "finalns") {

            $finIntSts = "Scheduled";
            $remarks3 = $request->get('ed_i_comment');

            DB::connection('sqlsrv2')->update('update interview_detail set InterviewerName=?, onlineLink=?, InterviewLocation=?, finalInterviewComments=?, finalInterviewstatus=?, DayDate=?, StartTime=?, EndTime=?, updatedOn=? where InterviewID=?', [$ed_i_name, $ed_i_link, $ed_i_location, $remarks3, $finIntSts, $ed_i_date, $ed_i_from, $ed_i_to, $update_date, $iId]);
            $data = "Interview updated successfully";
            //Activity log
            $ed_i_c_name = $request->get('ed_i_c_name');
            $company_id = Session::get('company_id');
            $username = Session::get('username');
            $UserFullName = Session::get('UserName');
            $Event_status = "Interview scheduled";
            $Description = "Final interview of ";

            // $update_date = date("Y-m-d h:i:s A");
            DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, $Event_status, $Description . $ed_i_c_name . " scheduled.", $update_date]);
            //End activity log
            return response()->json($data, 200);
        }
    }
    //fetch job to edit
    public function edit_job_fetch($id)
    {
        $company_id = Session::get('company_id');
        $job = DB::connection('sqlsrv2')->table('Post_Job')
            ->where('CompanyID', '=', $company_id)->where('JobID', '=', $id)
            ->orderBy('JobID', 'asc')->get();
        return request()->json(200, $job);
    }
    //fetch candidate to edit
    public function edit_candidate_fetch($id)
    {
        $company_id = Session::get('company_id');

        $cand = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->leftJoin('interview_detail', 'Candidate_Detail.CandID', '=', 'interview_detail.CandID')
            ->orderBy('Candidate_Detail.CandID', 'asc')
            ->select(
                'Candidate_Detail.*',
                'Post_Job.PostTitle',
                'Post_Job.JobID',
                // From interview_detail
                'interview_detail.rating',
                'interview_detail.firstInterviewstatus',
                'interview_detail.secondInterviewstatus',
                'interview_detail.finalInterviewstatus',
                'interview_detail.hire_sts'
            )
            ->where('Candidate_Detail.CompanyID', '=', $company_id)
            ->where('Candidate_Detail.CandID', '=', $id)
            ->get();

        // dd($cand);

        return response()->json($cand, 200);
    }

    // public function edit_candidate_fetch($id)
    // {
    //     $company_id = Session::get('company_id');
    //     $cand = DB::connection('sqlsrv2')->table('Candidate_Detail')
    //         ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')

    //         ->orderBy('CandID', 'asc')
    //         ->select('Candidate_Detail.*', 'Post_Job.PostTitle', 'Post_Job.JobID')
    //         ->where('Candidate_Detail.CompanyID', '=', $company_id)
    //         ->where('CandID', '=', $id)->get();
    //     return request()->json(200, $cand);
    // }
    //fetch rel candidate post
    public function fetch_can_post($cid)
    {

        $company_id = Session::get('company_id');
        $cposts = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->where('CompanyID', '=', $company_id)->where('CandName', '=', $cid)
            ->orderBy('PostTitle', 'asc')->get();
        return request()->json(200, $cposts);
    }
    //fetch interview to edit
    public function fetch_interviews_cand($ids)
    {
        $company_id = Session::get('company_id');
        $inter = DB::connection('sqlsrv2')->table('interview_detail')
            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')

            ->orderBy('interview_detail.InterviewID', 'asc')
            ->select('Candidate_Detail.*', 'interview_detail.*', 'Post_Job.*')
            ->where('interview_detail.CompanyID', '=', $company_id)
            ->where('interview_detail.InterviewID', '=', $ids)->get();
        // dd($inter);
        return request()->json(200, $inter);
    }
    public function edit_interview_fetch($ids)
    {
        $company_id = Session::get('company_id');
        $inter = DB::connection('sqlsrv2')->table('interview_detail')
            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')

            ->orderBy('interview_detail.InterviewID', 'asc')
            ->select('Candidate_Detail.*', 'interview_detail.*', 'Post_Job.*')
            ->where('interview_detail.CompanyID', '=', $company_id)
            ->where('interview_detail.InterviewID', '=', $ids)->get();
        // Dd($inter);
        return request()->json(200, $inter);
    }
    //Search interview
    public function searchinterviews(Request $request)
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
        $inter = DB::connection('sqlsrv2')->table('interview_detail')

            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
            ->orderBy('Candidate_Detail.CandName', 'asc')
            ->where('Candidate_Detail.CandName', 'like', '%' . $srch_name . '%')
            ->where('Post_Job.PostTitle', 'like', '%' . $designation . '%')
            ->where('interview_detail.firstInterviewstatus', 'like', $status1 . '%')
            ->where('interview_detail.secondInterviewstatus', 'like', $status2 . '%')
            ->where('interview_detail.finalInterviewstatus', 'like', $status3 . '%')
            ->where('interview_detail.rating', 'like', '%' . $s_rate . '%')
            ->where('interview_detail.CompanyID', '=', $company_id)->get();
        // }
        return request()->json(200, $inter);
    }
    //Search candidates
    public function searchcandidates(Request $request)
    {
        $company_id = Session::get('company_id');
        $name = $request->get('name');
        $post = $request->get('post');
        $address = $request->get('address');

        $result = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->select('Candidate_Detail.*', 'Post_Job.*')
            ->orderBy('Candidate_Detail.CandName', 'asc')
            ->where('Candidate_Detail.CandAddress', 'like', '%' . $address . '%')
            ->where('Post_Job.PostTitle', 'like', '%' . $post)
            ->where('Candidate_Detail.CandName', 'like', '%' . $name . '%')
            ->where('Candidate_Detail.CompanyID', '=', $company_id)->get();
        return request()->json(200, $result);
    }
    //view individule job detail
    public function ind_job_detail($id)
    {
        $company_id = Session::get('company_id');
        $job = DB::connection('sqlsrv2')->table('Post_Job')
            ->where('CompanyID', '=', $company_id)->where('JobID', '=', $id)->get();
        return request()->json(200, $job);
    }


    //Count top list of dashboard
    public function top_counters()
    {
        $company_id = Session::get('company_id');
        $sl_cand = DB::connection('sqlsrv2')->table('interview_detail')

            ->select('interview_detail.hire_sts')
            ->orderBy('interview_detail.InterviewID', 'asc')
            ->where('interview_detail.CompanyID', '=', $company_id)
            ->where('interview_detail.hire_sts', '=', '1')->get();
        $sl_cand_ct = Count($sl_cand);

        $ong_int = DB::connection('sqlsrv2')
            ->table('interview_detail')->select('CompanyID', 'firstInterviewstatus', 'finalInterviewstatus', 'hire_sts')
            ->where('CompanyID', '=', $company_id)
            ->where('hire_sts', '!=', '1')
            ->where('firstInterviewstatus', '=', 'Scheduled')
            ->orwhere('secondInterviewstatus', '=', 'Scheduled')
            ->orwhere('finalInterviewstatus', '=', 'Scheduled')
            ->get();
        $ct_ong_int = Count($ong_int);

        $cand = DB::connection('sqlsrv2')
            ->table('Candidate_Detail')->select('CompanyID', 'CandID')
            ->where('CompanyID', '=', $company_id)->get();
        $candct = Count($cand);



        $currentMonth = date('m');
        $currentYear = date('Y');
        $hiredData = DB::connection('sqlsrv2')
            ->table('interview_detail')
            ->select(DB::raw('DATEPART(WEEK, DayDate) as week_no'), DB::raw('COUNT(*) as total'))
            ->where('CompanyID', $company_id)
            ->where('hire_sts', '1')
            ->whereMonth('DayDate', '=', $currentMonth)
            ->whereYear('DayDate', '=', $currentYear)
            ->groupBy(DB::raw('DATEPART(WEEK, DayDate)'))
            ->orderBy(DB::raw('DATEPART(WEEK, DayDate)'))
            ->pluck('total', 'week_no')
            ->toArray();
        $pendingData = DB::connection('sqlsrv2')
            ->table('interview_detail')
            ->select(DB::raw('DATEPART(WEEK, DayDate) as week_no'), DB::raw('COUNT(*) as total'))
            ->where('CompanyID', $company_id)
            ->where('hire_sts', '0')
            ->whereMonth('DayDate', '=', $currentMonth)
            ->whereYear('DayDate', '=', $currentYear)
            ->groupBy(DB::raw('DATEPART(WEEK, DayDate)'))
            ->orderBy(DB::raw('DATEPART(WEEK, DayDate)'))
            ->pluck('total', 'week_no')
            ->toArray();


        $job = DB::connection('sqlsrv2')
            ->table('Post_Job')->select('CompanyID', 'JobNumber')
            ->where('CompanyID', '=', $company_id)
            ->Sum('JobNumber');

        $weeksList = array_values(array_unique(array_merge(array_keys($hiredData), array_keys($pendingData))));
        $finalHiredData = [];
        $finalPendingData = [];
        foreach ($weeksList as $week) {
            $finalHiredData[] = isset($hiredData[$week]) ? $hiredData[$week] : 0;
            $finalPendingData[] = isset($pendingData[$week]) ? $pendingData[$week] : 0;
        }




        $counts = array(
            'short_listed' => $sl_cand_ct,
            'ongoing_interview' => $ct_ong_int,
            'applications' => $candct,
            'jobs_count' => $job,
            'hired_data'    => $finalHiredData,
            'pending_data'  => $finalPendingData,
            'weeks_list'    => $weeksList,
            '1' => $pendingData,
            '2' => $hiredData

        );

        return request()->json(200, $counts);
    }

    //For active job status
    public function getJobStats()
    {
        $company_id = Session::get('company_id');

        $jobs = DB::connection('sqlsrv2')
            ->table('Post_Job')
            ->where('CompanyID', $company_id)
            ->select('JobID', 'PostTitle')
            ->get();

        $result = [];

        foreach ($jobs as $job) {

            $total_candidates = DB::connection('sqlsrv2')
                ->table('Candidate_Detail')
                ->where('CompanyID', $company_id)
                ->where('JobID', $job->JobID)
                ->count();

            $interviews = DB::connection('sqlsrv2')
                ->table('interview_detail')
                ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
                ->where('Candidate_Detail.JobID', $job->JobID)
                ->where('interview_detail.CompanyID', $company_id)
                ->where('hire_sts', '!=', '1')
                ->count();

            $hired = DB::connection('sqlsrv2')
                ->table('interview_detail')
                ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
                ->where('Candidate_Detail.JobID', $job->JobID)
                ->where('interview_detail.CompanyID', $company_id)
                ->where('hire_sts', '1')
                ->count();

            $result[] = [
                'JobID'            => $job->JobID,
                'PostTitle'        => $job->PostTitle,
                'total_candidates' => $total_candidates,
                'interviews'       => $interviews,
                'hired'            => $hired
            ];
        }

        return response()->json($result);
    }


    //Count relevent job candidates
    public function rel_cand_count(Request $request)
    {

        $company_id = session()->get('company_id');
        $selectedDate = $request->query('date');


        $query = DB::connection('sqlsrv2')->table('interview_detail')
            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->select('interview_detail.*', 'Candidate_Detail.CandName', 'Post_Job.PostTitle')
            ->orderBy('Candidate_Detail.CandName', 'asc')
            ->where('interview_detail.CompanyID', '=', $company_id)
            ->where(function ($q) {
                $q->where('interview_detail.firstInterviewstatus', '=', 'Scheduled')
                    ->orWhere('interview_detail.secondInterviewstatus', '=', 'Scheduled')
                    ->orWhere('interview_detail.finalInterviewstatus', '=', 'Scheduled');
            });
        if ($selectedDate) {
            $query->whereDate('interview_detail.DayDate', '=', $selectedDate);
        }

        $interviews = $query->get();


        return response()->json($interviews);




        // $company_id = Session::get('company_id');
        // $date = $request->query('date');

        // $job = DB::connection('sqlsrv2')->table('interview_detail')
        //     ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
        //     ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        //     ->select('interview_detail.*', 'Candidate_Detail.CandName', 'Post_Job.JobTitle')
        //     ->orderBy('Candidate_Detail.CandName', 'asc')
        //     ->where('interview_detail.CompanyID', '=', $company_id)
        //     ->where(function ($q) {
        //         $q->where('interview_detail.firstInterviewstatus', '=', 'Scheduled')
        //             ->orWhere('interview_detail.secondInterviewstatus', '=', 'Scheduled')
        //             ->orWhere('interview_detail.finalInterviewstatus', '=', 'Scheduled');
        //     })
        //     ->get();

        // ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
        // ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
        // ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
        // ->orderBy('Candidate_Detail.CandName','asc')
        // ->where('interview_detail.CompanyID','=',$company_id)
        // ->where('interview_detail.firstInterviewstatus','=','Scheduled')
        // ->orwhere('interview_detail.secondInterviewstatus','=','Scheduled')
        // ->orwhere('interview_detail.finalInterviewstatus','=','Scheduled')
        // ->get();
        // return request()->json(200, $job);
    }


    public function getSourcePercentage()
    {
        $company_id = session()->get('company_id');
        $query = DB::connection('sqlsrv2')->table('Candidate_Detail');

        $totalRecords = $query
            ->where('CompanyID', $company_id)
            ->whereNotNull('AppliedVia')
            ->where('AppliedVia', '!=', '')
            ->count();

        if ($totalRecords === 0) {
            return response()->json([
                'facebook' => 0,
                'indeed' => 0,
                'linkedin' => 0,
                'other' => 0
            ]);
        }

        $facebookCount = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->where('CompanyID', $company_id)
            ->where('AppliedVia', 'like', '%facebook%')
            ->count();

        $indeedCount = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->where('CompanyID', $company_id)
            ->where('AppliedVia', 'like', '%indeed%')
            ->count();

        $linkedinCount = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->where('CompanyID', $company_id)
            ->where('AppliedVia', 'like', '%linkedin%')
            ->count();

        $otherCount = DB::connection('sqlsrv2')->table('Candidate_Detail')
            ->where('CompanyID', $company_id)
            ->whereNotNull('AppliedVia')
            ->where('AppliedVia', '!=', '')
            ->where(function ($query) {
                $query->where('AppliedVia', 'not like', '%facebook%')
                    ->where('AppliedVia', 'not like', '%indeed%')
                    ->where('AppliedVia', 'not like', '%linkedin%');
            })
            ->count();

        // Percentage calculation
        $facebookPercentage = ($facebookCount / $totalRecords) * 100;
        $indeedPercentage = ($indeedCount / $totalRecords) * 100;
        $linkedinPercentage = ($linkedinCount / $totalRecords) * 100;
        $otherPercentage = ($otherCount / $totalRecords) * 100;

        return response()->json([
            'facebook' => round($facebookPercentage),
            'indeed' => round($indeedPercentage),
            'linkedin' => round($linkedinPercentage),
            'other' => round($otherPercentage)
        ]);
    }





    //Get hired candidates of last 30 days
    public function mnth_hired()
    {
        $company_id = Session::get('company_id');

        $today = date("m");
        $mnt_hir = DB::connection('sqlsrv2')
            ->table('interview_detail')
            ->join('Candidate_Detail', 'interview_detail.CandID', '=', 'Candidate_Detail.CandID')
            ->join('Post_Job', 'Candidate_Detail.JobID', '=', 'Post_Job.JobID')
            ->select('interview_detail.*', 'Candidate_Detail.*', 'Post_Job.*')
            ->orderBy('interview_detail.updatedOn', 'asc')
            ->where('interview_detail.CompanyID', '=', $company_id)
            ->where('interview_detail.hire_sts', '=', '1')
            ->whereMonth('interview_detail.updatedOn', '=', $today)->get();
        return request()->json(200, $mnt_hir);
    }
    //Count hired candidates
    public function cnd_hired()
    {
        $company_id = Session::get('company_id');
        $hir_int = DB::connection('sqlsrv2')
            ->table('interview_detail')->select('CompanyID', 'hire_sts')
            ->where('CompanyID', '=', $company_id)
            ->where('hire_sts', '=', '1')->get();
        $ct_hir_int = Count($hir_int);
        return request()->json(200, $ct_hir_int);
    }
    public function filter_jobs($id, $kew, $loc, $fresh, $exp, $internship, $partTime, $fullTime)
    {
        if ($kew == "All") {
            $kew = "";
        }
        if ($loc == "All") {
            $loc = "";
        }
        if ($fresh == "true") {
            $fresh = "Fresher";
        } else {
            $fresh = "Dont fetch";
        }
        if ($exp == "true") {
            $exp = "year";
        } else {
            $exp = "Dont fetch";
        }
        if ($internship == "true") {
            $internship = "Internship";
        } else {
            $internship = "Dont fetch";
        }
        if ($partTime == "true") {
            $partTime = "Part Time";
        } else {
            $partTime = "Dont fetch";
        }
        if ($fullTime == "true") {
            $fullTime = "Full Time";
        } else {
            $fullTime = "Dont fetch";
        }
        $job = DB::connection('sqlsrv2')
            ->table('Post_Job')->select('Post_Job.*')
            ->where('CompanyID', '=', $id)
            ->where('Address', 'like', '%' . $loc . '%')
            ->where('PostTitle', 'like', '%' . $kew . '%')
            ->where('Experience', 'like', '%' . $fresh . '%')
            ->orwhere('CompanyID', '=', $id)
            ->where('Address', 'like', '%' . $loc . '%')
            ->where('PostTitle', 'like', '%' . $kew . '%')
            ->where('Experience', 'like', '%' . $exp . '%')
            ->orwhere('CompanyID', '=', $id)
            ->where('Address', 'like', '%' . $loc . '%')
            ->where('PostTitle', 'like', '%' . $kew . '%')
            ->where('Experience', 'like', '%' . $internship . '%')
            ->orwhere('CompanyID', '=', $id)
            ->where('Address', 'like', '%' . $loc . '%')
            ->where('PostTitle', 'like', '%' . $kew . '%')
            ->where('Experience', 'like', '%' . $partTime . '%')
            ->orwhere('CompanyID', '=', $id)
            ->where('Address', 'like', '%' . $loc . '%')
            ->where('PostTitle', 'like', '%' . $kew . '%')
            ->where('Experience', 'like', '%' . $fullTime . '%')
            ->orderBy('PostTitle', 'asc')->get();
        return request()->json(200, $job);
    }
    public function company_id()
    {
        $company_id = Session::get('company_id');

        return request()->json(200, $company_id);
    }

    public function job_detail1($comid, $jobid)
    {
        $company_id = Session::get('company_id');
        $job = DB::connection('sqlsrv2')
            ->table('Post_Job')->select('Post_Job.*')->where('JobID', '=', $jobid)->where('CompanyID', '=', $comid)->orderBy('PostTitle', 'asc')->get();
        return request()->json(200, $job);
    }

    public function candidate_public(Request $request)
    {
        $company_id = $request->get('a_c_companyID');
        $username = "Appling online";

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
        $stats = "Applied";


        $add_date = date("Y-m-d h:i:s A");

        DB::connection('sqlsrv2')->insert('INSERT INTO Candidate_Detail(CandName, FatherHusband, stats, Mobile, Email, JobID, ExpectedSalary, CandAddress, Curr_Salary, Curr_Designation, Qualification, experience, Skill, Rating, CreatedOn, CreatedBy, CompanyID) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$a_c_name, $a_c_father, $stats, $a_c_mobile, $a_c_email, $a_c_job_id, $a_c_exp_salary, $a_c_address, $a_c_crt_salary, $a_c_job_title, $a_c_qualification, $a_c_experiance, $a_c_skill, $star_value, $add_date, $username, $company_id]);
        $data = "Candidate added Successfully!";

        //Activity log

        $UserFullName = $a_c_name;

        $update_date = date("Y-m-d h:i:s A");
        DB::insert('INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)', [$company_id, $username, $UserFullName, "Candidate applied", "Candidate " . $a_c_name . " Applie online.", $update_date]);
        //End activity log

        return request()->json(200, $data);
    }
}
