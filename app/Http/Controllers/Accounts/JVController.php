<?php

namespace App\Http\Controllers\Accounts;

use App\Contracts\Repository\Accounts\JVRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Contracts\Services\Accounts\JVServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use DB;
use App\Traits\CommonTrait;
class JVController extends Controller
{
    use CommonTrait;
    protected $JurnalVoucherService;
    protected $JurnalVoucherRepository;

    public function __construct(JVServiceInterface $JurnalVoucherService, JVRepositoryInterface $JurnalVoucherRepository)
    {
        $this->JurnalVoucherService = $JurnalVoucherService;
        $this->JurnalVoucherRepository = $JurnalVoucherRepository;
    }

    public function jv_detail()
    {
        try{
            return $this->sendSuccess('Data Fetch Successfully.', $this->JurnalVoucherService->jv_detail());
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

    public function insert_jv(Request $request)
  {
      try{
            return $this->sendSuccess('JV inserted Successfully.', $this->JurnalVoucherService->insert_jv($request));
          } catch (\Exception $e) {
        //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
        Log::error('Unhandled Exception: ' . $e->getMessage());
          return $this->sendError($e->getMessage());
        }
    }

    public function edit_jv(Request $request)
    {
        try{
            return $this->sendSuccess('JV updated Successfully.', $this->JurnalVoucherService->update_jv($request));
        } catch (\Exception $e) {
        Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

    public function update_jvStatus(Request $request)
    {
        try{
            //return $this->JurnalVoucherService->update_jvStatus($request);
            return $this->sendSuccess('JV updated Successfully.', $this->JurnalVoucherService->update_jvStatus($request));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

    public function get_jurnal_vchr($id)
    {
        try{
            return $this->sendSuccess('JV Fetched Successfully.', $this->JurnalVoucherRepository->JV_byID($id));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

    public function get_JV_detail($id)
    {
        try{
            return $this->sendSuccess('JV Details Fetched Successfully.', $this->JurnalVoucherRepository->jv_detail($id));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

    public function search_journals(Request $request)
    {
        try{
            return $this->sendSuccess('JV Filtered Successfully.', $this->JurnalVoucherRepository->JV_Bykeyword($request));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

    public function jv_searchdate($datefrom,$dateto)
    {
        try{
            return $this->sendSuccess('JV Successfully Filtered by Date.', $this->JurnalVoucherRepository->jv_searchdate($datefrom, $dateto));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

    public function jv_searchbyfilter($status)
    {
        try{
            return $this->sendSuccess('JV Successfully Filtered by Status.', $this->JurnalVoucherRepository->jv_searchbyfilter($status));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }

}
