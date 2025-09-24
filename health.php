<?php
/**
 * Health Check Endpoint for Notify Application
 * Access via: http://your-domain.com/health.php
 * Returns JSON status of system components
 */

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

$health = [
    'status' => 'ok',
    'timestamp' => date('Y-m-d H:i:s'),
    'checks' => []
];

// Check PHP version
$health['checks']['php'] = [
    'status' => version_compare(PHP_VERSION, '7.0.0', '>=') ? 'ok' : 'error',
    'version' => PHP_VERSION,
    'message' => version_compare(PHP_VERSION, '7.0.0', '>=') ? 'PHP version is supported' : 'PHP version is too old'
];

// Check required PHP extensions
$requiredExtensions = ['pdo', 'ldap', 'zlib', 'mbstring', 'json'];
$missingExtensions = [];

foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $missingExtensions[] = $ext;
    }
}

$health['checks']['php_extensions'] = [
    'status' => empty($missingExtensions) ? 'ok' : 'error',
    'missing' => $missingExtensions,
    'message' => empty($missingExtensions) ? 'All required extensions loaded' : 'Missing extensions: ' . implode(', ', $missingExtensions)
];

// Check SQL Server extensions
$sqlExtensions = ['sqlsrv', 'pdo_sqlsrv'];
$missingSqlExtensions = [];

foreach ($sqlExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $missingSqlExtensions[] = $ext;
    }
}

$health['checks']['sqlserver_extensions'] = [
    'status' => empty($missingSqlExtensions) ? 'ok' : 'warning',
    'missing' => $missingSqlExtensions,
    'message' => empty($missingSqlExtensions) ? 'SQL Server extensions loaded' : 'Missing SQL Server extensions: ' . implode(', ', $missingSqlExtensions)
];

// Check file permissions
$writableDirectories = ['temp'];
$permissionIssues = [];

foreach ($writableDirectories as $dir) {
    if (is_dir($dir)) {
        if (!is_writable($dir)) {
            $permissionIssues[] = $dir;
        }
    } else {
        $permissionIssues[] = $dir . ' (does not exist)';
    }
}

$health['checks']['file_permissions'] = [
    'status' => empty($permissionIssues) ? 'ok' : 'warning',
    'issues' => $permissionIssues,
    'message' => empty($permissionIssues) ? 'File permissions are correct' : 'Permission issues with: ' . implode(', ', $permissionIssues)
];

// Check configuration files
$configFiles = [
    'notify/config/config.php',
    'login/Auth.php'
];
$missingConfigs = [];

foreach ($configFiles as $file) {
    if (!file_exists($file)) {
        $missingConfigs[] = $file;
    }
}

$health['checks']['configuration'] = [
    'status' => empty($missingConfigs) ? 'ok' : 'error',
    'missing' => $missingConfigs,
    'message' => empty($missingConfigs) ? 'Configuration files present' : 'Missing configuration files: ' . implode(', ', $missingConfigs)
];

// Test database connection (basic test without exposing credentials)
try {
    if (file_exists('notify/config/config.php')) {
        // Don't actually connect, just check if the config file is readable
        $configContent = file_get_contents('notify/config/config.php');
        $hasDbConfig = (strpos($configContent, '$server') !== false && strpos($configContent, '$conn') !== false);
        
        $health['checks']['database_config'] = [
            'status' => $hasDbConfig ? 'ok' : 'warning',
            'message' => $hasDbConfig ? 'Database configuration found' : 'Database configuration incomplete'
        ];
    } else {
        $health['checks']['database_config'] = [
            'status' => 'error',
            'message' => 'Database configuration file not found'
        ];
    }
} catch (Exception $e) {
    $health['checks']['database_config'] = [
        'status' => 'error',
        'message' => 'Error reading database configuration'
    ];
}

// Overall health status
$hasErrors = false;
foreach ($health['checks'] as $check) {
    if ($check['status'] === 'error') {
        $hasErrors = true;
        break;
    }
}

$health['status'] = $hasErrors ? 'error' : 'ok';

// Set appropriate HTTP status code
http_response_code($hasErrors ? 500 : 200);

// Output JSON
echo json_encode($health, JSON_PRETTY_PRINT);
?>