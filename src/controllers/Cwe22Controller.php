<?php
namespace App\controllers;

class Cwe22Controller
{
    /**
     * VULNERABLE CODE: This method contains a CWE-22 (Path Traversal) vulnerability
     * DO NOT USE IN PRODUCTION - For educational purposes only
     */
    public function downloadFile($filename = null)
    {
        // The vulnerability: No validation of user input
        // An attacker could provide "../../../etc/passwd" to access files outside the intended directory
        $filename = isset($_GET['file']) ? $_GET['file'] : $filename;
        
        $file_path = "/home/ubuntu/" . $filename;
        
        if (file_exists($file_path)) {
            // Output headers
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            
            // Read file and exit
            readfile($file_path);
            exit;
        } else {
            echo "File not found.";
        }
    }
}
?>