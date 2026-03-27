<!DOCTYPE html>
<html>
<head>
    <title>CampusConnect</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #dfe9f3);
        }

        body.dark {
            background: #121212;
            color: white;
        }

        body.dark .card {
            background: #1e1e1e;
            color: white;
        }

        body.dark .form-control {
            background: #2c2c2c;
            color: white;
            border: none;
        }

        body.dark .comment-box {
            background: #2c2c2c;
        }

        .navbar-custom {
            background: linear-gradient(90deg, #4facfe, #00f2fe);
            border-radius: 0 0 15px 15px;
        }

        .post-box {
            border-radius: 15px;
        }

        .card {
            border-radius: 15px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .comment-box {
            border-radius: 10px;
            background: #f8f9fa;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>

<body class="<?= ($_SESSION['darkmode'] ?? false) ? 'dark' : '' ?>">

<!-- 🔥 HEADER -->
<div class="navbar-custom p-3 shadow">
    <div class="container d-flex justify-content-between align-items-center text-white">

        <h3 class="fw-bold m-0">CampusConnect 🚀</h3>

        <div class="d-flex align-items-center gap-2">
            <div class="avatar">
                <?= strtoupper(substr($_SESSION['full_name'] ?? 'U', 0, 1)) ?>
            </div>

          <img src="assets/uploads/<?= $_SESSION['profile_pic'] ?? 'default.png' ?>" 
              class="rounded-circle me-2" width="40" height="40">

            <a href="index.php?darkmode=1" class="btn btn-dark btn-sm">🌙</a>
            <a href="index.php?action=profile" class="btn btn-light btn-sm">👤 Profile</a>
            <a href="index.php?action=logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</div>

<div class="container mt-4">

    <!-- 🔍 SEARCH -->
    <form method="GET" action="index.php" class="mb-3">
        <input type="hidden" name="action" value="search">
        <input type="text" name="keyword" class="form-control shadow-sm" placeholder="🔍 Search users...">
    </form>

    <!-- ✍️ CREATE POST -->
    <form method="POST" class="mb-4">
        <textarea name="content" class="form-control post-box shadow-sm" 
                  placeholder="What's on your mind?" required></textarea>
        <button class="btn btn-primary mt-2">Post</button>
    </form>

    <!-- 📰 POSTS -->
    <?php foreach ($posts as $post): ?>
        <div class="card mb-3 shadow border-0">
            <div class="card-body">

            <?php
            $isOnline = isset($post['last_active']) && (strtotime($post['last_active']) > time() - 60);
            ?>
            
            <span class="<?= $isOnline ? 'text-success' : 'text-muted' ?>">
                ● <?= $isOnline ? 'Online' : 'Offline' ?>
            </span>

                <!-- USER -->
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-2">
                        <?= strtoupper(substr($post['username'], 0, 1)) ?>
                    </div>
                    <strong>@<?= htmlspecialchars($post['username']) ?></strong>
                </div>

                <!-- CONTENT -->
                <p><?= htmlspecialchars($post['content']) ?></p>

                <!-- ❤️ LIKE / UNLIKE -->
                <a href="index.php?action=like&post_id=<?= $post['id'] ?>" 
                   class="btn btn-sm <?= $post['user_liked'] ? 'btn-primary' : 'btn-outline-primary' ?>">
                   ❤️ <?= $post['user_liked'] ? 'Unlike' : 'Like' ?> (<?= $post['likes'] ?>)
                </a>

                <!-- 💬 COMMENT FORM -->
                <form method="POST" action="index.php?action=comment" class="mt-2">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <input type="text" name="content" class="form-control" 
                           placeholder="💬 Write a comment..." required>
                </form>

                <!-- COMMENTS -->
                <div class="mt-3">
                    <?php if (!empty($post['comments'])): ?>
                        <?php foreach ($post['comments'] as $comment): ?>
                            <div class="p-2 mb-2 comment-box">
                                <strong>@<?= htmlspecialchars($comment['username']) ?></strong>
                                <p class="mb-1"><?= htmlspecialchars($comment['content']) ?></p>
                                <small class="text-muted"><?= $comment['created_at'] ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <small class="text-muted">No comments yet</small>
                    <?php endif; ?>
                </div>

                <small class="text-muted"><?= $post['created_at'] ?></small>

            </div>
        </div>
    <?php endforeach; ?>

</div>  

</body>
</html>