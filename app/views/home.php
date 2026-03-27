<?php
$pageTitle = 'CampusConnect';
$extraHead = <<<HTML
    <style>
        :root {
            --cc-bg: linear-gradient(135deg, #f6f1e8 0%, #d9ebff 50%, #edf7e6 100%);
            --cc-card: rgba(255, 255, 255, 0.92);
            --cc-primary: #175676;
        }

        body {
            min-height: 100vh;
            background: var(--cc-bg);
        }

        .topbar {
            background: rgba(23, 86, 118, 0.92);
            backdrop-filter: blur(10px);
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #8fd3f4, #84fab0);
            color: #123;
            font-weight: 700;
        }

        .shell {
            max-width: 1180px;
        }

        .glass-card {
            background: var(--cc-card);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(23, 86, 118, 0.12);
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            object-fit: cover;
            background: #dbe9f4;
        }

        .post-image {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: 18px;
        }

        .action-link {
            border: 0;
            background: transparent;
            color: var(--cc-primary);
            text-decoration: none;
            padding: 0;
        }

        .action-link.danger {
            color: #b02a37;
        }

        .sidebar-stat {
            border-radius: 18px;
            background: rgba(23, 86, 118, 0.08);
        }

        textarea {
            resize: vertical;
        }
    </style>
HTML;
$extraScripts = <<<HTML
<script>
document.querySelectorAll('form[data-validate-post]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const textarea = form.querySelector('textarea[name="content"]');
        const fileInput = form.querySelector('input[name="post_image"]');
        const content = textarea ? textarea.value.trim() : '';
        const hasFile = fileInput && fileInput.files.length > 0;

        if (!content && !hasFile) {
            event.preventDefault();
            alert('Post must contain text or an image.');
        }
    });
});
</script>
HTML;
require __DIR__ . '/partials/head.php';
$activePage = 'home';
require __DIR__ . '/partials/topbar.php';
?>

<main class="container shell py-4">
    <?php require __DIR__ . '/partials/flash.php'; ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="glass-card p-4 mb-4">
                <div class="d-flex align-items-center gap-3">
                    <img class="avatar" src="assets/uploads/<?= htmlspecialchars($_SESSION['profile_pic'] ?? 'default-avatar.svg') ?>" alt="Profile" onerror="this.src='assets/uploads/default-avatar.svg'">
                    <div>
                        <div class="fw-semibold"><?= htmlspecialchars($_SESSION['full_name'] ?? 'Student') ?></div>
                        <div class="text-muted">@<?= htmlspecialchars($_SESSION['username'] ?? 'user') ?></div>
                    </div>
                </div>
                <div class="row g-2 mt-3">
                    <div class="col-6">
                        <div class="sidebar-stat p-3 h-100">
                            <div class="small text-muted">Posts in Feed</div>
                            <div class="fs-4 fw-semibold"><?= count($posts) ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="sidebar-stat p-3 h-100">
                            <div class="small text-muted">Messaging</div>
                            <div class="fs-4 fw-semibold">On</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-4">
                <h5 class="mb-3">Create Post</h5>
                <form method="POST" action="index.php?action=create_post" enctype="multipart/form-data" data-validate-post>
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="4" maxlength="1000" placeholder="Share an update, idea, or event with your campus..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Optional image</label>
                        <input type="file" name="post_image" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-send-fill"></i> Publish Post
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-card p-4 mb-4">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center">
                    <div>
                        <h4 class="mb-1">Newsfeed</h4>
                        <p class="text-muted mb-0">Latest campus updates, discussions, and conversations.</p>
                    </div>
                    <form method="GET" action="index.php" class="d-flex gap-2">
                        <input type="hidden" name="action" value="search">
                        <input type="text" name="keyword" class="form-control" placeholder="Search users">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <?php if (empty($posts)): ?>
                <div class="glass-card p-5 text-center">
                    <h5>No posts yet</h5>
                    <p class="text-muted mb-0">Create the first post to start your campus feed.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($posts as $post): ?>
                <?php $isOwner = (int) $post['user_id'] === (int) $_SESSION['user_id']; ?>
                <?php $isOnline = !empty($post['last_active']) && (strtotime($post['last_active']) > time() - 60); ?>
                <article class="glass-card p-4 mb-4">
                    <div class="d-flex justify-content-between gap-3">
                        <div class="d-flex gap-3">
                            <img class="avatar" src="assets/uploads/<?= htmlspecialchars($post['profile_pic'] ?? 'default-avatar.svg') ?>" alt="User" onerror="this.src='assets/uploads/default-avatar.svg'">
                            <div>
                                <div class="fw-semibold"><?= htmlspecialchars($post['full_name'] ?: $post['username']) ?></div>
                                <div class="text-muted small">
                                    @<?= htmlspecialchars($post['username']) ?> | <?= htmlspecialchars($post['created_at']) ?>
                                </div>
                                <?php if ($isOnline): ?>
                                    <div class="small text-success">
                                        <i class="bi bi-circle-fill"></i> Online
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($isOwner): ?>
                            <div class="d-flex gap-3 align-items-start">
                                <a class="action-link" href="index.php?action=home&edit_post=<?= (int) $post['id'] ?>">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form method="POST" action="index.php?action=delete_post" onsubmit="return confirm('Delete this post?');">
                                    <input type="hidden" name="post_id" value="<?= (int) $post['id'] ?>">
                                    <button class="action-link danger" type="submit">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-3">
                        <?php if ($editingPostId === (int) $post['id'] && $isOwner): ?>
                            <form method="POST" action="index.php?action=update_post" enctype="multipart/form-data">
                                <input type="hidden" name="post_id" value="<?= (int) $post['id'] ?>">
                                <textarea name="content" class="form-control mb-3" rows="4" maxlength="1000"><?= htmlspecialchars($post['content']) ?></textarea>
                                <?php if (!empty($post['image'])): ?>
                                    <img class="post-image mb-3" src="assets/uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post image">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove-image-<?= (int) $post['id'] ?>">
                                        <label class="form-check-label" for="remove-image-<?= (int) $post['id'] ?>">Remove current image</label>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <input type="file" name="post_image" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp">
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary" type="submit">Save Post</button>
                                    <a class="btn btn-outline-secondary" href="index.php?action=home">Cancel</a>
                                </div>
                            </form>
                        <?php else: ?>
                            <?php if (!empty($post['content'])): ?>
                                <p class="mb-3"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($post['image'])): ?>
                                <img class="post-image mb-3" src="assets/uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post image">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                        <a href="index.php?action=like&post_id=<?= (int) $post['id'] ?>" class="btn btn-sm <?= $post['user_liked'] ? 'btn-primary' : 'btn-outline-primary' ?>">
                            <i class="bi bi-hand-thumbs-up"></i> <?= $post['user_liked'] ? 'Unlike' : 'Like' ?> (<?= (int) $post['likes'] ?>)
                        </a>
                        <?php if (!$isOwner): ?>
                            <a href="index.php?action=chat&receiver_id=<?= (int) $post['user_id'] ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-chat-dots"></i> Message
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4">
                        <form method="POST" action="index.php?action=comment">
                            <input type="hidden" name="post_id" value="<?= (int) $post['id'] ?>">
                            <div class="input-group">
                                <input type="text" name="content" class="form-control" maxlength="500" placeholder="Write a comment...">
                                <button class="btn btn-outline-secondary" type="submit">Comment</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-3">
                        <?php if (empty($post['comments'])): ?>
                            <div class="text-muted small">No comments yet.</div>
                        <?php endif; ?>

                        <?php foreach ($post['comments'] as $comment): ?>
                            <?php $isCommentOwner = (int) $comment['user_id'] === (int) $_SESSION['user_id']; ?>
                            <div class="border rounded-4 p-3 mt-2 bg-light-subtle">
                                <div class="d-flex justify-content-between gap-3">
                                    <div>
                                        <div class="fw-semibold small"><?= htmlspecialchars($comment['full_name'] ?: $comment['username']) ?></div>
                                        <div class="text-muted small">@<?= htmlspecialchars($comment['username']) ?> | <?= htmlspecialchars($comment['created_at']) ?></div>
                                    </div>
                                    <?php if ($isCommentOwner): ?>
                                        <div class="d-flex gap-3">
                                            <a class="action-link" href="index.php?action=home&edit_comment=<?= (int) $comment['id'] ?>">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form method="POST" action="index.php?action=delete_comment" onsubmit="return confirm('Delete this comment?');">
                                                <input type="hidden" name="comment_id" value="<?= (int) $comment['id'] ?>">
                                                <button class="action-link danger" type="submit">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($editingCommentId === (int) $comment['id'] && $isCommentOwner): ?>
                                    <form method="POST" action="index.php?action=update_comment" class="mt-2">
                                        <input type="hidden" name="comment_id" value="<?= (int) $comment['id'] ?>">
                                        <div class="input-group">
                                            <input type="text" name="content" class="form-control" maxlength="500" value="<?= htmlspecialchars($comment['content']) ?>">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <a class="btn btn-outline-secondary" href="index.php?action=home">Cancel</a>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <p class="mb-0 mt-2"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
