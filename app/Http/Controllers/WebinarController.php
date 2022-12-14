<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Webinar;
use Illuminate\Http\Request;
use App\Exports\memberWebExport;
use App\Imports\memberWebImport;
use Maatwebsite\Excel\Facades\Excel;

class WebinarController extends Controller
{
    public function landing()
    {
        return view('index', [
            'title' => 'FOSTIFEST'
        ]);
    }

    public function index()
    {
        return view('form-webinar',  [
            'title' => 'Registrasi CTF | FOSTIFEST'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:webinars',
            'wa' => 'required',
            'gender' => 'required',
            'agency' => 'required',
            'agency_sp' => '',
            'sg1' => 'image|file',
            'sg2' => 'image|file',
            'sg3' => 'image|file',
            'payment' => 'image|file'
        ]);
        $sg1 = '-';
        $sg2 = '-';
        $sg3 = '-';
        $payment = '-';

        if ($request->agency == 'ums') {
            $extension1 = $request->sg1->extension();
            $extension2 = $request->sg2->extension();
            $extension3 = $request->sg3->extension();
            $extension4 = $request->payment->extension();
            $fileName1 = $request->fullname . '-sg1-' . date('dmYhis') . '.' . $extension1;
            $fileName2 = $request->fullname . '-sg2-' . date('dmYhis') . '.' . $extension2;
            $fileName3 = $request->fullname . '-sg3-' . date('dmYhis') . '.' . $extension3;
            $fileName4 = $request->fullname . '-payment-' . date('dmYhis') . '.' . $extension4;
            $sg1 = $request->file('sg1')->storeAs('sg1', $fileName1);
            $sg2 = $request->file('sg2')->storeAs('sg2', $fileName2);
            $sg3 = $request->file('sg3')->storeAs('sg3', $fileName3);
            $payment = $request->file('payment')->storeAs('payment', $fileName4);
            $agencySp = 'Universitas Muhammadiyah Surakarta';
        }

        if ($request->agency == 'umum') {
            $sg1 = '-';
            $sg2 = '-';
            $sg3 = '-';
            $extension = $request->payment->extension();
            $fileName = $request->fullname . '-payment-' . date('dmYhis') . '.' . $extension;
            $payment = $request->file('payment')->storeAs('payment', $fileName);
            $agencySp = $request->agency_sp;
        }

        Webinar::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'whatsapp' => $request->wa,
            'gender' => $request->gender,
            'agency' => $request->agency,
            'agency_sp' => $agencySp,
            'sg_1' => $sg1,
            'sg_2' => $sg2,
            'sg_3' => $sg3,
            'payment' => $payment,
        ]);
        return redirect('/')->with('success', 'Terima Kasih Telah Mendaftar');
        // try {

        // } catch (Throwable $e) {
        //     return redirect('/webinar')->with('emailError', 'Email yang digunakan telah terdaftar');
        // }
    }

    public function export()
    {
        return Excel::download(new memberWebExport, 'peserta_webinar.xlsx');
    }

    public function import()
    {
        Excel::import(new memberWebImport, request()->file('file'));

        return back();
    }
}
