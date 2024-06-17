$(document).ready(function(){
    $('#myTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Ambil semua elemen gambar Pokémon
    const pokemonImages = document.querySelectorAll('.pokemon-image');
    
    pokemonImages.forEach(image => {
        const pokemonUrl = image.getAttribute('data-url');
        
        // Panggil API untuk mendapatkan detail Pokémon
        fetch(pokemonUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                // Set gambar Pokémon
                image.src = data.sprites.front_default;

            })
            .catch(error => console.error('Error:', error));
    });
    
// modal
const pokemonCards = document.querySelectorAll('.card');

  pokemonCards.forEach((card, index) => {
    card.addEventListener('click', function() {
      const pokemonUrl = card.querySelector('.pokemon-image').dataset.url;
      fetch(pokemonUrl)
        .then(response => response.json())
        .then(data => {
          const modal = document.getElementById(`pokemonModal${index}`);
          const image = modal.querySelector('.modal-pokemon-image');
          const abilities = modal.querySelector('.modal-pokemon-abilities');
          const types = modal.querySelector('.modal-pokemon-types');
          const stats = modal.querySelector('.modal-pokemon-stats');
          const weight = modal.querySelector('.modal-pokemon-weight');
          const height = modal.querySelector('.modal-pokemon-height');
          const species = modal.querySelector('.modal-pokemon-species');
          const eggGroups = modal.querySelector('.modal-pokemon-egg-groups');

          image.src = data.sprites.front_default;
          abilities.textContent = data.abilities.map(ability => ability.ability.name).join(', ');
          types.textContent = data.types.map(type => type.type.name).join(', ');
          stats.textContent = data.stats.map(stat => `${stat.stat.name}: ${stat.base_stat}`).join(', ');
          weight.textContent = data.weight;
          height.textContent = data.height;
          species.textContent = data.species.name;
          
          fetch(data.species.url)
                    .then(response => response.json())
                    .then(speciesData => {
                        species.textContent = speciesData.name;
                        eggGroups.textContent = speciesData.egg_groups.map(group => group.name).join(', ');
                    })
                    .catch(error => console.error('Error fetching species data:', error));
                    
                    const encounterUrl = data.location_area_encounters;
                    fetch(encounterUrl)
                        .then(response => response.json())
                        .then(encounters => {
                            const conditions = encounters.map(encounter => encounter.version_details.map(detail => detail.encounter_details.map(enc => enc.condition_values.map(cond => cond.name).join(', ')).join(', ')).join(', ')).join(', ');
                            encounterConditions.textContent = conditions || 'No encounter conditions available';
                        })
                        .catch(error => console.error('Error fetching encounter conditions:', error));
                });
    });
  });

    // Ambil semua elemen gambar Berries
    const berryImages = document.querySelectorAll('.berry-image');
    
    berryImages.forEach(image => {
        const berryUrl = image.getAttribute('data-url');
        
        // Panggil API untuk mendapatkan detail Berry
        fetch(berryUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Tambahkan ini untuk melihat data di konsol

                // Set gambar Berry
                image.src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/${data.item.name}.png`;

                // Set tipe Berry 
                const firmness = data.firmness.name;
                image.closest('.card-body').querySelector('.berry-type').textContent = 'Firmness: ' + firmness;
            })
            .catch(error => console.error('Error:', error));
    });

    // Ambil semua elemen gambar Items
    const itemImages = document.querySelectorAll('.item-image');
    
    itemImages.forEach(image => {
        const itemUrl = image.getAttribute('data-url');
        
        // Panggil API untuk mendapatkan detail Item
        fetch(itemUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Tambahkan ini untuk melihat data di konsol

                // Set gambar Item
                image.src = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/${data.name}.png`;

                // Set detail Item (Jika ada data tambahan yang ingin ditampilkan)
                // Contoh: category
                const category = data.category.name;
                image.closest('.card-body').querySelector('.item-category').textContent = 'Category: ' + category;
            })
            .catch(error => console.error('Error:', error));
    });

    // search
    $('#pokemonSearch').on('input', function() {
        const searchValue = $(this).val().toLowerCase();
        $('.card').each(function() {
            const card = $(this);
            const pokemonName = card.find('.card-title').text().toLowerCase();
            if (pokemonName.includes(searchValue)) {
                card.show();
            } else {
                card.hide();
            }
        });
    });
});

