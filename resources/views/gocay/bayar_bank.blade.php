@extends('../layout/' . $layout)

@section('subhead')
    <title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Data Bank</h2>
                        <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10">
                            <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        @foreach ($bank as $item)
                            <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div>
                                            <a class="flex items-center mr-3" href="{{ url('cetak-bayar-bank-pdf',$item->id) }}">
                                                    <i data-feather="save"  class=" text-theme-10"></i> Download
                                                </a>
                                        </div>
                                        <div class="flex mt-3" >
                                            <i data-feather="dollar-sign" class="report-box__icon text-theme-10"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">
                                            {{ "Rp. " . number_format($total[$item->id],0,',','.') }}
                                        </div>
                                        <div class="text-base text-gray-600 mt-1">{{ $item->nama }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> 
                </div> 
                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">No</th>
                                    <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                    <th class="text-center whitespace-nowrap">Bank</th>
                                    <th class="text-center whitespace-nowrap">Nomor Rekekning</th>
                                    <!-- <th class="text-center whitespace-nowrap">Atas Nama</th> -->
                                    <th class="text-center whitespace-nowrap">Total</th>
                                    <!-- <th class="text-center whitespace-nowrap">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pegawai as $item)
                                    <tr class="intro-x">
                                        <td class="w-40">
                                        {{ ++ $i}}
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->nama }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->bank_id != null ? preg_replace('/[^A-Za-z0-9\-]/', '', $nama_bank[$item->bank_id]) : '' }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->no_rek }}</a>
                                        </td>
                                        <!-- <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $item->atas_nama }}</a>
                                        </td> -->

                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ "Rp. " . number_format($gaji_total[$item->id],0,',','.') }}</a>
                                            <!-- <a href="" class="font-medium whitespace-nowrap">{{ $item->pegawai_id }}</a> -->
                                        </td>
          
                                        <!-- <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3 bon-kas-edit" href="javascript:void(0)" data-toggle="modal" 
                                                id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                </a>
                                                <a class="flex items-center text-theme-6" href="/bon-kasdelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                </a>
                                            </div>
                                        </td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <div class="pagination">
                            {{ $pegawai->appends($data_request)->links() }}
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>

    </div>
@endsection
