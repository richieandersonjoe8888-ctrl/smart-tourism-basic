<?php

namespace App\Http\Controllers;

// MAKE SURE THIS IS IMPORTED AT THE TOP:
use App\Models\Blog; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    // ... your index and user Registry logic stays up here ...

    /**
     * Requirement 1: Write and submit blogs for admin approval
     */
    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Creates the record inside your shared database table
        Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'pending', 
        ]);

        return back()->with('success', 'Blog article successfully submitted to the administrator moderation queue!');
    }
}