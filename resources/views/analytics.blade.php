@include('layouts.header')


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
            <div class="card-body" >
                <div id="barChart" style="height: 100%;"></div>
            </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Latest News and Updates</h5>
                </div>
                <div class="card-body">
                    <ul id="newsList" class="list-group">
                        <!-- News items will be dynamically loaded here -->
                    </ul>
                </div>
            </div>
        </div>
        <script>
            fetch('/api/allocation-chart-data')
                .then(response => response.json())
                .then(data => {
                    console.log('Chart Data:', data);
            
                    const categories = data.map(item => item.allocation ?? 'Unknown');
                    const seriesData = data.map(item => item.total_count ?? 0);
                    const colors = ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A133FF', '#33FFF5', '#FFC733', '#FF3333']; // Add unique colors
            
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 400,
                            toolbar: {
                                show: true
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                barHeight: '70%',
                                distributed: true // Enable unique colors for each bar
                            }
                        },
                        colors: colors, // Apply the colors array
                        series: [{
                            name: 'Quantity',
                            data: seriesData
                        }],
                        xaxis: {
                            categories: categories,
                            labels: {
                                style: {
                                    fontSize: '10px',
                                    colors: colors // Match label colors with bars
                                }
                            },
                            title: {
                                text: 'Allocations',
                                style: {
                                    fontSize: '10px',
                                    fontWeight: 'bold'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    fontSize: '10px'
                                }
                            },
                            title: {
                                text: 'Quantity',
                                style: {
                                    fontSize: '10px',
                                    fontWeight: 'bold'
                                }
                            }
                        },
                        title: {
                            text: 'Allocation Chart',
                            align: 'left',
                            style: {
                                fontSize: '10px',
                                fontWeight: 'bold'
                            }
                        },
                        tooltip: {
                            theme: 'dark',
                            y: {
                                formatter: function (val) {
                                    return val + " units";
                                }
                            }
                        },
                        legend: {
                            show: false
                        }
                    };
            
                    const chart = new ApexCharts(document.querySelector("#barChart"), options);
                    chart.render();
                })
                .catch(error => console.error('Error loading chart data:', error));
        </script>
            
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="categChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="pmgChart"></div>
                </div>
            </div>
        </div>
  

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('/api/news')
            .then(response => response.json())
            .then(data => {
                const newsList = document.getElementById('newsList');
                if (newsList) {
                    data.forEach(newsItem => {
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item';
                        listItem.textContent = newsItem.title ?? 'No Title Available';
                        newsList.appendChild(listItem);
                    });
                } else {
                    console.error("News list container not found!");
                }
            })
            .catch(error => console.error('Error loading news data:', error));
    });
    </script>
    </div>
</div>

   

    {{-- <!-- Additional Design -->
    <div id="lineChart" style="flex: 1 1 45%; max-width: 45%; min-width: 300px; margin: auto;"></div>
    <script>
        fetch('/api/line-chart-data')
            .then(response => response.json())
            .then(data => {
                const categories = data.map(item => item.date ?? 'Unknown');
                const seriesData = data.map(item => item.value ?? 0);

                const options = {
                    chart: {
                        type: 'line',
                        height: 400,
                        toolbar: {
                            show: true
                        }
                    },
                    series: [{
                        name: 'Value',
                        data: seriesData
                    }],
                    xaxis: {
                        categories: categories,
                        title: {
                            text: 'Date',
                            style: {
                                fontSize: '14px',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Value',
                            style: {
                                fontSize: '14px',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    title: {
                        text: 'Line Chart Example',
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold'
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#lineChart"), options);
                chart.render();
            })
            .catch(error => console.error('Error loading line chart data:', error));
    </script> --}}

    {{-- <div id="pieChart" style="flex: 1 1 45%; max-width: 45%; min-width: 300px; margin: auto;"></div>
    <script>
        fetch('/api/pie-chart-data')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.label ?? 'Unknown');
                const seriesData = data.map(item => item.value ?? 0);

                const options = {
                    chart: {
                        type: 'pie',
                        height: 400
                    },
                    series: seriesData,
                    labels: labels,
                    title: {
                        text: 'Pie Chart Example',
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold'
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " units";
                            }
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#pieChart"), options);
                chart.render();
            })
            .catch(error => console.error('Error loading pie chart data:', error));
    </script> --}}
    <script>
    fetch('/api/categ-chart-data')
        .then(response => response.json())
        .then(data => {
            const categories = [...new Set(data.map(item => item.company ?? 'Unknown'))];
            const series = categories.map(category => {
                const categoryData = data.filter(item => item.company === category);
                return {
                    name: category,
                    data: categoryData.map(item => item.total_company ?? 0)
                };
            });

            const formattedDates = data.map(item => {
                const date = new Date(item.created_at);
                if (!isNaN(date.getTime())) {
                    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                } else {
                    console.error("Invalid date format:", item.created_at);
                    return 'Invalid Date';
                }
            });

            const options = {
                chart: {
                    type: 'line',
                    height: 400,
                    toolbar: {
                        show: true
                    }
                },
                series: series,
                xaxis: {
                    categories: formattedDates,
                    title: {
                        text: 'Date',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Total Units',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold'
                        }
                    }
                },
                title: {
                    text: 'Unit Category Distribution',
                    align: 'center',
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " units";
                        }
                    }
                }
            };

            const chartElement = document.querySelector("#categChart");
            if (chartElement) {
                const chart = new ApexCharts(chartElement, options);
                chart.render();
            } else {
                console.error("Chart container not found!");
            }
        })
        .catch(error => console.error('Error loading Categ chart data:', error));
    </script>

<script>
fetch('/api/pmg-chart-data')
    .then(response => response.json())
    .then(data => {
        const labels = data.map(item => item.pmg_stats ?? 'Unknown');
        const seriesData = data.map(item => item.total ?? 0);

        const options = {
            chart: {
                type: 'donut',
                height: 400
            },
            series: seriesData,
            labels: labels,
            title: {
                text: 'PMG Stats Distribution',
                align: 'center'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " units";
                    }
                }
            }
        };

        const chartElement = document.querySelector("#pmgChart");
        if (chartElement) {
            const chart = new ApexCharts(chartElement, options);
            chart.render();
        } else {
            console.error("Chart container not found!");
        }
    })
    .catch(error => console.error('Error loading PMG chart data:', error));
</script>
    
@include('layouts.script')
