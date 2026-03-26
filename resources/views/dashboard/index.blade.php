@extends('dashboard.admin')

@section('content')

<div class="container-fluid">

    <!-- Overview Cards -->
    <div class="row mb-4">

        <!-- Total Employees -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Total Employees</h6>
                <h3>{{ $totalEmployees }}</h3>
                <small class="text-success">System Data</small>
            </div>
        </div>

        <!-- Total Interactions -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Total Interactions</h6>
                <h3>{{ $totalInteractions }}</h3>
                <small class="text-success">System Data</small>
            </div>
        </div>

        <!-- Average Score -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Average Score</h6>
                <h3>{{ number_format($avgScore ?? 0, 2) }}</h3>
                <small class="text-info">Performance</small>
            </div>
        </div>

        <!-- Resources -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Resources</h6>
                <h3>{{ $totalEmployees }}</h3>
                <small class="text-success">Active Users</small>
            </div>
        </div>

    </div>

    <!-- Latest Interactions -->
    <div class="card p-4 shadow-sm mb-4">
        <h5>Latest Interactions</h5>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Score</th>
                </tr>
            </thead>

            <tbody id="interactionTable">
                @forelse($latestInteractions as $interaction)
                <tr class="employee-row">
                    <td class="emp-name">{{ $interaction->customer_name ?? 'N/A' }}</td>
                    <td>{{ $interaction->employee->name ?? 'N/A' }}</td>
                    <td>{{ $interaction->created_at->format('d M Y') }}</td>

                    <td>
                        <span class="badge bg-success">Completed</span>
                    </td>

                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-success"
                                 style="width: {{ $interaction->unified_score ?? 0 }}%">
                                {{ number_format($interaction->unified_score ?? 0, 0) }}%
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No interactions found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Overall Progress -->
    <div class="card p-4 shadow-sm">
        <h5>Overall Progress</h5>

        <div class="d-flex justify-content-center align-items-center mt-3">
            <div style="width: 200px; height: 200px; position: relative;">

                <svg viewBox="0 0 36 36" class="circular-chart">

                    <path class="circle-bg"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />

                    <path class="circle"
                        stroke-dasharray="{{ number_format($avgScore ?? 0, 0) }}, 100"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />

                    <text x="18" y="20.35" class="percentage">
                        {{ number_format($avgScore ?? 0, 0) }}%
                    </text>

                </svg>

            </div>
        </div>
    </div>

</div>

<!-- 🔍 SEARCH SCRIPT -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll(".employee-row");

    rows.forEach(row => {
        let name = row.querySelector(".emp-name").innerText.toLowerCase();

        if (name.includes(value)) {
            row.style.display = "";
            row.style.backgroundColor = "#fff3cd"; // highlight
        } else {
            row.style.display = "none";
        }
    });
});
</script>

<style>
.circular-chart {
    display: block;
    margin: 10px auto;
    max-width: 200px;
}
.circle-bg {
    fill: none;
    stroke: #eee;
    stroke-width: 3.8;
}
.circle {
    fill: none;
    stroke-width: 3.8;
    stroke-linecap: round;
    stroke: #f4b400;
}
.percentage {
    fill: #333;
    font-size: 0.5em;
    text-anchor: middle;
}
</style>

@endsection