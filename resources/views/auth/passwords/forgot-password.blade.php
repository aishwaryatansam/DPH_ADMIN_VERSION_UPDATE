@extends('auth.layouts.layout')
@section('content')

<style>
    /* Animation for the form */
    .animated-form {
        animation: slideDown 0.8s ease-in-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Styling for the button */
    .btn-animated {
        transition: all 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .btn-animated:after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: #007bff;
        transition: all 0.3s ease-in-out;
        z-index: -1;
    }

    .btn-animated:hover {
        color: white !important;
    }

    .btn-animated:hover:after {
        left: 0;
    }

    /* Error message styling */
    .error-message {
        color: #ff0000;
        font-size: 0.875rem;
        margin-top: 5px;
    }
</style>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h1 class="mb-4">Forgot Password</h1>
                <p class="mb-4">Enter your Email ID or Username to receive an OTP.</p>
            </div>
            <form id="forgotPasswordForm" class="animated-form shadow-lg p-4 rounded" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="emailOrUsername">Email ID or Username</label>
                    <input type="email" class="form-control form-control-lg" id="emailOrUsername" name="email"
                        placeholder="Enter your Email ID or Username"> 
                    <div id="error" class="error-message"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block btn-animated">
                    Send OTP
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        $("#forgotPasswordForm").on("submit", function (event) {
            event.preventDefault();

            const input = $("#emailOrUsername").val().trim();
            const errorDiv = $("#error");
            errorDiv.text(""); // Clear previous errors

            if (input === "") {
                errorDiv.text("This field cannot be empty. Please enter your Email ID or Username.");
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (input.includes("@")) {
                // Validate email format if input contains '@'
                if (!emailRegex.test(input)) {
                    errorDiv.text("Invalid email format. Please enter a valid Email ID.");
                    return false;
                }
            } else {
                // Validation for username: Ensure it doesn't have invalid characters
                const usernameRegex = /^[a-zA-Z0-9._-]+$/;
                if (!usernameRegex.test(input)) {
                    errorDiv.text(
                        "Invalid username format. Usernames can only contain letters, numbers, dots, underscores, and dashes."
                    );
                    return false;
                }
            }

            // Submit the form or trigger OTP logic here
            alert("OTP has been sent to the provided Email ID or Username!");
        });
    });
</script>

<h1>Forgot Password</h1>
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>
@endsection
