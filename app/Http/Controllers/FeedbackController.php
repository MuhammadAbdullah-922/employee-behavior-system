<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Interaction;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Ensure user is logged in
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List all feedbacks (for admin)
    public function index()
    {
        // Fetch all feedback with related employee and interaction
        $feedbacks = Feedback::with('employee', 'interaction')->latest()->get();

        return view('feedbacks.index', compact('feedbacks'));
    }

    // Show feedback form for customer via QR code
    public function createCustomerFeedback($interaction_id)
    {
        $interaction = Interaction::findOrFail($interaction_id);
        return view('feedbacks.qr_form', compact('interaction'));
    }

    // Store feedback submitted by customer
    public function storeCustomerFeedback(Request $request, $interaction_id)
    {
        // Validation
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Find interaction
        $interaction = Interaction::findOrFail($interaction_id);

        // Create feedback
        $interaction->feedback()->create([
            'customer_rating' => $request->rating,
            'comments' => $request->comment,
            'employee_id' => $interaction->employee_id,
        ]);

        // Convert rating (1–5) to score (0–100)
        $interaction->feedback_score = $request->rating * 20;

        // Calculate unified score (this already saves)
        $interaction->calculateUnifiedScore();

        // Redirect back with success message
        return redirect()
            ->route('feedback.customer.create', $interaction_id)
            ->with('success', 'Thank you for your feedback!');
    }
}