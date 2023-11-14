<?php
namespace App\Contracts\Repository\Admin\ClubManagement;
use Illuminate\Http\Request;
interface MemberRegisterationRepositoryInterface {
    public function create_new_member(Request $request);
    public function get_member_data($id);
    public function get_member_DetailById($id);
    public function create_Member_Receipt(Request $request);
    public function get_receipt_data($id);
    public function searchClubmember(Request $request);
    public function search_MemberFees(Request $request);
    
}
