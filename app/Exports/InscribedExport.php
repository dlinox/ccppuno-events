<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InscribedExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $incribed = Member::select(DB::raw("
            members.id AS ID, 
            members.degree AS TITULO,
            members.name AS NOMBRE,
            members.paternal_surname AS AP_PATERNO ,
            members.maternal_surname AS AP_MATERNO,
            CAST(members.document AS CHAR) AS DNI,
            CAST(members.phone AS CHAR) AS CELULAR,
            members.modality  AS MODALIDAD,
            members.type AS TIPO,
            members.email AS CORREO,
            payments.amount AS PAGO
        "))
            ->join('payments', 'payments.member_id', 'members.id')
            ->where('members.state', true)
            // ->whereNotNull('members.email_verified_at')
            ->orderBy('members.created_at', 'desc')
            ->get();

        return $incribed;
    }

    public function headings(): array
    {
        return [
            'ID',
            'TITULO',
            'NOMBRE',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'DNI',
            'CELULAR',
            'MODALIDAD',
            'TIPO',
            'CORREO',
            'PAGO',
        ];
    }
}
