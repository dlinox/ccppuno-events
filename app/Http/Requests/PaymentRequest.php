<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'collegiate_code'   => 'nullable|string|size:6',

            'series'            => 'required|string',
            'amount'            => 'required|numeric|between:0,999999.99',
            'payment_date'      => 'required|date',
            'voucher_image_file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:4096'  // Aceptar solo imágenes y limitar el tamaño a 4MB.
        ];
    }

    public function messages()
    {
        return [

            'collegiate_code.size'      => 'El código colegiado debe tener exactamente 6 caracteres.',

            'series.required'           => 'La serie es obligatoria.',
            'amount.required'           => 'El monto es obligatorio.',
            'amount.numeric'            => 'El monto debe ser un número.',
            'payment_date.required'     => 'La fecha de pago es obligatoria.',
            'payment_date.date'         => 'Ingrese una fecha válida.',
            'voucher_image_file.required' => 'El comprobante es obligatorio.',
            'voucher_image_file.file'   => 'El comprobante debe ser un archivo.',
            'voucher_image_file.mimes'  => 'El comprobante debe ser una imagen en formato jpeg, png, jpg, gif o svg.',
            'voucher_image_file.max'    => 'El tamaño del comprobante no debe superar los 4MB.'
        ];
    }
}
