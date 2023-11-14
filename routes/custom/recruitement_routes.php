<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

Route::get('/allJobs/{id}',function(){return view('jobs');});

Route::get('/company_id', 'App\Http\Controllers\RecruitementController@company_id');
Route::get('all_jobs_search/{id}/{keyword}/{location}/{fresh}/{experianced}','App\Http\Controllers\RecruitementController@filter_jobs');
Route::get('job_detail21/{comid}/{jobid}', 'App\Http\Controllers\RecruitementController@job_detail1');
Route::post('candidate_public','App\Http\Controllers\RecruitementController@candidate_public');
Route::post('jobs','App\Http\Controllers\RecruitementController@post_job')->middleware('permission:Recruitment Post job');
Route::get('/job_detail2', 'App\Http\Controllers\RecruitementController@job_detail')->middleware('permission:Recruitment Candidates view,Recruitment Post job,Recruitment Interview view,Recuriment Dashboard overall-view');
Route::get('/rec_activities', 'App\Http\Controllers\RecruitementController@all_rec_act')->middleware('permission:Recuriment Dashboard overall-view');   //view recruitment activities
Route::get('fetch_jobs/{id}', 'App\Http\Controllers\RecruitementController@edit_job_fetch');  //edit job
Route::post('update_job', 'App\Http\Controllers\RecruitementController@update_job');
Route::get('ind_job_detail2/{id}', 'App\Http\Controllers\RecruitementController@ind_job_detail');  //Individule job
// candidate
Route::post('candidate','App\Http\Controllers\RecruitementController@add_candidate')->middleware('permission:Add new Candidates');
Route::get('/candidate_detail2', 'App\Http\Controllers\RecruitementController@candidate_detail')->middleware('permission:Recruitment Candidates view,Recruitment Post job,Recruitment Interview view,Recuriment Dashboard overall-view');
Route::get('/get_candidate_detail/{id}', 'App\Http\Controllers\RecruitementController@view_detail');  //Details
Route::post('searchcandidates', 'App\Http\Controllers\RecruitementController@searchcandidates');  //search
Route::get('fetch_candidates/{id}', 'App\Http\Controllers\RecruitementController@edit_candidate_fetch');  //fetch candidate to update
Route::post('update_candidate', 'App\Http\Controllers\RecruitementController@update_candidate');  //update candidate
Route::post('update_status', 'App\Http\Controllers\RecruitementController@update_status');  //update status
Route::post('update_status_int', 'App\Http\Controllers\RecruitementController@update_status_int');  //update status

//Interview
Route::post('schInterview','App\Http\Controllers\RecruitementController@schedule_interview');  //Schedule
Route::post('searchinterviews', 'App\Http\Controllers\RecruitementController@searchinterviews');  //search
Route::post('update_interview', 'App\Http\Controllers\RecruitementController@update_interview');  //update
Route::post('int_hire', 'App\Http\Controllers\RecruitementController@hire_interview');  //hire interview
Route::post('int_hire1', 'App\Http\Controllers\RecruitementController@hire_interview1');  //hire interview1
Route::get('/interview_detail2', 'App\Http\Controllers\RecruitementController@view_interviews')->middleware('permission:Recruitment Interview view');
Route::get('fetch_can/{id}', 'App\Http\Controllers\RecruitementController@fetch_can_post');//fetch rel candidate post
Route::get('fetch_interviews/{id}', 'App\Http\Controllers\RecruitementController@edit_interview_fetch');//fetch interviews to update
Route::get('/mnth_hired', 'App\Http\Controllers\RecruitementController@mnth_hired')->middleware('permission:Recuriment Dashboard overall-view');  //Get hired candidates of last 30 days
Route::get('/cnd_hired', 'App\Http\Controllers\RecruitementController@cnd_hired')->middleware('permission:Recuriment Dashboard overall-view');   //Count hired candidates
Route::get('/rel_cand_count', 'App\Http\Controllers\RecruitementController@rel_cand_count')->middleware('permission:Recuriment Dashboard overall-view'); //Count relevent job candidates
Route::get('/top_counters', 'App\Http\Controllers\RecruitementController@top_counters')->middleware('permission:Recuriment Dashboard overall-view'); //Count top list of dashboard
Route::get('/cnt_tl_empl', 'App\Http\Controllers\RecruitementController@cnt_tl_emp');  // Count all employees
Route::get('all_jobs_test/{id}/{keyword}/{location}/{fresh}/{experianced}/{internship}/{partTime}/{fullTime}','App\Http\Controllers\RecruitementController@filter_jobs');
