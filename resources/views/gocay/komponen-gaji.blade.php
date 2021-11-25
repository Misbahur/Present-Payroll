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
                            <button class="btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                            </button>
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button>
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible py-5 mt-8 sm:mt-0">
                        <div class="flex justify-left md:justify-end mt-16">
                            <button class="btn btn-primary tablink p-5 flex " onclick="openTab(event,'komponen-gaji-tab')">Daftar Komponen</button>
                            <button class="btn tablink p-5 flex " onclick="openTab(event,'komponen-gaji-add-tab')">Tambah Komponen</button>
                            <button class="btn tablink p-5 flex " onclick="openTab(event,'bonus-harian-tab')">Bonus Harian</button>
                            <button class="btn tablink p-5 flex" onclick="openTab(event,'bonus-mingguan-tab')">Bonus Mingguan</button>
                            <button class="btn tablink p-5 flex" onclick="openTab(event,'bonus-bulanan-tab')">Bonus Bulanan</button>
                        </div>
                        <div id="komponen-gaji-tab" class="bonus max-w-md py-5 px-8 shadow-lg rounded-lg my-20" >
                            <table class="table table-report sm:mt-2">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">No</th>
                                        <th class="text-center whitespace-nowrap">Nama Pegawai</th>
                                        <th class="text-center whitespace-nowrap">Jabatan</th>
                                        <th class="text-center whitespace-nowrap">Tanggal</th>
                                        <th class="text-center whitespace-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($komponen_gaji->skip(3) as $item)
                                        <tr class="intro-x">
                                            <td class="w-40">
                                            {{ $no++; }}
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ $item->nama }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ $item->jabatan->nama }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="font-medium whitespace-nowrap">{{ $item->nominal }}</a>
                                            </td>
                                            <td class="table-report__action w-56">
                                                <div class="flex justify-center items-center">
                                                    <a class="flex items-center mr-3 pengecualian-edit" href="javascript:void(0)" data-toggle="modal" 
                                                    id="{{ $item->id }}" data-target="#header-footer-modal-preview-edit" data-id="{{ $item->id }}">
                                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
                                                    </a>
                                                    <a class="flex items-center text-theme-6" href="/pengecualiandelete/{{$item->id}}" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">
                                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="komponen-gaji-add-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('komponengajiadd') }}">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Bonus Harian</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nama</label>
                                        <input name='nama' type="text" class="form-control" placeholder="Nama Komponen Gaji">
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-2" class="form-label">Jabatan</label>
                                        <select name="jabatan_id" class="form-select">
                                        @foreach ($jabatans as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-3" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Harian">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary text-xl font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>
                        <div id="bonus-harian-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none" >
                            <form method="POST" action="{{ route('bonusharianupdate') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Bonus Harian</h2>
                                        <h2 class="text-gray-800 text-xl font-semibold">Rp. {{ $komponen_gaji[0]->nominal }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Harian">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary text-xl font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>
                        <div id="bonus-mingguan-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('bonusmingguanupdate') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Bonus Mingguan</h2>
                                        <h2 class="text-gray-800 text-xl font-semibold">Rp. {{ $komponen_gaji[1]->nominal }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Mingguan">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary text-xl font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>
                        <div id="bonus-bulanan-tab" class="bonus max-w-md py-5 px-8 bg-white shadow-lg rounded-lg my-20" style="display:none">
                            <form method="POST" action="{{ route('bonusbulananupdate') }}">
                                <input type="hidden" name="id" id="modal-update-id">
                                    @csrf
                                    <div>
                                        <h2 class="text-gray-800 text-2xl font-semibold">Bonus Bulanan</h2>
                                        <h2 class="text-gray-800 text-xl font-semibold">Rp. {{ $komponen_gaji[2]->nominal }}</h2>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12 mt-5">
                                        <label for="form-1" class="form-label">Nominal</label>
                                        <input name='nominal' type="number" class="form-control" placeholder="Nominal Bonus Bulanan">
                                    </div>
                                    <div class="flex justify-start mt-4">
                                        <button type="submit" class="btn btn-primary text-xl font-medium text-indigo-500">Simpan</button>
                                    </div>
                            </form>
                        </div>          
                    </div>
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <ul class="pagination">
                            <li>
                                <a class="pagination__link" href="">
                                    <i class="w-4 h-4" data-feather="chevrons-left"></i>
                                </a>
                            </li>
                            <li>
                                <a class="pagination__link" href="">
                                    <i class="w-4 h-4" data-feather="chevron-left"></i>
                                </a>
                            </li>
                            <li>
                                <a class="pagination__link" href="">...</a>
                            </li>
                            <li>
                                <a class="pagination__link" href="">1</a>
                            </li>
                            <li>
                                <a class="pagination__link pagination__link--active" href="">2</a>
                            </li>
                            <li>
                                <a class="pagination__link" href="">3</a>
                            </li>
                            <li>
                                <a class="pagination__link" href="">...</a>
                            </li>
                            <li>
                                <a class="pagination__link" href="">
                                    <i class="w-4 h-4" data-feather="chevron-right"></i>
                                </a>
                            </li>
                            <li>
                                <a class="pagination__link" href="">
                                    <i class="w-4 h-4" data-feather="chevrons-right"></i>
                                </a>
                            </li>
                        </ul>
                        <select class="w-20 form-select box mt-3 sm:mt-0">
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>


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
        
    </div>
@endsection
