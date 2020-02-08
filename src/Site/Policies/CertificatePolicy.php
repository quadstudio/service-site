<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Certificate;
use QuadStudio\Service\Site\Models\User;

class CertificatePolicy
{

    /**
     * Determine whether the user can view the engineer.
     *
     * @param User $user
     * @param Certificate $certificate
     * @return bool
     */
    public function view(User $user, Certificate $certificate)
    {
        return $user->id == $certificate->engineer->user_id;
    }

}
