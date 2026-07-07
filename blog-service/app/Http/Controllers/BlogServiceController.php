<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogServiceController extends Controller
{
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
        return redirect('http://127.0.0.1:7777/vendor/dashboard')
            ->with('success', 'Article successfully submitted to the publication queue via Blog Service Node!');
    }
}