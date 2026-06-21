<?php 
include 'connect.php'; 
$kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';
?>
<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <title>Sajam: <?php echo $kategorija; ?></title>
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
        <h2 style="text-align: left; padding-left:10px;">Ponuda iz sekcije: <?php echo $kategorija; ?></h2>
        
        <div class="vijesti-red" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
            <?php
            $kategorija_safe = mysqli_real_escape_string($dbc, $kategorija);
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$kategorija_safe' ORDER BY id DESC";
            $result = mysqli_query($dbc, $query);
            
            if (mysqli_num_rows($result) == 0) {
                echo '<p style="padding: 20px; color: #a499be;">Trenutno nema artefakata na prodaju u ovoj kategoriji.</p>';
            }

            while($row = mysqli_fetch_array($result)) {
                echo '<article style="margin-bottom:10px;">';
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