<!DOCTYPE html>
<html>
<head>
    <title>Register - CampusConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            height: 100vh;
        }
        .glass {
            backdrop-filter: blur(15px);
            background: rgba(255,255,255,0.2);
            border-radius: 15px;
            color: white;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="glass p-4 shadow" style="width: 350px;">
    <h3 class="text-center mb-3">Create Account</h3>

    <form method="POST">
        <input type="text" name="full_name" class="form-control mb-2" placeholder="Full Name" required>
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <button class="btn btn-light w-100">Register</button>
    </form>

    <p class="text-center mt-3">
        Already have an account? 
        <a href="index.php?action=login" class="text-white">Login</a>
    </p>
</div>

</body>
</html>