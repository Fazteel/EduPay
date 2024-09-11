<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'name' => $row['name'], 
            'nis' => $row['nis'], 
            'class' => $row['class'], 
            'outstanding_balance' => $row['outstanding_balance']
        ]);
    }
}
