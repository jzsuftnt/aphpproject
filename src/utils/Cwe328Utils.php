<?php
namespace App\utils;

/**
 * CWE-328 Utility Class - Demonstrates weak hash vulnerabilities
 * 
 * WARNING: This class contains intentionally vulnerable code for educational purposes.
 * DO NOT USE IN PRODUCTION ENVIRONMENTS.
 */
class Cwe328Utils
{
    /**
     * Hashes a string using MD5 (weak, vulnerable hash algorithm)
     * VULNERABLE: MD5 is cryptographically broken and unsuitable for security
     * 
     * @param string $input The string to hash
     * @return string The MD5 hash
     */
    public static function hashMD5($input)
    {
        return md5($input);
    }
    
    /**
     * Hashes a string using SHA-1 (weak, vulnerable hash algorithm)
     * VULNERABLE: SHA-1 is vulnerable to collision attacks
     * 
     * @param string $input The string to hash
     * @return string The SHA-1 hash
     */
    public static function hashSHA1($input)
    {
        return sha1($input);
    }
    
    /**
     * Hashes a password using weak algorithms without salt
     * VULNERABLE: Multiple vulnerabilities (weak algorithm, no salt)
     * 
     * @param string $password The password to hash
     * @return array Array of hashed passwords using different weak algorithms
     */
    public static function hashPasswordWeak($password)
    {
        return [
            'md5' => self::hashMD5($password),
            'sha1' => self::hashSHA1($password),
            'hash' => hash('sha256', $password) // Better but still no salt
        ];
    }
    
    /**
     * Securely hashes a password using modern techniques
     * SECURE: This is the proper way to hash passwords
     * 
     * @param string $password The password to hash
     * @param int $algorithm Password hashing algorithm to use
     * @return string The securely hashed password
     */
    public static function hashPasswordSecure($password, $algorithm = PASSWORD_DEFAULT)
    {
        return password_hash($password, $algorithm);
    }
    
    /**
     * Verifies a password against a hash
     * SECURE: Proper way to verify passwords
     * 
     * @param string $password The password to verify
     * @param string $hash The hash to verify against
     * @return bool Whether the password matches the hash
     */
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
    
    /**
     * Demonstrates hash collision vulnerability with weak algorithms
     * 
     * @return array Information about hash collision examples
     */
    public static function demonstrateCollisionVulnerability()
    {
        // These two different strings produce the same MD5 hash
        // (known MD5 collision example)
        $string1 = hex2bin('d131dd02c5e6eec4693d9a0698aff95c2fcab58712467eab4004583eb8fb7f8955ad340609f4b30283e488832571415a085125e8f7cdc99fd91dbdf280373c5bd8823e3156348f5bae6dacd436c919c6dd53e2b487da03fd02396306d248cda0e99f33420f577ee8ce54b67080a80d1ec69821bcb6a8839396f9652b6ff72a70');
        $string2 = hex2bin('d131dd02c5e6eec4693d9a0698aff95c2fcab50712467eab4004583eb8fb7f8955ad340609f4b30283e4888325f1415a085125e8f7cdc99fd91dbd7280373c5bd8823e3156348f5bae6dacd436c919c6dd53e23487da03fd02396306d248cda0e99f33420f577ee8ce54b67080280d1ec69821bcb6a8839396f965ab6ff72a70');
        
        $md5_1 = md5($string1);
        $md5_2 = md5($string2);
        
        return [
            'explanation' => 'This demonstrates how two different inputs can produce the same hash with weak algorithms (collision vulnerability)',
            'string1_binary' => bin2hex($string1),
            'string2_binary' => bin2hex($string2),
            'md5_hash1' => $md5_1,
            'md5_hash2' => $md5_2,
            'collision_found' => ($md5_1 === $md5_2),
            'sha256_hash1' => hash('sha256', $string1),
            'sha256_hash2' => hash('sha256', $string2),
            'sha256_collision' => (hash('sha256', $string1) === hash('sha256', $string2))
        ];
    }
    
    /**
     * Compare the computational time difference between weak and strong hashing
     * 
     * @param string $input The string to hash
     * @return array Timing results
     */
    public static function compareHashingPerformance($input)
    {
        $start = microtime(true);
        $md5 = self::hashMD5($input);
        $md5_time = microtime(true) - $start;
        
        $start = microtime(true);
        $sha1 = self::hashSHA1($input);
        $sha1_time = microtime(true) - $start;
        
        $start = microtime(true);
        $secure = self::hashPasswordSecure($input);
        $secure_time = microtime(true) - $start;
        
        return [
            'md5' => [
                'hash' => $md5,
                'time' => $md5_time,
                'note' => 'Fast but insecure'
            ],
            'sha1' => [
                'hash' => $sha1,
                'time' => $sha1_time,
                'note' => 'Fast but vulnerable to collisions'
            ],
            'secure' => [
                'hash' => $secure,
                'time' => $secure_time,
                'note' => 'Slower but cryptographically secure with salting'
            ],
            'conclusion' => 'Secure hashing takes longer by design to prevent brute force attacks'
        ];
    }
}
?>