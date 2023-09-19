<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Google_Client;
use Google_Service_Sheets;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {

        // Iniciar transacción para asegurar integridad de datos
        DB::beginTransaction();

        try {
            // Crear miembro
            $memberData = $request->only(['document', 'name', 'paternal_surname', 'maternal_surname', 'email', 'phone', 'collegiate_code']);
            $member = Member::create($memberData);

            // Manejar subida de archivo
            if ($request->hasFile('voucher_image_file')) {
                $file = $request->file('voucher_image_file');
                $filename = Str::uuid() . '.' . $file->extension();
                Storage::disk('public')->putFileAs('vouchers', $file, $filename);
                // Storage::putFileAs('vouchers', $file, $filename); // Asumiendo que tienes un disco 'vouchers' configurado en config/filesystems.php
            }

            // Crear pago
            $paymentData = $request->only(['series', 'amount', 'payment_date']);
            $paymentData['status'] = 'PENDIENTE'; // Valor por defecto
            $paymentData['voucher_image_path'] = isset($filename) ? 'vouchers/' . $filename : null;

            $payment = new Payment($paymentData);

            // Asociar el pago al miembro
            $member->payments()->save($payment);

            // Finalizar transacción
            DB::commit();

            return redirect()->back()->with('success', 'Miembro y pago guardados exitosamente!');
        } catch (\Exception $e) {
            // Si algo sale mal, revertir la transacción
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function sheets()
    {

        $client = new Google_Client();
        $client->setApplicationName('Google Sheets and Laravel');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(storage_path('app/google-sheets.json')); // Asegúrate de apuntar al archivo JSON


        $sheets = new Google_Service_Sheets($client);

        $spreadsheetId = '19UcWzZ6qkcZlk6wg_wWYWLxpe1YgJf_uzOfoTZe5U8k';
        $range = 'Respuestas de formulario 1!A1:K10';  // Por ejemplo, de la hoja 'Sheet1', celdas de A1 hasta D10.


        // dd(file_get_contents(storage_path('app/google-sheets.json')));

        $response = $sheets->spreadsheets_values->get($spreadsheetId, $range);
        $dataFromSheet = $response->getValues();



        $headers = array_shift($dataFromSheet); // Extraemos la primera fila para usarla como encabezados

        // Convertimos el resto de la matriz bidimensional en una matriz de diccionarios usando los encabezados
        $convertedData = array_map(function ($row) use ($headers) {
            $row = array_pad($row, count($headers), null);
            return array_combine($headers, $row);
        }, $dataFromSheet);

        // Convierte a JSON si lo necesitas
        $jsonData = json_encode($convertedData);

        echo $jsonData;
    }
}
