<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AprovePreRegistrationMail;
use App\Models\Member;
use App\Models\Payment;
use Google\Service\DriveActivity\Create;
use Illuminate\Http\Request;
use Inertia\Inertia;


use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/index', [
            'sheets' => $this->googleSheet(),
        ]);
    }

    public function memberAprovet(): JsonResponse
    {
        $members =  Member::where('state', true)->with('payments')->get();
        return response()->json([
            'status' =>  true,
            'message' =>  'Exito',
            'data' => $members,
        ]);
    }

    public function validatePayment(Request $request): JsonResponse{

        $payment = Payment::find($request->pay['id']);
        $payment->status = $request->validate;
        
        if($payment->save()){
            return response()->json([
                'status' =>  true,
                'message' =>  'Exito',
                'data' => $payment,
            ]);
        }

        
        return response()->json([
            'status' =>  false,
            'message' =>  'Error',
            'data' => null,
        ]);

    }

    function validatePreRegistration(Request $request): JsonResponse
    {
        $existMember = Member::where('document', $request->member['document'])->first();

        if ($existMember) {
            return response()->json([
                'status' => false,
                'message' => 'Persona ya esta registrada',
                'data' => null,
            ]);
        }

        $member = Member::create($request->member);

        if ($member->state) {

            $data = [
                'document' => Crypt::encryptString($member['document']),
                'email' => Crypt::encryptString($member['email'])
            ];

            Mail::to('nearlino20@gmail.com')->send(new AprovePreRegistrationMail($data));
        }
        $this->updateCell($request->sheet);
        return response()->json([
            'status' => true,
            'message' => 'Persona registrada',
            'data' => $member,
        ]);
    }

    protected function updateCell($request)
    {

        $spreadsheetId = "19UcWzZ6qkcZlk6wg_wWYWLxpe1YgJf_uzOfoTZe5U8k";
        $cell = $request['indexRow'];
        $value = $request['valueCell'];

        $client = new Google_Client();

        $client->setAuthConfig(storage_path('app/google-sheets.json'));  // Ajusta la ruta a tu archivo JSON de credenciales.
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);

        $sheets = new Google_Service_Sheets($client);

        // Prepara el rango y los valores para la actualización
        $range = "Respuestas de formulario 1!K$cell";  // Ejemplo: 'Sheet1!A2'
        $body = new Google_Service_Sheets_ValueRange([
            'values' => [[$value]]  // El valor que deseas establecer
        ]);

        $params = [
            'valueInputOption' => 'RAW'
        ];

        // Actualiza la celda
        $sheets->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

        return response()->json('exito');
    }

    protected function googleSheet()
    {

        //$client = new Google_Client();

        $client = new Google_Client();

        $client->setApplicationName('Sheet - Pre-inscripcion');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(storage_path('app/google-sheets.json')); // Asegúrate de apuntar al archivo JSON

        $sheets = new Google_Service_Sheets($client);

        $spreadsheetId = '19UcWzZ6qkcZlk6wg_wWYWLxpe1YgJf_uzOfoTZe5U8k';
        $range = 'Respuestas de formulario 1!A1:K100';

        $response = $sheets->spreadsheets_values->get($spreadsheetId, $range);
        $dataFromSheet = $response->getValues();

        $headers = array_shift($dataFromSheet); // Extraemos la primera fila para usarla como encabezados

        // Convertimos el resto de la matriz bidimensional en una matriz de diccionarios usando los encabezados
        $convertedData = array_map(function ($row) use ($headers) {
            $row = array_pad($row, count($headers), null);
            return array_combine($headers, $row);
        }, $dataFromSheet);

        // Convierte a JSON si lo necesitas
        return [
            'data' => $convertedData,
            'headers' => $headers,
        ];
    }
}
