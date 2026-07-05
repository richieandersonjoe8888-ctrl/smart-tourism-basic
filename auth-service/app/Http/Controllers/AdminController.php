<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tag;
use App\Models\VendorApplication;
use App\Models\Blog; // IMPORT THE BLOG MODEL
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
        $vendorQuery = User::whereHas('roles', fn($q) => $q->where('name', 'vendor'));
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

    // ... leave your toggleUserBan and handleApplicationAction methods below untouched ...
}