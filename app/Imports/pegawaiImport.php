<?php

namespace App\Imports;

use App\Models\pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class pegawaiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new pegawai([
            'jabatan_id'  => $row[0],
            'nama'  => $row[1],
            'email'   => $row[2],
            'alamat'   => $row[3],
        ]);
    }
}
