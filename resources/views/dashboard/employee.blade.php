@extends('dashboard.admin')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">My Performance Dashboard</h3>

    <!-- Overview Cards -->
    <div class="row mb-4">

        <!-- My Interactions -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm border-0">
                <h6 class="text-muted">My Interactions</h6>
                <h3 class="text-primary">{{ $myInteractions }}</h3>
                <small class="text-muted">Total handled</small>
            </div>
        </div>

        <!-- Average Score -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm border-0">
                <h6 class="text-muted">Average Score</h6>
                <h3 class="text-success">{{ number_format($avgScore ?? 0, 2) }}%</h3>
                <small class="text-muted">Overall performance</small>
            </div>
        </div>

        <!-- Performance Status -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm border-0">
                <h6 class="text-muted">Performance Level</h6>
                <h3 class="text-info">
                    @if(($avgScore ?? 0) >= 80)
                        Excellent
                    @elseif(($avgScore ?? 0) >= 60)
                        Good
                    @else
                        Needs Improvement
                    @endif
                </h3>
                <small class="text-muted">Based on score</small>
            </div>
        </div>

    </div>

    <!-- My Recent Interactions -->
    <div class="card p-4 shadow-sm border-0 mb-4">
        <h5>My Recent Interactions</h5>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Score</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentInteractions as $interaction)
                <tr>
                    <td>{{ $interaction->customer_name ?? 'N/A' }}</td>
                    <td>{{ $interaction->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-primary">
                            {{ number_format($interaction->unified_score ?? 0, 0) }}%
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No interactions yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Progress Circle -->
    <div class="card p-4 shadow-sm border-0">
        <h5>Overall Performance</h5>

        <div class="d-flex justify-content-center mt-3">
            <div style="width: 180px; height: 180px;">
                <svg viewBox="0 0 36 36">

                    <path stroke="#eee" stroke-width="3.8" fill="none"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />

                    <path stroke="#0d6efd" stroke-width="3.8" fill="none"
                        stroke-dasharray="{{ number_format($avgScore ?? 0, 0) }}, 100"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />

                    <text x="18" y="20.35" text-anchor="middle" font-size="4">
                        {{ number_format($avgScore ?? 0, 0) }}%
                    </text>

                </svg>
            </div>
        </div>
    </div>

</div>

@endsection