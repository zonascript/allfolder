
<?php
  $ch = curl_init();
  $skipper = "luxury assault recreational vehicle";
  $fields = array( 'penguins'=>$skipper, 'bestpony'=>'rainbowdash');
  $postvars = '';
  foreach($fields as $key=>$value) {
    $postvars .= $key . "=" . $value . "&";
  }
  $url = "http://www.google.com";
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
  curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
  curl_setopt($ch,CURLOPT_TIMEOUT, 20);
  $response = curl_exec($ch);
  print "curl response is:" . $response;
  curl_close ($ch);
 /* $post = [
      'username' => 'user1',
      'password' => 'passuser1',
      'gender'   => 1,
  ];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'http://www.domain.com');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  var_export($response);*/
?>