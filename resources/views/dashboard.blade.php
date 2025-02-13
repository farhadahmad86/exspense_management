@extends('layouts.app', ['pageSlug' => 'dashboard', 'page' => 'Dashboard', 'section' => ''])

@section('content')
    <!-- Loader -->
    <div id="loader" class="loader">
        <img src="{{ asset(session('company_logo', 'default-logo.png')) }}" alt="Loading...">
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Total Sales Chart -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Total Sales vs Total Purchases</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="totalSalesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Monthly Sales Chart -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Monthly Sales</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Daily Sales Chart -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daily Sales</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide the loader once the content is fully loaded
            const loader = document.getElementById('loader');

            // Total Sales and Purchases
            const totalSales = @json($totalSales);
            const totalPurchases = @json($totalPurchase);

            // Monthly Sales Data
            const monthlySalesLabels = @json($monthlySales['labels']);
            const monthlySalesValues = @json($monthlySales['values']);

            // Daily Sales Data
            const dailySalesLabels = @json($dailySales['labels']);
            const dailySalesValues = @json($dailySales['values']);

            // Total Sales Chart
            new Chart(document.getElementById('totalSalesChart'), {
                type: 'pie',
                data: {
                    labels: ['Sales', 'Purchases'],
                    datasets: [{
                        label: 'Total Sales vs Total Purchases',
                        data: [totalSales, totalPurchases],
                        backgroundColor: ['#36a2eb', '#ff6384']
                    }]
                }
            });

            // Monthly Sales Chart
            new Chart(document.getElementById('monthlySalesChart'), {
                type: 'bar',
                data: {
                    labels: monthlySalesLabels,
                    datasets: [{
                        label: 'Monthly Sales',
                        data: monthlySalesValues,
                        backgroundColor: '#36a2eb'
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Daily Sales Chart
            new Chart(document.getElementById('dailySalesChart'), {
                type: 'line',
                data: {
                    labels: dailySalesLabels,
                    datasets: [{
                        label: 'Daily Sales',
                        data: dailySalesValues,
                        borderColor: '#ff6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Hide the loader after charts are initialized
            loader.style.display = 'none';
        });
    </script>
@endsection

<style>
    /* Loader Styles */
    .loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loader img {
        width: 100px; /* Adjust size as needed */
        height: auto;
    }
</style>
