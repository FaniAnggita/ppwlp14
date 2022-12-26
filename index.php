<?php
//uri untuk mengakses webhservice
$opt = [
    "location" => "http://www.server1.com/soapServer3.php",
    "uri" => "http://www.server1.com/", "trace" => 1
];

//membaca API
$api = new SoapClient(NULL, $opt);


$data = json_decode($api->ambilData());



?>

<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD inventory</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body>

    <div class="container mt-4">
        <h2 class="text-center mb-3">CRUD Inventory Barang</h2>
        <hr>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Canvas untuk menampilkan diagram batang -->
                        <canvas id="produkterbanyak" style="width:100%;max-width:600px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <!-- Card untuk menampilkan statistik -->
                <div class="row">
                    <div class="col-6 col-md-6 p-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div>
                                        <?php
                                        require_once('config.php');
                                        $sql = "SELECT count(*) as total FROM barang";
                                        $result = mysqli_query($conn, $sql);
                                        $info = mysqli_fetch_assoc($result);
                                        ?>
                                        <h3 class="text-danger"><?php echo $info['total']; ?></h3>

                                        <p class="mb-0">Total Produk</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-bag-dash-fill fa-3x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 p-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div>
                                        <?php
                                        require_once('config.php');
                                        $sql = "SELECT COUNT(DISTINCT brand) as total FROM barang";
                                        $result = mysqli_query($conn, $sql);
                                        $info = mysqli_fetch_assoc($result);
                                        ?>
                                        <h3 class="text-success"><?php echo $info['total']; ?></h3>
                                        <p class="mb-0">Total Brand</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-bookmark-star-fill fa-3x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 p-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div>
                                        <?php
                                        require_once('config.php');
                                        $sql = "SELECT ROUND(AVG(harga), 2) as total FROM barang";
                                        $result = mysqli_query($conn, $sql);
                                        $info = mysqli_fetch_assoc($result);
                                        ?>
                                        <h3 class="text-warning"><span>Rp </span><?php echo number_format($info['total']); ?></h3>
                                        <p class="mb-0">Rata-rata Harga</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-cash-stack text-warning fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 p-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div>
                                        <?php
                                        require_once('config.php');
                                        $sql = "SELECT ROUND(MAX(harga), 2) as total FROM barang";
                                        $result = mysqli_query($conn, $sql);
                                        $info = mysqli_fetch_assoc($result);
                                        ?>
                                        <h3 class="text-info"><span>Rp </span><?php echo number_format($info['total']); ?></h3>
                                        <p class="mb-0">Harga Termahal</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-bar-chart-fill text-info fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- Button untuk tambah data -->
        <div class="row mb-2">
            <div class="col-md-12">
                <button type="button" id="insert-btn" class="btn btn-primary">
                    <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah
                </button>
            </div>
        </div>
        <!-- Form untuk input data baru -->
        <div class="card mb-3" id="form-body">
            <div class="card-header">
                Input Data Baru
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label>Nama </label>
                        <input type="text" class="form-control" id="nama">
                    </div>
                    <div class="form-group mt-2">
                        <label>Brand</label>
                        <input type="text" class="form-control" id="brand">
                    </div>
                    <div class="form-group mt-2">
                        <label>Satuan</label>
                        <input type="text" class="form-control" id="satuan">
                    </div>
                    <div class="form-group mt-2">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" id="jumlah">
                    </div>
                    <div class="form-group mt-2">
                        <label>Harga</label>
                        <input type="number" class="form-control" id="harga">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2" id="submit">Simpan</button>
                </form>
            </div>
        </div>
        <!-- Tabel untuk menampilkan data barang -->
        <div class="row">
            <table id="tbBarang" class="table table-hover table-striped table-bordered">
                <thead class="table-dark">
                    <th>Id</th>
                    <th>nama</th>
                    <th>brand</th>
                    <th>satuan</th>
                    <th>jumlah</th>
                    <th>harga</th>
                    <th>action</th>
                </thead>
                <tbody>
                    <!-- Fecthing data yang telah diambil dari server -->
                    <?php foreach ($data as $i) { ?>
                        <tr>
                            <td><?php echo $i->id; ?></td>
                            <td><?php echo $i->nama; ?></td>
                            <td><?php echo $i->brand; ?></td>
                            <td><?php echo $i->satuan; ?></td>
                            <td><?php echo $i->jumlah; ?></td>
                            <td><?php echo $i->harga; ?></td>
                            <td class="text-center">
                                <!-- Mengirimkan id ke halaman updae_data_form.php -->
                                <a href="update_data_form.php?id=<?php echo $i->id; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                <!-- Mengirimkan id ke halaman delete_data.php -->
                                <a href="delete_data.php?id=<?php echo $i->id; ?>" class="btn btn-danger btn-sm confirmation"><i class=" fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php  } ?>

                </tbody>
            </table>
        </div>
    </div>

    <?php
    require_once('config.php');
    $querynama = mysqli_query($conn, "select nama from barang  ORDER BY jumlah limit 5");
    while ($row = mysqli_fetch_array($querynama)) {
        $nama_barang[] = $row['nama'];
    }
    $queryjumlah = mysqli_query($conn, "select jumlah from barang  ORDER BY jumlah limit 5");
    while ($row = mysqli_fetch_array($queryjumlah)) {
        $jumlah[] = $row['jumlah'];
    }

    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            // DataTable ini merupakan plugin untuk generate search, pagination, dan sorting
            $('#tbBarang').DataTable();

            // menyembunyikan form
            $("#form-body").hide();

            // Apabila tombol #insert-btn diklik, maka..
            $("#insert-btn").on('click', function() {
                // elemen form ini akan ditampilkan/ disembunyikan
                $("#form-body").toggle(500);
            });

            // Jika tombol #submit diklik, maka akan terjadi proses penyimpanan data
            $("#submit").on('click', function(e) {
                e.preventDefault();
                // Mengambil nilai input berdasarkan id dari form
                var nama = $('#nama').val();
                var brand = $('#brand').val();
                var satuan = $('#satuan').val();
                var jumlah = $('#jumlah').val();
                var harga = $('#harga').val();



                // mengirimkan data ke insert_update.php melalui method POST
                $.ajax({
                    url: "insert_data.php",
                    type: "POST",
                    data: {
                        nama: nama,
                        brand: brand,
                        satuan: satuan,
                        jumlah: jumlah,
                        harga: harga
                    },
                    // Jika data berhasil dikirimkan, maka fungsi ini akan dijalanka
                    success: function(data) {
                        alert("Data berhasil disimpan!");
                        $("#form-body").hide();
                        location.reload(true);
                    }
                });



            });

        });
    </script>
    <script type="text/javascript">
        $('.confirmation').on('click', function() {
            return confirm('Apakah Anda yakin akan menghapus?');
        });
    </script>
    <!-- Chart diagram batang -->
    <script>
        var xValues = <?php echo json_encode($nama_barang); ?>;
        var yValues = <?php echo json_encode($jumlah); ?>;
        var barColors = ["red", "green", "blue", "orange", "brown"];

        new Chart("produkterbanyak", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "5 Produk dengan Jumlah Terbanyak"
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>