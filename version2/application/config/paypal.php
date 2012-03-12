<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['Sandbox'] = TRUE;
$config['APIVersion'] = '74.0';
$config['APIUsername'] = $config['Sandbox'] ? 'nsride_1329790642_biz_api1.gmail.com' : 'PRODUCTION_USERNAME_GOES_HERE';
$config['APIPassword'] = $config['Sandbox'] ? '1215254774' : 'PRODUCTION_PASSWORD_GOES_HERE';
$config['APISignature'] = $config['Sandbox'] ? 'Ax3PJydlYE6ah9ckEa-94mTy.W83AbtEmiC0DNqiTR8uyJKMWlFsOtKa' : 'PRODUCTION_SIGNATURE_GOES_HERE';
$config['DeviceID'] = $config['Sandbox'] ? '' : 'PRODUCTION_DEVICE_ID_GOES_HERE';
$config['ApplicationID'] = $config['Sandbox'] ? 'APP-80W284485P519543T' : 'PRODUCTION_APP_ID_GOES_HERE';
$config['DeveloperEmailAccount'] = $config['Sandbox'] ? 'nsridevi.php@gmail.com' : 'PRODUCTION_DEV_EMAIL_GOES_HERE';

/* End of file paypal.php */
/* Location: ./system/application/config/paypal.php */