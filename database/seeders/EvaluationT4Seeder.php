<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Http\Helpers\EvaluationProcessor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// class EvaluationT4Seeder extends Seeder
// {

//     public function run(): void
//     {
//         $targetStage = 't4';
//         $evaluationList = [
//             'Eka Suryana' => [
//                 'alternatif' => 'A1',
//                 'C1' => 1,
//                 'C2' => 2,
//                 'C3' => 2,
//                 'C4' => 1,
//                 'C5' => 2,
//                 'C6' => 1,
//                 'C7' => 2,
//                 'C8' => 2,
//                 'C9' => 1,
//                 'C10' => 2,
//                 'C11' => 1,
//                 'C12' => 2,
//                 'C13' => 2,
//                 'C14' => 1,
//                 'C15' => 2,
//             ],
//             'Mira Santoso' => [
//                 'alternatif' => 'A2',
//                 'C1' => 5,
//                 'C2' => 4,
//                 'C3' => 5,
//                 'C4' => 5,
//                 'C5' => 5,
//                 'C6' => 4,
//                 'C7' => 5,
//                 'C8' => 5,
//                 'C9' => 5,
//                 'C10' => 5,
//                 'C11' => 4,
//                 'C12' => 5,
//                 'C13' => 5,
//                 'C14' => 5,
//                 'C15' => 4,
//             ],
//             'Putri Anggraeni Lestari' => [
//                 'alternatif' => 'A3',
//                 'C1' => 3,
//                 'C2' => 3,
//                 'C3' => 4,
//                 'C4' => 4,
//                 'C5' => 3,
//                 'C6' => 4,
//                 'C7' => 4,
//                 'C8' => 4,
//                 'C9' => 3,
//                 'C10' => 4,
//                 'C11' => 3,
//                 'C12' => 3,
//                 'C13' => 3,
//                 'C14' => 4,
//                 'C15' => 3,
//             ],
//             'Rudi Hermawan Ramdani' => [
//                 'alternatif' => 'A4',
//                 'C1' => 2,
//                 'C2' => 2,
//                 'C3' => 2,
//                 'C4' => 2,
//                 'C5' => 2,
//                 'C6' => 2,
//                 'C7' => 2,
//                 'C8' => 2,
//                 'C9' => 2,
//                 'C10' => 3,
//                 'C11' => 2,
//                 'C12' => 3,
//                 'C13' => 3,
//                 'C14' => 2,
//                 'C15' => 3,
//             ],
//             'Prasetyo Utomo' => [
//                 'alternatif' => 'A5',
//                 'C1' => 4,
//                 'C2' => 3,
//                 'C3' => 4,
//                 'C4' => 4,
//                 'C5' => 3,
//                 'C6' => 3,
//                 'C7' => 4,
//                 'C8' => 3,
//                 'C9' => 4,
//                 'C10' => 3,
//                 'C11' => 4,
//                 'C12' => 3,
//                 'C13' => 4,
//                 'C14' => 4,
//                 'C15' => 4,
//             ],
//             'Gunawan' => [
//                 'alternatif' => 'A6',
//                 'C1' => 3,
//                 'C2' => 3,
//                 'C3' => 4,
//                 'C4' => 3,
//                 'C5' => 4,
//                 'C6' => 3,
//                 'C7' => 4,
//                 'C8' => 3,
//                 'C9' => 4,
//                 'C10' => 4,
//                 'C11' => 3,
//                 'C12' => 3,
//                 'C13' => 3,
//                 'C14' => 3,
//                 'C15' => 4,
//             ],
//             'Agus Setiawan Saputra' => [
//                 'alternatif' => 'A7',
//                 'C1' => 3,
//                 'C2' => 4,
//                 'C3' => 3,
//                 'C4' => 4,
//                 'C5' => 3,
//                 'C6' => 3,
//                 'C7' => 4,
//                 'C8' => 4,
//                 'C9' => 3,
//                 'C10' => 4,
//                 'C11' => 4,
//                 'C12' => 4,
//                 'C13' => 3,
//                 'C14' => 4,
//                 'C15' => 3,
//             ],
//             'Kartika Wijaya' => [
//                 'alternatif' => 'A8',
//                 'C1' => 4,
//                 'C2' => 4,
//                 'C3' => 3,
//                 'C4' => 3,
//                 'C5' => 4,
//                 'C6' => 4,
//                 'C7' => 4,
//                 'C8' => 3,
//                 'C9' => 4,
//                 'C10' => 4,
//                 'C11' => 3,
//                 'C12' => 4,
//                 'C13' => 4,
//                 'C14' => 4,
//                 'C15' => 4,
//             ],
//             'Fandi Kurniawan' => [
//                 'alternatif' => 'A9',
//                 'C1' => 5,
//                 'C2' => 5,
//                 'C3' => 5,
//                 'C4' => 5,
//                 'C5' => 5,
//                 'C6' => 5,
//                 'C7' => 4,
//                 'C8' => 5,
//                 'C9' => 5,
//                 'C10' => 5,
//                 'C11' => 4,
//                 'C12' => 5,
//                 'C13' => 5,
//                 'C14' => 5,
//                 'C15' => 5,
//             ],
//             'Budi Santoso' => [
//                 'alternatif' => 'A10',
//                 'C1' => 4,
//                 'C2' => 4,
//                 'C3' => 4,
//                 'C4' => 3,
//                 'C5' => 4,
//                 'C6' => 3,
//                 'C7' => 4,
//                 'C8' => 4,
//                 'C9' => 4,
//                 'C10' => 3,
//                 'C11' => 3,
//                 'C12' => 3,
//                 'C13' => 4,
//                 'C14' => 4,
//                 'C15' => 3,
//             ],
//             'Gita Maharani' => [
//                 'alternatif' => 'A11',
//                 'C1' => 5,
//                 'C2' => 4,
//                 'C3' => 5,
//                 'C4' => 5,
//                 'C5' => 5,
//                 'C6' => 5,
//                 'C7' => 5,
//                 'C8' => 4,
//                 'C9' => 4,
//                 'C10' => 5,
//                 'C11' => 5,
//                 'C12' => 4,
//                 'C13' => 5,
//                 'C14' => 5,
//                 'C15' => 4,
//             ],
//             'Ahmad Fauzi' => [
//                 'alternatif' => 'A12',
//                 'C1' => 3,
//                 'C2' => 4,
//                 'C3' => 3,
//                 'C4' => 4,
//                 'C5' => 3,
//                 'C6' => 4,
//                 'C7' => 4,
//                 'C8' => 3,
//                 'C9' => 3,
//                 'C10' => 3,
//                 'C11' => 4,
//                 'C12' => 3,
//                 'C13' => 4,
//                 'C14' => 4,
//                 'C15' => 3,
//             ],
//             'Bambang Sudrajat' => [
//                 'alternatif' => 'A13',
//                 'C1' => 2,
//                 'C2' => 2,
//                 'C3' => 2,
//                 'C4' => 2,
//                 'C5' => 2,
//                 'C6' => 2,
//                 'C7' => 3,
//                 'C8' => 2,
//                 'C9' => 3,
//                 'C10' => 2,
//                 'C11' => 2,
//                 'C12' => 3,
//                 'C13' => 2,
//                 'C14' => 2,
//                 'C15' => 3,
//             ],
//             'Wulan Sari' => [
//                 'alternatif' => 'A14',
//                 'C1' => 2,
//                 'C2' => 2,
//                 'C3' => 3,
//                 'C4' => 2,
//                 'C5' => 3,
//                 'C6' => 2,
//                 'C7' => 2,
//                 'C8' => 2,
//                 'C9' => 3,
//                 'C10' => 2,
//                 'C11' => 2,
//                 'C12' => 3,
//                 'C13' => 2,
//                 'C14' => 3,
//                 'C15' => 2,
//             ],
//             'Fajar Nugroho' => [
//                 'alternatif' => 'A15',
//                 'C1' => 4,
//                 'C2' => 3,
//                 'C3' => 4,
//                 'C4' => 3,
//                 'C5' => 4,
//                 'C6' => 3,
//                 'C7' => 4,
//                 'C8' => 4,
//                 'C9' => 3,
//                 'C10' => 4,
//                 'C11' => 3,
//                 'C12' => 4,
//                 'C13' => 3,
//                 'C14' => 4,
//                 'C15' => 3,
//             ],
//             'Hani Septiani' => [
//                 'alternatif' => 'A16',
//                 'C1' => 2,
//                 'C2' => 3,
//                 'C3' => 2,
//                 'C4' => 2,
//                 'C5' => 2,
//                 'C6' => 2,
//                 'C7' => 3,
//                 'C8' => 2,
//                 'C9' => 3,
//                 'C10' => 2,
//                 'C11' => 3,
//                 'C12' => 3,
//                 'C13' => 2,
//                 'C14' => 2,
//                 'C15' => 3,
//             ],
//             'Citra Novia' => [ // Tambahan jika duplikat dibiarkan
//                 'alternatif' => 'A17',
//                 'C1' => 4,
//                 'C2' => 3,
//                 'C3' => 4,
//                 'C4' => 3,
//                 'C5' => 4,
//                 'C6' => 3,
//                 'C7' => 4,
//                 'C8' => 3,
//                 'C9' => 4,
//                 'C10' => 3,
//                 'C11' => 4,
//                 'C12' => 3,
//                 'C13' => 4,
//                 'C14' => 4,
//                 'C15' => 3,
//             ],
//             'Rina Handayani' => [
//                 'alternatif' => 'A18',
//                 'C1' => 4,
//                 'C2' => 3,
//                 'C3' => 4,
//                 'C4' => 4,
//                 'C5' => 4,
//                 'C6' => 4,
//                 'C7' => 3,
//                 'C8' => 4,
//                 'C9' => 3,
//                 'C10' => 4,
//                 'C11' => 3,
//                 'C12' => 4,
//                 'C13' => 3,
//                 'C14' => 4,
//                 'C15' => 4,
//             ],
//             'Mulyadi' => [
//                 'alternatif' => 'A19',
//                 'C1' => 4,
//                 'C2' => 3,
//                 'C3' => 4,
//                 'C4' => 4,
//                 'C5' => 3,
//                 'C6' => 3,
//                 'C7' => 3,
//                 'C8' => 3,
//                 'C9' => 3,
//                 'C10' => 3,
//                 'C11' => 4,
//                 'C12' => 3,
//                 'C13' => 3,
//                 'C14' => 3,
//                 'C15' => 3,
//             ],
//             'Surya Darmawan' => [
//                 'alternatif' => 'A20',
//                 'C1' => 2,
//                 'C2' => 2,
//                 'C3' => 2,
//                 'C4' => 3,
//                 'C5' => 2,
//                 'C6' => 2,
//                 'C7' => 2,
//                 'C8' => 2,
//                 'C9' => 2,
//                 'C10' => 3,
//                 'C11' => 2,
//                 'C12' => 3,
//                 'C13' => 2,
//                 'C14' => 2,
//                 'C15' => 2,
//             ],

//         ];


//         foreach ($evaluationList as $fullname => $scores) {

//             $employee = DB::table('evaluation_employee_data')
//                 ->where('fullname', $fullname)
//                 ->where('evaluation_stage', strtoupper($targetStage))
//                 ->first();

//             if (!$employee) {
//                 echo "Data untuk $fullname tidak ditemukan di evaluation_employee_data.\n";
//                 continue;
//             }

//             $user = User::where('email', $employee->email)->first();
//             if (!$user) {
//                 echo "User dengan email {$employee->email} tidak ditemukan.\n";
//                 continue;
//             }


//             $data = array_merge($scores, [
//                 'fullname'           => $employee->fullname,
//                 'email'              => $employee->email,
//                 'departement'        => $employee->departement,
//                 'employeementStatus' => $employee->employeementStatus,
//                 'evaluation_years'   => $employee->evaluation_years,
//                 'evaluation_stage'   => $employee->evaluation_stage,
//                 'user_id'            => $user->id,
//                 'alternatif'         => 'A' . $employee->id,
//             ]);

//             EvaluationProcessor::process($data, $user);
//         }
//     }
// }
