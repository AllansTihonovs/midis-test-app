<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Admin\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminFormRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function __construct(protected AdminServiceInterface $adminService) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $admin = User::orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Admin/AdminList', [
            'administrators' => $admin,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/CreateAdmin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminFormRequest $request
     * @return RedirectResponse
     */
    public function store(AdminFormRequest $request): RedirectResponse
    {
        $this->adminService->createAdmin($request);

        return redirect()->route('admin.index')->with('success', 'Administrator created.');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $admin
     * @return Response
     */
    public function edit(User $admin): Response
    {
        return Inertia::render('Admin/EditAdmin', [
            'administrator' => $admin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminFormRequest $request
     * @param User $admin
     * @return RedirectResponse
     */
    public function update(AdminFormRequest $request, User $admin): RedirectResponse
    {
        $this->adminService->updateAdmin($admin, $request);

        return redirect()->route('admin.index')->with('success', 'Administrator updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $admin
     * @return RedirectResponse
     */
    public function destroy(User $admin): RedirectResponse
    {
        $this->adminService->deleteAdmin($admin);

        return redirect()->back()->with('success', 'Administrator deleted.');
    }
}
