<?php
namespace App\Http\Controllers; use App\Models\Movie; use Illuminate\Http\Request; use Illuminate\Support\Facades\Storage;
class MovieController extends Controller {
 public function index(){ $movies=Movie::latest()->paginate(10); return view('admin.movies.index',compact('movies')); }
 public function create(){return view('admin.movies.form',['movie'=>new Movie]);}
 public function store(Request $r){$d=$r->validate(['title'=>'required|string|max:255','genre'=>'required|string|max:100','duration'=>'required|integer|min:1','synopsis'=>'required|string','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']); if($r->hasFile('image'))$d['image']=$r->file('image')->store('posters','public'); Movie::create($d);return redirect()->route('movies.index')->with('success','Film ditambahkan.');}
 public function show(Movie $movie){return redirect()->route('movies.index');}
 public function edit(Movie $movie){return view('admin.movies.form',compact('movie'));}
 public function update(Request $r,Movie $movie){$d=$r->validate(['title'=>'required|string|max:255','genre'=>'required|string|max:100','duration'=>'required|integer|min:1','synopsis'=>'required|string','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);if($r->hasFile('image')){if($movie->image)Storage::disk('public')->delete($movie->image);$d['image']=$r->file('image')->store('posters','public');}$movie->update($d);return redirect()->route('movies.index')->with('success','Film diperbarui.');}
 public function destroy(Movie $movie){$movie->delete();return redirect()->route('movies.index')->with('success','Film dihapus.');}
}
