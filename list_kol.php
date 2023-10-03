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
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
        }

        /* Menggunakan kelas Bootstrap */
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

        *{
            font-family: 'Poppins';
            font-size: 16px;
        }

        .add-button:hover {
            background-color: #005f7f;
        }

        /* Mengatur posisi tombol */
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        /* Mempercantik tabel */
        .table-container {
            margin: 20px auto;
            max-width: 90%;
        }

    </style>
</head>
<body>
    <h2>Daftar KOL</h2>
    <!-- Menggunakan kelas Bootstrap untuk tabel -->
    <div class="table-container">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Created_at</th>
                    <th>Name</th>
                    <th>Type Influencer</th>
                    <th>Rate Card</th>
                    <th>Sosmed</th>
                    <th>Average</th>
                    <th>Followers</th>
                    <th>Contact Person</th>
                    <th>Spark Ads Code</th>
                </tr>
            </thead>
            <?php
            $query = "SELECT kol.created_at, kol.name_kol, influencer.name_influencer, kol.rate_card, sosmed.name_sosmed, kol.average, kol.followers, kol.contact_person, kol.spark_ads_code
                      FROM kol
                      INNER JOIN influencer ON kol.id_influencer = influencer.id_influencer
                      INNER JOIN sosmed ON kol.id_sosmed = sosmed.id_sosmed";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['name_kol'] . "</td>";
                    echo "<td>" . $row['name_influencer'] . "</td>";
                    echo "<td>" . $row['rate_card'] . "</td>";
                    echo "<td>" . $row['name_sosmed'] . "</td>";
                    echo "<td>" . $row['average'] . "</td>";
                    echo "<td>" . $row['followers'] . "</td>";
                    echo "<td>" . $row['contact_person'] . "</td>";
                    echo "<td>" . $row['spark_ads_code'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Tidak ada tugas yang ditemukan.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
    
    <!-- Menggunakan kelas Bootstrap untuk tombol -->
    <div class="button-container">
        <a class="btn btn-primary" href='add_kol.php'>Tambah KOL</a>
        <a class="btn btn-secondary" href='list_detail_kol.php'>Lihat List Detail KOL</a>
        <a class="btn btn-success" href='index.php'>Scrape Instagram</a>
    </div>
    
    <!-- Tambahkan Bootstrap JavaScript dan jQuery (diperlukan oleh Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
