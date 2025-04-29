<?php
$koneksi = new mysqli("localhost", "root", "", "user_db");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Tambah Buku Baru
if (isset($_POST['tambah_buku'])) {
    $kode_buku = $koneksi->real_escape_string($_POST['kode_buku']);
    $judul_buku = $koneksi->real_escape_string($_POST['judul_buku']);
    $nama_pengarang = $koneksi->real_escape_string($_POST['nama_pengarang']);
    $penerbit = $koneksi->real_escape_string($_POST['penerbit']);
    $id_kategori = intval($_POST['id_kategori']);
    $no_urut = intval($_POST['no_urut']);

    $koneksi->query("INSERT INTO buku (kode_buku, judul_buku, nama_pengarang, penerbit, id_kategori, no_urut) 
                     VALUES ('$kode_buku', '$judul_buku', '$nama_pengarang', '$penerbit', $id_kategori, $no_urut)");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$result = $koneksi->query("SELECT * FROM buku ORDER BY no_urut ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Buku</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: Arial; background: #f4f4f9; margin: 0; padding: 0; }
        .container { width: 90%; margin: 20px auto; }
        header { background: #4CAF50; padding: 10px; color: white; text-align: center; border-radius: 5px; }
        button { background: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }
        .modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center;
        }
        .modal-content {
            background: white; padding: 20px; border-radius: 8px; width: 400px; text-align: center;
        }
        .modal input {
            width: 90%; margin: 10px 0; padding: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h2>Dashboard Buku</h2>
        <button style="background-color:rgb(255, 34, 34);" class="logout-button" onclick="logout()">Logout</button>
    </header>

    <div style="margin: 20px 0;">
        <button onclick="openModal()">Tambah Buku Baru</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Nama Pengarang</th>
                <th>Penerbit</th>
                <th>ID Kategori</th>
                <th>No Urut</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>$no</td>
                            <td>" . htmlspecialchars($row['kode_buku']) . "</td>
                            <td>" . htmlspecialchars($row['judul_buku']) . "</td>
                            <td>" . htmlspecialchars($row['nama_pengarang']) . "</td>
                            <td>" . htmlspecialchars($row['penerbit']) . "</td>
                            <td>" . htmlspecialchars($row['id_kategori']) . "</td>
                            <td>" . htmlspecialchars($row['no_urut']) . "</td>
                          </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='7'>Belum ada data buku</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Form Tambah Buku -->
<div id="modalForm" class="modal">
    <div class="modal-content">
        <h3>Tambah Buku Baru</h3>
        <form method="POST">
            <input type="text" name="kode_buku" placeholder="Kode Buku" required>
            <input type="text" name="judul_buku" placeholder="Judul Buku" required>
            <input type="text" name="nama_pengarang" placeholder="Nama Pengarang" required>
            <input type="text" name="penerbit" placeholder="Penerbit" required>
            <input type="number" name="id_kategori" placeholder="ID Kategori" required>
            <input type="number" name="no_urut" placeholder="No Urut" required>
            <button type="submit" name="tambah_buku">Simpan</button>
        </form>
        <br>
        <button onclick="closeModal()" style="background:red;">Batal</button>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalForm').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('modalForm').style.display = 'none';
    }
</script>

</body>
</html>

<?php $koneksi->close(); ?>
