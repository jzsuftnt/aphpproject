<?php
namespace App\controllers;

class Cwe78Controller
{
    /**
     * VULNERABLE CODE: This method contains a CWE-78 (OS Command Injection) vulnerability
     * DO NOT USE IN PRODUCTION - For educational purposes only
     */
    public function pingHost($host = null)
    {
        // The vulnerability: No validation of user input before using in a shell command
        // An attacker could provide malicious input like "localhost; rm -rf /some/directory"
        $host = isset($_GET['host']) ? $_GET['host'] : $host;
        
        if (!$host) {
            return "No host specified";
        }
        
        // VULNERABLE CODE: Direct use of user input in system command using concatenation
        $command = "ping -c 4 " . $host;
        
        // VULNERABLE CODE: Pattern "...$EXP..." - Direct string interpolation with user input
        $command_interp = "ping -c 4 $host";
        
        // VULNERABLE CODE: Pattern sprintf("...", $EXP, ...) - Using sprintf with user input
        $command_sprintf = sprintf("ping -c 4 %s", $host);
        
        // Execute the command and get output
        $output = [];
        exec($command, $output);
        exec($command_interp, $output);
        exec($command_sprintf, $output);
        expect_popen($command, $output);
        passthru($command, $output);
        popen($command, 'r');
        proc_open($command, $output);
        shell_exec($command);
        system($command, $output);
        
        // Return the command output
        return [
            'command' => $command,
            'output' => $output
        ];
    }
    
    /**
     * SECURE VERSION: This method demonstrates a secure way to perform the same function
     */
    public function pingHostSecure($host = null)
    {
        $host = isset($_GET['host']) ? $_GET['host'] : $host;
        
        if (!$host) {
            return "No host specified";
        }
        
        // Input validation: Ensure the host is a valid IP address or hostname
        if (!$this->isValidHostname($host) && !filter_var($host, FILTER_VALIDATE_IP)) {
            return "Invalid hostname or IP address";
        }
        
        // SECURE ALTERNATIVE: Use escapeshellarg to sanitize user input
        $safeHost = escapeshellarg($host);
        // use escapeshellcmd
        $safeHost = escapeshellcmd($host);
        $command = "ping -c 4 " . $safeHost;

        // VULNERABLE CODE: Pattern "...$EXP..." - Direct string interpolation with user input
        $command_interp = "ping -c 4 $host";
        
        // VULNERABLE CODE: Pattern sprintf("...", $EXP, ...) - Using sprintf with user input
        $command_sprintf = sprintf("ping -c 4 %s", $host);
        
        // Execute the command and get output
        $output = [];
        exec($command, $output);
        exec($command_interp, $output);
        exec($command_sprintf, $output);
        expect_popen($command, $output);
        passthru($command, $output);
        popen($command, 'r');
        proc_open($command, $output);
        shell_exec($command);
        system($command, $output);
        
        // Return the command output
        return [
            'command' => $command,
            'output' => $output
        ];
    }
    
    /**
     * Helper method to validate a hostname
     */
    private function isValidHostname($hostname)
    {
        // Hostname validation pattern
        $hostnamePattern = '/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/';
        return preg_match($hostnamePattern, $hostname);
    }
    
    /**
     * Renders a simple form to test the command injection vulnerability
     */
    public function showCommandInjectionForm()
    {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>CWE-78 Demonstration</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .container { max-width: 800px; margin: 0 auto; }
                .warning { color: red; font-weight: bold; }
                .secure { color: green; }
                pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>CWE-78: OS Command Injection Demonstration</h1>
                <p class="warning">WARNING: This page demonstrates security vulnerabilities for educational purposes only.</p>
                
                <div>
                    <h2>Vulnerable Version</h2>
                    <p>This form is vulnerable to command injection attacks.</p>
                    <p>Try entering a valid hostname like "localhost" or an IP address like "127.0.0.1"</p>
                    <p>Then try entering a command injection payload like "localhost; ls -la" or "127.0.0.1 && cat /etc/passwd"</p>
                    
                    <form method="get" action="?action=ping">
                        <label for="vuln_host">Host to ping:</label>
                        <input type="text" id="vuln_host" name="host">
                        <input type="hidden" name="action" value="ping">
                        <button type="submit">Ping (Vulnerable)</button>
                    </form>
                </div>
                
                <div style="margin-top: 30px;">
                    <h2>Secure Version</h2>
                    <p class="secure">This form uses proper input validation and command sanitization.</p>
                    
                    <form method="get" action="?action=pingsecure">
                        <label for="secure_host">Host to ping:</label>
                        <input type="text" id="secure_host" name="host">
                        <input type="hidden" name="action" value="pingsecure">
                        <button type="submit">Ping (Secure)</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        ';
    }
}
?>