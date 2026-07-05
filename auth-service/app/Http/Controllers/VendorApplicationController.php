<?php

namespace App\Http\Controllers;

use App\Models\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorApplicationController extends Controller
{
    /**
     * Render the application page based on current application state.
     */
    public function showForm()
    {
        $user = Auth::user();
        $application = $user->vendorApplication;

        // Redirect if they are already fully verified vendors
        if ($user->hasRole('vendor') || ($application && $application->status === 'approved')) {
            return redirect()->route('dashboard')->with('info', 'You are already an approved vendor!');
        }

        // If a pending review is active, show a landing/waiting page instead of the form
        if ($application && $application->status === 'pending') {
            return view('vendor-application.waiting');
        }

        // Render the form page (passes existing model details if 'revision_required' or 'rejected')
        return view('vendor-application.form', compact('application'));
    }

    /**
     * Process fresh submissions and revision resubmissions.
     */
    public function storeApplication(Request $request)
    {
        $user = Auth::user();
        $application = $user->vendorApplication;

        // 1. Anti-troll state evaluations
        if ($application) {
            if ($application->status === 'pending') {
                return back()->withErrors(['message' => 'You already have an application under review.']);
            }
            if ($application->status === 'rejected' && $application->updated_at->gt(now()->subDays(7))) {
                $daysLeft = 7 - $application->updated_at->diffInDays(now());
                return back()->withErrors(['message' => "Your application was permanently rejected. Please wait {$daysLeft} more days to try again."]);
            }
        }

        // 2. Validate input constraints
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'physical_address' => 'required|string|max:500',
            'business_license_number' => 'required|string|max:100',
            'honeypot_check_field' => 'nullable|string|max:10' // Hidden bot safeguard
        ]);

        // 3. Evaluate Honeypot field
        if ($request->filled('honeypot_check_field')) {
            abort(422, 'Spam request blocked.');
        }

        // 4. Update existing application or create a new one (Ensures maximum 1 record per user)
        VendorApplication::updateOrCreate(
            ['user_id' => $user->id],
            [
                'shop_name' => $request->shop_name,
                'physical_address' => $request->physical_address,
                'business_license_number' => $request->business_license_number,
                'status' => 'pending', // Reverts 'revision_required' straight back to 'pending'
                'admin_notes' => null,  // Clear old admin complaints since they fixed it
            ]
        );

        return redirect()->route('vendor.apply.form')->with('success', 'Your application was successfully submitted for administrative evaluation!');
    }
}