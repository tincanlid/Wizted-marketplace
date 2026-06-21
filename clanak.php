<?php 
include 'connect.php'; 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM vijesti WHERE id = $id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);

if(!$row) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['naslov']; ?></title>
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
        <div class="clanak-prikaz">
            <p class="clanak-kategorija"><?php echo $row['kategorija']; ?></p>
            <h1 class="clanak-naslov"><?php echo $row['naslov']; ?></h1>
            
            <div class="clanak-meta">
                <span><strong>OGLASIO PRODAVAČ DANA:</strong> <?php echo date('d.m.Y.', strtotime($row['datum'])); ?></span>
                <span><strong>STATUS:</strong> Dostupno</span>
            </div>
            
            <div class="clanak-slika-okvir">
                <img src="img/<?php echo $row['slika']; ?>" alt="Slika predmeta" class="clanak-slika">
            </div>
            
            <p class="clanak-sazetak"><?php echo $row['sazetak']; ?></p>
            
            <div class="clanak-tekst">
                <h3 style="margin-bottom:10px; font-size:1.2rem;">Opis vlasnika:</h3>
                <p><?php echo nl2br($row['tekst']); ?></p>
            </div>
            
            <div style="margin-top: 30px; text-align: center;">
                <button class="gumb-prihvati" style="font-size: 1.1rem; padding: 15px 40px;">Kupi</button>
            </div>
        </div>
    </section>

    <footer><p>Wizted Marketplace 2026.</p></footer>
</body>
</html>
<?php mysqli_close($dbc); ?>