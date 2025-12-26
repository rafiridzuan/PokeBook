<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Pokémon</title>
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

        .image-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none; /* Hide image initially */
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
<h1>Insert Pokémon</h1>
<form action="{{ url('/admin/insert') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container">
    <!-- Bahagian Muat Naik Gambar -->
    <div class="image-upload" id="imageUploadContainer" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
        <label for="image" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
            <img id="pokemon-image" alt="Pokémon Image" />
            <span id="image-placeholder">Click or drop to select an image</span>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
        </label>
    </div>
    <!-- Bahagian Borang di Sebelah Kanan -->
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


            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
    <label for="type">Type:</label>
    <div class="type-grid">
        @php
            $types = ['Bug', 'Dark', 'Dragon', 'Electric', 'Fairy', 'Fighting', 'Fire', 'Flying', 'Ghost', 'Grass', 'Ground', 'Ice', 'Normal', 'Poison', 'Psychic', 'Rock', 'Steel', 'Water'];
        @endphp
        @foreach($types as $type)
        <label class="type-checkbox type-badge {{ 'type-' . $type }}">
            <input type="checkbox" name="types[]" value="{{ $type }}"> {{ $type }}
        </label>
        @endforeach
    </div>
</div>

            <!-- Slider HP -->
            <div class="form-group">
                <label for="hp" class="slider-label">HP:</label>
                <input type="range" id="hp" name="hp" min="1" max="120" value="1" class="slider" oninput="document.getElementById('hp-value').textContent = this.value;">
                <span id="hp-value" class="slider-value">1</span>
            </div>

            <!-- Slider Attack -->
            <div class="form-group">
                <label for="attack" class="slider-label">Attack:</label>
                <input type="range" id="attack" name="attack" min="1" max="120" value="1" class="slider" oninput="document.getElementById('attack-value').textContent = this.value;">
                <span id="attack-value" class="slider-value">1</span>
            </div>

            <!-- Slider Defense -->
            <div class="form-group">
                <label for="defense" class="slider-label">Defense:</label>
                <input type="range" id="defense" name="defense" min="1" max="120" value="1" class="slider" oninput="document.getElementById('defense-value').textContent = this.value;">
                <span id="defense-value" class="slider-value">1</span>
            </div>

            <!-- Butang Submit dan Reset -->
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Limit checkbox selection to 2 types
    document.querySelectorAll('.filter-button input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var checkedTypes = document.querySelectorAll('.filter-button input:checked');
            if (checkedTypes.length > 2) {
                alert('You can only select up to 2 types.');
                this.checked = false;
            }
        });
    });

    // Handle drag over and leave events
    function handleDragOver(event) {
        event.preventDefault();
        event.currentTarget.style.borderColor = "green";
    }

    function handleDragLeave(event) {
        event.preventDefault();
        event.currentTarget.style.borderColor = "#ccc";
    }

    // Handle drop event
    function handleDrop(event) {
        event.preventDefault();
        event.currentTarget.style.borderColor = "#ccc";

        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const imageInput = document.getElementById('image');
            imageInput.files = files;

            previewImage({ target: imageInput });
        }
    }

    // Preview Image Function
    function previewImage(event) {
        const imagePlaceholder = document.getElementById('pokemon-image');
        const imagePlaceholderText = document.getElementById('image-placeholder');

        if (event.target.files.length > 0) {
            imagePlaceholder.src = URL.createObjectURL(event.target.files[0]);
            imagePlaceholder.style.display = 'block';
            imagePlaceholderText.style.display = 'none';

            imagePlaceholder.onload = () => URL.revokeObjectURL(imagePlaceholder.src);
        }
    }
</script>

</body>
</html>
