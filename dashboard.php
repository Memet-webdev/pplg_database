<?php
session_start();
include 'db.php';

// Proses login admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $admin_password);
        $stmt->fetch();

        if ($password === $admin_password) { // tanpa hash
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_username'] = $username;
        } else {
            $error = "Password admin salah!";
        }
    } else {
        $error = "Username admin tidak ditemukan!";
    }
    $stmt->close();
}

// Jika admin belum login, tampilkan form login
if (!isset($_SESSION['admin_id'])):
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Login Admin</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username Admin" required><br>
        <input type="password" name="password" placeholder="Password Admin" required><br>
        <button type="submit" name="admin_login">Login</button>
    </form>
    <?php if (isset($error)) echo "<div class='message'>{$error}</div>"; ?>
</div>
</body>
</html>

<?php
exit();
endif;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #4a90e2;
        color: white;
    }
    .logout {
        margin-top: 20px;
        display: inline-block;
        padding: 10px 20px;
        background: red;
        color: white;
        border-radius: 8px;
        text-decoration: none;
    }
    .btn-hapus {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    </style>
</head>
<body>

<div class="container">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>!</p>

    <table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password</th> <!-- Kolom Password -->
        <th>Created At</th>
        <th>Aksi</th>
    </tr>

    <?php
    $result = $conn->query("SELECT id, username, password, created_at FROM users");
    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo htmlspecialchars($row['password']); ?></td> <!-- Menampilkan password -->
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        <td>
            <form method="POST" action="hapus_user.php" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn-hapus">Hapus</button>
            </form>
        </td>
    </tr>
    <?php
        endwhile;
    else:
    ?>
    <tr>
        <td colspan="5">Belum ada user.</td>
    </tr>
    <?php endif; ?>
</table>


    <a class="logout" href="logout_admin.php">Logout</a>
</div>

</body>
</html>
