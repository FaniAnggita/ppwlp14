<?php
//uri untuk mengakses webhservice
try {
    $opt = [
        "location" => "http://www.server1.com/soapServer3.php",
        "uri" => "http://www.server1.com/", "trace" => 1
    ];

    //membaca API
    $api = new SoapClient(NULL, $opt);

    $komen = $api->hapusData($_GET['id']);
} catch (SoapFault $ex) {
    echo $api->__getLastResponse();
}

echo '<script type="text/javascript">
alert("Data berhasil dihapus!");
location="index.php";
</script>';
