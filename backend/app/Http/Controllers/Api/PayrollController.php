<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PayrollController extends Controller
{
    /**
     * Get payslips list
     */
    public function index(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $payslips = Payslip::where('employee_id', $employee->id)
                ->with('payrollPeriod')
                ->orderBy('created_at', 'desc')
                ->paginate($request->input('per_page', 15));
            
            return response()->json([
                'success' => true,
                'data' => $payslips,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data slip gaji',
            ], 500);
        }
    }

    /**
     * Get payslip detail
     */
    public function show($id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $payslip = Payslip::where('id', $id)
                ->where('employee_id', $employee->id)
                ->with(['payrollPeriod', 'details'])
                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $payslip,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data slip gaji tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Download payslip PDF
     */
    public function download($id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $payslip = Payslip::where('id', $id)
                ->where('employee_id', $employee->id)
                ->with(['payrollPeriod', 'details', 'employee'])
                ->firstOrFail();
            
            // TODO: Generate PDF using DomPDF
            
            return response()->json([
                'success' => true,
                'message' => 'PDF generation not implemented yet',
                'data' => $payslip,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunduh slip gaji',
            ], 500);
        }
    }
}
