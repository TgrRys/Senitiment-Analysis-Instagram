<?php
require 'connection.php'; // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas</title>
    <!-- Tambahkan Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        *{
            font-family: 'Poppins';
            font-size: 16px;
        }

        h2 {
            text-align: center;
        }

        /* Menggunakan kelas Bootstrap untuk tabel */
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .add-button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
        }

        .add-button:hover {
            background-color: #005f7f;
        }

        /* Mempercantik tabel */
        .table-container {
            margin: 20px auto;
            max-width: 90%;
        }

        /* Memposisikan tombol tengah-tengah */
        .center-button {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Daftar Detail KOL</h2>
    <!-- Menggunakan kelas Bootstrap untuk tabel -->
    <div class="table-container">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Created_at</th>
                    <th>Name</th>
                    <th>Link Postingan</th>
                    <th>Rate Card Tawar</th>
                    <th>Sales</th>
                    <th>Omset</th>
                    <th>Nama Brand</th>
                    <th>Nama Program</th>
                    <th>fee</th>
                    <th>date</th>
                    <th>likes</th>
                    <th>comments</th>
                </tr>
            </thead>
            <?php
            $query = "SELECT  detail_kol.created_at, kol.name_kol, detail_kol.link_postingan, 
                      detail_kol.rate_card_tawar, detail_kol.sales, detail_kol.omset, brand.name_brand,
                      program.name_program, detail_kol.fee,detail_kol.date_post,detail_kol.likes,detail_kol.comments
                      FROM detail_kol
                      INNER JOIN kol ON detail_kol.id_kol = kol.id
                      INNER JOIN brand ON detail_kol.id_brand = brand.id_brand
                      INNER JOIN program ON detail_kol.id_program = program.id_program";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['name_kol'] . "</td>";
                    echo "<td>" . $row['link_postingan'] . "</td>";
                    echo "<td>" . $row['rate_card_tawar'] . "</td>";
                    echo "<td>" . $row['sales'] . "</td>";
                    echo "<td>" . $row['omset'] . "</td>";
                    echo "<td>" . $row['name_brand'] . "</td>";
                    echo "<td>" . $row['name_program'] . "</td>";
                    echo "<td>" . $row['fee'] . "</td>";
                    echo "<td>" . $row['date_post'] . "</td>";
                    echo "<td>" . $row['likes'] . "</td>";
                    echo "<td>" . $row['comments'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Tidak ada tugas yang ditemukan.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
    
    <!-- Memposisikan tombol tengah-tengah -->
    <div class="center-button">
        <a class="btn btn-primary" href='add_detail_kol.php'>Tambah Detail KOL</a>
    </div>

    <!-- Tambahkan Bootstrap JavaScript dan jQuery (diperlukan oleh Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
