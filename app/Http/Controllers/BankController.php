<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Metapenggajian;
use App\Models\Periode;
use App\Models\Pegawai;
use DB;
use DomPDF;



class BankController extends Controller
{
    public function index(Request $request)
    {
        //
        $bank = bank::paginate(10);
        return view('gocay.bank', [
            'bank' => $bank,
        ])->with('i', ($request->input('page', 1) - 1) * 10);
        
    }

    public function bayar_bank(Request $request)
    {
        $data_request = $request->all();
        $bank = Bank::all();
        foreach ($bank as $item):
            $in[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'in')
                            ->where('pegawais.bank_id' ,'=', $item->id)
                            ->get()->sum('nominal');
            $out[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'out')
                            ->where('pegawais.bank_id' ,'=', $item->id)
                            ->get()->sum('nominal');
            $total[$item->id] = intval($in[$item->id] - $out[$item->id]);
            $nama_bank[$item->id] = Bank::where('id', '=' , $item->id)->get()->pluck('nama');
        endforeach;

        $rekening = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                    // ->where('metapenggajians.status' ,'=', 'in')
                    ->where('metapenggajians.keterangan' ,'=', 'Gaji Pokok')
                    ->paginate(10);


        // $request->periode_id == null ? '1' : $request->periode_id;

        // if ($request->periode_id == null):
            $periode_id = Periode::latest()->first();
        


        // dd($request->periode_id);
        

        foreach ($rekening as $item):
            $gaji_in[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                                    ->where('metapenggajians.status' ,'=', 'in')
                                    ->where('pegawais.id' ,'=', $item->pegawai_id)
                                    ->where('penggajians.periode_id' ,'=', $request->periode_id == null ? $periode_id->id : $request->periode_id)
                                    ->get()->sum('nominal');   

            $gaji_out[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                                    ->where('metapenggajians.status' ,'=', 'out')
                                    ->where('pegawais.id' ,'=', $item->pegawai_id)
                                    ->where('penggajians.periode_id' ,'=', $request->periode_id == null ? $periode_id->id : $request->periode_id)
                                    ->get()->sum('nominal');      

            $gaji_total[$item->id] = intval($gaji_in[$item->id] - $gaji_out[$item->id]);
        endforeach;

        return view('gocay.bayar_bank', [
            'bank' => $bank,
            'rekening' => $rekening,
            'total' => $total,
            'nama_bank' => $nama_bank,
            'gaji_total' => $gaji_total,
            'data_request' => $data_request,
        ])->with('i', ($request->input('page', 1) - 1) * 10);

    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $bank = new Bank;
        $bank->nama = $request->nama;
        $bank->save();

        if($bank){
            return redirect()->back()->with(['success' => 'Data Komponen Gaji'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    public function edit(Request $Request)
    {
        $bank = Bank::findOrFail($Request->get('id'));
        echo json_encode($bank);
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $bank = Bank::find($request->id);
        $bank->update($request->all());

        if($bank){
            return redirect()->back()->with(['success' => 'Data Bank'.$request->input('nama').'berhasil disimpan']);
        }else{
            return redirect()->back()->with(['danger' => 'Data Tidak Terekam!']);
        }
    }

    public function destroy($id)
    {
        $bank = Bank::where('id', $id)
              ->delete();
        return redirect()->back()
                        ->with('success','Post deleted successfully');
    }

     public function ExportPDFBayarBank(Request $request, $id)
    {

        $bank_title = Bank::whereRaw('id = '. $id) 
        ->first();
        $bank = Bank::all();
        $bank_total = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'in')
                            ->where('pegawais.bank_id' ,'=', $id)
                            ->get()->sum('nominal');
        foreach ($bank as $item):
            $in[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'in')
                            ->where('pegawais.bank_id' ,'=', $item->id)
                            ->get()->sum('nominal');
            $out[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                            ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                            ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                            ->where('metapenggajians.status' ,'=', 'out')
                            ->where('pegawais.bank_id' ,'=', $item->id)
                            ->get()->sum('nominal');
            $total[$item->id] = intval($in[$item->id] - $out[$item->id]);
            $nama_bank[$item->id] = Bank::where('id', '=' , $item->id)->get()->pluck('nama');
        endforeach;

        $pegawai = Pegawai::where('id', $id)->first();

        $rekening = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                    // ->where('metapenggajians.status' ,'=', 'in')
                    ->where('pegawais.bank_id' ,'=', $id)
                    ->where('metapenggajians.keterangan' ,'=', 'Gaji Pokok')
                    // ->paginate(10);
                    ->get();

        // $request->periode_id == null ? '1' : $request->periode_id;

        // if ($request->periode_id == null):
        //     $periode_id = 1;
        


         $periode_id = Periode::latest()->first();
         // dd($request->periode_id);

        foreach ($rekening as $item):
            $gaji_in[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                                    ->where('metapenggajians.status' ,'=', 'in')
                                    ->where('pegawais.id' ,'=', $item->pegawai_id)
                                    ->where('pegawais.bank_id' ,'=', $id)
                                    ->where('penggajians.periode_id' ,'=', $request->periode_id == null ? $periode_id->id : $request->periode_id)
                                    ->get()->sum('nominal');   

            $gaji_out[$item->id] = Metapenggajian::select('metapenggajians.*' ,'penggajians.pegawai_id','penggajians.id', 'pegawais.id', 'pegawais.bank_id', 'pegawais.no_rek', 'pegawais.atas_nama', 'pegawais.nama as nama_pegawai')
                                    ->join('penggajians', 'penggajians.id', 'metapenggajians.penggajian_id')
                                    ->join('pegawais', 'pegawais.id', 'penggajians.pegawai_id')
                                    ->where('metapenggajians.status' ,'=', 'out')
                                    ->where('pegawais.id' ,'=', $item->pegawai_id)
                                    ->where('pegawais.bank_id' ,'=', $id)
                                    ->where('penggajians.periode_id' ,'=', $request->periode_id == null ? $periode_id->id : $request->periode_id)
                                    ->get()->sum('nominal');      

            $gaji_total[$item->id] = intval($gaji_in[$item->id] - $gaji_out[$item->id]);
        endforeach;

        $bank_id = Bank::where('id', $id)->first();

      $pdf = DomPDF::loadView('gocay.cetak.bayar-bank', [
            'adm_pegawai' => $pegawai,
            'bank_total' => $bank_total,
            'bank' => $bank,
            'bank_id' => $bank_id,
            'rekening' => $rekening,
            'total' => $total,
            'nama_bank' => $nama_bank,
            'gaji_total' => $gaji_total,
    ])->setPaper('landscape');
      // download PDF file with download method
      return $pdf->stream('Bayar Bank '.$bank_title->nama.'.pdf');
    }
}
