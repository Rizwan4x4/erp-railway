<?php

namespace App\Http\Controllers\HRMS\WarningDetails;

use App\Contracts\Repository\HRMS\WarningDetails\WarningDetailsRepositoryInterface;
use App\Contracts\Services\HRMS\WarningDetails\WarningDetailsServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Log;
use Session;
use DB;
class WarningDetailsController extends Controller
{
    use CommonTrait;
    protected $WarningDetailsRepository;
    protected $WarningDetailservice;
    public function __construct(WarningDetailsServiceInterface $WarningDetailservice, WarningDetailsRepositoryInterface $WarningDetailsRepository)
    {
        $this->WarningDetailsRepository = $WarningDetailsRepository;
        $this->WarningDetailservice = $WarningDetailservice;
    }

    public function count_warnings(){
try{


        return $this->sendSuccess('Count warning success',$this->WarningDetailsRepository->count_warnings());
    } catch (\Exception $e) {

                    Log::error('Unhandled Exception: ' . $e->getMessage());
                    return $this->sendError($e->getMessage(), $e->getCode());
                }
    }
    public function search_warnings(Request $request){
    try{
        $keyword = $request->query('keyword1');
        $Page = $request->query('page');
        return $this->sendSuccess('search warning success',$this->WarningDetailsRepository->searchWarnings($keyword, $Page));
    } catch (\Exception $e) {

        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }
    public function filter_warnings($location, $designation, $department)
    {
try{


       return $this->sendSuccess('filter warning success',$this->WarningDetailservice->filterWarnings($designation, $department, $location));

    } catch (\Exception $e) {

        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }

}
