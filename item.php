<!-- index.php -->

<?php
function fetchData($url)
{
    $response = file_get_contents($url);
    return json_decode($response);
}

// Ambil data Pokémon, berries, machines, dan items
$pokeapi_base_url = 'https://pokeapi.co/api/v2/';
$items_data = fetchData($pokeapi_base_url . 'item');
?>


<!-- index.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fajri Khoirunnisa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-warning" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="#">Fajri Khoirunnisa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Pokemon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="berry.php">Berry</a>
                    </li>
                    <li class="nav-item text-white">
                        <a class="nav-link" href="item.php">Item</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->
    <div class="container mt-5">

        <h1 class="text-center mb-4">Items</h1>
        <div id="item-list" class="row">
            <?php foreach ($items_data->results as $item) : ?>
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="" alt="<?= ucfirst($item->name); ?>" class="item-image img-fluid mb-2" data-url="<?= $item->url; ?>">
                            <h5 class="card-title"><?= ucfirst($item->name); ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>

</html>