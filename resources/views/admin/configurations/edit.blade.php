@extends('admin.layouts.layout')

@section('title', 'Edit Configuration')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Edit Configuration</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>

        @if ($errors->any())
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">

                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        @endif
        <div class="row">

            <div class="col-md-12">

                <form action="{{ url('configurations/update/'.$result->id) }}" enctype="multipart/form-data"
                    method="post">
                    {{ csrf_field() }}




                    <!-- Card Section 1 -->
                    <div class="card">
                        <div class="card-header alert-info">
                            <h4 class="m-b-0 font-weight-normal">DPH Header Texts Settings</h4>
                        </div>
                        <div class="card-body">
                            <!-- DPH Header Texts -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="address">TamilNadu Arasu title (Tamil)</label>
                                        <input type="text" class="form-control" id="TNGovtnametamil" value="{{ old('tamilnadu_government_title_tamil', $result->tamilnadu_government_title_tamil) }}" name="tamilnadu_government_title_tamil"
                                            placeholder="Tamil Text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="country">TamilNadu Arasu title (English)</label>
                                        <input type="text" class="form-control" id="TNGovtnameEnglish" value="{{ old('tamilnadu_government_title_english', $result->tamilnadu_government_title_english) }}" name="tamilnadu_government_title_english"
                                            placeholder="English Text">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="apartment">DPH Full Form (Tamil)</label>
                                        <input type="text" class="form-control" id="DPHfullformtamil" value="{{ old('dph_full_form_tamil', $result->dph_full_form_tamil) }}" name="dph_full_form_tamil"
                                            placeholder="Tamil Text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="postal_code">DPH full form (English)</label>
                                        <input type="text" class="form-control" id="DPHfullformenglish" value="{{ old('dph_full_form_english', $result->dph_full_form_english) }}" name="dph_full_form_english"
                                            placeholder="English Text">
                                    </div>
                                </div>
                        </div>
                    </div>


                    <!-- home page logo's -->

                    <!-- Card Section 2 -->
                    <div class="card">
                        <div class="card-header alert-info">
                            <h4 class="m-b-0 font-weight-normal">Homepage Header Logo Settings</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:50%;">Title</th>
                                            <th style="width:40%;">Image Upload</th>
                                            <th style="width:10%;">Image</th>
                                            <th style="width:10%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label for="header_logo_one_title">Logo 1 Title</label>
                                                <input type="text" name="header_logo_one_title"
                                                    id="header_logo_one_title" class="form-control"
                                                    value="{{ old('header_Logo_one_title', $result->header_logo_one_title) }}"
                                                    placeholder="Enter Logo One Title">
                                            </td>
                                            <td>
                                                <label for="header_logo_one">Logo 1</label>
                                                <input type="file" name="header_logo_one" id="header_logo_one"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->header_logo_one)
                                                <img src="{{ fileLink($result->header_logo_one) }}" alt="Logo One"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Logo Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="header_logo_one_status"
                                                    id="header_logo_one_status" value="1"
                                                    {{CHECKBOX('header_logo_one_status',
                                                    $result->header_logo_one_status)}} >
                                            </td>
                                        </tr>

                                        <!-- Repeat the structure for logo 2, 3, 4, 5 and 6 -->
                                        <tr>
                                            <td>
                                                <label for="header_logo_two_title">Logo 2 Title</label>
                                                <input type="text" name="header_logo_two_title"
                                                    id="header_logo_two_title" class="form-control"
                                                    value="{{ old('header_logo_two_title', $result->header_logo_two_title) }}"
                                                    placeholder="Enter Logo Two Title">
                                            </td>
                                            <td>
                                                <label for="header_logo_two">Logo 2</label>
                                                <input type="file" name="header_logo_two" id="header_logo_two"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->header_logo_two)
                                                <img src="{{ fileLink($result->header_logo_two) }}" alt="Logo Two"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Logo Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="header_logo_two_status"
                                                    id="header_Logo_two_status" value="1"
                                                    {{CHECKBOX('header_logo_two_status',
                                                    $result->header_logo_two_status)}} >
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="header_Logo_three_title">Logo 3 Title</label>
                                                <input type="text" name="header_logo_three_title"
                                                    id="header_logo_three_title" class="form-control"
                                                    value="{{ old('header_logo_three_title', $result->header_logo_three_title) }}"
                                                    placeholder="Enter Logo Three Title">
                                            </td>
                                            <td>
                                                <label for="header_Logo_three">Logo 3</label>
                                                <input type="file" name="header_logo_three" id="header_logo_three"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->header_logo_three)
                                                <img src="{{ fileLink($result->header_logo_three) }}" alt="Logo Three"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Logo Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="header_logo_three_status"
                                                    id="header_logo_three_status" value="1"
                                                    {{CHECKBOX('header_logo_three_status',
                                                    $result->header_logo_three_status)}} >
                                            </td>
                                        </tr>

                                        <!-- logo 4 -->
                                        <tr>
                                            <td>
                                                <label for="header_Logo_four_title">Logo 4 Title</label>
                                                <input type="text" name="header_logo_four_title"
                                                    id="header_logo_four_title" class="form-control"
                                                    value="{{ old('header_logo_four_title', $result->header_logo_four_title) }}"
                                                    placeholder="Enter Logo Four Title">
                                            </td>
                                            <td>
                                                <label for="header_Logo_four">Logo 4</label>
                                                <input type="file" name="header_logo_four" id="header_logo_four"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->header_logo_four)
                                                <img src="{{ fileLink($result->header_logo_four) }}" alt="Logo Four"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Logo Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="header_logo_four_status"
                                                    id="header_Logo_four_status" value="1"
                                                    {{CHECKBOX('header_logo_four_status',
                                                    $result->header_logo_four_status)}} >
                                            </td>
                                        </tr>

                                        <!-- logo 5 -->
                                        <tr>
                                            <td>
                                                <label for="header_Logo_five_title">Logo 5 Title</label>
                                                <input type="text" name="header_logo_five_title"
                                                    id="header_Logo_five_title" class="form-control"
                                                    value="{{ old('header_logo_five_title', $result->header_logo_five_title) }}"
                                                    placeholder="Enter Logo Five Title">
                                            </td>
                                            <td>
                                                <label for="header_Logo_five">Banner 5</label>
                                                <input type="file" name="header_logo_five" id="header_Logo_five"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->header_logo_five)
                                                <img src="{{ fileLink($result->header_logo_five) }}" alt="Logo Five"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Logo Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="header_logo_five_status"
                                                    id="header_Logo_five_status" value="1"
                                                    {{CHECKBOX('header_logo_five_status',
                                                    $result->header_logo_five_status)}} >
                                            </td>
                                        </tr>

                                        <!-- logo 6 -->
                                        <tr>
                                            <td>
                                                <label for="header_Logo_six_title">Logo 6 Title</label>
                                                <input type="text" name="header_logo_six_title"
                                                    id="header_Logo_six_title" class="form-control"
                                                    value="{{ old('header_logo_six_title', $result->header_logo_six_title) }}"
                                                    placeholder="Enter Logo six Title">
                                            </td>
                                            <td>
                                                <label for="header_Logo_six">Banner 6</label>
                                                <input type="file" name="header_logo_six" id="header_Logo_six"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->header_logo_six)
                                                <img src="{{ fileLink($result->header_logo_six) }}" alt="Logo six"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Logo Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="header_logo_six_status"
                                                    id="header_Logo_six_status" value="1"
                                                    {{CHECKBOX('header_logo_six_status',
                                                    $result->header_logo_six_status)}} >
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- home page logo's end -->

                    <!-- Card Section 3 -->
                    <div class="card">
                        <div class="card-header alert-info">
                            <h4 class="m-b-0 font-weight-normal">Scroller Notification Settings</h4>
                        </div>
                        <div class="card-body">

                            <!-- Scroller Notification Content -->
                            <div class="form-group">
                                <label for="notification_content">Scroller Notification Content</label>
                                <textarea name="notification_content" class="form-control" id="notification_content"
                                    placeholder="Enter Notification Content"
                                    rows="5">{{ old('notification_content', $result->notification_content) }}</textarea>
                            </div>

                            <!-- Scroller Notification Status -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="notification_status" class="required">Scroller Notification
                                        Status</label>
                                    <select name="notification_status" id="notification_status" class="form-control">
                                        <option value="1" {{ old("notification_status", $result->notification_status) ==
                                            '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old("notification_status", $result->notification_status) ==
                                            '0' ? 'selected' : '' }}>In-Active</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>



                    <!-- Card Section 4 -->
                    <div class="card">
                        <div class="card-header alert-info">
                            <h4 class="m-b-0 font-weight-normal">Homepage Banner Settings</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:50%;">Title</th>
                                            <th style="width:40%;">Image Upload</th>
                                            <th style="width:10%;">Image</th>
                                            <th style="width:10%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label for="homepage_banner_one_title">Banner 1 Title</label>
                                                <input type="text" name="homepage_banner_one_title"
                                                    id="homepage_banner_one_title" class="form-control"
                                                    value="{{ old('homepage_banner_one_title', $result->homepage_banner_one_title) }}"
                                                    placeholder="Enter Banner One Title">
                                            </td>
                                            <td>
                                                <label for="homepage_banner_one">Banner 1</label>
                                                <input type="file" name="homepage_banner_one" id="homepage_banner_one"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->homepage_banner_one)
                                                <img src="{{ fileLink($result->homepage_banner_one) }}" alt="Banner One"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Banner Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="homepage_banner_one_status"
                                                    id="homepage_banner_one_status" value="1"
                                                    {{CHECKBOX('homepage_banner_one_status',
                                                    $result->homepage_banner_one_status)}} >
                                            </td>
                                        </tr>

                                        <!-- Repeat the structure for banners 2, 3, 4, and 5 -->
                                        <tr>
                                            <td>
                                                <label for="homepage_banner_two_title">Banner 2 Title</label>
                                                <input type="text" name="homepage_banner_two_title"
                                                    id="homepage_banner_two_title" class="form-control"
                                                    value="{{ old('homepage_banner_two_title', $result->homepage_banner_two_title) }}"
                                                    placeholder="Enter Banner Two Title">
                                            </td>
                                            <td>
                                                <label for="homepage_banner_two">Banner 2</label>
                                                <input type="file" name="homepage_banner_two" id="homepage_banner_two"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->homepage_banner_two)
                                                <img src="{{ fileLink($result->homepage_banner_two) }}" alt="Banner Two"
                                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Banner Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="homepage_banner_two_status"
                                                    id="homepage_banner_two_status" value="1"
                                                    {{CHECKBOX('homepage_banner_two_status',
                                                    $result->homepage_banner_two_status)}} >
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="homepage_banner_three_title">Banner 3 Title</label>
                                                <input type="text" name="homepage_banner_three_title"
                                                    id="homepage_banner_three_title" class="form-control"
                                                    value="{{ old('homepage_banner_three_title', $result->homepage_banner_three_title) }}"
                                                    placeholder="Enter Banner Three Title">
                                            </td>
                                            <td>
                                                <label for="homepage_banner_three">Banner 3</label>
                                                <input type="file" name="homepage_banner_three"
                                                    id="homepage_banner_three" class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->homepage_banner_three)
                                                <img src="{{ fileLink($result->homepage_banner_three) }}"
                                                    alt="Banner Three" class="img-thumbnail"
                                                    style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Banner Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="homepage_banner_three_status"
                                                    id="homepage_banner_three_status" value="1"
                                                    {{CHECKBOX('homepage_banner_three_status',
                                                    $result->homepage_banner_three_status)}} >
                                            </td>
                                        </tr>

                                        <!-- Banner 4 -->
                                        <tr>
                                            <td>
                                                <label for="homepage_banner_four_title">Banner 4 Title</label>
                                                <input type="text" name="homepage_banner_four_title"
                                                    id="homepage_banner_four_title" class="form-control"
                                                    value="{{ old('homepage_banner_four_title', $result->homepage_banner_four_title) }}"
                                                    placeholder="Enter Banner Four Title">
                                            </td>
                                            <td>
                                                <label for="homepage_banner_four">Banner 4</label>
                                                <input type="file" name="homepage_banner_four" id="homepage_banner_four"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->homepage_banner_four)
                                                <img src="{{ fileLink($result->homepage_banner_four) }}"
                                                    alt="Banner Four" class="img-thumbnail"
                                                    style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Banner Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="homepage_banner_four_status"
                                                    id="homepage_banner_four_status" value="1"
                                                    {{CHECKBOX('homepage_banner_four_status',
                                                    $result->homepage_banner_four_status)}} >
                                            </td>
                                        </tr>

                                        <!-- Banner 5 -->
                                        <tr>
                                            <td>
                                                <label for="homepage_banner_five_title">Banner 5 Title</label>
                                                <input type="text" name="homepage_banner_five_title"
                                                    id="homepage_banner_five_title" class="form-control"
                                                    value="{{ old('homepage_banner_five_title', $result->homepage_banner_five_title) }}"
                                                    placeholder="Enter Banner Five Title">
                                            </td>
                                            <td>
                                                <label for="homepage_banner_five">Banner 5</label>
                                                <input type="file" name="homepage_banner_five" id="homepage_banner_five"
                                                    class="form-control">
                                                <small class="form-control-feedback text-danger"> Accepted
                                                    .jpg/.jpeg/.png format & allowed max size is 5MB </small>
                                            </td>
                                            <td>
                                                @if($result->homepage_banner_five)
                                                <img src="{{ fileLink($result->homepage_banner_five) }}"
                                                    alt="Banner Five" class="img-thumbnail"
                                                    style="max-width: 200px; max-height: 200px;">
                                                @else
                                                No Banner Available
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="homepage_banner_five_status"
                                                    id="homepage_banner_five_status" value="1"
                                                    {{CHECKBOX('homepage_banner_five_status',
                                                    $result->homepage_banner_five_status)}} >
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




                    <!-- Card Section 5 -->
                    <div class="card">
                        <div class="card-header alert-info">
                            <h4 class="m-b-0 font-weight-normal">Announcement Banner Settings</h4>
                        </div>
                        <div class="card-body">
                            <!-- Mini Banner relevant fields -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:50%;">Title</th>
                                        <th style="width:40%;">Image Upload</th>
                                        <th style="width:10%;">Image</th>
                                        <th style="width:10%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Announcement Banner 1 -->
                                    <tr>
                                        <td>
                                            <label for="mini_banner_one_title">Announcement Banner One Title</label>
                                            <input type="text" name="mini_banner_one_title" id="mini_banner_one_title"
                                                class="form-control"
                                                value="{{ old('mini_banner_one_title', $result->mini_banner_one_title) }}"
                                                placeholder="Enter Banner One Title">
                                        </td>
                                        <td>
                                            <label for="mini_banner_one">Announcement Banner One</label>
                                            <input type="file" name="mini_banner_one" id="mini_banner_one"
                                                class="form-control">
                                            <small class="form-control-feedback text-danger"> Accepted .jpg/.jpeg/.png
                                                format & allowed max size is 5MB </small>
                                        </td>
                                        <td>
                                            @if($result->mini_banner_one)
                                            <img src="{{ fileLink($result->mini_banner_one) }}"
                                                alt="Announcement Banner One" class="img-thumbnail"
                                                style="max-width: 200px; max-height: 200px;">
                                            @else
                                            No Banner Available
                                            @endif
                                        </td>
                                        <td>
                                            <input type="checkbox" name="mini_banner_one_status"
                                                id="mini_banner_one_status" value="1"
                                                {{CHECKBOX('mini_banner_one_status', $result->mini_banner_one_status)}}
                                            >
                                        </td>
                                    </tr>

                                    <!-- Announcement Banner 2 -->
                                    <tr>
                                        <td>
                                            <label for="mini_banner_two_title">Announcement Banner Two Title</label>
                                            <input type="text" name="mini_banner_two_title" id="mini_banner_two_title"
                                                class="form-control"
                                                value="{{ old('mini_banner_two_title', $result->mini_banner_two_title) }}"
                                                placeholder="Enter Banner Two Title">
                                        </td>
                                        <td>
                                            <label for="mini_banner_two">Announcement Banner Two</label>
                                            <input type="file" name="mini_banner_two" id="mini_banner_two"
                                                class="form-control">
                                            <small class="form-control-feedback text-danger"> Accepted .jpg/.jpeg/.png
                                                format & allowed max size is 5MB </small>
                                        </td>
                                        <td>
                                            @if($result->mini_banner_two)
                                            <img src="{{ fileLink($result->mini_banner_two) }}"
                                                alt="Announcement Banner Two" class="img-thumbnail"
                                                style="max-width: 200px; max-height: 200px;">
                                            @else
                                            No Banner Available
                                            @endif
                                        </td>
                                        <td>
                                            <input type="checkbox" name="mini_banner_two_status"
                                                id="mini_banner_two_status" value="1"
                                                {{CHECKBOX('mini_banner_two_status', $result->mini_banner_two_status)}}
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <!-- Card Section 6 -->
                    <div class="card">
                        <div class="card-header alert-info">
                            <h4 class="m-b-0 font-weight-normal">Office Address Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h4>Directorate of Public Health and Preventive Medicine</h4>
                            </div>
                            <!-- DPH office Address -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" value="{{ old('dph_address', $result->dph_address) }}" name="dph_address" placeholder="Address">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="postal_code">Zip/Postal Code</label>
                                        <input type="text" class="form-control" id="postal_code" value="{{ old('dph_zip_code', $result->dph_zip_code) }}" name="dph_zip_code"
                                            placeholder="Zip/Postal Code">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" value="{{ old('dph_city', $result->dph_city) }}" name="dph_city" placeholder="City">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" value="{{ old('dph_state', $result->dph_state) }}" name="dph_state" placeholder="State">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" value="{{ old('dph_phone', $result->dph_phone) }}" name="dph_phone" placeholder="Phone Number">
                                    </div>
                                </div>
                        </div>
                        <!-- Web Information Manager, Joint Director-HEB -->
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h4>Web Information Manager, Joint Director-HEB</h4>
                            </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" value="{{ old('joint_director_email', $result->joint_director_email) }}" name="joint_director_email" placeholder="Email Address">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" value="{{ old('joint_director_phone', $result->joint_director_phone) }}" name="joint_director_phone" placeholder="Phone Number">
                                    </div>
                                </div>
                            </div>
                        </div>


                    <!-- Common Action Buttons -->
                    <div class="mt-3 float-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light"><i
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>

        <br>
    </div>
</div>
@endsection