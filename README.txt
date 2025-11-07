READ ME - Free Fire Room Chat

1) Upload the contents of this folder to your web IDE / PHP hosting.
2) Edit config.php and replace the placeholder password:
   $pass = "YOUR_DB_PASSWORD_HERE";
   Replace with: @Gallant666
3) Import setup.sql into your database (or run the SQL in your DB panel) to create tables.
4) Open index.php in the browser, register a username (4+ chars) and password (5+ chars), then click Continue.
5) After registering you will be redirected to the group chat page.

NOTES:
- This is a simple polling chat (reloads messages every 2s). For production consider websockets.
- Keep your config.php safe and do not share your real password publicly.
