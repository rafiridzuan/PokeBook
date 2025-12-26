<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Detail</title>
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial;
            background-color: white; /* Light background color */
        }
        .pokemons-detail {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .pokemons-image {
            max-width: 200px;
            margin-right: 30px;
        }
        .type-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px; /* More rounded badge */
            color: #fff;
            margin: 2px;
            font-size: 14px;
        }
        .pagination-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .pagination-controls a {
            text-decoration: none;
            background-color: #5a2d91; /* Dark purple background */
            color: white; /* White text */
            padding: 10px 15px; /* Padding */
            border-radius: 50px; /* Rounded corners */
            margin: 0 10px; /* Space between buttons */
            transition: background-color 0.3s; /* Transition effect */
        }
        .pagination-controls a:hover {
            background-color: #7a4eab; /* Lighter purple on hover */
        }
        .progress-bar-container {
            margin-bottom: 10px;
        }
        .progress-bar {
            height: 20px;
            border-radius: 5px; /* Rounded corners for the progress bar */
        }
        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }
        .btn {
            padding: 10px 15px;
            margin: 5px;
            font-size: 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s; /* Transition effect */
        }
        .btn-warning {
            background-color: #ffc107; /* Yellow for edit */
            color: black;
        }
        .btn-warning:hover {
            background-color: #e0a800; /* Darker yellow on hover */
        }
        .btn-danger {
            background-color: #dc3545; /* Red for delete */
            color: white;
            
        }
        .btn-danger:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</head>
<body>

<div>
    <div class="pagination-controls">
        @if ($previousPokemon)
            <a href="{{ route('pokemons.show', ['id' => $previousPokemon->id]) }}"><</a>
        @else
            <a href="{{ route('pokemons.show', ['id' => $maxPageId]) }}"><</a>
        @endif

        <div>Record {{ $currentPage }} of {{ $totalRecords }}</div>

        @if ($nextPokemon)
            <a href="{{ route('pokemons.show', ['id' => $nextPokemon->id]) }}">></a>
        @else
            @php
                $firstExistingId = DB::table('pokemons')->min('id');
            @endphp
            <a href="{{ route('pokemons.show', ['id' => $firstExistingId]) }}">></a>
        @endif
    </div>

    <div class="pokemons-detail">
        <img src="{{ asset('pokemons/'.$pokemons->id.'.jpg') }}" alt="{{ $pokemons->name }}" class="pokemons-image">

        <div>
            <h2 class="text-center">{{ $pokemons->name }}</h2>

            <center><div class="text-center mb-3">
                @php
                    $typeColors = [
                        'Bug' => '#ab2',
                        'Dark' => '#754',
                        'Dragon' => '#76e',
                        'Electric' => '#fc3',
                        'Fairy' => '#e9e',
                        'Fighting' => '#b54',
                        'Fire' => '#f42',
                        'Flying' => '#89f',
                        'Ghost' => '#66b',
                        'Grass' => '#7c5',
                        'Ground' => '#db5',
                        'Ice' => '#6cf',
                        'Normal' => '#aa9',
                        'Poison' => '#a59',
                        'Psychic' => '#f59',
                        'Rock' => '#ba6',
                        'Steel' => '#aab',
                        'Water' => '#39f',
                    ];
                @endphp
                @foreach($types as $type)
                    <span class="type-badge" style="background-color: {{ $typeColors[$type] ?? 'blue' }};">
                        {{ $type }}
                    </span>
                @endforeach
            </div></center>

            <div class="text-center">
                @php
                    function progressBarColor($value) {
                        if ($value <= 30) return 'red';
                        if ($value <= 60) return 'orange';
                        if ($value <= 90) return 'yellow';
                        return 'green';
                    }
                @endphp

                <div class="progress-bar-container">
                    <div class="progress-label">
                        <strong>HP:</strong>  {{ $pokemons->hp }}
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ min($pokemons->hp, 120) }}%; background-color: {{ progressBarColor($pokemons->hp) }};"></div>
                    </div>
                </div>

                <div class="progress-bar-container">
                    <div class="progress-label">
                        <strong>Attack:</strong> {{ $pokemons->attack }}
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ min($pokemons->attack, 120) }}%; background-color: {{ progressBarColor($pokemons->attack) }};"></div>
                    </div>
                </div>

                <div class="progress-bar-container">
                    <div class="progress-label">
                        <strong>Defense:</strong> {{ $pokemons->defense }}
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ min($pokemons->defense, 120) }}%; background-color: {{ progressBarColor($pokemons->defense) }};"></div>
                    </div>
                </div>
            </div>

            <!-- Admin specific buttons -->
            @if(Session::has('user'))
                <div class="text-center mt-4">
                    <button class="btn btn-warning" onclick="window.location.href='{{ url('admins/edit/'.$pokemons->id) }}'">Edit</button>
                    <button class="btn btn-danger" onclick="confirmDelete({{ $pokemons->id }})">Delete</button>
                </div>
            @endif

            <script>
                function confirmDelete(pokemonId) {
                    if (confirm('Are you sure you want to delete this Pokémon?')) {
                        fetch(`/admin/delete/${pokemonId}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                alert('Done!');
                                window.location.href = '/admin/index';  // Redirect to index page after delete
                            } else {
                                alert('Failed to delete.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                }
            </script>

        </div>
    </div>
</div>

</body>
</html>
