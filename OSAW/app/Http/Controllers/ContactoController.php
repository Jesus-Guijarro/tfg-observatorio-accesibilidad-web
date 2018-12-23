<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;


class ContactoController extends Controller
{

    //Función para realizar un contacto al observatorio
    public function realizarContacto(Request $request){

        //Validaciones
        $this->validate($request, [
            'email' => 'required|string|email|min:2|max:30',
            'asunto' => 'required|string|min:2|max:50',
            'mensaje'=> 'required|string|max:1000',
        ]);

        //Envío del mensaje 
        Mail::send('emails.mensaje', [
            'email' => $request->email,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje
        ], function($mail) use ($request) {
            $mail->from($request->email);
            $mail->to('OSAW.TFG@gmail.com')->subject('Contacto OSAW - Asunto: ' . $request->asunto);
        
        });

        return back()->with('mensaje','Contacto realizado con éxito');
    }
}
