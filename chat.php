<?php
include('config.php');
if (!isset($_GET['user']) || empty($_GET['user'])) {
  header('Location: index.php');
  exit;
}
$user = htmlspecialchars($_GET['user'], ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>FF Group Chat</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body { background: white; font-family: Arial, sans-serif; margin:0; padding:0; }
.header { font-size:20px; padding:15px; font-weight:bold; }
.chat-box { height:60vh; overflow-y:auto; padding:10px; box-sizing:border-box; }
.message { margin:8px 0; padding:8px 12px; border-radius:12px; max-width:70%; display:inline-block; clear:both; }
.sent { background:#e1ffc7; float:right; text-align:right; }
.received { background:#f1f1f1; float:left; text-align:left; }
.input-area { position:fixed; bottom:20px; left:5%; width:90%; display:flex; align-items:center; }
.input-area input { flex:1; padding:10px 14px; border-radius:24px; border:1px solid #ccc; }
.send-btn { margin-left:10px; border:none; background:none; font-size:22px; cursor:pointer; display:none; }
</style>
</head>
<body>
<div class="header">Ff Group Chat</div>
<div id="chatBox" class="chat-box"></div>

<div class="input-area">
  <input id="msgInput" placeholder="Type a message...">
  <button id="sendBtn" class="send-btn">📩</button>
</div>

<script>
const user = "<?php echo $user; ?>";
const chatBox = document.getElementById('chatBox');
const msgInput = document.getElementById('msgInput');
const sendBtn = document.getElementById('sendBtn');

msgInput.addEventListener('input', () => {
  sendBtn.style.display = msgInput.value.trim() ? 'inline' : 'none';
});

sendBtn.addEventListener('click', sendMessage);
msgInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') sendMessage();
});

async function sendMessage() {
  const msg = msgInput.value.trim();
  if (!msg) return;
  const fd = new FormData();
  fd.append('username', user);
  fd.append('message', msg);
  await fetch('send.php', { method: 'POST', body: fd });
  msgInput.value = '';
  sendBtn.style.display = 'none';
  loadMessages();
}

async function loadMessages() {
  const res = await fetch('load.php');
  const data = await res.json();
  chatBox.innerHTML = '';
  data.forEach(m => {
    const div = document.createElement('div');
    div.className = 'message ' + (m.username === user ? 'sent' : 'received');
    // show only message text (username is optional)
    const nameSpan = document.createElement('div');
    nameSpan.style.fontSize = '12px';
    nameSpan.style.opacity = '0.8';
    nameSpan.textContent = m.username;
    const textSpan = document.createElement('div');
    textSpan.textContent = m.message;
    div.appendChild(nameSpan);
    div.appendChild(textSpan);
    chatBox.appendChild(div);
  });
  chatBox.scrollTop = chatBox.scrollHeight;
}

// poll every 2s
setInterval(loadMessages, 2000);
loadMessages();
</script>
</body>
</html>
