<!DOCTYPE html>
<html>
<head>
    <title>Search Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h3>🔎 Search Results</h3>

<a href="index.php?action=home" class="btn btn-secondary mb-3">⬅ Back</a>

<?php if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
        <div class="card p-3 mb-2">
            <strong><?= $user['full_name'] ?></strong>
            <span>@<?= $user['username'] ?></span>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No users found</p>
<?php endif; ?>

</body>
</html>