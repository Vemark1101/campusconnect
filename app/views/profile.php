<!DOCTYPE html>
<html>
<head>
    <title>Profile - CampusConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #dfe9f3);
        }

        .profile-card {
            border-radius: 20px;
        }

        .avatar-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0d6efd;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card profile-card shadow p-4">

        <!-- ✅ SUCCESS MESSAGE -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center">
                ✅ Profile updated successfully!
            </div>
        <?php endif; ?>

        <!-- ✅ PROFILE FORM -->
        <form method="POST" enctype="multipart/form-data">

            <div class="text-center mb-3">
                <img src="assets/uploads/<?= !empty($user['profile_pic']) ? $user['profile_pic'] : 'default.png' ?>" 
                     class="avatar-img mb-2">

                <h4><?= htmlspecialchars($user['full_name']) ?></h4>
                <small class="text-muted">@<?= htmlspecialchars($user['username']) ?></small>
            </div>

            <label class="fw-bold">Profile Picture</label>
            <input type="file" name="profile_pic" class="form-control mb-3">

            <label class="fw-bold">Full Name</label>
            <input type="text" name="full_name" class="form-control mb-3"
                value="<?= htmlspecialchars($user['full_name']) ?>">

            <label class="fw-bold">Bio</label>
            <textarea name="bio" class="form-control mb-3"><?= htmlspecialchars($user['bio']) ?></textarea>

            <button class="btn btn-success w-100">💾 Save Changes</button>

        </form>

        <a href="index.php?action=home" class="btn btn-secondary w-100 mt-2">⬅ Back to Home</a>

    </div>
</div>

</body>
</html>