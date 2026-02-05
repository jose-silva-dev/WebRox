<?php

return array (
  'password_hash_type' => 'plain',
  'memb_info_columns' => 
  array (
    'name_column' => 'memb_name',
    'email_column' => 'mail_addr',
    'password_column' => 'memb__pwd',
    'status_column' => 'bloc_code',
  ),
  'coins' => 
  array (
    0 => 
    array (
      'title' => 'WCoinC',
      'table' => 'CashShopData',
      'column_account' => 'AccountID',
      'column_coin' => 'WCoinC',
    ),
    1 => 
    array (
      'title' => 'WCoinP',
      'table' => 'CashShopData',
      'column_account' => 'AccountID',
      'column_coin' => 'WCoinP',
    ),
    2 => 
    array (
      'title' => 'GoblinPoint',
      'table' => 'CashShopData',
      'column_account' => 'AccountID',
      'column_coin' => 'GoblinPoint',
    ),
    3 => 
    array (
      'title' => 'CustomCoin',
      'table' => 'CashShopData',
      'column_account' => 'AccountID',
      'column_coin' => 'CustomCoin',
    ),
  ),
  'vip' => 
  array (
    'name' => 
    array (
      0 => 'Free',
      1 => 'Bronze',
      2 => 'Silver',
      3 => 'Gold',
    ),
    'column' => 'AccountLevel',
    'column_expire' => 'AccountExpireDate',
    'register' => 
    array (
      'active' => '1',
      'type' => 1,
      'days' => '10',
    ),
  ),
  'donate' => 
  array (
    'table' => 'MEMB_INFO',
    'column_account' => 'AccountID',
    'column_coin' => 'WCoinC',
    'active_multiplier' => '0',
    'multiplier' => 
    array (
      0 => 
      array (
        'min' => '5',
        'max' => '20',
        'multiplier' => '1',
      ),
      1 => 
      array (
        'min' => '21',
        'max' => '50',
        'multiplier' => '2',
      ),
      2 => 
      array (
        'min' => '51',
        'max' => '100',
        'multiplier' => '3',
      ),
      3 => 
      array (
        'min' => '101',
        'max' => '200',
        'multiplier' => '4',
      ),
    ),
  ),
);
