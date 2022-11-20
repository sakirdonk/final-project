<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //modul untuk menampilkan seluruh data patient
    public function index()
    {
        //function eloquent untuk mendapatkan seluruh data dari tabel patient
        $patients = Patient::all();

        //mengecek data tersedia atau tidak
        //jika tersedia
        if ($patients) {
            $data = [
                'message' => 'Get all Resource',
                'data' => $patients,
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika tidak tersedia
        else {
            $data = [
                'message' => 'Data is Empty'
            ];

            #mengubah format $data menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }

    //modul untuk menambahan data patient
    public function store(Request $request)
    {
        //setting untuk default jika tidak ada data yang dimasukkann
        $in_date_default = date("Y-m-d"); //default in_date (now())
        $out_date_default = NULL; //default out_date (empty/NULL)
        $status_default = 'Positive'; //default status (positive)

        #menggunakan model patient
        $input = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status ?? $status_default,
            'in_date_at' => $request->in_date_at ?? $in_date_default,
            'out_date_at' => $request->out_date_at ?? $out_date_default,
        ];

        //execute query insert table patient
        $patients = Patient::create($input);

        //jika data berhasil diinput
        if ($patients) {
            $data = [
                'message' => 'Resource is added Successfully',
                'data' => $patients,
            ];

            #mengubah format data patient menjadi json dengan code 201
            return response()->json($data, 201);
        }
        //jika data gagal diinput
        else {
            $data = [
                'message' => 'Patient not found'
            ];

            #mengubah format data patient menjadi json dengan code 401
            return response()->json($data, 401);
        }
    }

    //modul search patient menggunakan id
    public function show($id)
    {
        //menggunakan function find untuk mencari data patient berdasarkan id
        $patients = Patient::find($id);

        //jika data ditemukan
        if ($patients) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patients,
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika data tidak ditemukan
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            #mengubah format data patient menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }

    //modul update data patient
    public function update(Request $request, $id)
    {
        //menggunakan function find untuk mencari data patient berdasarkan id
        $patient = Patient::find($id);

        //jika data ditemukan
        if ($patient) {
            //menggunakan modul patient
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at,
            ];

            //execute query update patient data
            $patient->update($input);

            $data = [
                'message' => 'Resource is update succesfully',
                'data' => $patient,
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika data tidak ditemukan
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            #mengubah format data patient menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }

    //modul untuk menghapus data patient
    public function destroy(Patient $patient, $id)
    {
        //menggunakan function find untuk mencari data patient berdasarkan id
        $patient = Patient::find($id);

        //jika data ditemukan
        if ($patient) {

            //execute query untuk menghapus data patient
            $patient->delete($id);
            $data = [
                'message' => 'Resource is delete succesfully'
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika data tidak ditemukan
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            #mengubah format data patient menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }

    //modul untuk mencari data patient berdasarkan nama
    public function search($name)
    {
        //menggunakan function where like untuk mencari beberapa data patient berdasarkan column (name)
        $patients = Patient::where('name', 'like', '%' . $name . '%')->get(); //menggunakan get untuk menangkap semua isi data yang ada

        //jika data ditemukan
        if ($patients) {
            $data = [
                'message' => "Get searched Resource",
                'data' => $patients,
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika data tidak ditemukan
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            #mengubah format data patient menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }

    //modul untuk menampilkan data patient yang memiliki status positive
    public function positive()
    {
        //menggunakan function find untuk mencari data pasien berdasarkan column (status/positive)
        $patients = Patient::where('status', '=', 'positive')->get(); //menggunakan get untuk menangkap semua isi data yang ada
        $data_count = Patient::where('status', '=', 'positive')->count(); //menggunakan count untuk menghitung total data yang ada

        //jika data ditemukan
        if ($patients) {
            $data = [
                'message' => 'Get positive resource',
                'total' => $data_count,
                'data' => $patients,
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika data tidak ditemukan
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            #mengubah format data patient menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }

    //modul untuk menampilkan data patient yang memiliki status recovered
    public function recovered()
    {
        //menggunakan function find untuk mencari data pasien berdasarkan column (status/recovered)
        $patients = Patient::where('status', '=', 'recovered')->get(); //menggunakan get untuk menangkap semua isi data yang ada
        $data_count = Patient::where('status', '=', 'recovered')->count(); //menggunakan count untuk menghitung total data yang ada

        //jika data ditemukan
        if ($patients) {
            $data = [
                'message' => 'Get recovered resource',
                'total' => $data_count,
                'data' => $patients,
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika data tidak ditemukan
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            #mengubah format data patient menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }

    //modul untuk menampilkan data patient yang memiliki status dead
    public function dead()
    {
        //menggunakan function find untuk mencari data patient berdasarkan column (status/dead)
        $patients = Patient::where('status', '=', 'dead')->get(); //menggunakan get untuk menangkap semua isi data yang ada
        $data_count = Patient::where('status', '=', 'dead')->count(); //menggunakan count untuk menghitung total data yang ada

        //jika data ditemukan
        if ($patients) {
            $data = [
                'message' => 'Get dead resource',
                'total' => $data_count,
                'data' => $patients,
            ];

            #mengubah format data patient menjadi json dengan code 200
            return response()->json($data, 200);
        }
        //jika data tidak ditemukan
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            #mengubah format data patient menjadi json dengan code 404
            return response()->json($data, 404);
        }
    }
};
