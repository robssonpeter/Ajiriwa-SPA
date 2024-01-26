<?php
// Permanent redirection
header("HTTP/1.1 301 Moved Permanently");

// Build the target URL including the query string, if any
$targetUrl = '/search';
if (!empty($_SERVER['QUERY_STRING'])) {
    $targetUrl .= '?' . $_SERVER['QUERY_STRING'];
}

// Redirect to the target URL
header("Location: $targetUrl");
exit;
?>