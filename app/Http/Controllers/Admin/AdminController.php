<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InscribedExport;
use App\Http\Controllers\Controller;
use App\Mail\AprovePreRegistrationMail;
use App\Mail\WelcomeMail;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

use PDF;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{

    protected $member;
    public function __construct()
    {
        $this->member = new Member();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Member::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('document', 'like', '%' . $searchTerm . '%');
        }

        $query->where('state', false);
        // $query->whereNotNull('email_verified_at');
        $query->orderBy('created_at', 'desc');
        $query->with('payments');

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Admin/index', [
            'items' => $items,
            'headers' => $this->member->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
        ]);
    }

    public function inscribed(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Member::query();


        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('document', 'like', '%' . $searchTerm . '%');
        }

        $query->where('state', true);
        // $query->whereNotNull('email_verified_at');
        // Obtener resultados paginados
        $query->orderBy('created_at', 'desc');
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('Admin/inscribed', [
            'items' => $items,
            'headers' => $this->member->headers,
            'filters' => [
                'tipo_estado' => $request->tipo_estado,
                'search' => $request->search,
            ],
            'perPageOptions' => [10, 25, 50, 100], // Opciones de cantidad de elementos por página
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

    public function validatePayment(Request $request)
    {
        DB::beginTransaction();
        try {

            $payment = Payment::find($request->payment['id']);
            $payment->status = $request->value;

            if ($request->value === 'ACEPTADO') {
                $member = Member::find($request->payment['member_id']);
                $member->state = true;
                $member->save();
            }

            if ($payment->save()) {
                DB::commit();
                return back()->with('Todo bien');
            } else {
                DB::rollBack();
                return redirect()->back()->withInput()->withErrors(['message' => 'Error']);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['message' => $th->getMessage()]);
        }
    }

    public function sendEmail(Request $request)
    {

        //$emailHash = Crypt::encryptString($request->email);

        //$password = Str::random(8);

        $member =  Member::where('email', $request->email)->first();

        $member->password =  $member->document;
        // $member->status =  true;

        $member->save();

        $dataEmail = [
            'name' => $request->name . ' ' . $request->paternal_surname . ' ' . $request->maternal_surname,
            'url' => url("/login"),
            // 'url' => url("/create-password/$emailHash"),
            'password' => $member->document
        ];

        //Mail::to($request->email)->send(new WelcomeMail($dataEmail));
    }

    public function validatePreRegistration(Request $request): JsonResponse
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

            Mail::to($member['email'])->send(new AprovePreRegistrationMail($data));
        }
        $this->updateCell($request->sheet);
        return response()->json([
            'status' => true,
            'message' => 'Persona registrada',
            'data' => $member,
        ]);
    }

    public function exportInscribed()
    {

        $fecha = date('Y-m-d');
        $nameFile = 'member_inscribed_' . $fecha . '.xlsx';
        return Excel::download(new InscribedExport, $nameFile);
    }


    public function encryptTerm($term)
    {

        $termEncrypt = Crypt::encryptString($term);
        $url = url("/certificate");
        return response()->json("$url/$termEncrypt");
    }




    public function generateCertificate($key)
    {

        $_document = Crypt::decryptString($key);

        $member = Member::select('name', 'paternal_surname', 'maternal_surname')->where('document', $_document)->first();

        $content = url("/certificate") . "/$key";

        // Genera el código QR con el contenido especificado
        $qrCode = QrCode::size(120)->generate($content);

        $bg = public_path('certicates/bg-certificate.png');
        $f1 = public_path('certicates/F1.png');
        $f2 = public_path('certicates/decano.png');
        $f3 = public_path('certicates/rector.png');

        $pdf = PDF::loadView('pdf.certificate', [
            'name' => $member->name . ' ' .  $member->paternal_surname . ' ' . $member->maternal_surname,
            'course' => 'Laravel Basics',
            'bg' => $bg,
            'f1' => $f1,
            'f2' => $f2,
            'f3' => $f3,
            'qrCode' => $qrCode
        ]);

        // Configura Dompdf para que no tenga márgenes
        $pdf->setPaper('A4', 'landscape'); // Establece el tamaño de página a A4 horizontal
        $pdf->setOption('padding-top', 0);
        $pdf->setOption('padding-right', 0);
        $pdf->setOption('padding-bottom', 0);
        $pdf->setOption('padding-left', 0);

        return $pdf->stream('pdf.certificate.pdf');
    }

    // protected function updateCell($request)
    // {

    //     $spreadsheetId = "19UcWzZ6qkcZlk6wg_wWYWLxpe1YgJf_uzOfoTZe5U8k";
    //     $cell = $request['indexRow'];
    //     $value = $request['valueCell'];

    //     $client = new Google_Client();

    //     $client->setAuthConfig(storage_path('app/google-sheets.json'));  // Ajusta la ruta a tu archivo JSON de credenciales.
    //     $client->addScope(Google_Service_Sheets::SPREADSHEETS);

    //     $sheets = new Google_Service_Sheets($client);

    //     // Prepara el rango y los valores para la actualización
    //     $range = "Respuestas de formulario 1!K$cell";  // Ejemplo: 'Sheet1!A2'
    //     $body = new Google_Service_Sheets_ValueRange([
    //         'values' => [[$value]]  // El valor que deseas establecer
    //     ]);

    //     $params = [
    //         'valueInputOption' => 'RAW'
    //     ];

    //     // Actualiza la celda
    //     $sheets->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

    //     return response()->json('exito');
    // }

    // protected function googleSheet()
    // {

    //     //$client = new Google_Client();

    //     $client = new Google_Client();

    //     $client->setApplicationName('Sheet - Pre-inscripcion');
    //     $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    //     $client->setAccessType('offline');
    //     $client->setAuthConfig(storage_path('app/google-sheets.json')); // Asegúrate de apuntar al archivo JSON

    //     $sheets = new Google_Service_Sheets($client);

    //     $spreadsheetId = '19UcWzZ6qkcZlk6wg_wWYWLxpe1YgJf_uzOfoTZe5U8k';
    //     $range = 'Respuestas de formulario 1!A1:K100';

    //     $response = $sheets->spreadsheets_values->get($spreadsheetId, $range);
    //     $dataFromSheet = $response->getValues();

    //     $headers = array_shift($dataFromSheet); // Extraemos la primera fila para usarla como encabezados

    //     // Convertimos el resto de la matriz bidimensional en una matriz de diccionarios usando los encabezados
    //     $convertedData = array_map(function ($row) use ($headers) {
    //         $row = array_pad($row, count($headers), null);
    //         return array_combine($headers, $row);
    //     }, $dataFromSheet);

    //     // Convierte a JSON si lo necesitas
    //     return [
    //         'data' => $convertedData,
    //         'headers' => $headers,
    //     ];
    // }
}
