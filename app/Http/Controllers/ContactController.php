<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function show_contact()
    {
        $contact = Contacto::all();
        foreach ($contact as $contacts) {
            $actual = Carbon::now();
            $age = explode(" ", $actual->diffForHumans($contacts->birthday, $actual->toDateString()));
            $contacts->age = $age[0];
        }
        return response()->json(['status'=>true,'data'=>$contact]);
    }
    public function create_contact(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'lastname'=>'required',
            'direction'=>'required',
            'birthday'=>'required'
        ]);
        $contact = new Contacto();
        $contact->id = $request->id;
        $contact->name = $request->name;
        $contact->lastname = $request->lastname;
        $contact->direction = $request->direction;
        $contact->birthday = $request->birthday;
        $contact->save();
    }
    public function update_contac(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'lastname'=>'required',
            'direction'=>'required'
        ]);
        $contact = Contacto::where("id", "=", $request->id)->get()->first();
        if (isset($contact->id)) {
            $contact->name = $request->name;
            $contact->lastname = $request->lastname;
            $contact->direction = $request->direction;
            $contact->save();
        } else {
            response()->json([
                "status"=>0,
                "msj"=>"usuario no existe"
            ]);
        }
    }

    public function delete_contact(Request $request)
    {
       $exist = DB::table('contactos')->where('id', $request->id)->first();
       if(!$exist){
           return response()->json([
               'msg'=>"the User Not existed"
           ],404);
       }
       
       Contacto::destroy($request->id);
       return response()->json([
           'msg'=> 'Contact delete',
       ]);
    }
}