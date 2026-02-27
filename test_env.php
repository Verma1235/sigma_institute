<?php
echo "<h3>Environment Check:</h3>";
echo "Client ID: " . (getenv('GOOGLE_DRIVE_CLIENT_ID') ? "✅ Loaded" : "❌ Missing") . "<br>";
echo "Client Secret: " . (getenv('GOOGLE_DRIVE_CLIENT_SECRET') ? "✅ Loaded" : "❌ Missing") . "<br>";
echo "Refresh Token: " . (getenv('GOOGLE_DRIVE_REFRESH_TOKEN') ? "✅ Loaded" : "❌ Missing") . "<br>";
echo "Folder ID: " . (getenv('GOOGLE_DRIVE_FOLDER') ? "✅ Loaded" : "❌ Missing") . "<br>";