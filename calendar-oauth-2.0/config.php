<?php

// Google API configuration
define('GOOGLE_CLIENT_ID', 'Your id here!'); 
define('GOOGLE_CLIENT_SECRET', 'You secret here!'); 
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/calendar'); 
define('REDIRECT_URI', 'http://localhost/minhaagenda/google_calendar_event_sync.php'); 
  
// Google OAuth URL
$googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online'; 

// Start session 
if(!session_id()) session_start(); 

?>
