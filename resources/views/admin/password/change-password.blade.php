@extends('admin.layouts.layout')
@section('title', env('APP_GLOBAL_NAME'))
@section('content')

    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Manage Password</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Password</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="container-fluid mt-2">
                    <div class="row">

                        <div class="col-lg-6 col-md-8 col-sm-12 py-5 px-4 mx-auto" style="background-color: #ffffff; border-radius: 10px;">
                            <form action="{{ route('password.mupdate') }}" method="post">
                                {{ csrf_field() }}

                                @if (!empty($id))
                                    <input type="hidden" name="_identifier" value="{{ $id }}">
                                @endif  

                                <div class="form-group">
                                    <label for="formField2" class="required">New Password</label>
                                    <input type="password" name="password" class="form-control" id="formField1"
                                        placeholder="Enter New Password *" value="">
                                </div>

                                <div class="form-group">
                                    <label for="formField2" class="required">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="formField2"
                                        placeholder="Enter Confirm Password *" value="">
                                </div>

                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <button type="reset" class="btn btn-inverse waves-effect waves-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>


@endsection
