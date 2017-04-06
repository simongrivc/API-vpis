<?php
 
namespace App\Http\Controllers;
 
use App\Uporabnik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
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

    public function index(){
 
        $uporabniki = Uporabnik::all();
 
        return response()->json($uporabniki);
 
    }
}
?>
