<?php
$id = $_POST['id'];
$nama = $_POST['nama'];
$brand = $_POST['brand'];
$satuan = $_POST['satuan'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];

try {
    $opt = [
        "location" => "http://www.server1.com/soapServer3.php",
        "uri" => "http://www.server1.com/", "trace" => 1
    ];

    //membaca API
    $api = new SoapClient(NULL, $opt);

    $komen = $api->updateData($id, $nama, $brand, $satuan, $jumlah, $harga);
} catch (SoapFault $ex) {
    echo $api->__getLastResponse();
}

echo '<script type="text/javascript">
alert("Data berhasil diperbarui!");
location="index.php";
</script>';
