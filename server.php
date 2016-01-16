
<pre>
<?php
//print_r($_SERVER);
$proxy_headers = array(
        'HTTP_VIA',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_FORWARDED_FOR_IP',
        'VIA',
        'X_FORWARDED_FOR',
        'FORWARDED_FOR',
        'X_FORWARDED',
        'FORWARDED',
        'CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION',
        'HTTP_X_CLUSTER_CLIENT_IP'
    );
    foreach($proxy_headers as $x){
        if (isset($_SERVER[$x])) die("You are using a proxy!");
    }
?>
</pre>