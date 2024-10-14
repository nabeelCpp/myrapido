<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    protected $guard;
    public function __construct() {
        $this->guard = CommonHelper::getGuardName();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = CommonHelper::PER_PAGE;
        $admins = Admin::latest()->paginate(CommonHelper::PER_PAGE);
        $sn = isset($request->page) && $request->page > 1 ? $request->page * $perpage : 1;
        $guard = request()->whoIs;
        return view($guard.'.admins.index', compact('admins', 'sn', 'guard'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guard = request('whoIs');
        $data['guard'] = $guard;
        return view($guard.'.admins.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:15',
        ]);

        try {
            // Create a new user
            Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone ?? null
            ]);
            return CommonHelper::redirect('success',  'Admin created successfully!', $this->guard.'.admins.index');
        } catch (\Throwable $th) {
            //throw $th;
            return CommonHelper::redirect('error',  'Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['guard'] = $this->guard;
        $data['admin'] = Admin::findOrFail($id);
        return view($this->guard.'.admins.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Ignore the current user's email for uniqueness
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|min:6|confirmed',
        ]);
        try {
            // Find the user
            $user = Admin::findOrFail($id);

            if ($request->has('password') && !isEmpty($request->password)) {
                $update = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone ?? null
                ];
            } else {
                $update = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ];
            }

            // Update user attributes
            $user->update($update);
            return CommonHelper::redirect('success',  'Admin updated successfully!', $this->guard.'.admins.index');
        } catch (\Throwable $th) {
            //throw $th;
            return CommonHelper::redirect('error',  'Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Admin::findOrFail($id);
        $user->delete();
        return CommonHelper::redirect('success',  'Admin deleted successfully!', $this->guard.'.admins.index');
    }
}
