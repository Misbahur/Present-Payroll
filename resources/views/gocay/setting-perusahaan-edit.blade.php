@extends('../layout/' . $layout)

@section('subhead')
<title>Sistem Present & Payrol Gocay</title>
@endsection

@section('subcontent')
<!-- component -->
<div class="w-full mx-auto mt-4 rounded">
    <div class="bg-white w-full shadow rounded p-8 sm:p-12 -mt-72">
            <p class="text-3xl font-bold leading-7 text-center">Setting Edit</p>
            <form method="POST" action="{{ route('setting-update', $setting->id) }}">
                @csrf
                <div class="md:flex items-center mt-12">
                    <div class="w-1/5 md:w-1/2 flex flex-col px-3">
                        <label class="font-semibold leading-none">Name</label>
                        <input disabled name="name" type="text" value="{{ $setting->name }}" class="form-control leading-none text-gray-900 p-3 focus:outline-none focus:border-blue-700 mt-4 border rounded border-gray-200" />
                    </div>
                    <div class="w-4/5 md:w-1/2 flex flex-col">
                        <label class="font-semibold leading-none">Value</label>
                        <input name="value" type="text" value="{{ $setting->value }}" class="form-control p-3 mt-4 rounded" />
                    </div>
                </div>
                <div class="flex items-center justify-center w-full mt-4">
                    <input type="text" name="name" hidden value="{{ $setting->name }}">
                    <a href={{ route('setting-perusahaan') }} class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                </div>
            </form>
        </div>
</div>
@endsection