@extends('admin.layouts.layout')
@section('title', env('APP_GLOBAL_NAME'))
@section('content')
    <div class="container">
        <div class="page-inner">

            <!-- Total Users,Active Users,Inactive Users,Total Documents     start  -->

            <div class="row mt-4 mt-lg-3 mb-lg-2 d-md-flex mt-lg-5 justify-content-evenly">
                <!-- Total Users -->
                <div class="typeofusers col-md-2 border-2 py-3 d-flex flex-column align-items-center shadow-sm mb-4 mx-2"
                    style="background-color: white; border-radius: 8px;">
                    <i class="bi bi-people fs-1 text-primary"></i>
                    <h3 class="my-2">{{$totalEmployeeCount}}</h3>
                    <p>Total Users</p>
                </div>

                <!-- Active Users -->
                <div class="typeofusers col-md-2 border-2 py-3 d-flex flex-column align-items-center shadow-sm mb-4 mx-2"
                    style="background-color: white; border-radius: 8px;">
                    <i class="bi bi-person-check fs-1 text-success"></i>
                    <h3 class="my-2">{{$activeEmployeeCount}}</h3>
                    <p>Active Users</p>
                </div>

                <!-- Inactive Users -->
                <div class="typeofusers col-md-2 border-2 py-3 d-flex flex-column align-items-center shadow-sm mb-4 mx-2"
                    style="background-color: white; border-radius: 8px;">
                    <i class="bi bi-person-x fs-1 text-warning"></i>
                    <h3 class="my-2">{{$inActiveEmployeeCount}}</h3>
                    <p>Inactive Users</p>
                </div>

                <!-- Total Documents -->
                <div class="typeofusers col-md-2 border-2 py-3 d-flex flex-column align-items-center shadow-sm mb-4 mx-2"
                    style="background-color: white; border-radius: 8px;">
                    <i class="bi bi-file-earmark-text fs-1 text-danger"></i>
                    <h3 class="my-2">{{$documentCount}}</h3>
                    <p>Total Documents</p>
                </div>
            </div>

            <!-- Total Users,Active Users,Inactive Users,Total Documents     start  -->


            <!-- Documents piechart start =============================================================-->

            <div class="d-flex justify-content-center px-5 mt-lg-3 mb-lg-5">
                <div class="container-fluid"
                    style="background-color: rgb(255, 255, 255); border-radius: 10px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="text mb-0 m-3">Type Of Documents</h2>
                    </div>
                    <div class="chart-container">
                        <canvas id="myChart" class="mt-2"></canvas>
                    </div>
                </div>
            </div>



            <!-- Documents piechart end =================================================================-->

            <!-- type of sections start ====================================================================================================================================================================================================-->
            <div class="d-flex justify-content-center px-4  mt-lg-3 mb-lg-5 mt-md-5 mt-3">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card py-lg-3">
                            <div class="card-header">
                                <h4 class="card-title">Type Of Sections</h4>
                            </div>
                            <!-- new section start ============================================================================================================================================================================================================-->
                            <div class="row">
                                @foreach($sectionDocs as $doc)
                                  <div class="col-sm-6 col-lg-3">
                                    <div class="card p-2 my-2 mx-3">
                                      <div class="d-flex align-items-center">
                                        <span class="stamp stamp-md me-3">
                                          <i class="fa fas fa-file"></i>
                                        </span>
                                        <div>
                                          <h5 class="mb-1">
                                            <b><a href="#">{{ $doc->documents->count() }} <small>{{ $doc->name }}</small></a></b>
                                          </h5>
                                          <small class="text-muted">last update : <span>{{ $doc->updated_at->format('d/m/Y') }}</span></small>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                @endforeach
                            <!-- row end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- type of sections end ====================================================================================================================================================================================================-->


        <!-- insert the contents here start -->
            <!-- ***** -->







            <!-- ***** -->
        <!-- insert the contents here end -->


            

            <!-- page inner end-->
        </div>
      <!-- container end -->
    </div>
     <!-- script for random section color start-->
     <script>
        document.addEventListener("DOMContentLoaded", function () {
        // Get all span elements with the class 'stamp'
        const stamps = document.querySelectorAll(".stamp");

        stamps.forEach(function (stamp) {
           // Generate a random color
           const randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16);

           // Apply the random color as the background color of the span
           stamp.style.backgroundColor = randomColor;
        });
        });
     </script>
    <!-- type of doc start -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        // Parse the data from PHP to JavaScript
        var navigationDocs = @json($navigationDocsJson);
    
        // Extract names and document counts for labels and data
        var labels = navigationDocs.map(function(doc) {
            return doc.name;
        });
    
        var data = navigationDocs.map(function(doc) {
            return doc.document_count; // Use document count for data points
        });
    
        var ctx = document.getElementById('myChart').getContext('2d');
    
        // Find the maximum value in the dataset
        var maxValue = Math.max(...data);
    
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Use dynamic labels
                datasets: [{
                    label: 'Documents',
                    data: data, // Use dynamic data points
                    backgroundColor: '#435ebe',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 0
                        }
                    },
                    y: {
                        beginAtZero: true,
                        
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: true // Enable tooltips if needed
                    },
                    padding: {
                        bottom: 30 // Adds a 30px margin at the bottom of the title
                    },
                    datalabels: {
                        display: true,
                        align: 'end',
                        anchor: 'end',
                        color: '#435ebe',
                        font: {
                            weight: 'bold',
                            size: 20
                        },
                        formatter: function (value, context) {
                            return value;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
    <!-- type of doc end -->
@endsection
