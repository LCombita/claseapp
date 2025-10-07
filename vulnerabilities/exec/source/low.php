<?php
if(isset($_POST['Submit'])) {
    // Get input
    $target = $_REQUEST['ip'];
    
    // Validate IP address format (IPv4 or IPv6)
    if(filter_var($target, FILTER_VALIDATE_IP)) {
        // IP is valid, escape for shell usage
        $target = escapeshellarg($target);
        
        // Determine OS and execute the ping command
        if(stristr(php_uname('s'), 'Windows NT')) {
            // Windows
            $cmd = shell_exec('ping ' . $target);
        } else {
            // *nix
            $cmd = shell_exec('ping -c 4 ' . $target);
        }
        
        // Sanitize output for HTML display
        $html .= "<pre>" . htmlspecialchars($cmd, ENT_QUOTES, 'UTF-8') . "</pre>";
    } else {
        // Invalid IP address
        $html .= "<pre>Error: Invalid IP address format</pre>";
    }
}
?>