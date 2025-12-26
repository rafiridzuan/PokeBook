<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>

    <!-- CSS Custom -->
    <style>
        /* CSS Global */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333333;
        }

        .form-label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            width: 48%;
            padding: 10px;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            margin-right: 4%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert {
            padding: 10px;
            margin-top: 15px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h3 class="card-title">Login Page</h3>

            <!-- Form Start -->
            <form action="/login" method="POST">
                @csrf <!-- Laravel CSRF token -->
                
                <!-- Username Input -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Buttons -->
                <div style="display: flex; justify-content: space-between;">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
            <!-- Form End -->

            <!-- Error Message (Optional) -->
            @if (session('error'))
                <div class="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
