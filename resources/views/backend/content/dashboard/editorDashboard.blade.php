@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        @php
            $name = Auth::user()->name;
        @endphp

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hai, {{ $name }}!</h1>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Artikel Berita
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newsTotal }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kategori Berita
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categoriesTotal }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Artikel Terpublikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $wasPublished }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-upload fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Perlu Peninjauan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inReview }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row align-items-stretch">

            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Berita Terbaru</h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Judul Artikel</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestNews as $news)
                                        <tr>
                                            <td><img src="{{ route('storage', $news->newsImage) }}" width="50px" height="50px">
                                            </td>
                                            <td>{{ $news->newsTitle }}</td>
                                            <td>{{ $news->category->nameCategory }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Kategori Berita</h6>
                    </div>

                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="chart-pie pt-4 pb-2 d-flex justify-content-center">
                            <canvas id="myPieChart" height="250"></canvas>
                        </div>

                        <div class="mt-4 text-center small" id="dynamicLegend"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryNames = {!! json_encode($categoryNames) !!};
            const categoryNewsCounts = {!! json_encode($categoryNewsCounts) !!};

            const ctxPie = document.getElementById('myPieChart').getContext('2d');

            const backgroundColors = [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796',
                '#5a5c69',
                '#fd7e14',
                '#6610f2',
            ];

            const colors = backgroundColors.slice(0, categoryNames.length);

            const myPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: categoryNames,
                    datasets: [{
                        data: categoryNewsCounts,
                        backgroundColor: colors,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            const legendContainer = document.getElementById('dynamicLegend');
            categoryNames.forEach((name, i) => {
                const color = colors[i];
                const span = document.createElement('span');
                span.style.marginRight = '15px';
                span.innerHTML = `<i class="fas fa-circle" style="color:${color}"></i> ${name}`;
                legendContainer.appendChild(span);
            });
        });
    </script>

@endsection