<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PokemonsController extends Controller
{
    public function index()
    {
        // Retrieve all Pokémon from the 'pokemons' table
        $pokemonss = DB::table('pokemons')->select('id', 'name', 'type1', 'type2')->get();

        // Return view with Pokémon data
        return view('index', ['pokemonss' => $pokemonss]);
    }


    
    public function show($id)
    {
        // Cari rekod Pokémon berdasarkan ID yang diminta
        $pokemons = DB::table('pokemons')->where('id', $id)->first();
    
        // Jika rekod tidak wujud, cari rekod sebelumnya atau seterusnya yang wujud
        if (!$pokemons) {
            // Cuba dapatkan rekod sebelumnya yang wujud
            $pokemons = DB::table('pokemons')->where('id', '<', $id)->orderBy('id', 'desc')->first();
    
            // Jika tiada rekod sebelum, dapatkan rekod seterusnya yang wujud
            if (!$pokemons) {
                $pokemons = DB::table('pokemons')->where('id', '>', $id)->orderBy('id', 'asc')->first();
            }
    
            // Jika tiada rekod sama sekali, kembali ke index atau tunjukkan pesan
            if (!$pokemons) {
                return redirect()->route('index')->with('error', 'No Pokémon records found.');
            }
        }
    
        // Cari rekod sebelumnya yang wujud
        $previousPokemon = DB::table('pokemons')->where('id', '<', $pokemons->id)->orderBy('id', 'desc')->first();
    
        // Cari rekod seterusnya yang wujud
        $nextPokemon = DB::table('pokemons')->where('id', '>', $pokemons->id)->orderBy('id', 'asc')->first();
    
        // Ambil bilangan rekod yang wujud (tidak termasuk yang telah dipadam)
        $totalRecords = DB::table('pokemons')->count();
    
        // Kira currentPage sebagai kedudukan semasa dalam rekod yang wujud
        $currentPosition = DB::table('pokemons')
            ->where('id', '<=', $pokemons->id)
            ->count();
    
        // Ambil jenis Pokémon dalam array
        $types = [];
        if (!empty($pokemons->type1)) $types[] = $pokemons->type1;
        if (!empty($pokemons->type2)) $types[] = $pokemons->type2;
    
        // Dapatkan ID maksimum (rekod terakhir)
        $maxPageId = DB::table('pokemons')->max('id');
    
        // Tentukan view sama ada untuk admin atau guest
        return view('pokemons.show', [
            'pokemons' => $pokemons,
            'currentPage' => $currentPosition, // Guna kedudukan semasa
            'totalRecords' => $totalRecords,   // Guna jumlah rekod yang wujud
            'types' => $types,
            'maxPageId' => $maxPageId,
            'previousPokemon' => $previousPokemon,
            'nextPokemon' => $nextPokemon
        ]);
    }
    

    

    public function edit($id)
    {
        // Pastikan pengguna adalah admins
        if (Session::get('user') !== 'admins1') {
            return redirect('login');
        }

        $pokemons = DB::table('pokemons')->where('id', $id)->first();
        return view('admins.edit', ['pokemons' => $pokemons]);
    }

    public function update(Request $request, $id)
    {
        // Pastikan pengguna adalah admins
        if (Session::get('user') !== 'admins1') {
            return redirect('login');
        }

        $data = $request->all();
        DB::table('pokemons')->where('id', $id)->update([
            'name' => $data['name'],
            'type1' => $data['type1'],
            'type2' => $data['type2'],
            'hp' => $data['hp'],
            'attack' => $data['attack'],
            'defend' => $data['defend']
        ]);
        return redirect()->route('pokemons.show', ['id' => $id]);
    }

    public function destroy($id)
    {
        // Pastikan pengguna adalah admins
        if (Session::get('user') !== 'admins1') {
            return redirect('login');
        }
    
        // Padamkan rekod Pokémon
        DB::table('pokemons')->where('id', $id)->delete();
    
        // Redirect ke rekod sebelumnya jika wujud, atau ke halaman index
        $previousPokemon = DB::table('pokemons')->where('id', '<', $id)->orderBy('id', 'desc')->first();
        if ($previousPokemon) {
            return redirect()->route('pokemons.show', ['id' => $previousPokemon->id]);
        } else {
            return redirect()->route('index'); // Jika tiada rekod sebelumnya, pergi ke halaman index
        }
    }
}    