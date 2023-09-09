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
}
