@extends('auth.layouts.layout')
@section('content')
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Nunito", sans-serif;
}

body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: url("packa/theme/assets/images/background/loginbg1.jpg") no-repeat center center fixed;
    background-size: cover;
}

.login-container {
    display: flex;
    justify-content: space-evenly;
    gap: 20px;
    align-items: center;
    width: 80%;
    max-width: 1200px;
    height: 95vh;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    padding: 30px;
    flex-direction: column; /* Stack header, images, and form */
    overflow: hidden; /* Prevent overflow */
}

.header-container {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
}

.header-container h2 {
    font-size: 36px;
    font-weight: bold;
    color: #064ea2;
}

.header-container p {
    font-size: 22px;
    color: #064ea2 ;
    opacity: 0.65;
    font-weight: 900;
}

.image-container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 10px;
    width: 100%; /* Ensures images fit well inside */
    overflow: hidden; /* Prevent image overflow */
}

.image-container img {
    width: 200px;
    height: 150px;
    object-fit: contain;
    border-radius: 8px;
}

.form-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.form-container header {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.form-container form {
    width: 100%; /* Full width for form on small screens */
    max-width: 400px; /* Prevent form from becoming too wide on large screens */
}

.field {
    margin-bottom: 12px;
    width: 100%;
}

.input-field input {
    width: 100%;
    height: 45px;
    padding: 0 12px;
    border-radius: 8px;
    border: 1px solid #d1d1d1;
    font-size: 16px;
}

.input-field input:focus {
    border-color: #007bff;
}

.button {
    margin: 18px 0 6px;
}

.button input {
    background-image: linear-gradient(to right, #00d2ff 0%, #3a7bd5 51%, #00d2ff 100%);
    margin: 10px;
    padding: 15px 45px;
    text-align: center;
    text-transform: uppercase;
    transition: 0.5s;
    background-size: 200% auto;
    color: white;
    border-radius: 10px;
    display: block;
    border: none;
    width: 100%;
}

.button input:hover {
    background-position: right center;
}

.redirect-link {
    text-align: center;
    margin-top: 10px;
    color: #333;
}

.redirect-link a {
    color: #4070f4;
    text-decoration: none;
}

.redirect-link a:hover {
    text-decoration: underline;
}

/* Responsive Design for smaller screens */
@media (max-width: 768px) {
    .login-container {
        flex-direction: column;
        padding: 20px;
        height:max-content;
    }

    .image-container {
        flex-direction: row; /* Stack images vertically */
        width: 100%;
    }

    .image-container img {
        width: 200px;
        height: 120px;
        object-fit:contain;
        margin-bottom: 10px;
        /* display: none; */
    }

    .form-container form {
        width: 90%; /* Increase form width for smaller screens */
    }

    .header-container h2 {
        font-size: 28px; /* Smaller font size for smaller screens */
    }

    .header-container p {
        font-size: 14px; /* Smaller font size for smaller screens */
    }
}

@media (max-width: 480px) {
    .form-container form {
        width: 100%; /* Full width on very small screens */
    }

    .header-container h2 {
        font-size: 24px; /* Smaller font size */
    }

    .header-container p {
        font-size: 16px; /* Smaller font size */
    }

    .image-container {
        flex-direction: row; /* Stack images vertically */
        width: 100%;
    }

    .image-container img {
        width: 100px; /* Smaller images for mobile */
        height: 90px;
        object-fit: contain ;
    }
}

    </style>

    <div class="login-container">
        <!-- Moved the header inside the login-container -->
        <div class="header-container">
            <h2>Directorate of Public Health and Preventive Medicine</h2>
            <p>Admin portal</p>
        </div>

        <div class="image-container">
            <!-- Replace with your images -->
            <img src="packa/logo/tamilnadu_logo.png" alt="Image 3" />
            <img src="packa/logo/DPH.png" alt="Image 1" />
            <img src="packa/logo/100YEARS-dph.png" alt="Image 2" />

        </div>

        <div class="form-container">
            <header>Login</header>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if(count($errors))
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <p style="color:red;">These credentials do not match our records</p>
                        </div>
                    </div>
                @endif
                <div class="field username-field">
                    <div class="input-field">
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="{{ __('Username') }}" />
                    </div>
                </div>
                <div class="field password-field">
                    <div class="input-field">
                        <input type="password" class="password" id="password" name="password" required="" placeholder="{{ __('Password') }}" />
                    </div>
                </div>
                <div class="field remember-field">
                    <label for="remember" class="remember-label">
                        <input type="checkbox" name="remember_me" id="remember"/>
                        Remember Me
                    </label>
                </div>
                <a href="{{ route('password.request') }}">Forgot Password?</a>
                <div class="input-field button">
                    <input type="submit" value="Submit" />
                </div>
                <!-- Redirect link -->
                <div class="redirect-link">
                    <a href="https://prod.tndphpm.com/" target="_blank">BACK</a>
                </div>
            </form>
        </div>
    </div>
@endsection
