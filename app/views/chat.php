<?php
$pageTitle = 'Chat - CampusConnect';
$extraHead = <<<HTML
    <style>
        body { background: #f0f2f5; }
        .topbar {
            background: rgba(23, 86, 118, 0.92);
            backdrop-filter: blur(10px);
        }
        .shell { max-width: 1180px; }
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
        .chat-container { display: flex; height: 90vh; }
        .users-list { width: 25%; border-right: 1px solid #ddd; overflow-y: auto; }
        .chat-box { width: 75%; padding: 10px; display: flex; flex-direction: column; }
        .messages { flex: 1; overflow-y: auto; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .message { padding: 5px 10px; border-radius: 10px; margin-bottom: 5px; max-width: 70%; }
        .sent { background: #0d6efd; color: white; align-self: flex-end; }
        .received { background: #e4e6eb; align-self: flex-start; }
    </style>
HTML;
require __DIR__ . '/partials/head.php';
$activePage = 'home';
require __DIR__ . '/partials/topbar.php';
?>
<div class="container shell mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">CampusConnect Chat</h3>
        <a href="index.php?action=home" class="btn btn-outline-secondary btn-sm">Back to Home</a>
    </div>
    <div class="chat-container shadow rounded">
        <div class="users-list bg-white">
            <?php foreach ($users as $user): ?>
                <?php $isOnline = isset($user['last_active']) && (strtotime($user['last_active']) > time() - 60); ?>
                <a href="index.php?action=chat&receiver_id=<?= $user['id'] ?>"
                   class="d-block p-2 border-bottom text-decoration-none text-dark <?= $user['id'] == $receiverId ? 'bg-light fw-semibold' : '' ?>">
                    <?= htmlspecialchars($user['username']) ?>
                    <?php if ($isOnline): ?>
                        <span class="text-success">● Online</span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="chat-box bg-white">
            <div class="messages" id="messages">
                <?php foreach ($messages as $msg): ?>
                    <div class="message <?= $msg['sender_id'] == $_SESSION['user_id'] ? 'sent' : 'received' ?>">
                        <strong><?= htmlspecialchars($msg['sender_name']) ?>:</strong>
                        <?= htmlspecialchars($msg['content']) ?>
                        <br><small class="text-muted"><?= htmlspecialchars($msg['created_at']) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>

            <form id="chatForm" class="mt-2">
                <input type="hidden" name="receiver_id" value="<?= $receiverId ?>">
                <input type="text" name="content" class="form-control" placeholder="Type a message..." required>
                <button type="submit" class="btn btn-primary mt-1 w-100">Send</button>
            </form>
        </div>
    </div>
</div>

<script>
const form = document.getElementById('chatForm');
const messagesDiv = document.getElementById('messages');
const messageInput = form.querySelector('input[name="content"]');

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function scrollMessagesToBottom() {
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const content = messageInput.value.trim();

    if (!content) {
        return;
    }

    formData.set('content', content);

    await fetch('index.php?action=chat&receiver_id=<?= $receiverId ?>', {
        method: 'POST',
        body: formData
    });

    messageInput.value = '';
    await loadMessages();
});

async function loadMessages() {
    const res = await fetch('index.php?action=fetch_messages&receiver_id=<?= $receiverId ?>');
    const data = await res.json();
    messagesDiv.innerHTML = '';

    data.forEach((msg) => {
        const div = document.createElement('div');
        div.classList.add('message');
        div.classList.add(msg.sender_id == <?= (int) $_SESSION['user_id'] ?> ? 'sent' : 'received');
        div.innerHTML = `<strong>${escapeHtml(msg.sender_name)}:</strong> ${escapeHtml(msg.content)}<br><small class="text-muted">${escapeHtml(msg.created_at)}</small>`;
        messagesDiv.appendChild(div);
    });

    scrollMessagesToBottom();
}

scrollMessagesToBottom();
loadMessages();
setInterval(loadMessages, 2000);
</script>
<?php require __DIR__ . '/partials/footer.php'; ?>
