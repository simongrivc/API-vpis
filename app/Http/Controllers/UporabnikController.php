<?php
 
namespace App\Http\Controllers;
 
use App\Uporabnik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class UporabnikController extends Controller{

    public function ustvariUporabnika(Request $request){
 
        $uporabnik = Uporabnik::create($request->all());
 
        return response()->json($uporabnik);
 
    }
 
    public function urediUporabnika(Request $request, $id){

        $uporabnik = Uporabnik::find($id);
        $uporabnik->ImeUporabnika = $request->input('ImeUporabnika');
        $uporabnik->save();
 
        return response()->json($uporabnik);
    }  

    public function izbrisiUporabnika($id){
        $uporabnik = Uporabnik::find($id);
        $Uporabnik->delete();
 
        return response()->json('Uporabnik odstranjen uspešno.');
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function login(Request $request){
=======
    public function index(){
>>>>>>> parent of ae8090e... login
=======
    public function login(){
>>>>>>> parent of 2352fdb... jwt konfiguracija
 
        //$uporabniki = Uporabnik::all();
        $uporabnik = Auth::user();
        return response()->json($uporabnik);
 
    }
}
?>
