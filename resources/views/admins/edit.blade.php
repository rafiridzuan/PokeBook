<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pokémon</title>
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .container {
            display: flex;
            align-items: flex-start;
            width: 100%;
        }

        .image-upload {
            width: 300px; /* Saiz kotak gambar */
            height: 300px;
            background-color: #f0f0f0;
            border: 2px dashed #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            cursor: pointer;
            position: relative;
            margin-right: 50px; /* Ruang kosong tengah */
        }

        .image-upload input {
            display: none;
        }

        .form-container {
            width: 60%;
            margin-left: auto; /* Letak borang di kanan */
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group select,
        .form-group input[type="range"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 5px;
        }

        .form-group input[type="text"]:focus,
        .form-group select:focus,
        .form-group input[type="range"]:focus {
            border-color: #007bff;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        /* Checkbox Jenis */
    /* Gaya grid untuk jenis Pokémon */
    .type-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 kolum */
        grid-auto-rows: auto; /* Ketinggian baris automatik */
        gap: 1px; /* Jarak antara kotak */
        padding:5px; /* Ruang di sekeliling grid */
    }



        /* Slider */
        .slider {
            width: 100%;
        }

        .slider-label {
            margin-bottom: 5px;
        }

        .slider-value {
            font-weight: bold;
            margin-left: 10px;
        }

        /* Warna jenis Pokémon */
        .type-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 2px;
            color: white;
        }

        .type-Bug { background-color: #ab2; }
        .type-Dark { background-color: #754; }
        .type-Dragon { background-color: #76e; }
        .type-Electric { background-color: #fc3; }
        .type-Fairy { background-color: #e9e; }
        .type-Fighting { background-color: #b54; }
        .type-Fire { background-color: #f42; }
        .type-Flying { background-color: #89f; }
        .type-Ghost { background-color: #66b; }
        .type-Grass { background-color: #7c5; }
        .type-Ground { background-color: #db5; }
        .type-Ice { background-color: #6cf; }
        .type-Normal { background-color: #aa9; }
        .type-Poison { background-color: #a59; }
        .type-Psychic { background-color: #f59; }
        .type-Rock { background-color: #ba6; }
        .type-Steel { background-color: #aab; }
        .type-Water { background-color: #39f; }

        button[type="submit"],
        button[type="reset"] {
            width: 100px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Edit Pokémon</h1>
<form action="{{ url('/admin/update/'.$pokemons->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
    
<div class="container">
            <!-- Image Upload Area (4 col) -->
          <div>
            <div class="image-upload" id="imageUploadContainer"
            ondragover="handleDragOver(event)" 
         ondragleave="handleDragLeave(event)" 
         ondrop="handleDrop(event)">
        <label for="image" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
            @if (file_exists(public_path('pokemons/' . $pokemons->id . '.jpg')))
                <img src="{{ asset('pokemons/' . $pokemons->id . '.jpg') }}" alt="{{ $pokemons->name }}" id="pokemon-image" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <span id="image-placeholder" style="text-align: center;">Click to select a new image</span>
            @endif
            <!-- Input for image upload, hidden but triggered by the label -->
            <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
        </label>
    </div><br>! Klik Gambar pokemon untuk menukar <br>gambar pokemon ya
</div>
<div class="form-container">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif



                <!-- Pokémon Name -->
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $pokemons->name }}" required>
                </div>

                <!-- Pokémon Types -->
                <div class="form-group">
                    <label for="type">Type:</label>
                    <div class="type-grid">
                        @php
                            $types = ['Bug', 'Dark', 'Dragon', 'Electric', 'Fairy', 'Fighting', 'Fire', 'Flying', 'Ghost', 'Grass', 'Ground', 'Ice', 'Normal', 'Poison', 'Psychic', 'Rock', 'Steel', 'Water'];
                        @endphp
                        @foreach($types as $type)
                            <label class="type-checkbox type-badge {{ 'type-' . $type }} w-100">
                                <input type="checkbox" name="types[]" value="{{ $type }}" 
                                    @if(in_array($type, [$pokemons->type1, $pokemons->type2])) checked @endif
                                > {{ $type }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- HP Slider -->
                <div class="form-group">
                    <label for="hp" class="slider-label">HP:</label>
                    <input type="range" id="hp" name="hp" min="1" max="120" value="{{ $pokemons->hp }}" class="slider" oninput="document.getElementById('hp-value').textContent = this.value;">
                    <span id="hp-value" class="slider-value">{{ $pokemons->hp }}</span>
                </div>

                <!-- Attack Slider -->
                <div class="form-group">
                    <label for="attack" class="slider-label">Attack:</label>
                    <input type="range" id="attack" name="attack" min="1" max="120" value="{{ $pokemons->attack }}" class="slider" oninput="document.getElementById('attack-value').textContent = this.value;">
                    <span id="attack-value" class="slider-value">{{ $pokemons->attack }}</span>
                </div>

                <!-- Defense Slider -->
                <div class="form-group ">
                    <label for="defense" class="slider-label">Defense:</label>
                    <input type="range" id="defense" name="defense" min="1" max="120" value="{{ $pokemons->defense }}" class="slider" oninput="document.getElementById('defense-value').textContent = this.value;">
                    <span id="defense-value" class="slider-value">{{ $pokemons->defense }}</span>
                </div>

                <!-- Submit and Reset Buttons -->
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Preview Image Function
    function previewImage(event) {
        const imagePlaceholder = document.getElementById('pokemon-image');
        imagePlaceholder.src = URL.createObjectURL(event.target.files[0]);
        imagePlaceholder.onload = () => URL.revokeObjectURL(imagePlaceholder.src); // Free up memory
    }

    function handleDragOver(event) {
        event.preventDefault(); // Prevent default behavior
        event.currentTarget.style.borderColor = "green"; // Highlight border on dragover
    }

    function handleDragLeave(event) {
        event.preventDefault();
        event.currentTarget.style.borderColor = "#ccc"; // Revert border color when drag leaves
    }

    // Handle drop event
    function handleDrop(event) {
        event.preventDefault();
        event.currentTarget.style.borderColor = "#ccc"; // Revert border color

        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const imageInput = document.getElementById('image');
            imageInput.files = files; // Assign dropped files to the hidden input

            // Preview the dropped image
            previewImage({ target: imageInput });
        }
    }

    // Preview Image Function
    function previewImage(event) {
        const imagePlaceholder = document.getElementById('pokemon-image');
        imagePlaceholder.src = URL.createObjectURL(event.target.files[0]);
        imagePlaceholder.onload = () => URL.revokeObjectURL(imagePlaceholder.src); // Free up memory
    }
</script>

</body>
</html>
