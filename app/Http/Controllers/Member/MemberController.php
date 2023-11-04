<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use PDF;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class MemberController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Member/index', ['user' => $user]);
    }

    public function generateKeyCertificate(Request $request)
    {
        $document = $request->document;
        $event =   $request->event;
        $type =   $request->type;

        $key = $document . '-' . $event . '-' . $type;
        $keyEncrypt = Crypt::encryptString($key);

        if (intval($type) === 1) {
            $url = url("/m/certificate");
        } else {
            $url = url("/m/certificate/course");
        }


        return response()->json("$url/$keyEncrypt");
        // return $keyEncrypt;
    }

    public function generateCertificatePdf($key)
    {

        //!IMPORTANTE
        //TODO: TEMPORAL - IMPLEMENTAR LOGICA PARA MULTIPLES EVENTOS  
        $_key = Crypt::decryptString($key);

        $keyDecrypt = explode('-', $_key);

        $member = Member::select('degree', 'name', 'paternal_surname', 'maternal_surname')->where('document', $keyDecrypt[0])->first();

        $content = url("/m/certificate") . "/$key";

        // Genera el código QR con el contenido especificado
        $qrCode = QrCode::size(120)->generate($content);

        $bg = public_path('certicates/bg-certificate.png');
        $f1 = public_path('certicates/F1.png');
        $f2 = public_path('certicates/decano.png');
        $f3 = public_path('certicates/rector.png');

        $pdf = PDF::loadView('pdf.certificate', [
            'name' => $member->degree . ' ' .   $member->name . ' ' .  $member->paternal_surname . ' ' . $member->maternal_surname,
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


    public function generateCertificateCoursePdf($key)
    {

        //!IMPORTANTE
        //TODO: TEMPORAL - IMPLEMENTAR LOGICA PARA MULTIPLES EVENTOS  
        $_key = Crypt::decryptString($key);

        $keyDecrypt = explode('-', $_key);

        $member = Member::select('degree', 'name', 'paternal_surname', 'maternal_surname')->where('document', $keyDecrypt[0])->first();

        $content = url("/m/certificate/course") . "/$key";

        // Genera el código QR con el contenido especificado
        $qrCode = QrCode::size(120)->generate($content);

        $bg = public_path('certicates/course/bg-certificate.png');
        $f1 = public_path('certicates/F1.png');
        $f2 = public_path('certicates/decano.png');

        $pdf = PDF::loadView('pdf.certificate_etica', [
            'name' => $member->degree . ' ' .   $member->name . ' ' .  $member->paternal_surname . ' ' . $member->maternal_surname,
            'bg' => $bg,
            'f1' => $f1,
            'f2' => $f2,
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
}
