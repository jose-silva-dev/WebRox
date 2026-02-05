<?php

return array (
  'ddos' => 
  array (
    'enabled' => true,
    'global_rate_limit' => 
    array (
      'max_requests' => 1000,
      'window_seconds' => 60,
    ),
    'route_limits' => 
    array (
      '/login' => 
      array (
        'max' => 80,
        'window' => 60,
      ),
      '/register/store' => 
      array (
        'max' => 40,
        'window' => 300,
      ),
      '/forgot/send/mail' => 
      array (
        'max' => 15,
        'window' => 3600,
      ),
      '/auth/admin' => 
      array (
        'max' => 40,
        'window' => 300,
      ),
    ),
    'suspicious_patterns' => 
    array (
      'enabled' => false,
      'min_user_agent_length' => 10,
      'rapid_request_threshold' => 120,
      'rapid_request_window' => 5,
    ),
    'ip_blocking' => 
    array (
      'enabled' => true,
      'block_duration' => 1800,
    ),
    'concurrent_requests' => 
    array (
      'enabled' => false,
      'max_concurrent' => 50,
      'window_seconds' => 5,
    ),
  ),
  'license' => 
  array (
    'customer_name' => '',
  ),
  'recaptcha' => 
  array (
    'enabled' => false,
    'version' => 'v3',
    'site_key' => '',
    'secret_key' => '',
    'score_threshold' => 0.5,
  ),
);
