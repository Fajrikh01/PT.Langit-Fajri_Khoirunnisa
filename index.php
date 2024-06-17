<!-- index.php -->

<?php
function fetchData($url)
{
  $response = file_get_contents($url);
  return json_decode($response);
}

$pokeapi_base_url = 'https://pokeapi.co/api/v2/';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = trim($search_query);

if ($search_query) {
  $pokemon_data = fetchData($pokeapi_base_url . 'pokemon/' . strtolower($search_query));
  $total_pokemon_count = 1;
  $items_per_page = 1;
  $total_pages = 1;
  $current_page = 1;
} else {
  $total_pokemon_count = fetchData($pokeapi_base_url . 'pokemon?limit=1')->count;
  $items_per_page = 24;
  $total_pages = ceil($total_pokemon_count / $items_per_page);
  $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $current_page = max(1, min($current_page, $total_pages));
  $offset = ($current_page - 1) * $items_per_page;
  $pokemon_data = fetchData($pokeapi_base_url . "pokemon?offset=$offset&limit=$items_per_page");
}
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
          <li class="nav-item active">
            <a class="nav-link text-white" href="index.php">Pokemon</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="berry.php">Berry</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="item.php">Item</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Akhir Navbar -->

  <!-- Pokemon list -->

  <div class="container mt-5">
    <h1 class="text-center mb-4">Pokémon</h1>

    <!-- search -->
    <form class="mb-4" method="GET" action="index.php">
      <div class="input-group">
        <input type="text" class="form-control" id="pokemonSearch" name="search" placeholder="Search for a Pokémon" value="<?= htmlspecialchars($search_query); ?>">
        <button class="btn btn-warning text-dark" type="submit">Search</button>
      </div>
    </form>

    <!-- Pokemon card -->
    <div id="pokemon-list" class="row">
      <?php foreach ($pokemon_data->results as $key => $pokemon) : ?>
        <div class="col-md-2 mb-3">
          <div class="card">
            <img src="" alt="<?= ucfirst($pokemon->name); ?>" class="pokemon-image img-fluid mb-2 img-card-top" data-url="<?= $pokemon->url; ?>">
            <div class="card-body">
              <h5 class="card-title"><?= ucfirst($pokemon->name); ?></h5>
              <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#pokemonModal<?= $key; ?>">Detail<i data-feather="arrow-right" style="width: 20px; height: 20px;"></i></button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pokemon modal -->
    <?php foreach ($pokemon_data->results as $key => $pokemon) : ?>
      <div class="modal fade" id="pokemonModal<?= $key; ?>" tabindex="-1" role="dialog" aria-labelledby="pokemonModalLabel<?= $key; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="pokemonModalLabel<?= $key; ?>"><?= ucfirst($pokemon->name); ?> Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">
              <div class="d-flex position-relative">
                <div class="col-md-4">
                  <img src="" alt="<?= ucfirst($pokemon->name); ?>" class="modal-pokemon-image mb-2" style="height: 280px; width: 280px;">
                </div>
                <div class="col-md-8">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th scope="row">Abilities</th>
                        <td><span class="modal-pokemon-abilities"></span></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th scope="row">Type</th>
                        <td><span class="modal-pokemon-types"></span></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th scope="row">Type</th>
                        <td><span class="modal-pokemon-species"></span></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th scope="row">Type</th>
                        <td><span class="modal-pokemon-egg-groups"></span></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th scope="row">Weight</th>
                        <td><span class="modal-pokemon-weight"></span> kg</td>
                        <th>Height</th>
                        <td><span class="modal-pokemon-height"></span> m</td>
                      </tr>
                    </tbody>
                  </table>
                  <p><strong>Characteristics:</strong> <span class="modal-pokemon-stats"></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- Pagination -->
    <?php if (!$search_query) : ?>
      <nav aria-label="Page navigation example" class="d-flex justify-content-end">
        <ul class="pagination">
          <?php if ($current_page > 1) : ?>
            <li class="page-item"><a class="page-link" href="index.php?page=<?= $current_page - 1; ?>" aria-label="Previous">&laquo;</a></li>
          <?php endif; ?>

          <?php for ($i = max(1, $current_page - 1); $i <= min($total_pages, $current_page + 1); $i++) : ?>
            <li class="page-item <?= $i == $current_page ? 'active' : ''; ?>"><a class="page-link" href="index.php?page=<?= $i; ?>"><?= $i; ?></a></li>
          <?php endfor; ?>

          <?php if ($current_page < $total_pages) : ?>
            <li class="page-item"><a class="page-link" href="index.php?page=<?= $current_page + 1; ?>" aria-label="Next">&raquo;</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <!-- JS -->
  <script src="script.js"></script>

  <!-- icon -->
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();
  </script>
</body>

</html>