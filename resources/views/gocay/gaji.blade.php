@extends('../layout/' . $layout)

@section('subhead')
    <title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
     <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Modul Penggajian Karyawan</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5 lg:mt-0">
                <div class="relative flex items-center p-5">
                    <h2 class="font-medium text-base mr-auto">Filter Periode</h2>
                </div>
                <div class="p-5 border-gray-200">
                    <select class="form-select mt-2 sm:mr-2" aria-label="Default select example">
                        <option>November 2021</option>
                        <option>Desember 2021</option>
                        <option>Januari 2021</option>
                    </select>
                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                    <button type="button" class="btn btn-primary py-1 px-2 ml-auto">Submit</button>
                </div>
            </div>
            <div class="intro-y box mt-5 lg:mt-2">
                <div class="relative flex items-center p-5">
                    <h2 class="font-medium text-base mr-auto">Tambah Periode</h2>
                </div>
                <div class="p-5">
                    <input data-daterange="true" class="datepicker form-control w-56 block mx-auto">
                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                    <button type="button" class="btn btn-primary py-1 px-2 ml-auto">Save</button>
                </div>
            </div>
            <div class="intro-y box p-5 bg-theme-9 text-white mt-5">
                <div class="flex items-center">
                    <div class="font-medium text-lg">Peringatan</div>
                    <div class="text-xs bg-white dark:bg-theme-1 dark:text-white text-gray-800 px-1 rounded-md ml-auto">:)</div>
                </div>
                <div class="mt-4">Sebelum melakukan penggajian diharap untuk menambah data periode terlebih dahulu</div>
                <div class="font-medium flex mt-5">
                    <button type="button" class="btn py-1 px-2 border-white text-white dark:border-gray-700 dark:text-gray-300">Oke</button>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Daily Sales -->
                <div class="intro-y box col-span-12 xxl:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">Daily Sales</h2>
                        <div class="dropdown ml-auto sm:hidden">
                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false">
                                <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
                            </a>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="javascript:;" class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-secondary hidden sm:flex">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Excel
                        </button>
                    </div>
                    <div class="overflow-x-auto px-4 py-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nam Pegawai</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Jabatan</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Periode</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-b dark:border-dark-5">1</td>
                                    <td class="border-b dark:border-dark-5">Angelina</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">
                                        <a class="btn btn-warning w-24 inline-block mr-1 mb-2">
                                            <i data-feather="alert-circle" class="w-4 h-4 mr-2"></i>Detail</a>
                                        <a class="btn btn-primary w-24 inline-block mr-1 mb-2">
                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i>Print</a>
                                    </td>
                                </tr>
                               <tr>
                                    <td class="border-b dark:border-dark-5">1</td>
                                    <td class="border-b dark:border-dark-5">Angelina</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">
                                        <a class="btn btn-warning w-24 inline-block mr-1 mb-2">
                                            <i data-feather="alert-circle" class="w-4 h-4 mr-2"></i>Detail</a>
                                        <a class="btn btn-primary w-24 inline-block mr-1 mb-2">
                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i>Print</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b dark:border-dark-5">1</td>
                                    <td class="border-b dark:border-dark-5">Angelina</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">
                                        <a class="btn btn-warning w-24 inline-block mr-1 mb-2">
                                            <i data-feather="alert-circle" class="w-4 h-4 mr-2"></i>Detail</a>
                                        <a class="btn btn-primary w-24 inline-block mr-1 mb-2">
                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i>Print</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b dark:border-dark-5">1</td>
                                    <td class="border-b dark:border-dark-5">Angelina</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">Jolie</td>
                                    <td class="border-b dark:border-dark-5">
                                        <a class="btn btn-warning w-24 inline-block mr-1 mb-2">
                                            <i data-feather="alert-circle" class="w-4 h-4 mr-2"></i>Detail</a>
                                        <a class="btn btn-primary w-24 inline-block mr-1 mb-2">
                                            <i data-feather="printer" class="w-4 h-4 mr-2"></i>Print</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END: Daily Sales -->
            </div>
        </div>
    </div>
@endsection
