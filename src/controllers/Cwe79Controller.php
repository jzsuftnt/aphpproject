<?php
namespace App\controllers;

/**
 * CWE-79 Controller
 * 
 * This controller demonstrates Cross-Site Scripting (XSS) vulnerabilities
 * and proper mitigation techniques using sanitization functions.
 */
class Cwe79Controller
{
    /**
     * Demonstrates vulnerable XSS patterns and secure alternatives
     */
    public function index()
    {
        // Data for the view
        $data = [
            'title' => 'CWE-79: Cross-Site Scripting (XSS)',
            'message' => 'This page demonstrates XSS vulnerabilities and mitigations'
        ];
        
        return $data;
    }
    
    /**
     * Demonstrates vulnerable code using various input sources and output sinks
     */
    public function vulnerable()
    {
        // SOURCES - Collecting user input from various sources
        $objectNameFromGet = $_GET['obj']['name'] ?? '';
        $nameFromGet = isset($_GET['name']) ? $_GET['name'] : $objectNameFromGet;
        $nameFromGetDirectly = $_GET['name'];
        $commentFromPost = $_POST['comment'];
        $fileInfoFromFiles = $_FILES['uploadedFile'];
        $userAgentFromServer = $_SERVER['HTTP_USER_AGENT'];
        $userPreferenceFromCookie = $_COOKIE['preference'];
        $rawInput = file_get_contents('php://input');
        
        // SINKS - Outputting data without sanitization (VULNERABLE)
        echo $objectNameFromGet;
        echo $nameFromGet;
        echo $nameFromGetDirectly;
        print($commentFromPost);
        printf("File uploaded: %s", $fileInfoFromFiles);
        print_r($userAgentFromServer);
        
        return [
            'title' => 'Vulnerable XSS Examples',
            'sources' => [
                'get' => $nameFromGet,
                'post' => $commentFromPost,
                'files' => $fileInfoFromFiles,
                'server' => $userAgentFromServer,
                'cookie' => $userPreferenceFromCookie,
                'raw' => $rawInput
            ]
        ];
    }
    
    /**
     * Demonstrates secure code using sanitization functions
     */
    public function secure()
    {
        // SOURCES - Same inputs as vulnerable method
        $nameFromGet = isset($_GET['name']) ? $_GET['name'] : '';
        $commentFromPost = isset($_POST['comment']) ? $_POST['comment'] : '';
        $fileInfoFromFiles = isset($_FILES['uploadedFile']['name']) ? $_FILES['uploadedFile']['name'] : '';
        $userAgentFromServer = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $userPreferenceFromCookie = isset($_COOKIE['preference']) ? $_COOKIE['preference'] : '';
        $rawInput = file_get_contents('php://input');
        
        // SANITIZERS - Properly sanitizing output
        $safeName = htmlspecialchars($nameFromGet, ENT_QUOTES, 'UTF-8');
        $safeComment = htmlentities($commentFromPost, ENT_QUOTES, 'UTF-8');
        $safeFileInfo = htmlspecialchars($fileInfoFromFiles, ENT_QUOTES, 'UTF-8');
        $safeUserAgent = htmlspecialchars($userAgentFromServer, ENT_QUOTES, 'UTF-8');
        $safePreference = htmlspecialchars($userPreferenceFromCookie, ENT_QUOTES, 'UTF-8');
        $safeRawInput = htmlspecialchars($rawInput, ENT_QUOTES, 'UTF-8');
        
        // SINKS - Safe output using sanitized data
        echo $safeName;
        print($safeComment);
        printf("File uploaded: %s", $safeFileInfo);
        print_r($safeUserAgent);
        
        return [
            'title' => 'Secure XSS Examples',
            'sources' => [
                'get' => $safeName,
                'post' => $safeComment,
                'files' => $safeFileInfo,
                'server' => $safeUserAgent,
                'cookie' => $safePreference,
                'raw' => $safeRawInput
            ]
        ];
    }
    
    /**
     * Demonstrates a form that could be vulnerable to XSS
     */
    public function form()
    {
        return [
            'title' => 'XSS Test Form',
            'message' => 'Use this form to test XSS vulnerabilities'
        ];
    }
}
?>