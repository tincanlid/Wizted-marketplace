<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <title>Wizted</title>
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
        
        <h2 style="text-align: left; padding-left:10px;">Štapići</h2>
        <div class="vijesti-red">
            <?php
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Štapići' ORDER BY id DESC LIMIT 4";
            $result = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_array($result)) {
                echo '<article>';
                echo '  <a href="clanak.php?id='.$row['id'].'"><img src="img/'.$row['slika'].'" alt="Predmet" class="vijest-slika"></a>';
                echo '  <h3><a href="clanak.php?id='.$row['id'].' " style="text-decoration:none; color:#dfb76c;">'.$row['naslov'].'</a></h3>';
                echo '  <p>'.$row['sazetak'].'</p>';
                echo '</article>';
            }
            ?>
        </div>

        <h2 style="text-align: left; padding-left:10px; margin-top:40px;">Odjeća i odore</h2>
        <div class="vijesti-red">
            <?php
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Odjeća i odore' ORDER BY id DESC LIMIT 4";
            $result = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_array($result)) {
                echo '<article>';
                echo '  <a href="clanak.php?id='.$row['id'].'"><img src="img/'.$row['slika'].'" alt="Predmet" class="vijest-slika"></a>';
                echo '  <h3><a href="clanak.php?id='.$row['id'].'" style="text-decoration:none; color:#dfb76c;">'.$row['naslov'].'</a></h3>';
                echo '  <p>'.$row['sazetak'].'</p>';
                echo '</article>';
            }
            ?>
        </div>

    </section>
    <footer><p>Wizted Marketplace 2026.</p></footer>
</body>
</html>
<?php mysqli_close($dbc); ?>