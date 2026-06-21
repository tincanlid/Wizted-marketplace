<?php
include 'connect.php';

$msg = '';
$registriranKorisnik = false;

if (isset($_POST['submit'])) {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka = $_POST['pass'];
    $lozinka_potvrda = $_POST['pass_confirm'];

    if ($lozinka !== $lozinka_potvrda) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {
        $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
        $razina = 0;

        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $msg = 'Ovo ime već postoji u knjigama Ministarstva!';
            } else {
                $sql_insert = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_stmt_init($dbc);
                if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
                    mysqli_stmt_bind_param($stmt_insert, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                    mysqli_stmt_execute($stmt_insert);
                    $registriranKorisnik = true;
                }
            }
        }
    }
}
mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <title>Wizted - Registracija Čarobnjaka</title>
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
    <div class="prazan-bijeli-red"></div>

    <section id="sadrzaj">
        <h2>Registracija novog računa</h2>
        
        <div class="forma-kontejner" style="max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #ccc;">
            <?php if ($registriranKorisnik === true): ?>
                <p style="color: green; font-weight: bold; text-align: center;">Čarobnjak je uspješno upisan u registar tržnice!</p>
                <p style="text-align: center;"><a href="administrator.php" class="procitaj-vise" style="display:inline-block; float:none;">Idi na prijavu</a></p>
            <?php else: ?>
                
                <?php if (!empty($msg)): ?>
                    <p style="color: red; font-weight: bold;"><?php echo $msg; ?></p>
                <?php endif; ?>

                <form action="registracija.php" method="POST">
                    <div class="form-skup">
                        <label for="ime">Ime čarobnjaka / vještice:</label>
                        <input type="text" name="ime" id="ime" required>
                    </div>

                    <div class="form-skup">
                        <label for="prezime">Prezime:</label>
                        <input type="text" name="prezime" id="prezime" required>
                    </div>

                    <div class="form-skup">
                        <label for="username">Korisničko ime:</label>
                        <input type="text" name="username" id="username" required>
                    </div>

                    <div class="form-skup">
                        <label for="pass">Lozinka:</label>
                        <input type="password" name="pass" id="pass" required>
                    </div>

                    <div class="form-skup">
                        <label for="pass_confirm">Potvrdite lozinku:</label>
                        <input type="password" name="pass_confirm" id="pass_confirm" required>
                    </div>

                    <div class="form-gumbi">
                        <button type="submit" name="submit" class="gumb-prihvati">Kreiraj račun</button>
                    </div>
                </form>
                <p style="margin-top: 20px; text-align: center;">Već imate račun? <a href="administrator.php">Prijavite se ovdje</a>.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer><p>Wizted Marketplace 2026.</p></footer>
</body>
</html>