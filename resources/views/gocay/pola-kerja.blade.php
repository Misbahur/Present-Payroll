@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Pola Kerja Karyawan</h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button class="btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                            </button>
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button>
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">ID</th>
                                    <th class="text-center whitespace-nowrap">Jadwal</th>
                                    <th class="text-center whitespace-nowrap">Jam Masuk</th>
                                    <th class="text-center whitespace-nowrap">Jam Pulang</th>
                                    <th class="text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (array_slice($fakers, 0, 4) as $faker)
                                    <tr class="intro-x">
                                        <td class="w-40">
                                        {{ $faker['stocks'][0] }}
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $faker['products'][0]['name'] }}</a>
                                            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $faker['products'][0]['category'] }}</div>
                                        </td>
                                        <td class="w-40 text-center">
                                        {{ $faker['stocks'][0] }}
                                        </td>
                                        <td class="w-40 text-center">
                                        {{ $faker['stocks'][0] }}
                                        </td>
                                        <!-- <td class="text-center">
                                            <a href="" class="font-medium whitespace-nowrap">{{ $faker['products'][0]['name'] }}</a>
                                            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $faker['products'][0]['category'] }}</div>
                                        </td> -->
                                        <!-- <td class="w-40">
                                            <div class="flex items-center justify-center {{ $faker['true_false'][0] ? 'text-theme-9' : 'text-theme-6' }}">
                                                <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ $faker['true_false'][0] ? 'Active' : 'Inactive' }}
                                            </div>
                                        </td> -->
                                        <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3" href="">
                                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                                </a>
                                                <a class="flex items-center text-theme-6" href="">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        
    </div>
@endsection
