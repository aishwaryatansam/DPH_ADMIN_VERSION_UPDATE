@extends('admin.layouts.layout')
@section('title', 'Edit Director Message')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}" />
</head>
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color:#f2f2f2;">
        <h5 style="margin-left: 20px;">Edit Director Message</h5>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <div class="container">
                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <form action="{{ route('testimonials.update', $result->id) }}" enctype="multipart/form-data" method="post" id="myForm">
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <!-- Testimonial Type -->
                                        <tr>
                                            <td>
                                                <label for="role" class="form-label">Testimonial Type <span style="color: red;">*</span></label>
                                            </td>
                                            <td>
                                                <select class="form-control" name="role" id="testimonialType" required>
                                                    <option value="" disabled>Select a Testimonial Type</option>
                                                    @foreach (getTestimonialType() as $key => $type)
                                                        <option value="{{ $key }}" data-value="{{ $type }}" {{ SELECT($key, $result->role) }}>
                                                            {{ $type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                        <!-- Name -->
                                        <tr>
                                            <td>
                                                <label for="name" class="form-label">Name <span style="color: red;">*</span></label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="name" placeholder="Enter your name" value="{{ old('name', $result->name) }}" name="name" required>
                                            </td>
                                        </tr>

                                        <!-- Designation -->
                                        <tr>
                                            <td>
                                                <label for="designation" class="form-label">Designation <span style="color: red;">*</span></label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter your designation" value="{{ old('designation', $result->designation) }}" required>
                                            </td>
                                        </tr>

                                        <!-- Content (Director Only) -->
                                        <tr data-role="director-only">
                                            <td>
                                                <label for="content" class="form-label">Content <span style="color: red;">*</span></label>
                                            </td>
                                            <td>
                                                <textarea class="textarea_editor form-control" style="width: 100%" name="content" id="content" rows="15" placeholder="Enter content here" >{!! old('content', $result->content) !!}</textarea>
                                            </td>
                                        </tr>

                                        <!-- Profile Image -->
                                        <tr>
                                            <td>
                                                <label for="profileImage" class="form-label">Profile Image <span style="color: red;">*</span></label>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="testimonial_image" id="profileImage" accept="image/*">
                                                <small style="color: red;">Accepted .jpg/.jpeg/.png format & allowed max size is 5MB</small>
                                            </td>
                                            <td>
                                                <img src="{{ fileLink($result->image_url) }}" alt="Image Preview" class="img-fluid" height="100" width="100">
                                            </td>
                                        </tr>

                                        <!-- Profile Document (Director Only) -->
                                        <tr data-role="director-only">
                                            <td>
                                                <label for="profileDocument" class="form-label">Select Profile Document</label>
                                            </td>
                                            <td>
                                                <input type="file" name="testimonial_document" class="form-control" id="profileDocument" accept=".pdf,.doc,.docx">
                                            </td>
                                        </tr>

                                        <!-- Status -->
                                        <tr>
                                            <td>
                                                <label for="publicVisibility" class="form-label">Status</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" name="status" type="checkbox" id="toggleStatus" value="1" {{ CHECKBOX('status', $result->status) }} onchange="toggleStatusText('statusLabel', this)">
                                                    <label class="form-check-label" for="toggleStatus" id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('testimonials.index') }}';">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('packa/theme/assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script>
    document.getElementById('testimonialType').addEventListener('change', function () {
        const selectedValue = this.value;
        const directorOnlyRows = document.querySelectorAll('[data-role="director-only"]');

        if (selectedValue == 4) { // Assuming 4 is for Director
            directorOnlyRows.forEach(row => row.style.display = '');
        } else {
            directorOnlyRows.forEach(row => row.style.display = 'none');
        }
    });

    // Initialize visibility on page load
    document.addEventListener('DOMContentLoaded', function () {
        const event = new Event('change');
        document.getElementById('testimonialType').dispatchEvent(event);
    });

    $(document).ready(function() {
        $('.textarea_editor').wysihtml5();
    });
</script>
@endsection
