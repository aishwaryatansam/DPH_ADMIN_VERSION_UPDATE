@extends('admin.layouts.layout')
@section('title', 'View Programs')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}" />
    </head>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View AboutUs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <div class="container-fluid mt-2">
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <h4 class="card-title mb-4 text-primary">View AboutUs</h4>

                        <!-- Content Display in Grid -->
                        <div class="d-grid gap-3 mb-3 grid-3 grid-2 grid-1">

                            <div>
                                <label class="form-label">Content Type</label>
                                <p>{{ $result->submenu->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="form-label">Title</label>
                                <p>{{ $result->name }}</p>
                            </div>

                            @if($result->thumbnail_name)
                            <div>
                                <label class="form-label">Order</label>
                                <p>{{ $result->order_no }}</p>
                            </div>
                            @endif

                            @if($result->document_url)
                            <!-- PDF Document -->
                            <div>
                                <label class="form-label">Document</label>
                                @if($result->document_url)
                                    <a href="{{ fileLink($result->document_url) }}" target="_blank" class="btn btn-link">View PDF</a>
                                @else
                                    <p>N/A</p>
                                @endif
                            </div>
                            @endif

                            <!-- Image Display -->

                            @if($result->document_url)
                            <div>
                                <label class="form-label">Image</label>
                                @if($result->image_url)
                                    <a href="{{ fileLink($result->image_url) }}" target="_blank" class="btn btn-link">View Image</a>
                                @else
                                    <p>N/A</p>
                                @endif
                            </div>
                            @endif


                            @if($result->thumbnail_name)
                            <div>
                                <label class="form-label">Thumbnail</label>
                                <p>{{ $result->thumbnail_name }}</p>
                            </div>
                            @endif

                            @if($result->souvenir_name)
                            <div>
                                <label class="form-label">Souvenir</label>
                                <p>{{ $result->souvenir_name }}</p>
                            </div>
                            @endif

                        </div>

                        <!-- Description -->
                        <div>
                            <label class="form-label">Description</label>
                            <div class="d-flex flex-column">
                                <p>{!! $result->description !!}</p>
                            </div>
                        </div>

                        <!-- Status and Visibility -->
                        <div class="col-md-4">
                            <div class="font-weight-bold text-secondary">Status:</div>
                            <p>{{ $result->status == 1 ? 'Active' : 'In-Active' }}</p>
                        </div>

                        {{-- <div class="col-md-4">
                            <div class="font-weight-bold text-secondary">Visible to Public:</div>
                            <p>{{ $result->visible_to_public == 1 ? 'Yes' : 'No' }}</p>
                        </div> --}}


                        <div id="previous_directors_div">

                            <div class="container-fluid mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Previous Directors List</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <!-- Table Layout -->
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%;">Name</th>
                                                            <th style="width: 20%;">Image</th>
                                                            <th style="width: 20%;">Qualification</th>
                                                            <th style="width: 20%;">Year</th>
                                                            <th style="width: 8%;">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($previous_directors as $previous_director)
                                                            <!-- Director 1 start -->
                                                            <tr>
                                                                <td>{{ $previous_director->name }}</td>
                                                                <td>
                                                                    <img src="{{ fileLink($previous_director->image_url) }}"
                                                                        alt="Logo" style="max-width: 100px;">
                                                                </td>
                                                                <td>{{ $previous_director->qualification }}</td>
                                                                <td>{{ $previous_director->start_year }} -
                                                                    {{ $previous_director->end_year }}</td>
                                                                <td class="text-{{ $previous_director->status == 1 ? 'success' : 'danger' }}"
                                                                    style="font-weight: bold;">
                                                                    {{ $previous_director->status == 1 ? 'Active' : 'In-Active' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <!-- Director 1 end -->
                                                        <!-- Repeat similar rows for additional directors -->
                                                    </tbody>
                                                </table>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- model for edit director end -->

                        </div>

                        <!-- Buttons -->
                        <div class="d-flex mt-2">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
