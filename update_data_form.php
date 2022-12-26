<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <!-- query ini berdasarkan id pada data yang akan diupdate -->
    <?php

    require_once('config.php');

    $id = $_GET['id'];

    $query = "SELECT * FROM barang WHERE id='$id'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    ?>

    <div class="container">
        <div class="card mt-4" id="form-body">
            <div class="card-header">
                Update Data
            </div>
            <div class="card-body">
                <!-- Form untuk update data -->
                <form method="post" action="update_data.php">
                    <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                    <div class="form-group">
                        <label>Nama </label>
                        <input type="text" value="<?php echo $row['nama']; ?>" class="form-control" name="nama">
                    </div>
                    <div class="form-group mt-2">
                        <label>Brand</label>
                        <input type="text" value="<?php echo $row['brand']; ?>" class="form-control" name="brand">
                    </div>
                    <div class="form-group mt-2">
                        <label>Satuan</label>
                        <input type="text" value="<?php echo $row['satuan']; ?>" class="form-control" name="satuan">
                    </div>
                    <div class="form-group mt-2">
                        <label>Jumlah</label>
                        <input type="number" value="<?php echo $row['jumlah']; ?>" class="form-control" name="jumlah">
                    </div>
                    <div class="form-group mt-2">
                        <label>Harga</label>
                        <input type="number" value="<?php echo $row['harga']; ?>" class="form-control" name="harga">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2" id="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>