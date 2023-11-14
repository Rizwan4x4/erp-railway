<?php

namespace App\Contracts\Repository\Admin\ClubManagement;

interface MemberFeesRepositoryInterface
{
    public function getFees();
    public function getTotalFees();

}
