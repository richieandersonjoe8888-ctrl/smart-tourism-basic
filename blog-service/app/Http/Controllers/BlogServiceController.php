<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogServiceController extends Controller
{
    /**
     * Display a listing of published blogs for public viewing.
     */
    public function index()
    {
        // Fetch published blogs with their authors, newest first
        $blogs = Blog::with('user')->where('status', 'approved')->latest()->get();
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($id)
    {
        $blog = Blog::with(['user', 'tags'])->findOrFail($id);
        
        // Ensure the blog is approved before showing it publicly, unless the user is an admin
        if ($blog->status !== 'approved' && !(Auth::check() && Auth::user()->hasRole('admin'))) {
            abort(403, 'This blog is not available for public viewing.');
        }

        return view('blogs.show', compact('blog'));
    }

    /**
     * Action: Approve Blog from Moderation Bar
     */
    public function approve($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update(['status' => 'approved', 'moderation_reason' => null]);
        return back()->with('success', 'Blog article has been approved and published.');
    }

    /**
     * Action: Reject Blog from Moderation Bar
     */
    public function reject($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update(['status' => 'rejected']);
        return back()->with('warning', 'Blog article was rejected.');
    }

    /**
     * Action: Disable Blog from Moderation Bar
     */
    public function disable(Request $request, $id)
    {
        $request->validate([
            'moderation_reason' => 'required|string|max:1000',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->update([
            'status' => 'disabled',
            'moderation_reason' => $request->moderation_reason,
        ]);

        return back()->with('warning', 'Blog article has been disabled with reason.');
    }

    /**
     * Action: Accept binary file streams and commit articles to the database
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB restriction
        ]);

        $imagePath = null;

        // Process and isolate the article image if attached
        if ($request->hasFile('image')) {
            // Save inside the local blog-service repository: storage/app/public/articles
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        // Write directly to your shared MySQL table
        Blog::create([
            'user_id' => Auth::id(), // Reads the cookie session smoothly
            'title'   => $request->title,
            'content' => $request->content,
            'image'   => $imagePath,
            'status'  => 'pending', // Holds it in queue for admin moderation
        ]);

        // Redirect back across ports smoothly to the vendor dashboard interface
        return redirect(config('services.vendor_service.url') . '/vendor/dashboard')
            ->with('success', 'Article successfully submitted to the publication queue via Blog Service Node!');
    }
}