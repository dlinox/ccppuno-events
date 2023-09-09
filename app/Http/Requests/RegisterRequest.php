<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document'          => 'required|size:8|unique:members,document',
            'name'              => 'required|string|max:80',
            'paternal_surname'  => 'required|string|max:60',
            'maternal_surname'  => 'required|string|max:60',
            'email'             => 'required|email|max:100|unique:members,email',
            'phone'             => 'required|string|size:9',
            'collegiate_code'   => 'nullable|string|size:6',

            'series'            => 'required|string',
            'amount'            => 'required|numeric|between:0,999999.99',
            'payment_date'      => 'required|date',
            'voucher_image_file'=> 'required|file|mimes:jpeg,png,jpg,gif,svg|max:4096'  // Aceptar solo imágenes y limitar el tamaño a 4MB.
        ];
    }

    public function messages()
    {
        return [
            'document.required'              => 'El DNI es requerido.',
            'document.size'                  => 'El DNI debe tener exactamente 8 caracteres.',
            'document.unique'                => 'El DNI ya ha sido registrado.',
            'name.required'             => 'El nombre es obligatorio.',
            'paternal_surname.required' => 'El apellido paterno es obligatorio.',
            'maternal_surname.required' => 'El apellido materno es obligatorio.',
            'email.required'            => 'El correo electrónico es obligatorio.',
            'email.email'               => 'Ingrese un formato de correo electrónico válido.',
            'email.unique'              => 'El correo electrónico ya ha sido registrado.',
            'phone.required'            => 'El número de teléfono es obligatorio.',
            'phone.size'                => 'El número de teléfono debe tener exactamente 9 dígitos.',
            'collegiate_code.size'      => 'El código colegiado debe tener exactamente 6 caracteres.',

            'series.required'           => 'La serie es obligatoria.',
            'amount.required'           => 'El monto es obligatorio.',
            'amount.numeric'            => 'El monto debe ser un número.',
            'payment_date.required'     => 'La fecha de pago es obligatoria.',
            'payment_date.date'         => 'Ingrese una fecha válida.',
            'voucher_image_file.required'=> 'El comprobante es obligatorio.',
            'voucher_image_file.file'   => 'El comprobante debe ser un archivo.',
            'voucher_image_file.mimes'  => 'El comprobante debe ser una imagen en formato jpeg, png, jpg, gif o svg.',
            'voucher_image_file.max'    => 'El tamaño del comprobante no debe superar los 4MB.'
        ];
    }
}
