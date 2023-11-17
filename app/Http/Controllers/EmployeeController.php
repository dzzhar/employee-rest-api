<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    // method get all resources
    public function index()
    {
        // get all resources dengan model
        $employees = Employee::all();

        // jika data kosong kirim data (json) dan code status
        if ($employees->isEmpty()) {
            $data = [
                "message" => "Data is Empty"
            ];

            return response()->json($data, 200);
        } else {

            // jika data tersedia kirim data (json) dan code status
            $data = [
                "message" => "Get All Resources",
                "data" => $employees
            ];

            return response()->json($data, 200);
        }
    }

    // method add resource
    public function store(Request $request)
    {
        // validasi data request
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "gender" => "required",
            "phone" => "required",
            "address" => "required",
            "email" => "required|email",
            "status" => "required",
            "hired_on" => "required"
        ]);

        // jika validasi gagal kirim data (json) dan status code 422
        if ($validator->fails()) {
            $data = [
                "message" => "Validation Failed",
                "data" => $validator->errors()
            ];

            return response()->json($data, 422);
        } else {

            // jika validasi berhasil kirim data (json) dan status code 201
            // menyimpan data baru yang berhasil dibuat
            $employees = Employee::create($request->all());

            $data = [
                "message" => "Resource is Added Successfully",
                "data" => $employees
            ];

            return response()->json($data, 201);
        }
    }

    // method get detail resource
    public function show($id)
    {
        // cari data dengan model berdasarkan id
        $employees = Employee::find($id);

        // jika data tersedia kirim data (json) dan status code (200)
        if ($employees) {
            $data = [
                "message" => "Get Detail Resource",
                "data" => $employees
            ];

            return response()->json($data, 200);
        } else {

            // jika data tidak tersedia kirim data (json) dan status code (404)
            $data = [
                "message" => "Resource Not Found"
            ];

            return response()->json($data, 404);
        }
    }

    // method update resource
    public function update(Request $request, $id)
    {
        // cari data dengan model berdasarkan id
        $employees = Employee::find($id);

        // jika data tersedia maka jalankan
        if ($employees) {

            // menangkap data request
            $input = [
                "name" => $request->name ?? $employees->name,
                "gender" => $request->gender ?? $employees->gender,
                "phone" => $request->phone ?? $employees->phone,
                "address" => $request->address ?? $employees->address,
                "email" => $request->email ?? $employees->email,
                "status" => $request->status ?? $employees->status,
                "hired_on" => $request->hired_on ?? $employees->hired_on
            ];

            // update data input
            $employees->update($input);

            // mengirim data (json) dan status code (200)
            $data = [
                "message" => "Resources id Update Successfully",
                "data" => $employees
            ];

            return response()->json($data, 200);
        } else {

            // jika data tidak ditemukan kirim data (json) dan status code (404)
            $data = [
                "message" => "Resource Not Found",
            ];

            return response()->json($data, 404);
        }
    }

    // method delete resource
    public function destroy($id)
    {
        // cari data dengan model berdasarkan id
        $employees = Employee::find($id);

        // jika data tersedia kirim data (json) dan status code (200)
        if ($employees) {
            // menghapus data
            $employees->delete();

            $data = [
                "message" => "Resource is Deleted Successfully"
            ];

            return response()->json($data, 200);
        } else {

            // jika data tidak ditemukan kirim data (json) dan status code (404)
            $data = [
                "message" => "Resource Not Found"
            ];

            return response()->json($data, 404);
        }
    }

    // method search resource by name
    public function search($name)
    {
        // mencari data berdasarkan name
        $employeeName = Employee::where('name', 'like', '%' . $name . '%')->get();

        // jika data tidak tersedia maka kirim data (json) dan status code (404)
        if ($employeeName->count() == 0) {
            $data = [
                "message" => "Resource Not Found"
            ];

            return response()->json($data, 404);
        } else {

            // jika data tersedia maka kirim data (json) dan status code (200)
            $data = [
                "message" => "Get Searched Resource",
                "data" => $employeeName
            ];

            return response()->json($data, 200);
        }
    }

    // method get active resource
    public function active()
    {
        // mencari data berdasarkan status == active
        $employeeData = Employee::where('status', 'active')->get();

        // kirim data (json) dan status code (200)
        $data = [
            "message" => "Get Active Resource",
            "data" => $employeeData
        ];

        return response()->json($data, 200);
    }

    // method get inactive resource
    public function inactive()
    {
        // mencari data berdasarkan status == inactive
        $employeeData = Employee::where('status', 'inactive')->get();

        // kirim data (json) dan status code (200)
        $data = [
            "message" => "Get Inactive Resource",
            "data" => $employeeData
        ];

        return response()->json($data, 200);
    }

    public function terminated()
    {
        // mencari data berdasarkan status == terminated
        $employeeData = Employee::where('status', 'terminated')->get();

        /// kirim data (json) dan status code (200)
        $data = [
            "message" => "Get Terminated Resource",
            "data" => $employeeData
        ];

        return response()->json($data, 200);
    }
}
