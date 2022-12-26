<?php
// Kelas ini digunakan untuk menyediakan layanan API
class Service1
{
    // Fungsi ini untuk mengambil data dari database lalu mengembalikan dalam JSON
    public function ambilData()
    {
        // Koneksi ke database
        $koneksi = new mysqli('localhost', 'root', '', 'inventory');
        // Query data
        $hasil = $koneksi->query("SELECT * FROM barang ");

        // Mengambil data dalam bentuk array
        while ($rows = $hasil->fetch_array()) {
            $return_brg[] = array(
                'id' => $rows['id'],
                'nama' => $rows['nama'],
                'brand' => $rows['brand'],
                'satuan' => $rows['satuan'],
                'jumlah' => $rows['jumlah'],
                'harga' => $rows['harga'],
            );
        }
        // Proses encode data ke JSON
        return json_encode($return_brg);
    }

    // Fungsi untuk menambahkan data
    function tambahData($nama, $brand, $satuan, $jumlah, $harga)
    {
        $koneksi = new mysqli('localhost', 'root', '', 'inventory');
        $sql = "INSERT INTO barang(nama,brand,satuan,jumlah,harga) VALUES ('$nama','$brand', '$satuan', '$jumlah', '$harga')";

        if ($koneksi->query($sql) === true) {
            return "Tambah Data Berhasil";
        } else {
            return "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }

    // Fungsi untuk update data
    function updateData($id, $nama, $brand, $satuan, $jumlah, $harga)
    {
        $koneksi = new mysqli('localhost', 'root', '', 'inventory');
        $sql = "UPDATE barang SET nama='$nama', brand='$brand', satuan='$satuan',jumlah='$jumlah', harga='$harga' WHERE id='$id'";

        if ($koneksi->query($sql) === true) {
            echo "<script>alert('data berhasil diperbarui!');</script>";
        } else {
            return "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }

    // Fungsi untuk hapus data
    function hapusData($id)
    {
        $koneksi = new mysqli('localhost', 'root', '', 'inventory');
        $sql = "DELETE FROM barang WHERE id = $id";
        if ($koneksi->query($sql) === true) {
            // 
        } else {
            return "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }
}

// Alamat server
$opt = ["uri" => "http://www.server1.com/"];
//membuat kelas instan
$serv = new SoapServer(NULL, $opt);
//memanggil kelas
$serv->setClass('Service1');
//start
$serv->handle();
