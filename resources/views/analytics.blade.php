@include('layouts.header')


<div class="container-fluid mt-4" style="font-size: 10px;">
    {{-- <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col text-center">
            <h1 class="display-5 text-primary fw-bold">Admin Dashboard</h1>
            <p class="lead text-muted">Monitor and manage your units effectively</p>
        </div>
    </div> --}}

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title text-success text-center fw-bold">Total Units</h5>
                    <p class="card-text text-center fs-1">{{ $totalUnits }}</p>
                    <i class="bi bi-box-seam d-block text-center fs-2 text-muted"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary text-center fw-bold">Recent Additions</h5>
                    <p class="card-text text-center fs-1">{{ $recentAdditions }}</p>
                    <i class="bi bi-calendar-check d-block text-center fs-2 text-muted"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title text-warning text-center fw-bold">Pulled Units</h5>
                    <p class="card-text text-center fs-1">{{ $pulledUnits }}</p>
                    <i class="bi bi-arrow-up-circle d-block text-center fs-2 text-muted"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title text-danger text-center fw-bold">Critical Issues</h5>
                    <p class="card-text text-center fs-1">{{ $criticalIssues }}</p>
                    <i class="bi bi-exclamation-circle d-block text-center fs-2 text-muted"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Recent Units Section -->
    <div class="row mb-5">
        <div class="col">
            <h2 class="text-center">Recent Units</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered shadow rounded">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Company</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Serial Number</th>
                            <th>Date Added</th>
                            <th>Date Pulled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUnits as $unit)
                            <tr>
                                <td>{{ $unit->company }}</td>
                                <td>{{ $unit->sku }}</td>
                                <td>{{ $unit->categ }}</td>
                                <td>{{ $unit->ser_no }}</td>
                                <td>{{ $unit->date_add }}</td>
                                <td>{{ $unit->date_pull }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    <!-- Charts Section -->
    <div class="row mb-5">
        {{-- <!-- Bar Chart -->
        <div class="col-lg-6">
            <h2 class="text-center">Unit Statistics by Location</h2>
            <div class="chart-container mx-auto" style="max-width: 100%;">
                <canvas id="unitChart"></canvas>
            </div>
        </div> --}}

        <!-- Pie Chart -->
        <div class="col-lg-6">
            {{-- <h2 class="text-center">Unit Distribution by Brand</h2> --}}
            @if(!empty($chartData['labels']) && !empty($chartData['series']))
                <div id="pieChart" class="chart-container mx-auto" style="max-width: 100%;"></div>
            @else
                <p class="text-center text-muted">No data available to display the chart.</p>
            @endif
        </div>
    </div>

    <!-- Units by Category -->
    <div class="row mb-5">
        {{-- <h2 class="text-center mb-4">Units by Category</h2> --}}
        <div class="row g-4">
            @foreach($categoryTotals as $category => $total)
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary fw-bold">{{ $category }}</h5>
                            <p class="card-text">
                                <span class="badge bg-success">{{ $total }}</span> Units
                            </p>
                            <i class="bi bi-box-seam fs-1 text-secondary"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    // Bar Chart for Location Statistics
    const unitStatistics = @json($unitStatistics);
    const locationLabels = unitStatistics.map(stat => stat.location);
    const locationData = unitStatistics.map(stat => stat.total_units);

    const ctx = document.getElementById('unitChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: locationLabels,
            datasets: [{
                label: 'Units by Location',
                data: locationData,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // Pie Chart for Brand Distribution
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData);
        const options = {
            chart: {
                type: 'pie'
            },
            series: chartData.series.length ? chartData.series : [0],
            labels: chartData.labels.length ? chartData.labels : ['No Data'],
            title: {
                text: 'Unit Distribution by Brand'
            }
        };

        new ApexCharts(document.querySelector("#pieChart"), options).render();
    });
</script>

@include('layouts.footer')
@include('layouts.script')
