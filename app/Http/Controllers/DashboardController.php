<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interaction;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard based on the user's role.
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user->role) {
            abort(403, 'No role assigned');
        }

        switch ($user->role->name) {

            // ================= ADMIN DASHBOARD =================
            case 'Admin':
                // Total employees
                $totalEmployees = User::count();

                // Total interactions in the system
                $totalInteractions = Interaction::count();

                // Average score of all interactions
                $avgScore = Interaction::avg('unified_score');

                // Latest 5 interactions with employee relationship
                $latestInteractions = Interaction::with('employee')
                    ->latest()
                    ->take(5)
                    ->get();

                return view('dashboard.index', compact(
                    'totalEmployees',
                    'totalInteractions',
                    'avgScore',
                    'latestInteractions'
                ));

            // ================= EMPLOYEE DASHBOARD =================
            case 'Employee':
                // Total interactions handled by this employee
                $myInteractions = Interaction::where('employee_id', $user->id)->count();

                // Average score of this employee
                $avgScore = Interaction::where('employee_id', $user->id)
                    ->avg('unified_score');

                // Recent interactions for table (last 5)
                $recentInteractions = Interaction::where('employee_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();

                return view('dashboard.employee', compact(
                    'myInteractions',
                    'avgScore',
                    'recentInteractions'
                ));

            // ============= BRANCH MANAGER DASHBOARD ============
            case 'Branch Manager':
                // Total employees under this manager's branch
                $totalEmployees = User::where('branch_id', $user->branch_id)->count();

                // Total interactions under this manager's branch
                $totalInteractions = Interaction::whereHas('employee', function ($q) use ($user) {
                    $q->where('branch_id', $user->branch_id);
                })->count();

                // Average score for this branch
                $avgScore = Interaction::whereHas('employee', function ($q) use ($user) {
                    $q->where('branch_id', $user->branch_id);
                })->avg('unified_score');

                // Latest 5 interactions for this branch
                $latestInteractions = Interaction::with('employee')
                    ->whereHas('employee', function ($q) use ($user) {
                        $q->where('branch_id', $user->branch_id);
                    })
                    ->latest()
                    ->take(5)
                    ->get();

                return view('dashboard.manager', compact(
                    'totalEmployees',
                    'totalInteractions',
                    'avgScore',
                    'latestInteractions'
                ));

            // ================= SUPERVISOR DASHBOARD =================
            case 'Supervisor':
                // Interactions handled by supervisor directly
                $myInteractions = Interaction::where('employee_id', $user->id)->count();

                // Average score of supervisor's handled interactions
                $avgScore = Interaction::where('employee_id', $user->id)
                    ->avg('unified_score');

                // Latest 5 interactions for table
                $recentInteractions = Interaction::where('employee_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();

                return view('dashboard.supervisor', compact(
                    'myInteractions',
                    'avgScore',
                    'recentInteractions'
                ));

            default:
                abort(403, 'Unauthorized');
        }
    }
}