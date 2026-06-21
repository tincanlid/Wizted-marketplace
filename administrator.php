<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$uspjesnaPrijava = null;
$msg = '';

// logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: administrator.php");
    exit();
}

// login
if (isset($_POST['prijava'])) {
    $form_username = $_POST['username'];
    $form_password = $_POST['lozinka'];

    $sql = "SELECT ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $form_username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
            mysqli_stmt_fetch($stmt);
            
            if (password_verify($form_password, $lozinkaKorisnika)) {
                $uspjesnaPrijava = true;
                
                $_SESSION['$username'] = $imeKorisnika;
                $_SESSION['$level'] = $levelKorisnika;
            } else {
                $uspjesnaPrijava = false;
                $msg = 'Pogrešna zaporka čarobnjaka!';
            }
        } else {
            $uspjesnaPrijava = false;
            $msg = 'Korisničko ime ne postoji u bazi. Morate se registrirati u Ministarstvu magije!';
        }
    }
}

$is_logged_in = isset($_SESSION['$username']);
$is_admin = isset($_SESSION['$level']) && $_SESSION['$level'] == 1;

// if admin
if ($is_logged_in && $is_admin) {
    
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql_delete = "DELETE FROM vijesti WHERE id = ?";
        $stmt_del = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt_del, $sql_delete)) {
            mysqli_stmt_bind_param($stmt_del, 'i', $id);
            mysqli_stmt_execute($stmt_del);
        }
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $about = $_POST['about'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $archive = isset($_POST['archive']) ? 1 : 0;
        
        if ($_FILES['pphoto']['name'] != "") {
            $picture = $_FILES['pphoto']['name'];
            $target_dir = UPLPATH . $picture;
            move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
            
            $sql_update = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
            $stmt_upd = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt_upd, $sql_update)) {
                mysqli_stmt_bind_param($stmt_upd, 'sssssii', $title, $about, $content, $picture, $category, $archive, $id);
                mysqli_stmt_execute($stmt_upd);
            }
        } else {
            $sql_update = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=? WHERE id=?";
            $stmt_upd = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt_upd, $sql_update)) {
                mysqli_stmt_bind_param($stmt_upd, 'ssssii', $title, $about, $content, $category, $archive, $id);
                mysqli_stmt_execute($stmt_upd);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <title>Administracija Tržnice</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header><img src="img/logo.png" alt="Wizted Logo" class="logo"><a>WIZTED MARKETPLACE</a></header>
    <nav>
        <div class="nav-kontejner">
            <a href="index.php">Početna</a>
            <a href="kategorija.php?kategorija=Štapići">Štapići</a>
            <a href="kategorija.php?kategorija=Odjeća i odore">Odjeća i odore</a>
            <a href="unos.html">Prodaj predmet</a>
            <a href="administrator.php">Moja oglasna ploča</a>
        </div>
    </nav>

    <section id="sadrzaj">
        
        <?php
        if ($is_logged_in && $is_admin) {
            echo '<h2>Dobrodošli natrag, ' . $_SESSION['$username'] . '! (Upravitelj tržnice)</h2>';
            echo '<p style="text-align:right; margin-bottom:20px;"><a href="administrator.php?action=logout" class="gumb-ponisti" style="text-decoration:none; padding: 10px 20px; display:inline-block;">Odjava s računa</a></p>';
            
            $query = "SELECT * FROM vijesti ORDER BY id DESC";
            $result = mysqli_query($dbc, $query);
            
            while($row = mysqli_fetch_array($result)) {
                echo '
                <div class="forma-kontejner" style="margin-bottom: 40px; border: 1px solid #3d265e;">
                    <form action="administrator.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="'.$row['id'].'">

                        <div class="form-skup">
                            <label>Naziv magičnog predmeta:</label>
                            <input type="text" name="title" value="'.$row['naslov'].'" required>
                        </div>

                        <div class="form-skup">
                            <label>Cijena (Galeoni) i stanje predmeta:</label>
                            <textarea name="about" rows="2" required>'.$row['sazetak'].'</textarea>
                        </div>

                        <div class="form-skup">
                            <label>Magična svojstva i detaljan opis:</label>
                            <textarea name="content" rows="6" required>'.$row['tekst'].'</textarea>
                        </div>

                        <div class="form-skup">
                            <label>Prikaz predmeta (slika):</label>
                            <input type="file" name="pphoto" accept="image/*">
                            <div style="margin-top: 10px;">
                                <img src="img/'.$row['slika'].'" style="width: 120px; height: auto; border: 1px solid #3d265e; border-radius:4px;">
                            </div>
                        </div>

                        <div class="form-skup">
                            <label>Kategorija:</label>
                            <select name="category" required>
                                <option value="Čarobni štapići" '.($row['kategorija'] == "Štapići" ? "selected" : "").'>Štapići</option>
                                <option value="Odjeća i odore" '.($row['kategorija'] == "Odjeća i odore" ? "selected" : "").'>Odjeća i odore</option>
                            </select>
                        </div>

                        <div class="form-skup checkbox-skup">
                            <input type="checkbox" name="archive" id="archive_'.$row['id'].'" value="1" '.($row['arhiva'] == 1 ? "checked" : "").'>
                            <label for="archive_'.$row['id'].'">Označi ovaj predmet kao PRODAN (sakrij s tržnice)</label>
                        </div>

                        <div class="form-gumbi">
                            <button type="submit" name="delete" class="gumb-ponisti" onclick="return confirm(\'Jeste li sigurni da želite povući artikl s tržnice?\')">Ukloni oglas</button>
                            <button type="submit" name="update" class="gumb-prihvati">Spremi izmjene</button>
                        </div>
                    </form>
                </div>';
            }
        }
        
        else if ($is_logged_in && !$is_admin) {
            echo '<h2>Magična barijera pristupa</h2>';
            echo '<div class="forma-kontejner" style="max-width: 500px; margin: 0 auto; text-align:center;">';
            echo '  <p>Pozdrav ' . $_SESSION['$username'] . '! Uspješno ste se teleportirali na sustav, ali niste registrirani Upravitelj Tržnice.</p>';
            echo '  <p style="color: #dfb76c; font-weight: bold; margin-top:15px;">Nemate ovlasti za uređivanje tuđih magičnih oglasa.</p>';
            echo '  <p style="margin-top: 20px;"><a href="administrator.php?action=logout" class="gumb-ponisti" style="text-decoration:none; padding: 10px 20px; display:inline-block;">Odjava</a></p>';
            echo '</div>';
        }
        
        else {
            echo '<h2 style="text-align:center; margin-bottom:30px;">Prijava na Čarobnjački Račun</h2>';
            echo '<div class="forma-kontejner" style="max-width: 450px; margin: 0 auto;">';
            
            if (!empty($msg)) {
                echo '<p style="color: #ff6b6b; font-weight: bold; text-align:center; margin-bottom: 15px;">' . $msg . '</p>';
            }
            if ($uspjesnaPrijava === false && strpos($msg, 'registrirati') !== false) {
                echo '<p style="text-align:center; margin-bottom:15px;"><a href="registracija.php" style="color:#dfb76c; font-weight:bold;">Registriraj se u Ministarstvo</a></p>';
            }
            ?>
            <form action="administrator.php" method="POST">
                <div class="form-skup">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="form-skup">
                    <label for="lozinka">Password:</label>
                    <input type="password" name="lozinka" id="lozinka" required>
                </div>

                <div class="form-gumbi" style="justify-content: center;">
                    <button type="submit" name="prijava" class="gumb-prihvati" style="width: 100%;">Otvori Tržnicu</button>
                </div>
            </form>
            <p style="margin-top: 25px; text-align: center; color:#a499be; font-size:0.9rem;">Prvi put prodajete? <a href="registracija.php" style="color:#dfb76c; text-decoration:none; font-weight:bold;">Registrirajte račun</a>.</p>
            </div>
            <?php
        }
        ?>
    </section>

    <footer><p>Wizted Marketplace 2026.</p></footer>
</body>
</html>
<?php mysqli_close($dbc); ?>