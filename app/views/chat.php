<?php
$pageTitle = 'Chat - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            background: linear-gradient(135deg, #f6f1e8 0%, #d9ebff 50%, #edf7e6 100%);
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
        .chat-shell { max-width: 1180px; }
        .chat-container {
            display: flex;
            min-height: 76vh;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(23, 86, 118, 0.12);
            backdrop-filter: blur(12px);
        }
        .users-list {
            width: 30%;
            min-width: 260px;
            border-right: 1px solid rgba(255, 255, 255, 0.45);
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.84);
        }
        .user-link {
            display: block;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.42);
            text-decoration: none;
            color: #16324f;
        }
        .user-link.active {
            background: rgba(23, 86, 118, 0.08);
        }
        .chat-box { width: 70%; padding: 1.2rem; display: flex; flex-direction: column; }
        .messages { flex: 1; overflow-y: auto; padding-bottom: 1rem; }
        .message {
            padding: 0.85rem 1rem;
            border-radius: 20px;
            margin-bottom: 0.8rem;
            max-width: 72%;
            box-shadow: 0 8px 18px rgba(17, 48, 74, 0.08);
        }
        .sent {
            background: linear-gradient(135deg, #175676 0%, #2b7ea1 100%);
            color: white;
            align-self: flex-end;
            margin-left: auto;
        }
        .received { background: #eef3f7; align-self: flex-start; }
        .chat-composer {
            border-top: 1px solid rgba(255, 255, 255, 0.42);
            padding-top: 1rem;
        }

        @media (max-width: 991px) {
            .chat-container { flex-direction: column; }
            .users-list, .chat-box { width: 100%; }
            .users-list { min-width: 0; max-height: 240px; }
            .message { max-width: 88%; }
        }
    </style>
HTML;
require __DIR__ . '/partials/head.php';
$activePage = 'home';
require __DIR__ . '/partials/topbar.php';
?>
<div class="container chat-shell mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="soft-pill mb-2"><i class="bi bi-chat-dots"></i> Direct messaging</span>
            <h3 class="mb-0 page-heading">CampusConnect Chat</h3>
        </div>
        <a href="index.php?action=home" class="btn btn-outline-secondary btn-sm">Back to Home</a>
    </div>
    <div class="chat-container">
        <div class="users-list">
            <?php foreach ($users as $user): ?>
                <?php $isOnline = isset($user['last_active']) && (strtotime($user['last_active']) > time() - 60); ?>
                <a href="index.php?action=chat&receiver_id=<?= $user['id'] ?>"
                   class="user-link <?= $user['id'] == $receiverId ? 'active fw-semibold' : '' ?>">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <span><?= htmlspecialchars($user['username']) ?></span>
                        <?php if ($isOnline): ?>
                            <span class="small text-success">Online</span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="chat-box">
            <div class="messages" id="messages">
                <?php foreach ($messages as $msg): ?>
                    <div class="message <?= $msg['sender_id'] == $_SESSION['user_id'] ? 'sent' : 'received' ?>">
                        <strong><?= htmlspecialchars($msg['sender_name']) ?></strong>
                        <div><?= htmlspecialchars($msg['content']) ?></div>
                        <small class="<?= $msg['sender_id'] == $_SESSION['user_id'] ? 'text-white-50' : 'text-muted' ?>"><?= htmlspecialchars($msg['created_at']) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>

            <form id="chatForm" class="chat-composer">
                <input type="hidden" name="receiver_id" value="<?= $receiverId ?>">
                <div class="row g-2">
                    <div class="col-md-9">
                        <input type="text" name="content" class="form-control" placeholder="Type a message..." required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 h-100">Send</button>
                    </div>
                </div>
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
