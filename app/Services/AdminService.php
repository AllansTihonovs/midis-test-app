<?php

namespace App\Services;

use App\Models\User;
use App\Http\Requests\Admin\AdminFormRequest;
use App\Contracts\Admin\AdminServiceInterface;
use Illuminate\Support\Facades\Hash;

class AdminService implements AdminServiceInterface
{
    public function createAdmin(AdminFormRequest $request): User
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function updateAdmin(User $administrator, AdminFormRequest $request): User
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $administrator->update($data);

        return $administrator;
    }

    public function deleteAdmin(User $administrator): void
    {
        $administrator->delete();
    }
}
