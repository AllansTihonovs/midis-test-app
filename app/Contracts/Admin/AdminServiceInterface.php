<?php

namespace App\Contracts\Admin;

use App\Http\Requests\Admin\AdminFormRequest;
use App\Models\User;

interface AdminServiceInterface
{
    /**
     * @param AdminFormRequest $request
     * @return User
     */
    public function createAdmin(AdminFormRequest $request): User;

    /**
     * @param User $administrator
     * @param AdminFormRequest $request
     * @return User
     */
    public function updateAdmin(User $administrator, AdminFormRequest $request): User;

    /**
     * @param User $administrator
     */
    public function deleteAdmin(User $administrator): void;
}
