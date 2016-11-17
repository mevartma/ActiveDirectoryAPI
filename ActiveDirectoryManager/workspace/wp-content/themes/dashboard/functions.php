<?php

add_theme_support( 'post-thumbnails' ); 


function limit_length($x, $length)
{
  if(strlen($x)<=$length)
  {
    return $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    return $y;
  }
}

function tradingCentral_generateToken ($key) {
		 // Parameters
		 $key        = 'SGQyNXNkRmY0NEREZDU1cw==';             // The encryption key
		 $partnerId  = '24OptionHF';    // The partner id
		 $userName   = gethostname();//GUID            // Username
		 $language   = 'en-US';                           // Language code
		 $cipher     = MCRYPT_BLOWFISH;  // Encryption algorithm 
		 $cipherMode = MCRYPT_MODE_ECB;  // Cypher mode
		
		 // Creating the clear token.
		 $input = $partnerId . ',' . $userName . ',' . $language . ',' . time();
		
		 // Formatting the key.
		 $key = base64_decode($key);
		
		 // Setting the mcrypt cipher and cipher mode.		        
		 $td = mcrypt_module_open($cipher, '', $cipherMode, '');
		
		 // Initiating mcrypt.
		// No iv needed in ECB mode, so using 00000000
		 mcrypt_generic_init($td, $key, '00000000');
		
		 // Crypting the token.
		 $token = mcrypt_generic($td, $input);
		 $base64Token = base64_encode($token);
		
		 // closing mcrypt
		 mcrypt_generic_deinit($td);
		 mcrypt_module_close($td);
		 return $base64Token;
	
}