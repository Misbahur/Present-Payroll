@extends('../layout/' . $layout)

@section('subhead')
<title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Settings</h2>
</div>
<!-- component -->
<div class="w-full mx-auto mt-4  rounded">
    <!-- Tabs -->
    <ul id="tabs" class="inline-flex w-full px-1 pt-2 ">
        <li class="px-4 py-2 -mb-px font-semibold text-xl text-gray-600 border-b-2 rounded-t"><a id="default-tab"
                href="#first">General</a></li>
        <li class="px-4 py-2 font-semibold text-xl text-gray-600 rounded-t opacity-50"><a href="#second">Waktu</a>
        </li>
        {{-- <li class="px-4 py-2 font-semibold text-xl text-gray-600 rounded-t opacity-50"><a href="#third">Electronics</a>
        </li>
        <li class="px-4 py-2 font-semibold text-xl text-gray-600 rounded-t opacity-50"><a href="#fourth">Others</a></li> --}}
    </ul>

    <!-- Tab Contents -->
    <div id="tab-contents">
        <div class="p-4" id="first">
            <h5 class="mb-0 mt-3 text-base font-medium">General Settings</h5>
            <p class="text-sm italic">Pengaturan dasar anda ada di sini.</p>
            <ul class="list-none w-1/2 py-4">
                @foreach ($settings as $item)
                    
                <li class="bg-white dark:bg-gray-300 p-4 border-b-2">
                    <div class="intro-y block sm:flex items-center h-10">
                        <div class="truncate mr-5">
                            <h3 class="text-base font-medium">{{ $item->name }}</h3>
                            <span class="text-base font-light italic">{{ $item->value }}</span>
                        </div>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <a href="{{ route('setting-edit', $item->id) }}" class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="navigation" class="hidden sm:block w-6 h-6 mr-2"></i>
                            </a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div id="second" class="hidden p-4">
            <h5 class="mb-0 mt-3 text-base font-medium">Jam Kerja Kantor</h5>
            <p class="text-sm italic">Pengaturan tanggal dan waktu ada disini.</p>
            <ul class="list-none w-1/2 py-4">
                @foreach ($jams as $item)
                    
                <li class="bg-white dark:bg-gray-300 p-4 border-b-2">
                    <div class="intro-y block sm:flex items-center h-10">
                        <div class="truncate mr-5">
                            <h3 class="text-base font-medium">{{ $item->name }}</h3>
                            <span class="text-base font-light italic">{{ $item->value }}</span>
                        </div>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="navigation" class="hidden sm:block w-6 h-6 mr-2"></i>
                            </button>
                        </div>
                    </div>
                </li>
                @endforeach

            </ul>
        </div>
        {{-- <div id="third" class="hidden p-4">
            <h5 class="mb-0 mt-3 text-lg font-medium">General Settings</h5>
            <p class="text-base italic">Pengaturan dasar anda ada di sini.</p>
            <ul class="list-none w-1/2 py-4">
                <li class="bg-white dark:bg-gray-300 p-4">
                    <div class="intro-y block sm:flex items-center h-10">
                        <div class="truncate mr-5">
                            <h2 class="text-lg font-medium">Daftar item</h2>
                            <span class="text-base font-light italic">hai</span>
                        </div>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="navigation" class="hidden sm:block w-6 h-6 mr-2"></i>
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div id="fourth" class="hidden p-4">
           <h5 class="mb-0 mt-3 text-lg font-medium">General Settings</h5>
            <p class="text-base italic">Pengaturan dasar anda ada di sini.</p>
            <ul class="list-none w-1/2 py-4">
                <li class="bg-white dark:bg-gray-300 p-4">
                    <div class="intro-y block sm:flex items-center h-10">
                        <div class="truncate mr-5">
                            <h2 class="text-lg font-medium">Daftar item</h2>
                            <span class="text-base font-light italic">hai</span>
                        </div>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button class="ml-3 btn box flex items-center text-gray-700 dark:text-gray-300">
                                <i data-feather="navigation" class="hidden sm:block w-6 h-6 mr-2"></i>
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div> --}}
    </div>
</div>

<script>
    let tabsContainer = document.querySelector("#tabs");

    let tabTogglers = tabsContainer.querySelectorAll("a");
    console.log(tabTogglers);

    tabTogglers.forEach(function (toggler) {
        toggler.addEventListener("click", function (e) {
            e.preventDefault();

            let tabName = this.getAttribute("href");

            let tabContents = document.querySelector("#tab-contents");

            for (let i = 0; i < tabContents.children.length; i++) {

                tabTogglers[i].parentElement.classList.remove("border-blue-400", "border-b", "-mb-px",
                    "opacity-100");
                tabContents.children[i].classList.remove("hidden");
                if ("#" + tabContents.children[i].id === tabName) {
                    continue;
                }
                tabContents.children[i].classList.add("hidden");

            }
            e.target.parentElement.classList.add("border-blue-400", "border-b-4", "-mb-px",
                "opacity-100");
        });
    });

    document.getElementById("default-tab").click();

</script>
@endsection