<!DOCTYPE html>
<html>
<head>
    <title>Chat - CampusConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .chat-container { display: flex; height: 90vh; }
        .users-list { width: 25%; border-right: 1px solid #ddd; overflow-y: auto; }
        .chat-box { width: 75%; padding: 10px; display: flex; flex-direction: column; }
        .messages { flex: 1; overflow-y: auto; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .message { padding: 5px 10px; border-radius: 10px; margin-bottom: 5px; max-width: 70%; }
        .sent { background: #0d6efd; color: white; align-self: flex-end; }
        .received { background: #e4e6eb; align-self: flex-start; }
    </style>
</head>
<body>
<div class="container mt-3">
    <h3>CampusConnect Chat 🚀</h3>
    <div class="chat-container shadow rounded">
        <!-- LEFT: USERS LIST -->
        <div class="users-list bg-white">
            <?php foreach($users as $user): ?>
                <a href="index.php?action=chat&receiver_id=<?= $user['id'] ?>" 
                   class="d-block p-2 border-bottom text-decoration-none text-dark">
                   <?= htmlspecialchars($user['username']) ?>
                   <?php
                       $isOnline = isset($user['last_active']) && (strtotime($user['last_active']) > time() - 60);
                       echo $isOnline ? ' ● <span class="text-success">Online</span>' : '';
                   ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- RIGHT: CHAT BOX -->
        <div class="chat-box bg-white">
            <div class="messages" id="messages">
                <?php foreach($messages as $msg): ?>
                    <div class="message <?= $msg['sender_id'] == $_SESSION['user_id'] ? 'sent' : 'received' ?>">
                        <strong><?= htmlspecialchars($msg['sender_name']) ?>:</strong> <?= htmlspecialchars($msg['content']) ?>
                        <br><small class="text-muted"><?= $msg['created_at'] ?></small>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- MESSAGE INPUT -->
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

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);

    await fetch('index.php?action=chat&receiver_id=<?= $receiverId ?>', {
        method: 'POST',
        body: formData
    });

    form.content.value = '';
    loadMessages(); // Refresh messages
});

// Auto-refresh messages every 2 seconds
async function loadMessages() {
    const res = await fetch('index.php?action=fetch_messages&receiver_id=<?= $receiverId ?>');
    const data = await res.json();
    messagesDiv.innerHTML = '';
    data.forEach(msg => {
        const div = document.createElement('div');
        div.classList.add('message');
        div.classList.add(msg.sender_id == <?= $_SESSION['user_id'] ?> ? 'sent' : 'received');
        div.innerHTML = `<strong>${msg.sender_name}:</strong> ${msg.content}<br><small class="text-muted">${msg.created_at}</small>`;
        messagesDiv.appendChild(div);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    });
}

// Initial load
loadMessages();
setInterval(loadMessages, 2000);
</script>
</body>
</html>