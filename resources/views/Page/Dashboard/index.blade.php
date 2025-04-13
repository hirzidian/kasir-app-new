@extends('template')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (Auth::user()->role == 'Petugas')
                        <h3>Selamat Datang, {{ Auth::user()->name }}</h3>
                        <div class="card d-block m-auto text-center">
                            <div class="card-header">
                                Total Penjualan Hari Ini
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">{{ $count }}</h3>
                                <p class="card-text">Jumlah total penjualan yang terjadi hari ini.</p>
                            </div>
                            <div class="card-footer text-muted">
                                Terakhir diperbarui: {{ $date }}
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <h3>Selamat Datang, Administrator!</h3>
                            <div class="row">
                                <div class="col-8">
                                    <canvas id="myChart" width="384" height="192"></canvas>
                                </div>
                                <div class="col-4">
                                    <canvas id="myChart2" width="192" height="192"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartTransaction = {!! json_encode($chartTransaction) !!};
        const chartProduct = {!! json_encode($chartProduct) !!};

        let date = [];
        let count = [];
        let product = [];
        let productCount = [];

        Object.values(chartTransaction).forEach(element => {
            date.push(element.date);
            count.push(element.count);
        });

        Object.values(chartProduct).forEach(element => {
            product.push(element.productName);
            productCount.push(element.productCount);
        });

        console.log(chartTransaction); // Debug to check if chartTransaction data is correct
        console.log(chartProduct); // Debug to check if chartProduct data is correct

        // Bar chart for transactions
        const ctx = document.getElementById('myChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik
            data: {
                labels: date, // Menggunakan data dari controller
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: count, // Menggunakan data dari controller
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie chart for product sales distribution
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const productChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: product,
                datasets: [{
                    label: 'Persentase Penjualan Produk',
                    data: productCount,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Persentase Penjualan Produk'
                    }
                }
            }
        });
    </script>
@endsection
