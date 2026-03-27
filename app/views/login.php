<!DOCTYPE html>
<html>
<head>
    <title>Login - CampusConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
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
    <h3 class="text-center mb-3">CampusConnect</h3>
    <p class="text-center">Login to your account</p>

    <form method="POST">
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

        <button class="btn btn-light w-100">Login</button>
    </form>

    <p class="text-center mt-3">
        No account? <a href="index.php?action=register" class="text-white">Register</a>
    </p>
</div>

</body>
</html>