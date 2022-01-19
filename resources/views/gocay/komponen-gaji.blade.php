@extends('../layout/' . $layout)

@section('subhead')
    <title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Komponen Gaji Karyawan</h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <!-- <button class="btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                            </button>
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button> -->
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible py-5 mt-8 sm:mt-0">
                        <div class="flex justify-left md:justify-end mt-16">
                            <button class="btn btn-primary tablink p-5 flex " onclick="openTab(event,'komponen-gaji-tab')">Daftar Komponen</button>
                            <button class="btn tablink p-5 flex " onclick="openTab(event,'lembur-tab')">Lembur</button>
                            <button class="btn tablink p-5 flex " onclick="openTab(event,'keterlambatan-tab')">Keterlambatan</button>
                            <button class="btn tablink p-5 flex" onclick="openTab(event,'bonus-mingguan-tab')">Bonus Mingguan</button>
                            <button class="btn tablink p-5 flex" onclick="openTab(event,'bonus-bulanan-tab')">Bonus Bulanan</button>
                            {{-- <button class="btn tablink p-5 flex" onclick="openTab(event,'liburmasuk-tab')">Bonus Libur Masuk</button>
                            <button class="btn tablink p-5 flex" onclick="openTab(event,'masuklibur-tab')">Potongan Tidak Masuk</button> --}}
                        </div>
                        <div id="komponen-gaji-tab" class="bonus max-w-md py-5 px-8 shadow-lg rounded-lg my-20" >
                        <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
                        class="btn btn-primary shadow-md mr-2">Tambah Data Komponen</a>
                            <table class="table table-report sm:mt-2">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                        <th class="text-center whitespace-nowrap">Jabatan</th>
                                        <th class="text-center whitespace-nowrap">Gaji Pokok</th>
                                        <th class="text-center whitespace-nowrap">+ Masuk Libur</th>
                                        <th class="text-center whitespace-nowrap">- Tidak Masuk</th>
                                        <th class="text-center whitespace-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($komponen_gaji->skip(2) as $item)
                                        <tr class="intro-x">
                                            <td class="w-40">
                                            <!-- {{ $no++; }} -->
                                            {{ ++ $i }}
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ $item->nama }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ $item->jabatan->nama }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ "Rp. " . number_format($item->nominal,0,',','.'); }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ "Rp. " . number_format($item->masuklibur,0,',','.'); }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ "Rp. " . number_format($item->tidakmasuk,0,',','.'); }}</a>
                                            </td>
                                            <td class="table-report__action w-56">
                                                <div class="flex justify-center items-center">
                                                    <a class="flex items-center mr-3 komponengajiedit" href="javascript:void(0)" data-toggle="modal" 
                                                    id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                    </a>
                                                    <a class="flex items-center text-theme-6" href="{{ route('komponengajidelete',$item->id) }}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="lembur-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('lembur') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Lembur</h2>
                                        <h2 class="text-gray-800 text-lg font-base">Durasi : {{ $lembur->durasi }} Menit</h2>
                                        <h2 class="text-gray-800 text-lg font-base">Fee : {{ "Rp. " . number_format($lembur->nominal,0,',','.') }} </h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Durasi</label>
                                        <input name='durasi' type="number" class="form-control" placeholder="Durasi Untuk Mendapatkan Bonus Lembur">
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Lembur">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>

                        <div id="keterlambatan-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none" >
                            <form method="POST" action="{{ route('keterlambatan') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Keterlambatan</h2>
                                         <h2 class="text-gray-800 text-lg font-base">Durasi : {{ $keterlambatan->durasi }} Menit</h2>
                                        <h2 class="text-gray-800 text-lg font-base">Fee : {{ "Rp. " . number_format($keterlambatan->nominal,0,',','.') }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Durasi</label>
                                        <input name='durasi' type="number" class="form-control" placeholder="Durasi Untuk Sanksi Keterlambatan">
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Sanksi Keterlambatan">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>

                        <div id="bonus-mingguan-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('bonusmingguanupdate') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Bonus Mingguan</h2>
                                        <h2 class="text-gray-800 text-xl font-semibold">{{ "Rp. " . number_format($komponen_gaji[0]->nominal,0,',','.') }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Mingguan">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>

                        <div id="bonus-bulanan-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('bonusbulananupdate') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Bonus Bulanan</h2>
                                        <h2 class="text-gray-800 text-xl font-semibold">{{ "Rp. " . number_format($komponen_gaji[1]->nominal,0,',','.') }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Bulanan">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>
                        {{-- <div id="liburmasuk-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('liburmasuk') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Bonus Libur Masuk</h2>
                                        <h2 class="text-gray-800 text-xl font-semibold">{{ "Rp. " . number_format($komponen_gaji[2]->nominal,0,',','.') }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Bulanan">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>
                        <div id="masuklibur-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('masuklibur') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Potongan Tidak Masuk</h2>
                                        <h2 class="text-gray-800 text-xl font-semibold">{{ "Rp. " . number_format($komponen_gaji[3]->nominal,0,',','.') }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Bulanan">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>           --}}
                    </div>

                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <div class="pagination">
                                {{ $komponen_gaji->appends($data_request)->links() }}
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>

        <!-- BEGIN: Modal Content -->
        <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Tambah item</h2>
                        <div class="dropdown sm:hidden">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                                <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-600"></i>
                            </a>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="javascript:;"
                                        class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <form method="POST" enctype="multipart/form-data" action="{{ route('komponengajiadd') }}">
                        @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1" class="form-label">Nama Komponen</label>
                            <input id="modal-form-1" name="nama" type="text" class="form-control" placeholder="Nama Komponen Gaji">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label">Jabatan Pegawai</label>
                            <select id="modal-form-2" class="form-select" name="jabatan_id">
                            @foreach ($jabatans as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">Nominal</label>
                            <input id="modal-form-3" type="number" class="form-control"  name="nominal">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">+ Bonus Masuk Libur</label>
                            <input id="modal-form-3" type="number" class="form-control"  name="masuklibur">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">- Potongan Tidak Masuk</label>
                            <input id="modal-form-3" type="number" class="form-control"  name="tidakmasuk">
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-right">
                        <button type="button" data-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Send</button>
                    </div>
                    </form>
                    <!-- END: Modal Footer -->
                </div>
            </div>
        </div>
        <!-- END: Modal Content -->

         <!-- BEGIN: Modal Content -->
        <div id="header-footer-modal-preview-edit" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">Tambah item</h2>
                        <div class="dropdown sm:hidden">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                                <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-600"></i>
                            </a>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="javascript:;"
                                        class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <form method="POST" enctype="multipart/form-data" action="{{ route('komponengajiupdate') }}">
                        @csrf
                    <input type="hidden" name="id" id="modal-update-id-komponen">
                    <!-- <input id="modal-form-jabatan-edit" name="jabatan_id" type="hidden"> -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-1-edit" class="form-label">Nama Komponen</label>
                            <input id="modal-form-1-edit" name="nama" type="text" class="form-control" placeholder="Nama Komponen Gaji">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2-edit" class="form-label">Jabatan_id</label>
                            <input  type="hidden" id="modal-form-2-edit" name="jabatan_id" type="text" class="form-control">
                            <select id="modal-form-2-edit" class="form-select" name="jabatan_id" disabled>
                            @foreach ($jabatans as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            </select> 
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3-edit" class="form-label">Nominal</label>
                            <input id="modal-form-3-edit" type="number" class="form-control"  name="nominal">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-4-edit" class="form-label">+ Bonus Masuk Libur</label>
                            <input id="modal-form-4-edit" type="number" class="form-control"  name="masuklibur">
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-5-edit" class="form-label">- Potongan Tidak Masuk</label>
                            <input id="modal-form-5-edit" type="number" class="form-control"  name="tidakmasuk">
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-right">
                        <button type="button" data-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Send</button>
                    </div>
                    </form>
                    <!-- END: Modal Footer -->
                </div>
            </div>
        </div>
        <!-- END: Modal Content -->

        <script>
            function openTab(evt, tabName) {
                var i, x, tablinks;
                x = document.getElementsByClassName("bonus");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablink");
                for (i = 0; i < x.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" btn-primary", " ");
                }
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " btn-primary";
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //edit data
                
                $('.komponengajiedit').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url : "{{route('komponengajiedit')}}?id="+id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            
                            $('#modal-update-id-komponen').val(data.id);
                            $('#modal-form-2-edit-jabatan option[value="' + data.jabatan_id +'"]').prop("selected", true);

                            $('#modal-update-id').val(data.id);
                            $('#modal-form-1-edit').val(data.nama);
                            $('#modal-form-2-edit').val(data.jabatan_id);
                            $('#modal-form-jabatan-edit').val(data.jabatan_id);
                            $('#modal-form-3-edit').val(data.nominal);
                            $('#modal-form-4-edit').val(data.masuklibur);
                            $('#modal-form-5-edit').val(data.tidakmasuk);
                            // $('#modal-form-2-edit option[value="' + data.gender +'"]').prop("selected", true);
                            // $('#modal-form-2-edit option[value="' + data.role +'"]').prop("selected", true);
                        }
                    });

                });
            });
        </script>
        
    </div>
@endsection
