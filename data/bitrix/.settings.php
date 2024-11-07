<?php

return array (
  'cache_flags' => 
  array (
    'value' => 
    array (
      'config_options' => 3600,
    ),
    'readonly' => false,
  ),
  'cookies' => 
  array (
    'value' => 
    array (
      'secure' => false,
      'http_only' => true,
    ),
    'readonly' => false,
  ),
  'exception_handling' => 
  array (
    'value' => 
    array (
      'debug' => true,
      'handled_errors_types' => 4437,
      'exception_errors_types' => 4437,
      'ignore_silence' => false,
      'assertion_throws_exception' => true,
      'assertion_error_type' => 256,
      'log' => array (
        'settings' => array (
          'file' => 'bitrix/error.log',
          'log_size' => 500000,
        ),
      ),
    ),
    'readonly' => false,
  ),
  'connections' => 
  array (
    'value' => 
    array (
      'default' => 
      array (
        'host' => 'localhost',
        'database' => 'host70',
        'login' => 'nobody',
        'password' => '1234aaa',
        'options' => 2,
        'className' => '\\Bitrix\\Main\\DB\\MysqliConnection',
      ),
    ),
    'readonly' => true,
  ),
  'crypto' => 
  array (
    'value' => 
    array (
      'crypto_key' => '734d00f3ad3be7aa8fc828914afe8a41',
    ),
    'readonly' => true,
  ),
);
