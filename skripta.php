<?php
include 'connect.php';

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $datum = date('Y-m-d H:i:s');
    
    // arhiva check
    $archive = isset($_POST['archive']) ? 1 : 0;

    $picture = $_FILES['pphoto']['name'];
    $target_dir = 'img/' . $picture;
    move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);

    // Zaštita unosa od lomljenja SQL upita (Prepared statements su bolji, ali ovo osigurava rad s vašim postojećim kodom)
    $title_db = mysqli_real_escape_string($dbc, $title);
    $about_db = mysqli_real_escape_string($dbc, $about);
    $content_db = mysqli_real_escape_string($dbc, $content);
    $category_db = mysqli_real_escape_string($dbc, $category);

    $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) 
              VALUES ('$datum', '$title_db', '$about_db', '$content_db', '$picture', '$category_db', '$archive')";
    
    $result = mysqli_query($dbc, $query) or die('Greška pri magičnom upisu u bazu podataka.');
} else {
    header("Location: unos.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <title>Predmet postavljen na tržnicu</title>
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
        <h2 style="text-align: center; margin-bottom: 30px;">Oglas je uspješno poslan i objavljen na Wiztedu!</h2>
        <div class="clanak-prikaz">
            <p class="clanak-kategorija"><?php echo $category; ?></p>
            <h1 class="clanak-naslov"><?php echo $title; ?></h1>
            <div class="clanak-meta">
                <span><strong>VRIJEME POSTAVLJANJA:</strong> <?php echo date('d.m.Y. H:i', strtotime($datum)); ?></span>
                <span><strong>SKRIVENO (SKICA):</strong> <?php echo ($archive == 1) ? 'Da' : 'Ne'; ?></span>
            </div>
            <div class="clanak-slika-okvir">
                <img src="img/<?php echo $picture; ?>" alt="Slika artefakta" class="clanak-slika">
            </div>
            <p class="clanak-sazetak"><?php echo $about; ?></p>
            <div class="clanak-tekst"><p><?php echo nl2br($content); ?></p></div>
            
            <div style="margin-top: 30px; text-align: center;">
                <a href="index.php" class="gumb-prihvati" style="text-decoration: none; display: inline-block;">Povratak na tržnicu</a>
            </div>
        </div>
    </section>
    <footer><p>Wizted Marketplace 2026.</p></footer>
</body>
</html>
<?php mysqli_close($dbc); ?>