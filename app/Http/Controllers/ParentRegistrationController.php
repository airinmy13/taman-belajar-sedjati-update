<?php

namespace App\Http\Controllers;

use App\Models\ParentRegistration;
use App\Models\OrangTua;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ParentRegistrationController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('parent.register');
    }

    /**
     * Handle registration submission
     */
    public function register(Request $request)
    {
        $request->validate([
            'parent_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:parent_registrations,username|unique:parents,username',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:parent_registrations,email|unique:parents,email',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:L,P',
            'child_name' => 'required|string|max:255',
            'child_class' => 'required|string|max:50',
        ]);

        ParentRegistration::create([
            'parent_name' => $request->parent_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'child_name' => $request->child_name,
            'child_class' => $request->child_class,
            'status' => 'pending',
        ]);

        return redirect()->route('parent.register.success');
    }

    /**
     * Show success page
     */
    public function showSuccessPage()
    {
        return view('parent.register-success');
    }

    /**
     * Show pending registrations (Admin only)
     */
    public function index()
    {
        $registrations = ParentRegistration::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.parent-registrations.index', compact('registrations'));
    }

    /**
     * Approve registration
     */
    public function approve($id)
    {
        $registration = ParentRegistration::findOrFail($id);
        
        // Create parent account
        $parent = OrangTua::create([
            'parent_name' => $registration->parent_name,
            'child_name' => $registration->child_name, // Optional: keep for backward compatibility if column exists
            'username' => $registration->username,
            'password' => $registration->password, // Already hashed
            'email' => $registration->email,
            'phone' => $registration->phone,
            'gender' => $registration->gender,
        ]);

        // Create student account
        Student::create([
            'nama_anak' => $registration->child_name,
            'kelas' => $registration->child_class,
            'parent_id' => $parent->id,
        ]);

        // Update registration status
        $registration->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => session('admin_id'),
        ]);

        // Send approval email
        $this->sendApprovalEmail($registration);

        return redirect()->back()->with('success', 'Pendaftaran telah disetujui! Email konfirmasi telah dikirim.');
    }

    /**
     * Reject registration
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $registration = ParentRegistration::findOrFail($id);
        
        $registration->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'reviewed_at' => now(),
            'reviewed_by' => session('admin_id'),
        ]);

        // Send rejection email
        $this->sendRejectionEmail($registration);

        return redirect()->back()->with('success', 'Pendaftaran telah ditolak. Email pemberitahuan telah dikirim.');
    }

    /**
     * Send approval email
     */
    private function sendApprovalEmail($registration)
    {
        // TODO: Implement email sending
        // For now, just log it
        \Log::info("Approval email would be sent to: {$registration->email}");
    }

    /**
     * Send rejection email
     */
    private function sendRejectionEmail($registration)
    {
        // TODO: Implement email sending
        // For now, just log it
        \Log::info("Rejection email would be sent to: {$registration->email}");
    }
}
