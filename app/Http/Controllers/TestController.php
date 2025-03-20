<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller{

    public function __invoke(Request $request, int $id){
        $format = $request->input("format");
        return response("Toto je kniha cislo = $id");
    }

    public function testAction(){
        return "Funguje to?";
    }

    public function viewForm() {
        return view('form');
    }

    public function submitForm(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $age = $request->input('age');

        if ($age < 18) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => "Nemôžete sa pripojiť, ak máte menej ako 18 rokov.",
            ]);
        } else {
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => "$name, s emailom $email bol úspešne pridaný.",
            ]);
        }
    }
}
