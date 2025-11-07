<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Free Fire Room Chat - Register</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body { background: white; font-family: Arial, sans-serif; margin:0; padding:0; }
.header { font-size:20px; padding:15px; font-weight:bold; }
.container { width:320px; margin:80px auto; text-align:left; }
label { display:block; margin-top:10px; font-size:14px;}
input { width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:5px; box-sizing:border-box; }
.error { color:red; font-size:13px; margin-top:5px; height:18px; }
.continue-box { display:none; margin-top:20px; width:100%; padding:12px; text-align:center; border-radius:8px; background:#000; color:#fff; cursor:pointer; }
</style>
</head>
<body>
  <div class="header">Welcome to Free Fire Room Chat</div>
  <div class="container">
    <label for="username">Username</label>
    <input type="text" id="username" placeholder="Enter username (4+ chars)">
    <div id="userError" class="error"></div>

    <label for="password">Password</label>
    <input type="password" id="password" placeholder="Enter password (5+ chars)">
    <div id="passError" class="error"></div>

    <div id="continueBox" class="continue-box">Continue</div>
  </div>

<script>
const usernameEl = document.getElementById('username');
const passwordEl = document.getElementById('password');
const userError = document.getElementById('userError');
const passError = document.getElementById('passError');
const continueBox = document.getElementById('continueBox');

let usernameAvailable = false;

async function checkUsername(name) {
  if (name.length < 4) {
    userError.textContent = "Username must be at least 4 characters";
    usernameAvailable = false;
    return;
  }
  // ask server if username exists
  const fd = new FormData();
  fd.append('username', name);
  const res = await fetch('register.php', { method: 'POST', body: fd });
  const text = await res.text();
  if (text.includes('in use')) {
    userError.textContent = "Username already in use";
    usernameAvailable = false;
  } else if (text.includes('ok-check-only')) {
    userError.textContent = "";
    usernameAvailable = true;
  } else {
    userError.textContent = "Error checking username";
    usernameAvailable = false;
  }
  updateContinue();
}

usernameEl.addEventListener('blur', () => checkUsername(usernameEl.value.trim()));

function updateContinue() {
  const passOk = passwordEl.value.trim().length >= 5;
  if (usernameAvailable && passOk) {
    continueBox.style.display = 'block';
  } else {
    continueBox.style.display = 'none';
  }
}

passwordEl.addEventListener('input', () => {
  passError.textContent = passwordEl.value.trim().length < 5 ? "Password must be at least 5 characters" : "";
  updateContinue();
});

continueBox.addEventListener('click', async () => {
  const fd = new FormData();
  fd.append('username', usernameEl.value.trim());
  fd.append('password', passwordEl.value.trim());
  const res = await fetch('register.php', { method: 'POST', body: fd });
  const text = await res.text();
  if (text.includes('success')) {
    // redirect to chat
    window.location.href = 'chat.php?user=' + encodeURIComponent(usernameEl.value.trim());
  } else if (text.includes('in use')) {
    userError.textContent = "Username already in use";
  } else {
    userError.textContent = "Registration error";
  }
});
</script>
</body>
</html>
