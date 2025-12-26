<!DOCTYPE html>
<html>
<head>
    <title>Poke Book</title>
    <!-- Add jQuery for filtering -->
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <style>
        body{
            font-family: Arial;
            background-color: #f9f9f9;
        }
    .alert {
        padding: 15px; /* Padding inside the alert */
        border-radius: 5px; /* Rounded corners */
        margin-bottom: 20px; /* Space below the alert */
        background-color: #d4edda; /* Light green background for success */
        color: #155724; /* Dark green text color */
        border: 1px solid #c3e6cb; /* Green border */
        display: flex; /* Flexbox for alignment */
        align-items: center; /* Center items vertically */
        justify-content: space-between; /* Space between message and close button */
    }

    .alert-success {
        background-color: #d4edda; /* Light green background */
        color: #155724; /* Dark green text color */
        border: 1px solid #c3e6cb; /* Green border */
    }


    /* Container for Pokémon cards */
    #pokemons-container {
        display: flex;
        flex-wrap: wrap; /* Allows the cards to wrap into new rows */
        gap: 20px; /* Space between cards */
        justify-content: center; /* Center the cards */
    }

    .pokemons-card {
        border: 2px solid #ccc; /* Card border */
        border-radius: 10px; /* Rounded corners */
        padding: 15px; /* Padding inside the card */
        text-align: center; /* Center text inside the card */
        background-color: white; /* Light background */
        transition: transform 0.3s; /* Animation on hover */
        width: calc(25% - 20px); /* Width of the card, adjust for 4 columns */
        cursor: pointer; /* Change cursor to pointer for entire card */
    }

    .pokemons-card img {
        width: 50%; /* Responsive image width */
        height: auto; /* Maintain aspect ratio */
        border-radius: 5px; /* Rounded corners for the image */
    }

    .badge {
        padding: 5px 10px; /* Padding inside badges */
        border-radius: 5px; /* Rounded corners for badges */
        margin: 2px; /* Space between badges */
    }

    /* Remove default link styles */
    .text-decoration-none {
        color: inherit; /* Use the inherited text color */
        text-decoration: none; /* Remove underline */
    }

    .text-decoration-none:hover {
        text-decoration: none; /* Ensure no underline on hover */
    }


    .header {
        background-color: #6f42c1; /* Purple background */
        color: white;
        padding: 5px;
        text-align: center;
    }
    
    ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    }

    li {
    float: left;
    }

    .navbar {
        background-color: #5a2d91; /* Darker purple background */
        display: flex;
        justify-content: space-between; /* Distribute space evenly */
        align-items: center;
        max-width: 3000px;
        margin: 0 auto;
        padding: 10px; /* Added padding for better spacing */
    }
    .navbar a {
        color: white;
        text-decoration: none;
        margin: 0 15px; /* Add some space between links */
    }
    .navbar a:hover {
        text-decoration: underline;
    }
    .navbar-text {
        color: white;
    }
   /* Filter Section Styles */
   .filter-section {
        margin: 20px;
        padding: 10px; /* Padding for the filter section */
    }

    .filter-buttons {
        display: flex; /* Use flexbox for rows */
        flex-wrap: wrap; /* Allow wrapping for multiple rows */
        gap: 10px; /* Space between buttons */
    }

    .filter-button {
        flex: 0 0 calc(16.66% - 10px); /* 6 buttons per row with gap */
        padding: 10px; /* Padding for buttons */
        border-radius: 5px; /* Rounded corners */
        border: 1px solid transparent; /* Border for button */
        color: white; /* Text color */
        cursor: pointer; /* Pointer on hover */
        text-align: center; /* Center text */
        box-sizing: border-box; /* Include padding and border in element's total width */
        margin-bottom: 5px; /* Spacing between rows */
    }


    /* CSS classes for type colors */
    .type-Bug { background-color: #ab2; color: white; }
    .type-Dark { background-color: #754; color: white; }
    .type-Dragon { background-color: #76e; color: white; }
    .type-Electric { background-color: #fc3; color: black; }
    .type-Fairy { background-color: #e9e; color: white; }
    .type-Fighting { background-color: #b54; color: white; }
    .type-Fire { background-color: #f42; color: white; }
    .type-Flying { background-color: #89f; color: black; }
    .type-Ghost { background-color: #66b; color: white; }
    .type-Grass { background-color: #7c5; color: white; }
    .type-Ground { background-color: #db5; color: black; }
    .type-Ice { background-color: #6cf; color: black; }
    .type-Normal { background-color: #aa9; color: black; }
    .type-Poison { background-color: #a59; color: white; }
    .type-Psychic { background-color: #f59; color: white; }
    .type-Rock { background-color: #ba6; color: black; }
    .type-Steel { background-color: #aab; color: black; }
    .type-Water { background-color: #39f; color: white; }
</style>


</head>
<body>

<!-- Header Section -->
<div class="header">
    <h1>Poke Book</h1>
</div>

<!-- Custom Navbar -->
<nav class="navbar">
    <div class="navbar-nav">
    <ul>
        <li><a class="nav-link" href="{{ url('/') }}">Index</a></li>
        <li><a class="nav-link" href="{{ url('pokemons') }}">Pokemon</a></li>
        <li><a class="nav-link" href="{{ url('admins/insert') }}">Insert</a></li>
        <li><a class="nav-link" href="{{ url('logout') }}">Logout</a></li>
    </ul>
    </div>
    @auth
        <span class="navbar-text">{{ Session::get('user') }}</span>
    @else
        <span class="navbar-text">{{ Session::get('user') }}</span>
    @endauth
</nav>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<!-- Main Content Section -->
<div class="container mt-4">
<center><h1>Index</h1></center>
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-buttons">
            @php
                $types = ['Bug', 'Dark', 'Dragon', 'Electric', 'Fairy', 'Fighting', 'Fire', 'Flying', 'Ghost', 'Grass', 'Ground', 
                          'Ice', 'Normal', 'Poison', 'Psychic', 'Rock', 'Steel', 'Water'];
            @endphp
            @foreach($types as $type)
                <label class="filter-button type-{{ $type }}">
                    <input type="checkbox" class="filter-checkbox" value="{{ $type }}"> {{ $type }}
                </label>
            @endforeach
        </div>
    </div>
</div>


    <!-- Display Section -->
<!-- Display Section -->
<div class="row" id="pokemons-container">
    @foreach($pokemonss as $pokemons)
    <div class="col-md-3 pokemons-card" data-types="@php
        $types = [];
        if (!empty($pokemons->type1)) $types[] = $pokemons->type1;
        if (!empty($pokemons->type2)) $types[] = $pokemons->type2;
        echo implode(' ', $types);
    @endphp">
        <a href="{{ url('pokemons/'.$pokemons->id) }}" class="text-decoration-none">
            <img src="{{ asset('pokemons/'.$pokemons->id.'.jpg') }}" alt="{{ $pokemons->name }}">
            <h4>{{ $pokemons->name }}</h4>
            <div>
                @php
                    $types = [];
                    if (!empty($pokemons->type1)) $types[] = $pokemons->type1;
                    if (!empty($pokemons->type2)) $types[] = $pokemons->type2;
                @endphp
                @foreach($types as $type)
                    <span class="badge {{ 'type-' . $type }}">{{ $type }}</span>
                @endforeach
                @if (empty($types))
                    <span class="badge bg-secondary">No Types</span>
                @endif
            </div>
        </a>
    </div>
    @endforeach
</div>



    <!-- Filtering Script -->
    <script>
        $(document).ready(function() {
            $('.filter-checkbox').on('change', function() {
                var selectedTypes = [];
                $('.filter-checkbox:checked').each(function() {
                    selectedTypes.push($(this).val());
                });

                $('.pokemons-card').each(function() {
                    var cardTypes = $(this).data('types').split(' ');
                    var show = selectedTypes.length === 0 || selectedTypes.every(type => cardTypes.includes(type));
                    if (show) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

</body>
</html>
