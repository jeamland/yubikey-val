<?php                                                             # -*- php -*-

//// DB
//
$baseParams = array ();
$baseParams['__DB_HOST__'] = 'localhost';
$baseParams['__DB_USER__'] = 'ykval_verifier';
$baseParams['__DB_PW__'] = 'password';
$baseParams['__DB_NAME__'] = 'ykval';

// otp2ksmurls: Return array of YK-KSM URLs for decrypting OTP for
// CLIENT.  The URLs must be fully qualified, i.e., contain the OTP
// itself.
function otp2ksmurls ($otp, $client) {
  if ($client == 42) {
    return array("http://another-ykkms.example.com/wsapi/decrypt?otp=$otp");
  }

  if (preg_match ("/^dteffujehknh/", $otp)) {
    return array("http://different-ykkms.example.com/wsapi/decrypt?otp=$otp");
  }

  return array(
	       "http://ykkms1.example.com/wsapi/decrypt?otp=$otp",
	       "http://ykkms2.example.com/wsapi/decrypt?otp=$otp",
	       );
}

?>
