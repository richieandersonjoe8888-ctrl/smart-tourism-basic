<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 1. Contextual lists for approvals and moderation
        $pendingBlogs = Blog::where('status', 'pending')->latest()->get();
        $activeBlogs = Blog::where('status', 'approved')->latest()->get();
        
        // Vendor Requests: Users who are active but don't have the vendor role yet (simulated logic)
        $vendorRequests = User::where('status', 'active')
            ->whereDoesntHave('roles', fn($q) => $q->where('name', 'vendor'))
            ->latest()->get();

        // 2. Filtered list of vendors by tags for communication (No global user list!)
        $vendorQuery = User::whereHas('roles', fn($q) => $q->where('name', 'vendor'));
        
        if ($request->has('tag')) {
            $vendorQuery->whereHas('tags', fn($q) => $q->where('name', $request->tag));
        }
        $communicableVendors = $vendorQuery->take(15)->get(); // Strictly limited list

        return view('admin.dashboard', compact(
            'pendingBlogs', 
            'activeBlogs',
            'vendorRequests', 
           'communicableVendors'
        ));
    }

    // 3. Action: Handle Vendor Onboarding Approvals
    public function handleVendorRequest(Request $request, User $user)
    {
        if ($request->action === 'approve') {
            $user->assignRole('vendor');
            return back()->with('success', 'User upgraded to Vendor.');
        }
        
        return back()->with('info', 'Vendor request denied.');
    }

    // 4. Action: Ban / Unban Users (Leveraging your status engine)
    public function toggleUserBan(User $user)
    {
        if ($user->status === 'frozen') {
            $user->update(['status' => 'active']);
            return back()->with('success', 'User account unbanned successfully.');
        }

        $user->update(['status' => 'frozen']);
        // Drop vendor rights immediately upon being banned
        $vendorRole = Role::where('name', 'vendor')->first();
        $user->roles()->detach($vendorRole->id);

        return back()->with('warning', 'User has been banned and vendor rights revoked.');
    }
}