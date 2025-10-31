@extends('admin.layouts.layout')
@section('title', 'Edit Facility Profile')
@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* .next:disabled {
        background-color: lightgray;
        cursor: not-allowed;
    } */

        .notification-badge {
            background-color: rgb(10118, 255);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 22px;
            min-width: 22px;
            text-align: center;
            line-height: 1;
        }

        /* Styling for the badge when its parent nav-link is active */
        .nav-link.active .notification-badge {
            background-color: white;
            color: rgb(10118, 255);
        }



        /* style for the confirm popup start */
        /* Modal Styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0.1);
        }

        .modal-header {
            border-bottom: none;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 15px 15px 0 0;
            position: relative;
        }

        .modal-title {
            font-weight: 600;
            color: #333;
        }

        .modal-body {
            padding: 30px 20px;
        }

        .confirmation-icon {
            color: #28a745;
        }

        .modal-body p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 0;
        }

        .modal-footer {
            padding: 20px;
            border-top: none;
            background-color: #f9f9f9;
            border-radius: 0 0 15px 15px;
        }

        .btn-outline-secondary {
            border-color: #7d6f6c;
            color: #6c757d;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn-success:hover {
            background-color: #218838;
            box-shadow: 0 4px 10px rgba(4167, 69, 0.2);
        }

        .btn-close {
            background-color: transparent;
            border: none;
        }

        /* style for multi form start */
        * {
            margin: 0;
            padding: 0
        }

        html {
            height: 100%
        }

        p {
            color: grey
        }

        .check {
            margin: 0;
        }

        #heading {
            text-transform: uppercase;
            color: #000;
            font-weight: normal
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        select {
            padding: 8px 15px 8px 15px;
            border: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 25px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            background-color: #ECEFF1;
            font-size: 16px;
            letter-spacing: 1px
        }

        .form-card {
            text-align: left
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        /* style for multi form start
                                                                                                                                                    #msform input,
                                                                                                                                                    #msform textarea {
                                                                                                                                                        padding: 8px 15px 8px 15px;
                                                                                                                                                        border: 1px solid #ccc;
                                                                                                                                                        border-radius: 0px;
                                                                                                                                                        margin-bottom: 25px;
                                                                                                                                                        margin-top: 2px;
                                                                                                                                                        width: 100%;
                                                                                                                                                        box-sizing: border-box;
                                                                                                                                                        font-family: montserrat;
                                                                                                                                                        color: #2C3E50;
                                                                                                                                                        background-color: #ECEFF1;
                                                                                                                                                        font-size: 16px;
                                                                                                                                                        letter-spacing: 1px
                                                                                                                                                    }
                                                                                                                                                        */

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #673AB7;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: #3B71CA;
            font-weight: bold;
            color: white;
            border-radius: 10px !important;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px 10px 5px;
            float: right
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            background-color: #0c4db4
        }

        #msform .action-button-previous {
            width: 100px;
            background: #9FA6B2;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 10px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px 10px 0px;
            float: right
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            background-color: #494949
        }

        .card {
            z-index: 0;
            border: none;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #122161;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .purple-text {
            color: #673AB7;
            font-weight: normal
        }

        .steps {
            font-size: 25px;
            color: gray;
            margin-bottom: 10px;
            font-weight: normal;
            text-align: right
        }

        .fieldlabels {
            color: gray;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey;

        }

        #progressbar .active {
            color: #673AB7
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f13e"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f030"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }


        /*new changes start*/
        #progressbar #UploadDetails:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar #BuildingDetails:before {
            font-family: FontAwesomr;
            content: "\f1ad"
        }

        #progressbar #idDetail:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        /*new changes end*/
        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 16.66%;
            float: left;
            position: relative;
            font-weight: 400;
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px;
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #5d00ff;
        }

        .progress {
            height: 20px
        }

        .progress-bar {
            background-color: #673AB7
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }

        /* style for multi form end */

        #maincontent {
            margin-top: 95px;
        }


        .img-thumbnail {
            max-width: 150px;
            max-height: 150px;
            margin-right: 10px;
        }

        .position-relative {
            position: relative;
        }

        .remove-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #dc3545;
            /* Bootstrap danger color */
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            /* Adjust size as needed */
        }

        /* new popup start */

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0.2);
            padding: 20px;
            width: 300px;
            text-align: center;
            z-index: 1000;
        }

        .popup-content {
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .success-icon {
            margin-bottom: 10px;
        }

        .checkmark {
            width: 60px;
            height: 60px;
        }

        .checkmark__circle {
            stroke: #4CAF50;
            stroke-width: 2;
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            animation: stroke 0.6s ease forwards;
        }

        .checkmark__check {
            stroke: #4CAF50;
            stroke-width: 5;
            stroke-linecap: round;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.4s 0.6s ease forwards;
        }

        .previewtext {
            word-wrap: break-word;
            overflow-wrap: break-word;
            width: 1050px;
        }

        /* Animations */
        @keyframes stroke {
            to {
                stroke-dashoffset: 0;
            }
        }


        /* preview wrap start */
        .word-wrap {
            word-wrap: break-word;
        }

        /* preview wrap end */
        /* new popup end */
        /* css for content width in director message list start */
        @media (max-width: 1280px) {
            .arrow {
                right: 15px;
            }

            .previewtext {
                word-wrap: break-word;
                overflow-wrap: break-word;
                width: 750px;
            }
        }

        @media (max-width: 1024px) {
            #maincontent {
                margin-top: 120px;
            }

            .arrow {
                right: 15px;
            }

            .previewtext {
                word-wrap: break-word;
                overflow-wrap: break-word;
                width: 530px;
            }
        }

        /* Custom styles to control the grid layout */
        @media (min-width: 992px) {

            /* Large devices */
            .grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 991px) {

            /* Medium devices */
            .grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* css for content width in director message list start */
        @media (max-width: 768px) {

            #maincontent {
                margin-top: 70px;
            }

            .arrow {
                right: 15px;
                /* Slightly adjust for smaller screens */
            }

            .previewtext {
                word-wrap: break-word;
                overflow-wrap: break-word;
                width: 600px;
            }

            .grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 767px) {

            /* Small devices */
            .grid-1 {
                grid-template-columns: 1fr;
            }

            .previewtext {
                word-wrap: break-word;
                overflow-wrap: break-word;
                width: 600px;
            }

        }

        @media (max-width:430px) {

            .previewtext {
                word-wrap: break-word;
                overflow-wrap: break-word;
                width: 200px;
            }

        }

        /* Hide number input spinners (up/down arrows) */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }


        /* For Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
            -webkit-appearance: none;
            /* Chrome, Safari, newer Edge */
            appearance: none;
        }

        #fundingDropdown {
            font-family: 'Public Sans', sans-serif;
        }

        #dropdown1 {
            font-family: 'Public Sans', sans-serif;
        }

        .selected-items {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-left: 30px
        }

        .selected-item {
            display: inline-flex;
            align-items: center;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;

        }

        .remove-btn {
            margin-left: 13px;
            color: #dc3545;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .remove-btn:hover {
            text-decoration: underline;
        }

        /* css for content width in director message list end */
    </style>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Facility Profile </h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-lg-12 " style="border-radius: 10px;">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- insert the contents Here start -->


                            <div class="card px-5 pt-0 pb-0 mt-3 mb-3">
                                <form id="msform" action="{{ route('facility-profile.update', $result->id) }}"
                                    enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <!-- progressbar -->
                                    <ul id="progressbar" class="d-none d-md-flex">
                                        <li class="active" id="account"><strong>Facility Info</strong></li>
                                        <li id="personal"><strong>Contact Details</strong></li>
                                        <li id="payment"><strong>Address Information</strong></li>
                                        <li id="BuildingDetails"><strong>Building Details</strong></li>
                                        <li id="confirm"><strong>Photos</strong></li>

                                        <li id="UploadDetails"><strong>Upload Details</strong></li>
                                        <li id="idDetail"><strong>ID Details</strong></li>
                                        <!-- <li id="preview"><strong>Preview</strong></li> -->
                                    </ul>
                                    <br>
                                    <!-- Facility Info -->
                                    <!-- Facility Info -->
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Facility Information:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 1 - 7</h2>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                <div>
                                                    <label for="facility_id" class="form-label">Facility Id
                                                        <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="facility_id"
                                                        name="facility_id" value="{{ $result->facility_hierarchy_id }}"
                                                        placeholder="Enter Facility Id" readonly />
                                                </div>
                                                <div>
                                                    <label for="facility_name" class="form-label">Facility Name
                                                        <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="facility_name"
                                                        name="facility_name"
                                                        value="{{ $result->facility_hierarchy->facility_name }}"
                                                        placeholder="Enter Facility Name" readonly />
                                                </div>
                                                <div>
                                                    <label for="facility_level" class="form-label">Facility
                                                        Level <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="facility_level"
                                                        name="facility_level"
                                                        value="{{ $result->facility_hierarchy->facility_level->name }}"
                                                        placeholder="Enter Facility Level" readonly />
                                                </div>

                                                @if ($result->facility_hierarchy->facility_level_id != 1)
                                                    <div>
                                                        <label for="district_id" class="form-label">District ID
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="district_id"
                                                            name="district_id"
                                                            value="{{ $result->facility_hierarchy->district_id }}"
                                                            placeholder="Enter District ID" disabled />
                                                    </div>
                                                    <div>
                                                        <label for="district_name" class="form-label">District Name
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="district_name"
                                                            value="{{ $result->facility_hierarchy->district->name }}"
                                                            name="district_name" placeholder="Enter District Name"
                                                            disabled />
                                                    </div>

                                                    @if (in_array($result->facility_hierarchy->facility_level_id, [3, 4, 5, 6]))
                                                        <div>
                                                            <label for="hud_id" class="form-label">HUD ID <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="hud_id"
                                                                name="hud_id"
                                                                value="{{ $result->facility_hierarchy->hud_id }}"
                                                                placeholder="Enter HUD ID" disabled />
                                                        </div>
                                                        <div>
                                                            <label for="hud_name" class="form-label">HUD Name <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="hud_name"
                                                                value="{{ $result->facility_hierarchy->hud->name }}"
                                                                name="hud_name" placeholder="Enter HUD Name" disabled />
                                                        </div>
                                                    @endif

                                                    @if (in_array($result->facility_hierarchy->facility_level_id, [4, 5, 6]))
                                                        <div>
                                                            <label for="block_id" class="form-label">Block ID <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="block_id"
                                                                value="{{ $result->facility_hierarchy->block_id }}"
                                                                name="block_id" placeholder="Enter Block ID" disabled />
                                                        </div>
                                                        <div>
                                                            <label for="block_name" class="form-label">Block Name <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="block_name"
                                                                value="{{ $result->facility_hierarchy->block->name }}"
                                                                name="block_name" placeholder="Enter Block Name"
                                                                disabled />
                                                        </div>
                                                    @endif

                                                    @if (in_array($result->facility_hierarchy->facility_level_id, [5, 6]))
                                                        <div>
                                                            <label for="phc_id" class="form-label">PHC ID <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="phc_id"
                                                                value="{{ $result->facility_hierarchy->phc_id }}"
                                                                name="phc_id" placeholder="Enter PHC ID" disabled />
                                                        </div>
                                                        <div>
                                                            <label for="phc_name" class="form-label">PHC Name <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="phc_name"
                                                                value="{{ $result->facility_hierarchy->phc->name }}"
                                                                name="phc_name" placeholder="Enter PHC Name" disabled />
                                                        </div>
                                                    @endif

                                                    @if ($result->facility_hierarchy->facility_level_id == 6)
                                                        <div>
                                                            <label for="hsc_id" class="form-label">HSC ID <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="hsc_id"
                                                                value="{{ $result->facility_hierarchy->hsc_id }}"
                                                                name="hsc_id" placeholder="Enter HSC ID" disabled />
                                                        </div>
                                                        <div>
                                                            <label for="hsc_name" class="form-label">HSC Name <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="hsc_name"
                                                                value="{{ $result->facility_hierarchy->hsc->name }}"
                                                                name="hsc_name" placeholder="Enter HSC Name" disabled />
                                                        </div>
                                                    @endif
                                                @endif

                                            </div>
                                            
                                            <input type="button" name="next"
                                                class="next action-button btn btn-primary" value="Next" />
                                            <!-- <input type="button" name="previous" class="previous action-button btn btn-secondary" value="Previous" /> -->
                                        </div>
                                    </fieldset>


                                    <!-- Contact Details -->

                                    <fieldset>
                                        <div class="form-card">
                                            {{-- @if (isset($result->contacts->id))
                                                <input type="hidden" name="contacts_id"
                                                    value="{{ $result->contacts->id }}">
                                            @endif --}}
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Contact Details:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 2 - 7</h2>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                <div>
                                                    <label for="toggleAreaType" class="form-label">Urban/Rural
                                                        <span style="color: red;">*</span>
                                                    </label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="toggleAreaType" value="1"
                                                            {{ CHECKBOX('area_type', $result->area_type) }}
                                                            onchange="toggleAreaTypeText('areaTypeLabel', this)"
                                                            name="area_type">
                                                        <label class="form-check-label" for="toggleAreaType"
                                                            id="areaTypeLabel">{{ $result->area_type == 1 ? 'Urban' : 'Rural' }}</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label for="mobile_number" class="form-label">Mobile Number
                                                        <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="mobile_number"
                                                        name="mobile_number"
                                                        value="{{ $result->mobile_number ?? '' }}"
                                                        placeholder="Enter Mobile Number" 
                                                        required
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"/>
                                                </div>
                                                <div>
                                                    <label for="landline" class="form-label">Landline</label>
                                                    <input type="text" class="form-control" id="landline"
                                                        value="{{ $result->landline_number ?? '' }}"
                                                        name="landline_number" placeholder="Enter Landline Number" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"/>
                                                </div>
                                                <div>
                                                    <label for="fax" class="form-label">Fax</label>
                                                    <input type="text" class="form-control" id="fax"
                                                        value="{{ $result->fax ?? '' }}" name="fax"
                                                        placeholder="Enter Fax Number" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"/>
                                                </div>
                                                <div>
                                                    <label for="email" class="form-label">Email <span
                                                            style="color: red;">*</span></label>
                                                    <input type="email" class="form-control" id="email"
                                                        value="{{ $result->email_id ?? '' }}" name="email_id"
                                                        required
                                                        placeholder="Enter Email" />
                                                </div>
                                            </div>
                                            <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" />
                                                <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->
                                            
                                            <input type="button" name="next"
                                                class="next action-button btn btn-primary" value="Next" />
                                            <input type="button" name="previous"
                                                class="previous action-button btn btn-secondary" value="Previous" />
                                        </div>
                                    </fieldset>


                                    <!-- Address Information -->
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Address Information:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 3 - 6</h2>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                <div>
                                                    <label for="address_line_1" class="form-label">Line 1 <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="address_line_1"
                                                        value="{{ $result->address_line1 ?? '' }}" name="address_line1"
                                                        placeholder="Street, Campus" required />
                                                </div>
                                                <div>
                                                    <label for="address_line_2" class="form-label">Line 2 <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="address_line_2"
                                                        value="{{ $result->address_line2 ?? '' }}" name="address_line2"
                                                        placeholder="City, District" required/>
                                                </div>
                                                <div>
                                                    <label for="pincode" class="form-label">Pincode <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="pincode"
                                                        value="{{ $result->pincode ?? '' }}" name="pincode"
                                                        pattern="^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$" 
                                                        placeholder="Enter Pincode"  maxlength="6"  required
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);"/>
                                                </div>
                                                <div>
                                                    <label for="latitude" class="form-label">Latitude <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" step="any" class="form-control"
                                                        value="{{ $result->latitude ?? '' }}" id="latitude"
                                                        name="latitude" placeholder="Enter Latitude"
                                                        min="-90" max="90"
                                                        oninput="this.value = this.value.replace(/[^0-9.-]/g, '');" required  />
                                                </div>
                                                <div>
                                                    <label for="longitude" class="form-label">Longitude <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" step="any" class="form-control"
                                                        value="{{ $result->longitude ?? '' }}" id="longitude"
                                                        min="-180"  max="180" 
                                                        name="longitude" placeholder="Enter Longitude"
                                                        oninput="this.value = this.value.replace(/[^0-9.-]/g, '');" required />
                                                </div>
                                            </div>
                                            <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" />
                                                <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->
                                            
                                            <input type="button" name="next"
                                                class="next action-button btn btn-primary" value="Next" />
                                            <input type="button" name="previous"
                                                class="previous action-button btn btn-secondary" value="Previous" />
                                        </div>
                                    </fieldset>

                                    <!-- Building Status Section -->
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Building Details:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 4 - 7</h2>
                                                </div>
                                            </div>

                                            <div class="d-grid gap-4 mb-2">
                                                <!-- Building Status -->
                                                <div>
                                                    <div>
                                                        <label><strong style="font-size:18px;">Building Status:</strong>
                                                            <span style="color: red;">*</span></label>
                                                        <div class="d-flex justify-content-start gap-4 mt-2"
                                                            style="margin-left: 40px;">
                                                            <label><input type="radio" name="building_status"
                                                                    value="own" onchange="toggleInputs()"
                                                                    {{ $result->facilityBuilding->building_status == 'own' ? 'checked' : '' }}>
                                                                Own</label>
                                                            <label><input type="radio" name="building_status"
                                                                    value="rent_free" onchange="toggleInputs()"
                                                                    {{ $result->facilityBuilding->building_status == 'rent_free' ? 'checked' : '' }}>
                                                                Rent Free</label>
                                                            <label><input type="radio" name="building_status"
                                                                    value="rented" onchange="toggleInputs()"
                                                                    {{ $result->facilityBuilding->building_status == 'rented' ? 'checked' : '' }}>
                                                                Rented</label>
                                                            <label><input type="radio" name="building_status"
                                                                    value="public_building" onchange="toggleInputs()"
                                                                    {{ $result->facilityBuilding->building_status == 'public_building' ? 'checked' : '' }}>
                                                                Public
                                                                Building</label>
                                                            <label><input type="radio" name="building_status"
                                                                    value="under_construction" onchange="toggleInputs()"
                                                                    {{ $result->facilityBuilding->building_status == 'under_construction' ? 'checked' : '' }}>
                                                                Under Construction</label>
                                                        </div>
                                                    </div>

                                                    <!-- Conditional Dynamic Inputs -->
                                                    <div id="conditionalInputs" class="mt-3">
                                                        <!-- Dropdown for 7 Stages (Initially Hidden) -->
                                                        <div id="stageDropdownContainer"
                                                            style="display: none; width: 100%;">
                                                            <!-- Support Service -->
                                                            <div>
                                                                <div style="margin-bottom: 20px;">
                                                                    <label><strong>Enter Electric service No:</strong> <span
                                                                            style="color: red;">*</span></label>
                                                                    <input type="number" name="electric_service_number"
                                                                        class="form-control"
                                                                        value="{{ $result->facilityBuilding->electric_service_number }}"
                                                                        placeholder="Enter service Number">
                                                                </div>
                                                            </div>
                                                            <label><strong>Select Stage:</strong> <span
                                                                    style="color: red;">*</span></label>
                                                            <select id="stageDropdown" name="under_construction_type"
                                                                class="form-select w-100">
                                                                <option value="">Select a Stage</option>
                                                                <option value="land_identified"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'land_identified' ? 'selected' : '' }}>
                                                                    Land Identified</option>
                                                                <option value="basement_level"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'basement_level' ? 'selected' : '' }}>
                                                                    Basement Level</option>
                                                                <option value="wall_level"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'wall_level' ? 'selected' : '' }}>
                                                                    Wall Level</option>
                                                                <option value="lintel_level"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'lintel_level' ? 'selected' : '' }}>
                                                                    Lintel Level</option>
                                                                <option value="roof_level"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'roof_level' ? 'selected' : '' }}>
                                                                    Roof Level</option>
                                                                <option value="g_work_started"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'g_work_started' ? 'selected' : '' }}>
                                                                    G+1 Work Started</option>
                                                                <option value="service_support_Water"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'service_support_water' ? 'selected' : '' }}>
                                                                    Service support - Water</option>
                                                                <option value="service_support_electricity"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'service_support_electricity' ? 'selected' : '' }}>
                                                                    Service support - Electricity</option>
                                                                <option value="service_support_carpentary"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'service_support_carpentary' ? 'selected' : '' }}>
                                                                    Service support - Carpentary</option>
                                                                <option value="painting"
                                                                    {{ $result->facilityBuilding->under_construction_type == 'painting' ? 'selected' : '' }}>
                                                                    Painting Identified</option>


                                                            </select>
                                                        </div>

                                                        <!-- Multi-Step Progress Bar (Initially Hidden) -->
                                                        <div id="progressBarContainer" class="progress mt-3"
                                                            style="height: 15px; display: none;">
                                                            <div id="progressBar"
                                                                class="progress-bar progress-bar-striped progress-bar-animated"
                                                                role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                Stage 0 of 7
                                                            </div>
                                                        </div>

                                                        <!-- Stage-Specific Content -->
                                                        <div id="stageContent" class="mt-4"></div>

                                                        <!-- Button to Navigate Stages (Initially Hidden) -->
                                                        {{-- <button id="nextStageButton" type="button"
                                                            class="btn btn-primary mt-3" style="display: none;">
                                                            Next Stage
                                                        </button> --}}

                                                        <!-- {{-- <div id="stageHistoryLog" class="mt-3"></div> --}} -->
                                                        <!-- History Log Table (Initially Hidden) -->
                                                        <div id="stageHistoryLog"
                                                            style="display: none; margin-top: 20px;">
                                                            <h5>History Log</h5>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Stage</th>
                                                                        <th>Details</th>
                                                                        <th>Date/Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="historyTableBody"></tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <hr>

                                                </div>

                                                <!-- Source of Funding -->
                                                <div>
                                                    <div>
                                                        <label><strong style="font-size:18px;">Source of Funding:</strong>
                                                            <span style="color: red;">*</span>
                                                        </label>
                                                        <!-- Input Group -->
                                                        <div class="input-group-custom" style="width: 200%;">
                                                            <!-- Multiselect Dropdown using Select2 -->
                                                            <select id="fundingDropdown" class="form-select w-50"
                                                                name="source_of_funding[]" multiple>
                                                                <option value="state-fund"
                                                                    {{ in_array('state-fund', old('source_of_funding', $result->source_of_funding ?? [])) ? 'selected' : '' }}>
                                                                    State Fund
                                                                </option>
                                                                <option value="NHM-fund"
                                                                    {{ in_array('NHM-fund', old('source_of_funding', $result->source_of_funding ?? [])) ? 'selected' : '' }}>
                                                                    NHM Fund
                                                                </option>
                                                                <option value="15-FC-Fund"
                                                                    {{ in_array('15-FC-Fund', old('source_of_funding', $result->source_of_funding ?? [])) ? 'selected' : '' }}>
                                                                    15 FC Fund
                                                                </option>
                                                                <option value="tribal"
                                                                    {{ in_array('tribal', old('source_of_funding', $result->source_of_funding ?? [])) ? 'selected' : '' }}>
                                                                    Tribal
                                                                </option>
                                                                <option value="Welfare-fund"
                                                                    {{ in_array('Welfare-fund', old('source_of_funding', $result->source_of_funding ?? [])) ? 'selected' : '' }}>
                                                                    Welfare Fund
                                                                </option>
                                                                <option value="SBGF-fund"
                                                                    {{ in_array('SBGF-fund', old('source_of_funding', $result->source_of_funding ?? [])) ? 'selected' : '' }}>
                                                                    SBGF Fund
                                                                </option>
                                                            </select>
                                                            <!-- Selected Items Container -->
                                                            <div id="selectedContainer" class="selected-items ml-2">
                                                                <!-- Dynamically added selected items will appear here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- Common Inputs (only for "Own", "Rent Free", "Rented", "Public Building") -->
                                                    <div id="commonInputs" style="display: none;">
                                                        <!-- Approach Road -->
                                                        <div>
                                                            <div class="mt-3">
                                                                <label><strong>Approach Road:</strong> <span
                                                                        style="color: red;">*</span></label>
                                                                <div class="d-flex align-items-center gap-3 mt-2">
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" name="approach_road_status"
                                                                            {{ $result->facilityBuilding->approach_road_status == 1 ? 'checked' : '' }}
                                                                            id="approachRoadYes" value="yes"
                                                                            class="form-check-input">
                                                                        <label for="approachRoadYes"
                                                                            class="form-check-label">Yes</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" name="approach_road_status"
                                                                            {{ $result->facilityBuilding->approach_road_status === 0 ? 'checked' : '' }}
                                                                            id="approachRoadNo" value="no"
                                                                            class="form-check-input">
                                                                        <label for="approachRoadNo"
                                                                            class="form-check-label">No</label>
                                                                    </div>
                                                                </div>
                                                                <!-- Dynamic Road Type Selection -->
                                                                <div id="roadTypeContainer" class="mt-3"
                                                                    style="display: none;">
                                                                    <label><strong>Select Road Type:</strong></label>
                                                                    <div class="d-flex align-items-center gap-3 mt-2">
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio"
                                                                                name="approach_road_type"
                                                                                {{ $result->facilityBuilding->approach_road_type == 'bituminous' ? 'checked' : '' }}
                                                                                id="bituminousRoad" value="bituminous"
                                                                                class="form-check-input">
                                                                            <label for="bituminousRoad"
                                                                                class="form-check-label">Bituminous
                                                                                Road</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input type="radio"
                                                                                name="approach_road_type"
                                                                                {{ $result->facilityBuilding->approach_road_type == 'concrete' ? 'checked' : '' }}
                                                                                id="concreteRoad" value="concrete"
                                                                                class="form-check-input">
                                                                            <label for="concreteRoad"
                                                                                class="form-check-label">Concrete
                                                                                Road</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div>
                                                            <div>
                                                                <!-- Water Storage Facilities -->
                                                                <div>
                                                                    <h5><strong>Water Storage Facilities:</strong> <span
                                                                            style="color: red;">*</span></h5>

                                                                    <!-- Water Tank -->
                                                                    <div class="mt-3">
                                                                        <label><strong>Water Tank:</strong></label>
                                                                        <div class="d-flex align-items-center gap-3 mt-2">
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio"
                                                                                    name="water_tank_status"
                                                                                    id="waterTankYes" value="yes"
                                                                                    {{ $result->facilityBuilding->water_tank_status == 1 ? 'checked' : '' }}
                                                                                    class="form-check-input">
                                                                                <label for="waterTankYes"
                                                                                    class="form-check-label">Yes</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio"
                                                                                    name="water_tank_status"
                                                                                    id="waterTankNo" value="no"
                                                                                    {{ $result->facilityBuilding->water_tank_status === 0 ? 'checked' : '' }}
                                                                                    class="form-check-input">
                                                                                <label for="waterTankNo"
                                                                                    class="form-check-label">No</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="waterTankInputs" class="mt-3"></div>

                                                                    <!-- Sump -->
                                                                    <div class="mt-3">
                                                                        <label><strong>Sump:</strong></label>
                                                                        <div class="d-flex align-items-center gap-3 mt-2">
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" name="sump_status"
                                                                                    id="sumpYes" value="yes"
                                                                                    {{ $result->facilityBuilding->sump_status == 1 ? 'checked' : '' }}
                                                                                    class="form-check-input">
                                                                                <label for="sumpYes"
                                                                                    class="form-check-label">Yes</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" name="sump_status"
                                                                                    id="sumpNo" value="no"
                                                                                    {{ $result->facilityBuilding->sump_status === 0 ? 'checked' : '' }}
                                                                                    class="form-check-input">
                                                                                <label for="sumpNo"
                                                                                    class="form-check-label">No</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="sumpInputs" class="mt-3"></div>

                                                                    <!-- OHT (Overhead Tank) -->
                                                                    <div class="mt-3">
                                                                        <label><strong>OHT (Overhead Tank):</strong></label>
                                                                        <div class="d-flex align-items-center gap-3 mt-2">
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" name="oht_status"
                                                                                    id="ohtYes" value="yes"
                                                                                    {{ $result->facilityBuilding->oht_status == 1 ? 'checked' : '' }}
                                                                                    class="form-check-input">
                                                                                <label for="ohtYes"
                                                                                    class="form-check-label">Yes</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" name="oht_status"
                                                                                    id="ohtNo" value="no"
                                                                                    {{ $result->facilityBuilding->oht_status === 0 ? 'checked' : '' }}
                                                                                    class="form-check-input">
                                                                                <label for="ohtNo"
                                                                                    class="form-check-label">No</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="ohtInputs" class="mt-3"></div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <!-- RO Water Availability -->
                                                        <div>
                                                            <div class="mt-3">
                                                                <label><strong>RO Water Availability:</strong> <span
                                                                        style="color: red;">*</span></label>
                                                                <div class="d-flex align-items-center gap-3 mt-2">
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" name="ro_water_availability"
                                                                            {{ $result->facilityBuilding->ro_water_availability == 1 ? 'checked' : '' }}
                                                                            id="roWaterYes" value="yes"
                                                                            class="form-check-input">
                                                                        <label for="roWaterYes"
                                                                            class="form-check-label">Yes</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" name="ro_water_availability"
                                                                            {{ $result->facilityBuilding->ro_water_availability === 0 ? 'checked' : '' }}
                                                                            id="roWaterNo" value="no"
                                                                            class="form-check-input">
                                                                        <label for="roWaterNo"
                                                                            class="form-check-label">No</label>
                                                                    </div>
                                                                </div>
                                                                <!-- Dynamic Inputs for RO Water -->
                                                                <div id="roWaterDetails" class="mt-3"
                                                                    style="display: none;">
                                                                    <div>
                                                                        <label><strong>Make:</strong></label>
                                                                        <input type="text" class="form-control"
                                                                            name="ro_water_make"
                                                                            value="{{ $result->facilityBuilding->ro_water_make }}"
                                                                            placeholder="Enter RO Water Make">
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label><strong>Capacity (Liters):</strong></label>
                                                                        <input type="number" class="form-control"
                                                                            name="ro_water_capacity"
                                                                            value="{{ $result->facilityBuilding->ro_water_capacity }}"
                                                                            placeholder="Enter Capacity in Liters">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <!-- Electric Connection Service -->
                                                        <div>
                                                            <div>
                                                                <label><strong style="font-size:18px;">Electric Connection
                                                                        Service:</strong> <span
                                                                        style="color: red;">*</span></label>
                                                                <div class="mt-2">
                                                                    <!-- Number of Connections Dropdown -->
                                                                    <label for="numConnections"><strong>No. of
                                                                            Connections:</strong></label>
                                                                    <select id="numConnections" name="numConnections"
                                                                        class="form-control" style="width: 100%;"
                                                                        onchange="generateConnectionTable()">
                                                                        <option value="">Select</option>
                                                                        <!-- Options for 1 to 15 connections -->
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                        <option value="13">13</option>
                                                                        <option value="14">14</option>
                                                                        <option value="15">15</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Table for Electric Connection -->
                                                                <div id="connectionTable"
                                                                    style="display: none; margin-top: 20px;">
                                                                    <table class="table table-bordered"
                                                                        style="width: 100%; margin-top: 15px;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sl.NO</th>
                                                                                <th>Building Name</th>
                                                                                <th>Service Number</th>
                                                                                <th>Electricity Type</th>
                                                                                <th>KVA Capacity</th>
                                                                                <th>Year of Installation</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="connectionTableBody">
                                                                            <!-- Rows will be added dynamically here -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <!-- Additional Power Source -->
                                                        <div>
                                                            <div>
                                                                <label><strong>Additional Power Source:</strong> <span
                                                                        style="color: red;">*</span></label>
                                                                <div
                                                                    style="display: flex; gap: 20px; align-items: center;">
                                                                    <div class="form-check">
                                                                        <input type="radio" id="powerSourceYes"
                                                                            name="additional_power_source" value="yes"
                                                                            {{ $result->facilityBuilding->additional_power_source == 1 ? 'checked' : '' }}
                                                                            class="form-check-input">
                                                                        <label for="powerSourceYes"
                                                                            class="form-check-label">Yes</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="radio" id="powerSourceNo"
                                                                            name="additional_power_source" value="no"
                                                                            {{ $result->facilityBuilding->additional_power_source === 0 ? 'checked' : '' }}
                                                                            class="form-check-input">
                                                                        <label for="powerSourceNo"
                                                                            class="form-check-label">No</label>
                                                                    </div>
                                                                </div>

                                                                <!-- Dynamic Inputs for Additional Power Source -->
                                                                <div id="powerSourceDetails"
                                                                    style="display: none; margin-top: 15px;">
                                                                    <label><strong>Select Power Type:</strong></label>
                                                                    <div
                                                                        style="display: flex; gap: 20px; align-items: center;">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="generatorOption"
                                                                                name="power_type" value="generator"
                                                                                {{ $result->facilityBuilding->power_type == 'generator' ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="generatorOption"
                                                                                class="form-check-label">Generator</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="radio" id="upsOption"
                                                                                name="power_type" value="ups"
                                                                                {{ $result->facilityBuilding->power_type == 'ups' ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="upsOption"
                                                                                class="form-check-label">UPS</label>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Inputs for Generator or UPS -->
                                                                    <div id="powerTypeDetails"
                                                                        style="display: none; margin-top: 15px;">
                                                                        <div>
                                                                            <label><strong>Make:</strong></label>
                                                                            <input type="text" class="form-control"
                                                                                name="generator_make"
                                                                                value="{{ $result->facilityBuilding->generator_make }}"
                                                                                placeholder="Enter Make">
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Capacity
                                                                                    (Liters):</strong></label>
                                                                            <input type="number" class="form-control"
                                                                                name="generator_capacity"
                                                                                value="{{ $result->facilityBuilding->generator_capacity }}"
                                                                                placeholder="Enter Capacity">
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Year of
                                                                                    Installation:</strong></label>
                                                                            <input type="number" class="form-control"
                                                                                name="generator_year_of_installation"
                                                                                value="{{ $result->facilityBuilding->generator_year_of_installation }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                            <!-- Internet Connection -->
                                                            <div>
                                                                <div>
                                                                    <label><strong>Internet Connection:</strong> <span
                                                                            style="color: red;">*</span></label>
                                                                    <div
                                                                        style="display: flex; gap: 20px; align-items: center;">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="internetYes"
                                                                                name="internet_connection" value="yes"
                                                                                {{ $result->facilityBuilding->internet_connection === 1 ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="internetYes"
                                                                                class="form-check-label">Yes</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="radio" id="internetNo"
                                                                                name="internet_connection" value="no"
                                                                                {{ $result->facilityBuilding->internet_connection === 0 ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="internetNo"
                                                                                class="form-check-label">No</label>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Dynamic Inputs for Internet Connection -->
                                                                    <div id="internetDetails"
                                                                        style="display: none; margin-top: 15px;">
                                                                        <div>
                                                                            <label><strong>Brand Name:</strong></label>
                                                                            <input type="text" class="form-control"
                                                                                name="internet_brand_name"
                                                                                value="{{ $result->facilityBuilding->internet_brand_name }}"
                                                                                placeholder="Enter Brand Name">
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Payment
                                                                                    Frequency:</strong></label>
                                                                            <select class="form-control"
                                                                                name="internet_payment_frequency">
                                                                                <option value="">Select Frequency
                                                                                </option>
                                                                                <option
                                                                                    {{ SELECT('monthly', $result->facilityBuilding->internet_payment_frequency) }}
                                                                                    value="monthly">Monthly</option>
                                                                                <option
                                                                                    {{ SELECT('six_month', $result->facilityBuilding->internet_payment_frequency) }}
                                                                                    value="six_month">Six-Month</option>
                                                                                <option
                                                                                    {{ SELECT('yearly', $result->facilityBuilding->internet_payment_frequency) }}
                                                                                    value="yearly">Yearly</option>
                                                                            </select>
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Amount Cost (Numbers
                                                                                    Only):</strong></label>
                                                                            <input type="number" class="form-control"
                                                                                name="internet_payment_cost"
                                                                                value="{{ $result->facilityBuilding->internet_payment_cost }}"
                                                                                placeholder="Enter Amount">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                            <!-- Landline Connection -->
                                                            <div>
                                                                <div>
                                                                    <label><strong>Landline Connection:</strong> <span
                                                                            style="color: red;">*</span></label>
                                                                    <div
                                                                        style="display: flex; gap: 20px; align-items: center;">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="landlineYes"
                                                                                name="landline_connection" value="yes"
                                                                                {{ $result->facilityBuilding->landline_connection == 1 ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="landlineYes"
                                                                                class="form-check-label">Yes</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="radio" id="landlineNo"
                                                                                name="landline_connection" value="no"
                                                                                {{ $result->facilityBuilding->landline_connection === 0 ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="landlineNo"
                                                                                class="form-check-label">No</label>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Dynamic Inputs for Landline Connection -->
                                                                    <div id="landlineDetails"
                                                                        style="display: none; margin-top: 15px;">
                                                                        <div>
                                                                            <label><strong>Service Provider
                                                                                    Name:</strong></label>
                                                                            <input type="text" class="form-control"
                                                                                name="landline_service_provider"
                                                                                value="{{ $result->facilityBuilding->landline_service_provider }}"
                                                                                placeholder="Enter Service Provider Name">
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Plan details:</strong></label>
                                                                            <input type="text" class="form-control"
                                                                                name="landline_plan_details"
                                                                                value="{{ $result->facilityBuilding->landline_plan_details }}"
                                                                                placeholder="Enter plan details">
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Payment
                                                                                    Frequency:</strong></label>
                                                                            <select class="form-control"
                                                                                name="landline_payment_frequency">
                                                                                <option value="">Select Frequency
                                                                                </option>
                                                                                <option
                                                                                    {{ SELECT('monthly', $result->facilityBuilding->landline_payment_frequency) }}
                                                                                    value="monthly">Monthly</option>
                                                                                <option
                                                                                    {{ SELECT('quarterly', $result->facilityBuilding->landline_payment_frequency) }}
                                                                                    value="quarterly">Quarterly</option>
                                                                                <option
                                                                                    {{ SELECT('yearly', $result->facilityBuilding->landline_payment_frequency) }}
                                                                                    value="yearly">Yearly</option>
                                                                            </select>
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Amount:</strong></label>
                                                                            <input type="number" class="form-control"
                                                                                name="landline_payment_cost"
                                                                                value="{{ $result->facilityBuilding->landline_payment_cost }}"
                                                                                placeholder="Enter Amount">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                            <!--  -->
                                                            <div>
                                                                <div>
                                                                    <label><strong>Fax Connection:</strong> <span
                                                                            style="color: red;">*</span></label>
                                                                    <div
                                                                        style="display: flex; gap: 20px; align-items: center;">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="faxYes"
                                                                                name="fax_connection" value="yes"
                                                                                {{ $result->facilityBuilding->fax_connection == 1 ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="faxYes"
                                                                                class="form-check-label">Yes</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="radio" id="faxNo"
                                                                                name="fax_connection" value="no"
                                                                                {{ $result->facilityBuilding->fax_connection === 0 ? 'checked' : '' }}
                                                                                class="form-check-input">
                                                                            <label for="faxNo"
                                                                                class="form-check-label">No</label>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Dynamic Inputs for Fax Connection -->
                                                                    <div id="faxDetails"
                                                                        style="display: none; margin-top: 15px;">
                                                                        <div>
                                                                            <label><strong>Service Provider
                                                                                    Name:</strong></label>
                                                                            <input type="text" class="form-control"
                                                                                name="fax_service_provider"
                                                                                value="{{ $result->facilityBuilding->fax_service_provider }}"
                                                                                placeholder="Enter Service Provider Name">
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Plan Details:</strong></label>
                                                                            <input type="text" class="form-control"
                                                                                name="fax_plan_details"
                                                                                value="{{ $result->facilityBuilding->fax_plan_details }}"
                                                                                placeholder="Enter Plan Details">
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Payment
                                                                                    Frequency:</strong></label>
                                                                            <select class="form-control"
                                                                                name="paymentFrequencyFax">
                                                                                <option value="">Select Frequency
                                                                                </option>
                                                                                <option
                                                                                    {{ SELECT('monthly', $result->facilityBuilding->fax_payment_frequency) }}
                                                                                    value="monthly">Monthly</option>
                                                                                <option
                                                                                    {{ SELECT('monthly', $result->facilityBuilding->fax_payment_frequency) }}
                                                                                    value="quarterly">Quarterly</option>
                                                                                <option
                                                                                    {{ SELECT('monthly', $result->facilityBuilding->fax_payment_frequency) }}
                                                                                    value="yearly">Yearly</option>
                                                                            </select>
                                                                        </div>
                                                                        <div>
                                                                            <label><strong>Amount:</strong></label>
                                                                            <input type="number" class="form-control"
                                                                                name="fax_payment_cost"
                                                                                value="{{ $result->facilityBuilding->fax_payment_cost }}"
                                                                                placeholder="Enter Amount">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                            <!--  -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Navigation Buttons -->
                                            <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" />
                                                <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->
                                            
                                            <input type="button" name="next"
                                                class="next action-button btn btn-primary" value="Next" />
                                            <input type="button" name="previous"
                                                class="previous action-button btn btn-secondary" value="Previous" />
                                        </div>
                                    </fieldset>
                                    <!-- Photos -->
                                    <fieldset>
                                        <div class="form-card">
                                            {{-- Common Images --}}
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title text-info">Center Images</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 5 - 7<h2>
                                                </div>
                                            </div>

                                            @if (in_array($result->facility_hierarchy->facility_level_id, [1, 2, 3, 4]))
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Facility Images:</h2>
                                                    </div>
                                                </div>
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="entrance_image" class="form-label">Entrance Image
                                                            </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="entrance_image" name="entrance_image"
                                                                accept="image/*" @if (!isset($entranceImage->image_url))  @endif
                                                                value="{{ $entranceImage->image_url ?? '' }}"
                                                                onchange="previewImage(this, 'EntrancePreview')" />
                                                            @if (isset($entranceImage->image_url))
                                                                <input type="hidden" name="entrance_image_id" value="{{ $entranceImage->id }}">
                                                                <a href="{{ fileLink($entranceImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="entrance_description" placeholder="Enter description for the image">{{ $entranceImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="waiting_area_image" class="form-label">Waiting
                                                            Area Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="waiting_area_image" name="waiting_area_image"
                                                                accept="image/*" @if (!isset($waitingAreaImage->image_url))  @endif
                                                                value="{{ $waitingAreaImage->image_url ?? '' }}"
                                                                onchange="previewImage(this, 'waitingAreaPreview')" />
                                                            @if (isset($waitingAreaImage->image_url))
                                                                <input type="hidden" name="waiting_area_image_id" value="{{ $waitingAreaImage->id }}">
                                                                <a href="{{ fileLink($waitingAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="waiting_area_description" placeholder="Enter description for the image">{{ $waitingAreaImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="toilet_area_image" class="form-label">Toilet and Amenities Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="toilet_area_image" name="toilet_area_image"
                                                                accept="image/*" @if (!isset($toiletAreaImage->image_url))  @endif
                                                                value="{{ $toiletAreaImage->image_url ?? '' }}"
                                                                onchange="previewImage(this, 'waitingAreaPreview')" />
                                                            @if (isset($toiletAreaImage->image_url))
                                                                <input type="hidden" name="toilet_area_image_id" value="{{ $toiletAreaImage->id }}">
                                                                <a href="{{ fileLink($toiletAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="toilet_area_description" placeholder="Enter description for the image">{{ $toiletAreaImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="other_image" class="form-label">Other Image
                                                            <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="other_image"
                                                                name="other_image" accept="image/*"
                                                                value="{{ $otherImage->image_url ?? '' }}"
                                                                onchange="previewImage(this, 'otherPreview')" />
                                                            @if (isset($otherImage->image_url))
                                                                <input type="hidden" name="other_image_id" value="{{ $otherImage->id }}">
                                                                <a href="{{ fileLink($otherImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="other_description" placeholder="Enter description for the image">{{ $otherImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="general_image" class="form-label">General Image
                                                            <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="general_image"
                                                                name="general_image" accept="image/*"
                                                                value="{{ $generalImage->image_url ?? '' }}"
                                                                onchange="previewImage(this, 'generalPreview')" />
                                                            @if (isset($generalImage->image_url))
                                                                <input type="hidden" name="general_image_id" value="{{ $generalImage->id }}">
                                                                <a href="{{ fileLink($generalImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="general_description" placeholder="Enter description for the image">{{ $generalImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                </div>
                                            @endif




                                            {{-- Hsc Images --}}
                                            @if ($result->facility_hierarchy->facility_level_id == 6)
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">HSC Images:</h2>
                                                    </div>
                                                </div>
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="hsc_entrance_image" class="form-label">HSC
                                                            Entrance Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="hsc_entrance_image" name="entrance_image"
                                                                accept="image/*" @if (!isset($entranceImage->image_url))  @endif
                                                                onchange="previewImage(this, 'hscEntrancePreview')" />
                                                            @if (isset($entranceImage->image_url))
                                                                <input type="hidden" name="entrance_image_id" value="{{ $entranceImage->id }}">
                                                                <a href="{{ fileLink($entranceImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="entrance_description" placeholder="Enter description for the image">{{ $entranceImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="waiting_area_image" class="form-label">Waiting
                                                            Area Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="waiting_area_image" name="waiting_area_image"
                                                                accept="image/*" @if (!isset($waitingAreaImage->image_url))  @endif
                                                                onchange="previewImage(this, 'waitingAreaPreview')" />
                                                            @if (isset($waitingAreaImage->image_url))
                                                                <input type="hidden" name="waiting_area_image_id" value="{{ $waitingAreaImage->id }}">
                                                                <a href="{{ fileLink($waitingAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="waiting_area_description" placeholder="Enter description for the image">{{ $waitingAreaImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="toilet_area_image" class="form-label">Toilet and Amenities Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="toilet_area_image" name="toilet_area_image"
                                                                accept="image/*" @if (!isset($toiletAreaImage->image_url))  @endif
                                                                value="{{ $toiletAreaImage->image_url ?? '' }}"
                                                                onchange="previewImage(this, 'waitingAreaPreview')" />
                                                            @if (isset($toiletAreaImage->image_url))
                                                                <input type="hidden" name="toilet_area_image_id" value="{{ $toiletAreaImage->id }}">
                                                                <a href="{{ fileLink($toiletAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="toilet_area_description" placeholder="Enter description for the image">{{ $toiletAreaImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="clinic_area_image" class="form-label">Clinic
                                                            Area Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="clinic_area_image" name="clinic_area_image"
                                                                accept="image/*" @if (!isset($clinicAreaImage->image_url))  @endif
                                                                onchange="previewImage(this, 'clinicAreaPreview')" />
                                                            @if (isset($clinicAreaImage->image_url))
                                                                <input type="hidden" name="clinic_area_image_id" value="{{ $clinicAreaImage->id }}">
                                                                <a href="{{ fileLink($clinicAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="clinic_area_description" placeholder="Enter description for the image">{{ $clinicAreaImage->description ?? '' }}</textarea>

                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="other_image" class="form-label">Other Image
                                                            <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="other_image"
                                                                name="other_image" accept="image/*"
                                                                onchange="previewImage(this, 'otherPreview')" />
                                                            @if (isset($otherImage->image_url))
                                                                <input type="hidden" name="other_image_id" value="{{ $otherImage->id }}">
                                                                <a href="{{ fileLink($otherImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="other_description" placeholder="Enter description for the image">{{ $otherImage->description ?? '' }}</textarea>

                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="general_image" class="form-label">General Image
                                                            <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="general_image"
                                                                name="general_image" accept="image/*"
                                                                onchange="previewImage(this, 'generalPreview')" />
                                                            @if (isset($generalImage->image_url))
                                                                <input type="hidden" name="general_image_id" value="{{ $generalImage->id }}">
                                                                <a href="{{ fileLink($generalImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="general_description" placeholder="Enter description for the image">{{ $generalImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- PHC Images --}}
                                            @if ($result->facility_hierarchy->facility_level_id == 5)
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">PHC Images:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        <!-- <h2 class="steps">Step 5 - 6</h2> -->
                                                    </div>
                                                </div>
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="op_image" class="form-label">OP Image <span
                                                                style="color: red;">*</span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="op_image"
                                                                name="op_image" accept="image/*"
                                                                @if (!isset($opImage->image_url))  @endif
                                                                onchange="previewImage(this, 'opPreview')" />
                                                            @if (isset($opImage->image_url))
                                                                <input type="hidden" name="op_image_id" value="{{ $opImage->id }}">
                                                                <a href="{{ fileLink($opImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="op_description" placeholder="Enter description for the image">{{ $opImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="ip_image" class="form-label">IP Image <span
                                                                style="color: red;">*</span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="ip_image"
                                                                name="ip_image" accept="image/*"
                                                                @if (!isset($ipImage->image_url))  @endif
                                                                onchange="previewImage(this, 'ipPreview')" />
                                                            @if (isset($ipImage->image_url))
                                                                <input type="hidden" name="ip_image_id" value="{{ $ipImage->id }}">
                                                                <a href="{{ fileLink($ipImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="ip_description"
                                                                placeholder="Enter description for the image">{{ $ipImage->description ?? '' }}</textarea>

                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="pharmacy_image" class="form-label">Pharmacy
                                                            Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="pharmacy_image" name="pharmacy_image"
                                                                accept="image/*"
                                                                @if (!isset($pharmacyImage->image_url))  @endif
                                                                onchange="previewImage(this, 'pharmacyPreview')" />
                                                            @if (isset($pharmacyImage->image_url))
                                                                <input type="hidden" name="pharmacy_image_id" value="{{ $pharmacyImage->id }}">
                                                                <a href="{{ fileLink($pharmacyImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="pharmacy_description"
                                                                placeholder="Enter description for the image">{{ $pharmacyImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="lab_image" class="form-label">Lab Image <span
                                                                style="color: red;">*</span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="lab_image"
                                                                name="lab_image" accept="image/*"
                                                                @if (!isset($labImage->image_url))  @endif
                                                                onchange="previewImage(this, 'labPreview')" />
                                                            @if (isset($labImage->image_url))
                                                                <input type="hidden" name="lab_image_id" value="{{ $labImage->id }}">
                                                                <a href="{{ fileLink($labImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="lab_description"
                                                                placeholder="Enter description for the image">{{ $labImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="entrance_image" class="form-label">Entrance
                                                            Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="entrance_image" name="entrance_image"
                                                                accept="image/*"
                                                                @if (!isset($entranceImage->image_url))  @endif
                                                                onchange="previewImage(this, 'entrancePreview')" />
                                                            @if (isset($entranceImage->image_url))
                                                                <input type="hidden" name="entrance_image_id" value="{{ $entranceImage->id }}">
                                                                <a href="{{ fileLink($entranceImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="entrance_description"
                                                                placeholder="Enter description for the image">{{ $entranceImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="waiting_area_phc_image" class="form-label">Waiting
                                                            Area
                                                            Image <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="waiting_area_phc_image"
                                                                name="waiting_area_image" accept="image/*"
                                                                onchange="previewImage(this, 'waitingAreaPhcPreview')" />
                                                            @if (isset($waitingAreaImage->image_url))
                                                                <input type="hidden" name="waiting_area_image_id" value="{{ $waitingAreaImage->id }}">
                                                                <a href="{{ fileLink($waitingAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="waiting_area_description"
                                                                placeholder="Enter description for the image">{{ $waitingAreaImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="toilet_area_image" class="form-label">Toilet and Amenities Image </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="toilet_area_image" name="toilet_area_image"
                                                                accept="image/*" @if (!isset($toiletAreaImage->image_url))  @endif
                                                                value="{{ $toiletAreaImage->image_url ?? '' }}"
                                                                onchange="previewImage(this, 'waitingAreaPreview')" />
                                                            @if (isset($toiletAreaImage->image_url))
                                                                <input type="hidden" name="toilet_area_image_id" value="{{ $toiletAreaImage->id }}">
                                                                <a href="{{ fileLink($toiletAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="toilet_area_description" placeholder="Enter description for the image">{{ $toiletAreaImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="clinic_area_phc_image" class="form-label">Clinic
                                                            Area Image <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="clinic_area_phc_image" name="clinic_area_image"
                                                                accept="image/*"
                                                                onchange="previewImage(this, 'clinicAreaPhcPreview')" />
                                                            @if (isset($clinicAreaImage->image_url))
                                                                <input type="hidden" name="clinic_area_image_id" value="{{ $clinicAreaImage->id }}">
                                                                <a href="{{ fileLink($clinicAreaImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="clinic_area_description"
                                                                placeholder="Enter description for the image">{{ $clinicAreaImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                    <div>
                                                        <label for="other_phc_image" class="form-label">Other PHC
                                                            Image <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control"
                                                                id="other_phc_image" name="other_image"
                                                                accept="image/*"
                                                                onchange="previewImage(this, 'otherPhcPreview')" />
                                                            @if (isset($otherImage->image_url))
                                                                <input type="hidden" name="other_image_id" value="{{ $otherImage->id }}">
                                                                <a href="{{ fileLink($otherImage->image_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div style="position: relative;">
                                                            <textarea class="form-control mt-2" name="other_description"
                                                                placeholder="Enter description for the image">{{ $otherImage->description ?? '' }}</textarea>
                                                        </div>
                                                        <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" onclick="uploadDocument();" />
                                                <input type="button" name="previous"
                                                    class="previous action-button-previous" value="Previous" /> -->
                                            
                                            <input type="button" name="next"
                                                class="next action-button btn btn-primary" value="Next" />
                                            <input type="button" name="previous"
                                                class="previous action-button btn btn-secondary" value="Previous" />
                                        </div>
                                    </fieldset>



                                    <!-- Upload Details -->
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">Upload Details:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 6 - 7</h2>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                <div>
                                                    <label for="video_url" class="form-label">Video URL <span
                                                            style="color: red;">*</span></label>

                                                    <input type="text" class="form-control" id="video_url"
                                                        value="{{ $result->video_url ?? '' }}" name="video_url"
                                                        placeholder="Enter Video URL" />

                                                </div>
                                                <div>
                                                    <label for="land_document" class="form-label">Land Document
                                                        1
                                                        <span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="land_document"
                                                            name="land1_document" accept=".pdf,.doc,.docx"
                                                            @if (!isset($result->facilityDocuments[0]->document_url))  @endif />
                                                        @if (isset($result->facilityDocuments[0]))
                                                            <input type="hidden" name="land1_document_id" value="{{ $result->facilityDocuments[0]->id }}">
                                                            <a href="{{ fileLink($result->facilityDocuments[0]->document_url) }}"
                                                                target="_blank"
                                                                class="btn btn-primary input-group-text">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <small style="color: red;">Upload accepted file types: .pdf,
                                                        .doc, .docx</small>
                                                </div>
                                                <div>
                                                    <label for="land_document" class="form-label">Land Document
                                                        2
                                                        <span style="color: red;"></span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="land_document"
                                                            name="land2_document" accept=".pdf,.doc,.docx" />
                                                        @if (isset($result->facilityDocuments[1]))
                                                        <input type="hidden" name="land2_document_id" value="{{ $result->facilityDocuments[1]->id }}">
                                                            <a href="{{ fileLink($result->facilityDocuments[1]->document_url) }}"
                                                                target="_blank"
                                                                class="btn btn-primary input-group-text">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <small style="color: red;">Upload accepted file types: .pdf,
                                                        .doc, .docx</small>
                                                </div>
                                                <div>
                                                    <label for="land_document" class="form-label">Land Document
                                                        3
                                                        <span style="color: red;"></span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="land_document"
                                                            name="land3_document" accept=".pdf,.doc,.docx" />
                                                        @if (isset($result->facilityDocuments[2]))
                                                            <input type="hidden" name="land3_document_id" value="{{ $result->facilityDocuments[2]->id }}">
                                                            <a href="{{ fileLink($result->facilityDocuments[2]->document_url) }}"
                                                                target="_blank"
                                                                class="btn btn-primary input-group-text">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <small style="color: red;">Upload accepted file types: .pdf,
                                                        .doc, .docx</small>
                                                </div>
                                            </div>
                                            <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" onclick="uploadDocument();" />
                                                <input type="button" name="previous"
                                                    class="previous action-button-previous" value="Previous" /> -->
                                            
                                            <input type="button" name="next"
                                                class="next action-button btn btn-primary" value="Next" />
                                            <input type="button" name="previous"
                                                class="previous action-button btn btn-secondary" value="Previous" />
                                        </div>
                                    </fieldset>



                                    <!-- ID Details -->
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">ID Details:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 7 - 7</h2>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                <div>
                                                    <label for="abdm_health_facility_number" class="form-label">ABDM
                                                        Health Facility Number
                                                        {{-- <span style="color: red;">*</span> --}}
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $result->abdm_facility_number ?? '' }}"
                                                        id="abdm_health_facility_number" name="abdm_facility_number"
                                                        placeholder="Enter ABDM Health Facility Number" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"/>
                                                </div>
                                                <div>
                                                    <label for="nin_number" class="form-label">NIN Number
                                                        {{-- <span style="color: red;">*</span> --}}
                                                    </label>
                                                    <input type="text" class="form-control" id="nin_number"
                                                        value="{{ $result->nin_number ?? '' }}" name="nin_number"
                                                        placeholder="Enter NIN Number" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"/>
                                                </div>
                                                <div>
                                                    <label for="picme" class="form-label">PICME
                                                        {{-- <span style="color: red;">*</span> --}}
                                                    </label>
                                                    <input type="text" class="form-control" id="picme"
                                                        value="{{ $result->picme ?? '' }}" name="picme"
                                                        placeholder="Enter PICME" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"/>
                                                </div>
                                                <div>
                                                    <label for="hmis" class="form-label">HMIS
                                                        {{-- <span style="color: red;">*</span> --}}
                                                    </label>
                                                    <input type="text" class="form-control" id="hmis"
                                                        value="{{ $result->hmis ?? '' }}" name="hmis"
                                                        placeholder="Enter HMIS" 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"/>
                                                </div>
                                            </div>
                                            <input type="submit" class="action-button"></button>
                                            <!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> -->
                                            
                                            <input type="button" name="previous"
                                                class="previous action-button btn btn-secondary" value="Previous" />
                                        </div>
                                    </fieldset>

                                    <!-- Preview ==========================================================================-->
                                    {{-- <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <!-- <h2 class="fs-title">Preview:</h2> -->
                                                </div>
                                                <div class="col-5 text-end">
                                                    <h2 class="steps">Step 7 - 6</h2>
                                                </div>
                                            </div>
                                            <div id="previewContent" class="d-grid gap-4 mb-3"></div>
                                            <input type="button" name="submit"
                                                class="submit action-button btn btn-primary" value="Submit" />
                                            <input type="button" name="previous"
                                                class="previous action-button-previous btn btn-secondary mt-3"
                                                value="Previous" />
                                        </div>
                                    </fieldset> --}}

                                    <!-- Success Popup =====================================================================-->
                                    <div id="successPopup" class="popup" style="display:none;">
                                        <div class="popup-content">
                                            <span class="close" onclick="closePopup()">&times;</span>
                                            <div class="success-icon">
                                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 52 52">
                                                    <circle class="checkmark__circle" cx="26" cy="26"
                                                        r="25" fill="none" />
                                                    <path class="checkmark__check" fill="none"
                                                        d="M14 27l7.8 7.8L38 16" />
                                                </svg>
                                            </div>
                                            <p>Successfully User Created!</p>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <!-- insert the contents Here end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- page inner end-->
        </div>

        <!-- database table end -->
    </div>
    <script>
        $(document).ready(function() {
            var current_fs, next_fs, previous_fs;
    
            // Handle Next button click
            $(".next").click(function() {
                current_fs = $(this).closest("fieldset");
                next_fs = current_fs.next();
    
                var isValid = true;
                var missingFields = [];
    
                // Validate required fields in the current fieldset
                current_fs.find("input[required]").each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).css("border", "2px solid red"); // Highlight empty field
                        var label = $(this).closest("div").find("label").text();
                        missingFields.push(label); // Add label to missing fields
                    } else {
                        $(this).css("border", ""); // Remove red border for valid fields
                    }
                });
    
                if (!isValid) {
                    alert("Please complete all the required fields to proceed.");
                    return false; // Stop the transition to the next fieldset
                }
    
                // Move to the next fieldset if validation is successful
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                next_fs.show();
                current_fs.hide();
            });
    
            // Handle Previous button click
            $(".previous").click(function() {
                current_fs = $(this).closest("fieldset");
                previous_fs = current_fs.prev();
    
                // Move to the previous fieldset
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
                previous_fs.show();
                current_fs.hide();
            });
    
            // Handle Submit button click
            $(".submit").click(function() {
                $("#successPopup").show();
            });
        });
    
        // Function to close the success popup
        function closePopup() {
            document.getElementById("successPopup").style.display = "none";
        }
    </script>
    

    <script>
        // if (!isValid) {
        //     // Show alert with missing field labels
        //     alert("Please fill in the following fields:\n" + missingFields.join("\n"));
        //     return false; // Prevent moving to the next step
        // }

        // If all fields are valid, proceed to the next step
        const result = @json($result);
        // Function to toggle input fields based on the selected building status
        function toggleInputs() {
            const buildingStatus = document.querySelector('input[name="building_status"]:checked')?.value;
            const commonInputs = document.getElementById('commonInputs');
            const stageDropdownContainer = document.getElementById('stageDropdownContainer');
            const progressBarContainer = document.getElementById('progressBarContainer');
            const stageContent = document.getElementById('stageContent');
            // const nextStageButton = document.getElementById('nextStageButton');
            const additionalInputsContainer = document.getElementById('additionalInputsContainer');
            const stageHistoryLog = document.getElementById('stageHistoryLog');

            // Reset all containers and hide stage-related elements
            commonInputs.style.display = "none";
            stageDropdownContainer.style.display = "none";
            progressBarContainer.style.display = "none";
            stageContent.innerHTML = "";
            // nextStageButton.style.display = "none";
            if (additionalInputsContainer) additionalInputsContainer.innerHTML = ""; // Clear previous inputs

            // Display common inputs for specific building statuses
            if (buildingStatus === "own" || buildingStatus === "rent_free" || buildingStatus === "rented" ||
                buildingStatus === "public_building") {
                commonInputs.style.display = "block";
            }

            // If "Under Construction" is selected, show the stage dropdown and progress bar
            if (buildingStatus === "under_construction") {
                stageDropdownContainer.style.display = "block";
                progressBarContainer.style.display = "block";
                // nextStageButton.style.display = "block";
            }

            // Handle building-specific inputs for "own", "rent_free", "rented", "public"
            if (additionalInputsContainer) additionalInputsContainer.style.display =
                "none"; // Hide the additional inputs container by default

            if (buildingStatus === "own") {
                if (additionalInputsContainer) additionalInputsContainer.style.display = "block";
                const ownDocURL = result.facility_building.own_go_ms_no_pdf_path ?
                    `${result.facility_building.own_go_ms_no_pdf_path}` : null;
                let ownGoMSNoValue = result.facility_building.own_go_ms_no || '';
                stageContent.innerHTML += `
                    <div>
                        <label><strong>GO.MS.No (Upload PDF):</strong> <span style="color: red;">*</span></label>
                        <input type="file" class="form-control" accept="application/pdf" name="own_go_ms_no_pdf_path">
                        ${ownDocURL ? `<a href="${ownDocURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}
                    </div>
                    <div>
                        <label><strong>GO.MS.No:</strong> <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter GO.MS.No" name="own_go_ms_no" value="${ownGoMSNoValue}">
                    </div>
                    <div>
                        <label><strong>Date:</strong> <span style="color: red;">*</span></label>
                        <input type="date" class="form-control" name="own_date" value="${result.facility_building.own_date}">
                    </div>
                    <div>
                        <label><strong>Total Amount (Numbers Only):</strong> <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" placeholder="Enter Total Amount" name="own_total_amount" value="${result.facility_building.own_total_amount}">
                    </div>

                    <!-- Radio Buttons for PWD and Private Concern -->
                    <div class="mt-3">
                    <hr>
                        <label><strong>Type of Concern:</strong> <span style="color: red;">*</span></label>
                        <div class="form-check">
                            <input type="radio" id="pwdOption" value="pwd" class="form-check-input" name="work_completed_by" ${ result.facility_building.work_completed_by == 'pwd' ? 'checked' : '' }>
                            <label for="pwdOption" class="form-check-label">PWD</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="privateOption" value="private_concern" class="form-check-input" name="work_completed_by" ${ result.facility_building.work_completed_by == 'private_concern' ? 'checked' : '' }>
                            <label for="privateOption" class="form-check-label">Private Concern</label>
                        </div>
                    </div>

                    <!-- Dynamic Inputs for PWD or Private Concern -->
                    <div id="dynamicConcernInputs" class="mt-3"></div>

                    <!-- Inauguration Status -->
                    <div class="mt-3">
                    <hr>
                        <label><strong>Inauguration Status:</strong> <span style="color: red;">*</span></label>
                        <div class="form-check">
                            <input type="radio" name="inauguration_status" id="completedOption" value="completed" class="form-check-input" ${ result.facility_building.inauguration_status == 'completed' ? 'checked' : '' }>
                            <label for="completedOption" class="form-check-label">Completed</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="inauguration_status" id="readyOption" value="ready" class="form-check-input" ${ result.facility_building.inauguration_status == 'ready' ? 'checked' : '' }>
                            <label for="readyOption" class="form-check-label">Ready for Inauguration</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="inauguration_status" id="notFixedOption" value="not_fixed" class="form-check-input" ${ result.facility_building.inauguration_status == 'not_fixed' ? 'checked' : '' }>
                            <label for="notFixedOption" class="form-check-label">Not Fixed</label>
                        </div>
                    </div>
                    <div id="dynamicInaugurationInputs" class="mt-3"></div>

                    <!-- Culvert Status -->
                    <div class="mt-3">
                    <hr>
                        <label><strong>Culvert Status:</strong> <span style="color: red;">*</span></label>
                        <div class="form-check">
                            <input type="radio" name="culvert_status" id="culvertYes" value="yes" class="form-check-input" ${ result.facility_building.culvert_status == 1 ? 'checked' : '' }>
                            <label for="culvertYes" class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="culvert_status" id="culvertNo" value="no" class="form-check-input" ${ result.facility_building.culvert_status === 0 ? 'checked' : '' }>
                            <label for="culvertNo" class="form-check-label">No</label>
                        </div>

                    </div>
                    <div id="dynamicCulvertInputs" class="mt-3"></div>

                    <!-- Compound Wall -->
                    <div class="mt-3">
                    <hr>
                        <label><strong>Compound Wall:</strong> <span style="color: red;">*</span></label>
                        <div class="form-check">
                            <input type="radio" name="compound_wall_status" id="fullyOption" value="fully" class="form-check-input" ${ result.facility_building.compound_wall_status == 'fully' ? 'checked' : '' }>
                            <label for="fullyOption" class="form-check-label">Fully</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="compound_wall_status" id="partialOption" value="partial" class="form-check-input" ${ result.facility_building.compound_wall_status == 'partial' ? 'checked' : '' }>
                            <label for="partialOption" class="form-check-label">Partial</label>
                        </div>
                    </div>
                `;

                // Event listener for Type of Concern
                document.querySelectorAll('input[name="work_completed_status"]').forEach((radio) => {
                    radio.addEventListener('change', function() {
                        const dynamicInputs = document.getElementById('dynamicConcernInputs');
                        if (this.value === "pwd") {
                            dynamicInputs.innerHTML = `
                                <div>
                                    <label><strong>Enter Details for PWD:</strong></label>
                                    <input type="text" class="form-control" placeholder="Enter details for PWD" name="work_completed_details" value="${result.facility_building.work_completed_details}">
                                </div>
                                <div>
                                    <label><strong>Enter Date for PWD:</strong></label>
                                    <input type="date" class="form-control" name="work_completed_date" value="${result.facility_building.work_completed_date}">
                                </div>
                            `;
                        } else if (this.value === "private_concern") {
                            dynamicInputs.innerHTML = `
                                <div>
                                    <label><strong>Enter Details for Private Concern:</strong></label>
                                    <input type="text" class="form-control" placeholder="Enter details for Private Concern" name="work_completed_details" value="${result.facility_building.work_completed_details}">
                                </div>
                                <div>
                                    <label><strong>Enter Date for Private Concern:</strong></label>
                                    <input type="date" class="form-control" name="work_completed_date" value="${result.facility_building.work_completed_date}">
                                </div>
                            `;
                        }
                    });
                });

                // Event listener for Inauguration Status
                document.querySelectorAll('input[name="inauguration_status"]').forEach((radio) => {
                    radio.addEventListener('change', function() {
                        const dynamicInputs = document.getElementById('dynamicInaugurationInputs');
                        const inaugurationImageURL = result.facility_building.inauguration_images;
                        const readyImageURL = result.facility_building.ready_current_images;
                        result.facility_building.inauguration_by = result.facility_building.inauguration_by || '';
                        if (this.value === "completed") {
                            dynamicInputs.innerHTML = `
                                <div>
                                    <label><strong>Whom:</strong></label>
                                    <input type="text" class="form-control" placeholder="Whom" name="inauguration_by" value="${result.facility_building.inauguration_by}">
                                </div>
                                <div>
                                    <label><strong>Inaugurate Date:</strong></label>
                                    <input type="date" class="form-control" name="inauguration_date" value="${result.facility_building.inauguration_date}">
                                </div>
                                <div>
                                    <label><strong>Inaugurate Image:</strong></label>
                                    <input type="file" class="form-control" accept="image/*" name="inauguration_images">
                                    ${inaugurationImageURL ? `<a href="${inaugurationImageURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}

                                </div>
                            `;
                        } else if (this.value === "ready") {
                            dynamicInputs.innerHTML = `
                                <div>
                                    <label><strong>Whom to Inaugurate:</strong></label>
                                    <input type="text" class="form-control" placeholder="Whom to Inaugurate" name="ready_who_inaugurate" value="${result.facility_building.ready_who_inaugurate}">
                                </div>
                                <div>
                                    <label><strong>Date:</strong></label>
                                    <input type="date" class="form-control" name="ready_inaugurate_fixed_date" value="${result.facility_building.ready_inaugurate_fixed_date}">
                                </div>
                                <div>
                                    <label><strong>Ready Condition Image:</strong></label>
                                    <input type="file" class="form-control" accept="image/*" name="ready_current_images">
                                    ${readyImageURL ? `<a href="${readyImageURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}

                                </div>
                            `;
                        } else if (this.value === "not_fixed") {
                            dynamicInputs.innerHTML = `
                                    <div>
                                        <label><strong>Status:</strong> Not Fixed</label>
                                    </div>
                                `;
                        }
                    });
                });

                renderDynamicCulvertInputs();
                document.querySelectorAll('input[name="culvert_status"]').forEach((radio) => {
                    radio.addEventListener('change', function() {
                        const newStatus = this.value === "yes" ? 1 : 0; // Convert "yes"/"no" to numeric values
                        renderDynamicCulvertInputs(newStatus); // Re-render inputs based on the new selection
                    });
                });

                renderDynamicInaugurationInputs();
                document.querySelectorAll('input[name="inauguration_status"]').forEach((radio) => {
                    radio.addEventListener('change', function () {
                        renderDynamicInaugurationInputs(this.value); // Re-render inputs based on the new selection
                    });
                });
                // Event listener for Culvert Status
                // document.querySelectorAll('input[name="culvert_status"]').forEach((radio) => {
                //     radio.addEventListener('change', function() {
                //         const culvertImageURL = result.facility_building.inauguration_images;
                //         const dynamicInputs = document.getElementById('dynamicCulvertInputs');
                //         if (this.value === "yes" || culvertStatus) {
                //             dynamicInputs.innerHTML = `
                //                 <div>
                //                     <label><strong>Upload Culvert Image:</strong></label>
                //                     <input type="file" name="culvert_image" class="form-control" accept="image/*">
                //                     ${culvertImageURL ? `<a href="${culvertImageURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}

                //                 </div>
                //                 <div>
                //                     <label><strong>Culvert Date:</strong></label>
                //                     <input name="culvert_date_of_installation" type="date" class="form-control">
                //                 </div>
                //             `;
                //         } else {
                //             dynamicInputs.innerHTML = ''; // Clear inputs for "No"
                //         }
                //     });
                // });
            } else if (buildingStatus === "rent_free") {
                if (additionalInputsContainer) additionalInputsContainer.style.display = "block";
                const rentFreePermissionLetterURL = result.facility_building.rent_free_permission_letter ?
                    `${result.facility_building.rent_free_permission_letter}` : null;
                stageContent.innerHTML += `
                <div>
                    <label><strong>Allocated By Whom:</strong> <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Allocator Name" name="rent_free_allocated_by" value="${result.facility_building.rent_free_allocated_by}">
                </div>
                <div>
                    <label><strong>Date:</strong> <span style="color: red;">*</span></label>
                    <input type="date" class="form-control" name="rent_free_date" value="${result.facility_building.rent_free_date}">
                </div>
                <div>
                    <label><strong>No. of Years (Numbers Only):</strong> <span style="color: red;">*</span></label>
                    <input type="number" class="form-control" name="rent_free_no_of_years" value="${result.facility_building.rent_free_no_of_years}">
                </div>
                <div>
                    <label><strong>Permission Letter (Upload):</strong> <span style="color: red;">*</span></label>
                    <input type="file" class="form-control" accept="application/pdf" name="rent_free_permission_letter">
                    ${rentFreePermissionLetterURL ? `<a href="${rentFreePermissionLetterURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}
                </div>
            `;
            } else if (buildingStatus === "rented") {
                if (additionalInputsContainer) additionalInputsContainer.style.display = "block";
                const agreementLetterURL = result.facility_building.rented_lease_document_path ?
                    `${result.facility_building.rented_lease_document_path}` : null;
                stageContent.innerHTML += `
                    <div>
                        <label><strong>Payment Frequency:</strong> <span style="color: red;">*</span></label>
                        <select class="form-select" name="rented_payment_frequency">
                            <option value="">Select Frequency</option>
                            <option value="monthly" ${result.facility_building.rented_payment_frequency === 'monthly' ? 'selected' : ''}>Monthly</option>
                            <option value="yearly" ${result.facility_building.rented_payment_frequency === 'yearly' ? 'selected' : ''}>Yearly</option>
                            <option value="lease" ${result.facility_building.rented_payment_frequency === 'lease' ? 'selected' : ''}>Lease</option>
                        </select>
                    </div>
                    <div>
                        <label><strong>Amount (Numbers Only):</strong> <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" placeholder="Enter Amount" name="rented_amount" value="${result.facility_building.rented_amount}">
                    </div>
                    <div>
                        <label><strong>Upload Agreement/Receipt:</strong> <span style="color: red;">*</span></label>
                        <input type="file" class="form-control" accept="application/pdf" name="rented_lease_document_path">
                        ${agreementLetterURL ? `<a href="${agreementLetterURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}
                    </div>
                `;
            } else if (buildingStatus === "public_building") {
                if (additionalInputsContainer) additionalInputsContainer.style.display = "block";
                const permissionLetterURL = result.facility_building.public_permission_letter ?
                    `${result.facility_building.public_permission_letter}` : null;
                stageContent.innerHTML += `
                <div>
                    <label><strong>Allocated By Whom:</strong> <span style="color: red;">*</span></label>
                    <input type="text" name="public_allocated_by" value="${result.facility_building.public_allocated_by}" class="form-control" placeholder="Enter Allocator Name">
                </div>
                <div>
                    <label><strong>Date:</strong> <span style="color: red;">*</span></label>
                    <input type="date" class="form-control" name="public_date" value="${result.facility_building.public_date}">
                </div>
                <div>
                    <label><strong>No. of Years (Numbers Only):</strong> <span style="color: red;">*</span></label>
                    <input type="number" class="form-control" placeholder="Enter No. of Years" name="public_no_of_years" value="${result.facility_building.public_no_of_years}" placeholder="Enter No. of Years">
                </div>
                <div>
                    <label><strong>Upload Permission Letter:</strong> <span style="color: red;">*</span></label>
                    <input type="file" class="form-control" name="public_permission_letter" accept="application/pdf">
                    ${permissionLetterURL ? `<a href="${permissionLetterURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}
                </div>
            `;
            }
        }
        function renderDynamicCulvertInputs(culvertStatus = null) {
            const dynamicInputs = document.getElementById('dynamicCulvertInputs');
            const culvertImageURL = result.facility_building.culvert_image_path;
            culvertStatus = culvertStatus !== null ? culvertStatus : result.facility_building.culvert_status;
            if (culvertStatus === 1 || culvertStatus === "yes") {
                dynamicInputs.innerHTML = `
                    <div>
                        <label><strong>Upload Culvert Image:</strong></label>
                        <input type="file" name="culvert_image" class="form-control" accept="image/*">
                        ${culvertImageURL ? `<a href="${culvertImageURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}
                    </div>
                    <div>
                        <label><strong>Culvert Date:</strong></label>
                        <input name="culvert_date_of_installation" value="${result.facility_building.culvert_date_of_installation || ''}" type="date" class="form-control">
                    </div>
                `;
            } else {
                dynamicInputs.innerHTML = '';
            }
        }

        function renderDynamicInaugurationInputs(inaugurationStatus = null) {
            const dynamicInputs = document.getElementById('dynamicInaugurationInputs');
            const inaugurationImageURL = result.facility_building.inauguration_images;
            const readyImageURL = result.facility_building.ready_current_images;

            // Use the provided inaugurationStatus or default to the current value in `result`
            inaugurationStatus = inaugurationStatus !== null ? inaugurationStatus : result.facility_building.inauguration_status;

            if (inaugurationStatus === "completed") {
                dynamicInputs.innerHTML = `
                    <div>
                        <label><strong>Whom:</strong></label>
                        <input type="text" class="form-control" placeholder="Whom" name="inauguration_by" value="${result.facility_building.inauguration_by || ''}">
                    </div>
                    <div>
                        <label><strong>Inaugurate Date:</strong></label>
                        <input type="date" class="form-control" name="inauguration_date" value="${result.facility_building.inauguration_date || ''}">
                    </div>
                    <div>
                        <label><strong>Inaugurate Image:</strong></label>
                        <input type="file" class="form-control" accept="image/*" name="inauguration_images">
                        ${inaugurationImageURL ? `<a href="${inaugurationImageURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}
                    </div>
                `;
            } else if (inaugurationStatus === "ready") {
                dynamicInputs.innerHTML = `
                    <div>
                        <label><strong>Whom to Inaugurate:</strong></label>
                        <input type="text" class="form-control" placeholder="Whom to Inaugurate" name="ready_who_inaugurate" value="${result.facility_building.ready_who_inaugurate || ''}">
                    </div>
                    <div>
                        <label><strong>Date:</strong></label>
                        <input type="date" class="form-control" name="ready_inaugurate_fixed_date" value="${result.facility_building.ready_inaugurate_fixed_date || ''}">
                    </div>
                    <div>
                        <label><strong>Ready Condition Image:</strong></label>
                        <input type="file" class="form-control" accept="image/*" name="ready_current_images">
                        ${readyImageURL ? `<a href="${readyImageURL}" target="_blank" class="btn btn-primary btn-sm">View</a>` : ''}
                    </div>
                `;
            } else if (inaugurationStatus === "not_fixed") {
                dynamicInputs.innerHTML = `
                    <div>
                        <label><strong>Status:</strong> Not Fixed</label>
                    </div>
                `;
            } else {
                dynamicInputs.innerHTML = ''; // Clear if no valid status
            }
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            const stageDropdown = document.getElementById('stageDropdown');
            const progressBar = document.getElementById('progressBar');
            const stageContent = document.getElementById('stageContent');
            const progressBarContainer = document.getElementById('progressBarContainer');
            // const nextStageButton = document.getElementById('nextStageButton');
            const historyTableBody = document.getElementById('historyTableBody');

            let currentStageIndex = stageDropdown.selectedIndex;
            handleStageChange();
            displayHistoryLog();

            // Event listener for stage dropdown change
            stageDropdown.addEventListener('change', handleStageChange);

            // Handle stage change and update UI
            function handleStageChange() {
                const selectedStage = stageDropdown.value;

                if (selectedStage) {
                    progressBarContainer.style.display = 'block';
                    currentStageIndex = stageDropdown.selectedIndex;
                    const totalStages = stageDropdown.options.length - 1;

                    // Update progress bar
                    progressBar.style.width = `${(currentStageIndex / totalStages) * 100}%`;
                    progressBar.setAttribute('aria-valuenow', currentStageIndex);
                    progressBar.innerHTML = `Stage ${currentStageIndex} of ${totalStages}`;

                    // Generate and display content for the selected stage
                    stageContent.innerHTML = generateStageContent(selectedStage);


                    // Add event listener for "Submit Stage" button
                    const submitButton = document.getElementById('submitStageButton');
                    if (submitButton) {
                        submitButton.addEventListener('click', () => submitStage(selectedStage));
                    }
                } else {
                    progressBarContainer.style.display = 'none';
                    stageContent.innerHTML = '';
                }
            }

            // Generate content for the selected stage
            function generateStageContent(selectedStage) {
                let content = '';
                // Logic for generating stage-specific content
                if (["land_identified", "basement_level", "wall_level", "lintel_level", "roof_level",
                        "g_work_started"
                    ].includes(selectedStage)) {
                    content = `<label><strong>Upload Images for Stage (${selectedStage}):</strong></label>
                                ${generateImageUploadInputs(selectedStage)}`;
                } else if (selectedStage === "service_support_electricity") {
                    const wiringStatus = result.facility_building.electricity_wiring_status || '';
                    content =
                        `
                        <label><strong>Wiring:</strong></label>
                        <div class="form-check">
                            <input type="radio" name="electricity_wiring_status" ${wiringStatus === 'completed' ? 'checked' : ''} value="completed" class="form-check-input">
                            <label>Completed</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="electricity_wiring_status" ${wiringStatus === 'partial' ? 'checked' : ''} value="partial" class="form-check-input">
                            <label>Partial</label>
                        </div>
                        <button id="submitStageButton" type="button" class="btn btn-success mt-2 float-end">Submit Stage</button>`;
                } else if (selectedStage === "service_support_water") {
                    content =
                        `
                        <label><strong>Water Connection:</strong></label>
                        <input type="text" class="form-control" name="water_connection_details" placeholder="Enter details">
                        <input type="date" class="form-control" name="water_connection_date">
                        <button id="submitStageButton" type="button" class="btn btn-success mt-2 float-end">Submit Stage</button>`;

                } else if (selectedStage === "service_support_carpentary") {
                    content =
                        `
                        <label><strong>Carpentry Details:</strong></label>
                        <input type="number" name="carpentry_doors" value="${result.facility_building.carpentry_doors || ''}" class="form-control" placeholder="Number of doors">
                        <input type="number" name="carpentry_windows" value="${result.facility_building.carpentry_windows || ''}" class="form-control mt-2" placeholder="Number of windows">
                        <input type="number" name="carpentry_cupboards" value="${result.facility_building.carpentry_cupboards || ''}" class="form-control mt-2" placeholder="Number of cupboards">
                        <button id="submitStageButton" type="button" class="btn btn-success mt-2 float-end">Submit Stage</button>`;
                } else if (selectedStage === "painting") {
                    content =
                        `
                        <label><strong>Painting Status:</strong></label>
                        <div class="form-check">
                            <input type="radio" name="building_paint_status" value="completed" class="form-check-input">
                            <label>Completed</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="building_paint_status" value="incomplete" class="form-check-input">
                            <label>Incomplete</label>
                        </div>
                        <button id="submitStageButton" type="button" class="btn btn-success mt-2 float-end">Submit Stage</button>`;
                }
                return content;
            }

            // Generate image upload inputs
            function generateImageUploadInputs(stage) {
                console.log(stage)
                let imageInputs = '';
                const existingImages = @json($currentConstructionImages);
                const filteredImages = existingImages.filter(image => image.under_construction_status === stage);
                console.log(filteredImages);
                for (let i = 1; i <= 10; i++) {
                    if (i % 2 === 1) imageInputs += `<div class="d-flex gap-4 mb-3">`;
                    const existingImage = filteredImages[i - 1];
                    imageInputs += `
                        <div class="col-6">
                            <label><strong>Image ${i} (${stage}):</strong></label>
                            <div class="input-group">
                                <input type="file" name="under_construction_image${i}" class="form-control" accept="image/*">
                               ${existingImage ? `
                                        <a href="${existingImage.image_url}" target="_blank" class="input-group-text text-decoration-none" style="background-color: #007bff; color: white; border-radius: 0.375rem;">
                                            View
                                        </a>` : ''}
                            </div>
                        </div>`;
                    if (i % 2 === 0 || i === 10) imageInputs += `</div>`;
                }
                return imageInputs;
            }

            function displayHistoryLog() {
                // Clear the existing table rows
                const oldConstructionImages = @json($oldConstructionImages);
                historyTableBody.innerHTML = '';
                console.log(oldConstructionImages); // Debugging to check the data structure

                // Check if we have any history to display
                if (Object.keys(oldConstructionImages).length > 0) {
                    stageHistoryLog.style.display = 'block';

                    // Loop through each construction status (status as the key, images as the array)
                    Object.keys(oldConstructionImages).forEach(status => {
                        // Get the array of images for the current status
                        const images = oldConstructionImages[status];

                        // Only display if images are present for the current status
                        if (images && images.length > 0) {
                            // Create a row for the current status
                            const row = document.createElement('tr');

                            // For the Details column, show image links (separate if there are multiple images)
                            const imageLinks = images.map(img =>
                                `<a href="${img.image_url}" target="_blank">View Image</a>`
                            ).join('<br>'); // Join them with <br> to separate the links

                            // Add the status, image links, and date to the row
                            row.innerHTML = `
                                <td>${status}</td>
                                <td>
                                    ${imageLinks || 'No images available'}
                                </td>
                                <td>${new Date(images[0].created_at).toLocaleString()}</td>
                            `;

                            // Append the row to the table
                            historyTableBody.appendChild(row);
                        }
                    });
                } else {
                    stageHistoryLog.style.display = 'none'; // Hide the history log if no data
                }
            }



        });
    </script>
    <!-- RO Water -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const roWaterYes = document.getElementById('roWaterYes');
            const roWaterNo = document.getElementById('roWaterNo');
            const roWaterDetails = document.getElementById('roWaterDetails');

            function updateROWaterDetails() {
                if (roWaterYes.checked) {
                    roWaterDetails.style.display = 'block'; // Show RO Water details inputs
                } else {
                    roWaterDetails.style.display = 'none'; // Hide RO Water details inputs
                }
            }

            roWaterYes.addEventListener('change', updateROWaterDetails);
            roWaterNo.addEventListener('change', updateROWaterDetails);

            // Initial visibility on page load
            updateROWaterDetails();
        });
    </script>
    <!-- Service -->
    <script>
        let existingElectricConnections = [];
        existingElectricConnections = result.facility_building.electric_connections || [];
        // console.log(existingElectricConnections);

        function generateConnectionTable() {
            const numConnections = document.getElementById('numConnections').value;
            const connectionTable = document.getElementById('connectionTable');
            const connectionTableBody = document.getElementById('connectionTableBody');

            // Clear existing rows
            connectionTableBody.innerHTML = '';

            // Check if there are connections to display
            if (numConnections) {
                connectionTable.style.display = 'block'; // Show the table

                // Parse the JSON string into an array of connections
                const electricConnections = existingElectricConnections.length > 0
                    ? JSON.parse(existingElectricConnections)
                    : []; // Use fallback if no data exists
                console.log("Parsed Connections:", electricConnections);
                console.log(electricConnections);
                for (let i = 0; i < numConnections; i++) {
                    const row = document.createElement('tr');
                    const connection = electricConnections[i];

                    // Sl. No
                    const slNoCell = document.createElement('td');
                    slNoCell.textContent = i + 1;
                    row.appendChild(slNoCell);

                    // Building Name
                    const buildingNameCell = document.createElement('td');
                    buildingNameCell.innerHTML = `
                        <input type="text" class="form-control" name="building_name_${i+1}" placeholder="Enter Building Name" value="${connection?.building_name || ''}">
                    `;
                    row.appendChild(buildingNameCell);

                    // Service Number
                    const serviceNumberCell = document.createElement('td');
                    serviceNumberCell.innerHTML = `
                        <input type="text" class="form-control" name="service_number_${i+1}" placeholder="Enter Service Number" value="${connection?.service_number || ''}">
                    `;
                    row.appendChild(serviceNumberCell);

                    // Electricity Type (LT/HT)
                    const electricityTypeCell = document.createElement('td');
                    electricityTypeCell.innerHTML = `
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <div class="form-check">
                                <input type="radio" id="lt_${i+1}" name="electricity_type_${i+1}" value="LT" class="form-check-input" ${connection?.electricity_type === 'LT' ? 'checked' : ''}>
                                <label for="lt_${i+1}" class="form-check-label">LT</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="ht_${i+1}" name="electricity_type_${i+1}" value="HT" class="form-check-input" ${connection?.electricity_type === 'HT' ? 'checked' : ''}>
                                <label for="ht_${i+1}" class="form-check-label">HT</label>
                            </div>
                        </div>
                    `;
                    row.appendChild(electricityTypeCell);

                    // KVA Capacity
                    const kvaCapacityCell = document.createElement('td');
                    kvaCapacityCell.innerHTML = `
                        <input type="number" class="form-control" name="kva_capacity_${i+1}" placeholder="Enter KVA Capacity" value="${connection?.kva_capacity || ''}">
                    `;
                    row.appendChild(kvaCapacityCell);

                    // Year of Installation
                    const yearOfInstallationCell = document.createElement('td');
                    yearOfInstallationCell.innerHTML = `
                        <input type="number" class="form-control" name="year_installation_${i+1}" placeholder="Enter Year" value="${connection?.year_of_installation || ''}">
                    `;
                    row.appendChild(yearOfInstallationCell);

                    // Append the row to the table body
                    connectionTableBody.appendChild(row);
                }
            } else {
                connectionTable.style.display = 'none'; // Hide the table if no option selected
            }
        }

        // Pre-select the number of connections and generate the table
        document.addEventListener('DOMContentLoaded', () => {
            const electricConnections = existingElectricConnections.length > 0
                ? JSON.parse(existingElectricConnections)
                : []; // Use fallback if no data exists
            const numConnections = electricConnections.length || document.getElementById('numConnections').value;
            document.getElementById('numConnections').value = numConnections;
            generateConnectionTable();
        });
    </script>
    <script>
        // function setupToggleVisibility(radioName, detailsContainerId, showValue = "yes") {
        //     const detailsContainer = document.getElementById(detailsContainerId);

        //     // Function to update visibility
        //     function updateVisibility() {
        //         const checkedRadio = document.querySelector(`input[name="${radioName}"]:checked`);
        //         if (checkedRadio && checkedRadio.value === showValue) {
        //             detailsContainer.style.display = "block";
        //         } else {
        //             detailsContainer.style.display = "none";
        //         }
        //     }

        //     // Attach event listeners to radio buttons
        //     document.querySelectorAll(`input[name="${radioName}"]`).forEach((radio) => {
        //         radio.addEventListener('change', updateVisibility);
        //     });

        //     // Initialize visibility on page load
        //     updateVisibility();
        // }

        // // Call the function for each group
        // document.addEventListener('DOMContentLoaded', function() {
        //     setupToggleVisibility('additional_power_source', 'powerSourceDetails');
        //     setupToggleVisibility('power_type', 'powerTypeDetails'); // Power Type radios
        //     setupToggleVisibility('internet_connection', 'internetDetails');
        //     setupToggleVisibility('landline_connection', 'landlineDetails');
        //     setupToggleVisibility('fax_connection', 'faxDetails');
        // });


        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for Additional Power Source radio buttons
            document.querySelectorAll('input[name="additional_power_source"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    const powerSourceDetails = document.getElementById('powerSourceDetails');
                    if (this.value === "yes") {
                        powerSourceDetails.style.display = "block";
                    } else {
                        powerSourceDetails.style.display = "none";
                        document.getElementById('powerTypeDetails').style.display = "none";
                    }
                });
            });

            // Event listener for Power Type radio buttons
            document.querySelectorAll('input[name="power_type"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    const powerTypeDetails = document.getElementById('powerTypeDetails');
                    powerTypeDetails.style.display = "block";
                });
            });
        });

        // Landline connection
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for Landline Connection radio buttons
            document.querySelectorAll('input[name="landline_connection"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    const landlineDetails = document.getElementById('landlineDetails');
                    if (this.value === "yes") {
                        landlineDetails.style.display = "block";
                    } else {
                        landlineDetails.style.display = "none";
                    }
                });
            });
        });
        // Fax details
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for Fax Connection radio buttons
            document.querySelectorAll('input[name="fax_connection"]').forEach((radio) => {
                radio.addEventListener('change', function() {
                    const faxDetails = document.getElementById('faxDetails');
                    if (this.value === "yes") {
                        faxDetails.style.display = "block";
                    } else {
                        faxDetails.style.display = "none";
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="building_status"]:checked');
            if (checkedRadio) {
                toggleInputs();
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            // Initialize Select2 on the dropdown
            $('#fundingDropdown').select2({
                placeholder: 'Select Source of Funding',
                allowClear: true
            });

            // Event listener to handle selections
            $('#fundingDropdown').on('change', function() {
                const selectedContainer = document.getElementById('selectedContainer');
                selectedContainer.innerHTML = '';

                $(this).find(':selected').each(function() {
                    const item = document.createElement('div');
                    item.classList.add('selected-item');
                    item.style.display = 'inline-block';
                    item.style.marginRight = '10px';
                    item.style.padding = '5px';
                    item.style.border = '1px solid #ccc';
                    item.style.borderRadius = '5px';
                    item.style.backgroundColor = '#f8f9fa';

                    item.textContent = this.textContent;

                    selectedContainer.appendChild(item);
                });
            });
        });

        // Approach  Road:
        document.addEventListener('DOMContentLoaded', function() {
            const roadTypeContainer = document.getElementById('roadTypeContainer');
            const yesRadio = document.getElementById('approachRoadYes');
            const noRadio = document.getElementById('approachRoadNo');

            // Function to toggle the road type container visibility
            function toggleRoadTypeContainer() {
                if (yesRadio.checked) {
                    roadTypeContainer.style.display = 'block'; // Show when "Yes" is selected
                } else {
                    roadTypeContainer.style.display = 'none'; // Hide otherwise
                }
            }

            // Attach event listeners to the radio buttons
            yesRadio.addEventListener('change', toggleRoadTypeContainer);
            noRadio.addEventListener('change', toggleRoadTypeContainer);

            // Initial state check based on preselected value
            toggleRoadTypeContainer();
        });
    </script>

    <script>

        // Event listeners for Water Tank
        function handleDynamicInputs(radioName, inputContainerId, inputFieldName, inputValue) {
            const inputContainer = document.getElementById(inputContainerId);
            const checkedRadio = document.querySelector(`input[name="${radioName}"]:checked`);
            if (checkedRadio && checkedRadio.value === "yes") {
                inputContainer.innerHTML = `
                    <div>
                        <label><strong>Capacity (Liters):</strong></label>
                        <input type="number" name="${inputFieldName}" value="${inputValue}" class="form-control" placeholder="Enter capacity in liters">
                    </div>
                `;
            } else {
                inputContainer.innerHTML = ''; // Clear inputs for "No"
            }
        }
        // Attach event listeners to dynamically handle radio button changes
        function setupDynamicInputHandling(radioName, inputContainerId, inputFieldName, inputValue) {
            // Initial load handling
            handleDynamicInputs(radioName, inputContainerId, inputFieldName, inputValue);
            // Add event listeners for radio button changes
            document.querySelectorAll(`input[name="${radioName}"]`).forEach((radio) => {
                radio.addEventListener('change', () => {
                    handleDynamicInputs(radioName, inputContainerId, inputFieldName, inputValue);
                });
            });
        }
        // Setup dynamic handling for all groups
        setupDynamicInputHandling(
            'water_tank_status',
            'waterTankInputs',
            'water_tank_capacity',
            result.facility_building.water_tank_capacity
        );
        setupDynamicInputHandling(
            'sump_status',
            'sumpInputs',
            'sump_capacity',
            result.facility_building.sump_capacity
        );
        setupDynamicInputHandling(
            'oht_status',
            'ohtInputs',
            'oht_capacity',
            result.facility_building.oht_capacity
        );
        // Additional Power Sources
        document.addEventListener('DOMContentLoaded', function() {
            const powerSourceYes = document.getElementById('powerSourceYes');
            const powerSourceNo = document.getElementById('powerSourceNo');
            const powerSourceDetails = document.getElementById('powerSourceDetails');
            const generatorOption = document.getElementById('generatorOption');
            const upsOption = document.getElementById('upsOption');
            const powerTypeDetails = document.getElementById('powerTypeDetails');

            // Function to toggle power source details visibility
            function togglePowerSourceDetails() {
                if (powerSourceYes.checked) {
                    powerSourceDetails.style.display = 'block'; // Show details
                } else {
                    powerSourceDetails.style.display = 'none'; // Hide details
                    powerTypeDetails.style.display = 'none'; // Hide generator/UPS fields
                }
            }

            // Function to toggle power type details visibility
            function togglePowerTypeDetails() {
                if (generatorOption.checked || upsOption.checked) {
                    powerTypeDetails.style.display = 'block'; // Show generator/UPS details
                } else {
                    powerTypeDetails.style.display = 'none'; // Hide generator/UPS details
                }
            }

            // Attach event listeners for power source radio buttons
            powerSourceYes.addEventListener('change', togglePowerSourceDetails);
            powerSourceNo.addEventListener('change', togglePowerSourceDetails);

            // Attach event listeners for power type radio buttons
            generatorOption.addEventListener('change', togglePowerTypeDetails);
            upsOption.addEventListener('change', togglePowerTypeDetails);

            // Initialize visibility based on backend data
            togglePowerSourceDetails();
            togglePowerTypeDetails();
        });

        // Internet Connection
        document.addEventListener('DOMContentLoaded', function() {
            const internetYes = document.getElementById('internetYes');
            const internetNo = document.getElementById('internetNo');
            const internetDetails = document.getElementById('internetDetails');

            // Function to toggle internet details visibility
            function toggleInternetDetails() {
                if (internetYes.checked) {
                    internetDetails.style.display = 'block'; // Show internet details
                } else {
                    internetDetails.style.display = 'none'; // Hide internet details
                }
            }

            // Attach event listeners for the radio buttons
            internetYes.addEventListener('change', toggleInternetDetails);
            internetNo.addEventListener('change', toggleInternetDetails);

            // Initialize visibility based on backend data
            toggleInternetDetails();
        });
        
        // Landline connection and Fax connection
        document.addEventListener('DOMContentLoaded', function() {
            // Elements for landline
            const landlineYes = document.getElementById('landlineYes');
            const landlineNo = document.getElementById('landlineNo');
            const landlineDetails = document.getElementById('landlineDetails');

            // Elements for fax
            const faxYes = document.getElementById('faxYes');
            const faxNo = document.getElementById('faxNo');
            const faxDetails = document.getElementById('faxDetails');

            // Toggle visibility for landline details
            function toggleLandlineDetails() {
                landlineDetails.style.display = landlineYes.checked ? 'block' : 'none';
            }

            // Toggle visibility for fax details
            function toggleFaxDetails() {
                faxDetails.style.display = faxYes.checked ? 'block' : 'none';
            }

            // Attach event listeners for landline
            landlineYes.addEventListener('change', toggleLandlineDetails);
            landlineNo.addEventListener('change', toggleLandlineDetails);

            // Attach event listeners for fax
            faxYes.addEventListener('change', toggleFaxDetails);
            faxNo.addEventListener('change', toggleFaxDetails);

            // Initialize visibility based on backend data
            toggleLandlineDetails();
            toggleFaxDetails();
        });
    </script>

    <style>
        .selected-items {
            margin-top: 10px;
        }

        .selected-item {
            display: inline-flex;
            align-items: center;
            padding: 5px;
            background-color: #e9ecef;
            border-radius: 4px;
            margin-right: 5px;
        }
    </style>
@endsection
