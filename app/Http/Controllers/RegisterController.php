<?php
 
namespace App\Http\Controllers;
 
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller{

  
    public function registerStudent(Request $request){
        
        //dobi podatke o študentu
        //preveri pravilno strukturo emaila preveri podvajanje up imena in email naslova in šibkost gesla
        //vrni errorje če je kaj narobe drugače dodaj userja z šifriranim geslom
        //če ne dodaj v tabelo ter pošlji email z potrditvenim url jem v bazo dodaj potditev
        //naredi endpoint za potrditve

       
       
    }

    public function registerUser(Request $request){
        
        //dobi podatke o študentu
        //preveri pravilno strukturo emaila preveri podvajanje up imena in email naslova in šibkost gesla
        //vrni errorje če je kaj narobe drugače dodaj userja z šifriranim geslom
        //če ne dodaj v tabelo ter pošlji email z potrditvenim url jem v bazo dodaj potditev
        //naredi endpoint za potrditve
        return response()->json('Dobrodošel uporabnik.');
       
       
    }
    

   
}
?>
