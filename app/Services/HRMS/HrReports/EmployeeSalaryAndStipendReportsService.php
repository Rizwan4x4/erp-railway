<?php

namespace App\Services\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeSalaryAndStipendReportsRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeSalaryAndStipendReportsServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\HrReports\EmployeeSalaryAndStipendReportsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Arr;

use App\CustomFpdf;
class EmployeeSalaryAndStipendReportsService implements EmployeeSalaryAndStipendReportsServiceInterface
{
    protected $EmployeeSalaryAndStipendReportsRepositoryInterface;

    public function __construct(EmployeeSalaryAndStipendReportsRepositoryInterface $EmployeeSalaryAndStipendReportsRepositoryInterface)
    {
        $this->EmployeeSalaryAndStipendReportsRepositoryInterface = $EmployeeSalaryAndStipendReportsRepositoryInterface;
    }


    public function generateDepartmentReport()
    {
        $company_id = session()->get('company_id');
        $sessionClosed = $this->EmployeeSalaryAndStipendReportsRepositoryInterface->getClosedSession();

        foreach ($sessionClosed as $session) {
            $sessionName = $session->SessionName;
        }

        $result = $this->EmployeeSalaryAndStipendReportsRepositoryInterface->getSalaryDetails($sessionName);
        $this->fpdf = new Fpdf();
        $this->fpdf->AddPage("L", ['280', '297']);
        $this->fpdf->SetTextColor(41, 46, 46);
        
        $fetch_image = DB::connection('sqlsrv3')
            ->table('CompanyLogo')
            ->where('CompanyID', '=', company_id())
            ->get();

        foreach ($fetch_image as $fetch_image1) {
            // code...
        }

        $this->fpdf->Image('public/images/logo/'.$fetch_image1->RightLogo, 15, 12, 40, 12);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/sasystems.png', 247, 2, 34, 35);
        $this->fpdf->ln(3);
        
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->MultiCell(265, 8, 'Department Stipend Report'."\n Salary month: ".Carbon::parse($session->EndDate)->format('F Y'), 0, 'C', false);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
        $this->fpdf->Cell(75, 6, 'Department Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Stipend', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Allo. / Bonus', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Gross Payable', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Loan', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Advance', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Net Payable', 1, 1, 'C', 0);
        
        $row = 0;
        $sr = 1;
        foreach ($result as $result1) {
            $fetch_detail = $this->EmployeeSalaryAndStipendReportsRepositoryInterface->getSalarySums($sessionName);
        //    dd($fetch_detail);
            // $dept = $fetch_detail['Department Name'];
            $stipend = $fetch_detail['stipend_sum'];
            $AllowanceAmount = $fetch_detail['allowance_sum'];
            $BonusAmount = $fetch_detail['bonus_sum'];
            $TAmount = $fetch_detail['t_sum'];
            $InstallmentAmount = $fetch_detail['installment_sum'];
            $AdvanceAmount = $fetch_detail['advance_sum'];
            $PayableSalary = $fetch_detail['payable_sum'];

            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetFillColor(237, 240, 238);

            if ($row % 2 == 0) {
                $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);
                $this->fpdf->Cell(75, 6, substr($dept, 0, 55), 1, 0, 'L', 0);
                $this->fpdf->Cell(30, 6, number_format($stipend), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($AllowanceAmount + $BonusAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($TAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($InstallmentAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($AdvanceAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($PayableSalary), 1, 1, 'R', 0);
            } else {
                $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 1);
                $this->fpdf->Cell(75, 6, substr($dept, 0, 55), 1, 0, 'L', 1);
                $this->fpdf->Cell(30, 6, number_format($stipend), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($AllowanceAmount + $BonusAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($TAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($InstallmentAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($AdvanceAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($PayableSalary), 1, 1, 'R', 1);
            }

            $row++;
            $sr++;
        }

        $salarySums = $this->EmployeeSalaryAndStipendReportsRepositoryInterface->getSalarySums($sessionName);

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(84, 6, 'Grand Total:', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, number_format($salarySums['stipend_sum']).'/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($salarySums['allowance_sum'] + $salarySums['bonus_sum']).'/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($salarySums['t_sum']).'/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($salarySums['installment_sum']).'/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($salarySums['advance_sum']).'/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($salarySums['payable_sum']).'/-', 1, 1, 'R', 0);
        $this->fpdf->ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(40, 6, 'Prepared By:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Accounts:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Director HR:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 1, 'L', 0);
        $this->fpdf->ln(15);
        $this->fpdf->Cell(40, 6, '', 0, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, 'CEO: ', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Chairman:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->SetY(-10);
        $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
        $this->fpdf->Output();
        exit;
    }
}