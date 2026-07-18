<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tag;
use App\Models\VendorApplication;
use App\Models\Blog; // IMPORT THE BLOG MODEL
use App\Models\Role; // Import Role model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 1. Fetch real pending items for moderation
        $pendingBlogs = Blog::where('status', 'pending')->with('user')->latest()->get();
        $vendorRequests = VendorApplication::where('status', 'pending')->latest()->get();

        // 2. Fetch ancillary layout data
        $activeBlogs = Blog::where('status', 'approved')->with('user')->latest()->take(10)->get();
        
        // Retrieve vendors: either currently active vendors, or frozen users who have an approved vendor application (or the default test vendor)
        $vendorQuery = User::where(function ($query) {
            $query->whereHas('roles', fn($q) => $q->where('name', 'vendor'))
                  ->orWhere(function ($q) {
                      $q->where('status', 'frozen')
                        ->where(function ($sub) {
                            $sub->whereHas('vendorApplication', fn($appQuery) => $appQuery->where('status', 'approved'))
                                ->orWhere('email', 'vendor@test.com');
                        });
                  });
        });

        // Filter by tag if selected
        if ($request->filled('tag')) {
            $vendorQuery->whereHas('tags', fn($q) => $q->where('name', $request->tag));
        }

        $communicableVendors = $vendorQuery->take(15)->get();
        $allTags = Tag::orderBy('name', 'asc')->get();

        return view('admin.dashboard', compact(
            'pendingBlogs', 
            'activeBlogs',
            'vendorRequests', 
            'communicableVendors',
            'allTags'
        ));
    }

    /**
     * Action: Moderate Submitted Blogs
     */
    public function handleBlogAction(Request $request, Blog $blog)
    {
        $request->validate(['action' => 'required|in:approve,reject']);

        if ($request->action === 'approve') {
            $blog->update(['status' => 'approved']);
            return back()->with('success', 'Blog article has been approved and published.');
        }

        $blog->update(['status' => 'rejected']);
        return back()->with('warning', 'Blog article was rejected.');
    }

    public function storeTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags,name|max:50'
        ]);

        Tag::create([
            'name' => strtolower(trim($request->name)) // Kept lowercased for uniform matching
        ]);

        return back()->with('success', 'New business tag added successfully!');
    }

    public function toggleUserBan(User $user)
    {
        if ($user->status === 'frozen') {
            $user->update(['status' => 'active']);
            
            // Restore vendor role if they had an approved application or are the default test vendor
            if ($user->vendorApplication()->where('status', 'approved')->exists() || $user->email === 'vendor@test.com') {
                $user->assignRole('vendor');
                return back()->with('success', 'Vendor account unbanned and vendor rights restored.');
            }

            return back()->with('success', 'User account unbanned successfully.');
        }

        // Before freezing, check if they are a vendor
        $isVendor = $user->hasRole('vendor');

        $user->update(['status' => 'frozen']);

        if ($isVendor) {
            // Drop vendor rights immediately upon being banned
            $vendorRole = Role::where('name', 'vendor')->first();
            if ($vendorRole) {
                $user->roles()->detach($vendorRole->id);
            }
            
            // Ensure they have an approved VendorApplication record so they stay in the table
            $user->vendorApplication()->updateOrCreate(
                [],
                [
                    'shop_name' => 'Banned Vendor Shop',
                    'physical_address' => 'Temporary Hold',
                    'business_license_number' => 'REVOKED-HOLD',
                    'status' => 'approved'
                ]
            );
        }

        return back()->with('warning', 'User has been banned and vendor rights revoked.');
    }

    public function handleApplicationAction(Request $request, VendorApplication $application)
    {
        // 1. Approve Step
        if ($request->action === 'approve') {
            $application->update(['status' => 'approved', 'admin_notes' => null]);
            $application->user->assignRole('vendor'); // Grant vendor permissions
            return back()->with('success', 'Application approved! User upgraded to Vendor.');
        }

        // 2. Revision Loop Step
        if ($request->action === 'revision') {
            $request->validate(['admin_notes' => 'required|string|max:1000']);
            $application->update([
                'status' => 'revision_required',
                'admin_notes' => $request->admin_notes
            ]);
            return back()->with('info', 'Application returned to the user for revision.');
        }

        // 3. Hard Rejection Step
        if ($request->action === 'reject') {
            $application->update([
                'status' => 'rejected',
                'admin_notes' => 'Application permanently denied due to failure of platform verification standards.'
            ]);
            return back()->with('warning', 'Application permanently rejected. Cooldown penalty applied.');
        }

        return back();
    }

    public function disableBlog(Request $request, Blog $blog)
    {
        $request->validate([
            'moderation_reason' => 'required|string|max:1000',
        ]);

        $blog->update([
            'status' => 'disabled',
            'moderation_reason' => $request->moderation_reason,
        ]);

        return back()->with('warning', 'Blog article has been disabled with reason.');
    }
}