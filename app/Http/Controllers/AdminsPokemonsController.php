<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminsPokemonsController extends Controller
{
    public function index()
    {
        // Retrieve all Pokémon from the 'pokemons' table
        $pokemonss = DB::table('pokemons')->select('id', 'name', 'type1', 'type2')->get();

        // Return view with Pokémon data
        return view('admins.index', ['pokemonss' => $pokemonss]);
    }

    public function insert() {
        return view('admins.insert'); // Ensure you have a Blade file named 'insert.blade.php' in the 'admin' folder
    }
    

    public function create()
    {
        return view('admins.insert'); // Display the insert form
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'types' => 'required|array|max:2', // Ensure only 2 types are selected
            'types.*' => 'string', // Ensure each type is a string
            'hp' => 'required|integer|min:1|max:120',
            'attack' => 'required|integer|min:1|max:120',
            'defense' => 'required|integer|min:1|max:120',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);
    
        // Cari ID yang kosong
        $missingId = DB::table('pokemons')
            ->select(DB::raw('id + 1 as next_id'))
            ->whereRaw('NOT EXISTS (SELECT 1 FROM pokemons p2 WHERE p2.id = pokemons.id + 1)')
            ->orderBy('id')
            ->limit(1)
            ->pluck('next_id')
            ->first();
    
        // Jika ada ID kosong, gunakan missingId, jika tidak guna ID seterusnya
        $pokemonId = $missingId ?? (DB::table('pokemons')->max('id') + 1);
    
        // Insert Pokémon data with the chosen ID
        DB::table('pokemons')->insert([
            'id' => $pokemonId,
            'name' => $validatedData['name'],
            'type1' => $validatedData['types'][0],
            'type2' => $validatedData['types'][1] ?? '', // If only 1 type selected, make type2 empty string
            'hp' => $validatedData['hp'],
            'attack' => $validatedData['attack'],
            'defense' => $validatedData['defense'],
        ]);
    
        // Handle image upload and rename the image to match the Pokémon ID
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // Get the file extension
            $imageName = $pokemonId . '.' . $extension; // Rename the image using the Pokémon ID
            $image->move(public_path('pokemons'), $imageName); // Save the image to public/pokemons
        }
    
        // Redirect back with a success message
        return redirect('/admin/index')->with('success', 'Pokémon added successfully!');
    }
    
    
    

    public function edit($id)
    {
        // Ambil data Pokémon berdasarkan ID
        $pokemons = DB::table('pokemons')->where('id', $id)->first();
        
        // Hantar data ke view
        return view('admins.edit', ['pokemons' => $pokemons]);
    }
    

    public function update(Request $request, $id)
{
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'types' => 'required|array|max:2', // Max 2 types
        'types.*' => 'string',
        'hp' => 'required|integer|min:1|max:120',
        'attack' => 'required|integer|min:1|max:120',
        'defense' => 'required|integer|min:1|max:120',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image upload
    ]);

    // Update the Pokémon record in the database
    DB::table('pokemons')->where('id', $id)->update([
        'name' => $validatedData['name'],
        'type1' => $validatedData['types'][0],
        'type2' => isset($validatedData['types'][1]) ? $validatedData['types'][1] : '', // Set to empty string if type2 is not selected
        'hp' => $validatedData['hp'],
        'attack' => $validatedData['attack'],
        'defense' => $validatedData['defense']
    ]);

    // Handle image upload if present
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $id . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('pokemons'), $imageName); // Save the image to the correct folder
    }

    // Redirect back to the index page with a success message
    return redirect('/admin/index')->with('success', 'Pokémon updated successfully!');
}

    

    public function destroy($id)
    {
        // Delete Pokémon from the 'pokemons' table
        DB::table('pokemons')->where('id', $id)->delete();
        
        // Check if it's an AJAX request
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
    
        return redirect()->route('admins.index'); // Redirect to admins index
    }
    
}