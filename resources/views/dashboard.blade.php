@include('layouts.header')
<body>
    <div id="company-chart" style="width: 100%; height: 400px;"></div>
    <div id="unit-status-chart" style="width: 100%; height: 400px;"></div>
    <div id="pmg-stats-chart" style="width: 100%; height: 400px;"></div>
    <div id="sales-stats-chart" style="width: 100%; height: 400px;"></div>
    <div id="allocation-chart" style="width: 100%; height: 400px;"></div>
    <script>
        async function fetchChartData() {
            const response = await fetch('/getChartData'); // Adjust endpoint as needed
            return response.json(); // Get data in JSON format
        }
    
        // Function to render individual charts
        function renderChart(containerId, title, labels, data) {
            const chartData = {
                categories: [title],
                series: labels.map((label, index) => ({ name: label, data: data[index] })),
            };
    
            const options = {
                chart: {
                    title: title,
                    width: 700,
                    height: 400,
                },
                legend: {
                    align: 'bottom',
                },
            };
    
            const container = document.getElementById(containerId);
            toastui.Chart.pieChart({ el: container, data: chartData, options });
        }
    
        async function initCharts() {
            // Fetch data from the API
            const data = await fetchChartData();
    
            // Render charts for each dataset
            renderChart(
                'company-chart',
                'Company Distribution',
                Object.keys(data.companies),
                Object.values(data.companies)
            );
            renderChart(
                'unit-status-chart',
                'Unit Status',
                Object.keys(data.unitStatus),
                Object.values(data.unitStatus)
            );
            renderChart(
                'pmg-stats-chart',
                'PMG Stats',
                Object.keys(data.pmgStats),
                Object.values(data.pmgStats)
            );
            renderChart(
                'sales-stats-chart',
                'Sales Stats',
                Object.keys(data.salesStats),
                Object.values(data.salesStats)
            );
            renderChart(
                'allocation-chart',
                'Allocation Distribution',
                Object.keys(data.allocations),
                Object.values(data.allocations)
            );
        }
    
        // Initialize charts when the page loads
        document.addEventListener('DOMContentLoaded', initCharts);
    </script>
    
@include('layouts.footer')

    @include('layouts.script')
</body>
</html>