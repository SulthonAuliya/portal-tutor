@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <main class="card mt-5">
            <section class="container-fluid">
              <div class="row py-lg-5">
                <div class="col-lg-8 col-md-8 mx-auto">
                    <div class="text-center">
                        <h1>Edit Preferences</h1><br>
                    </div>
                  <form action="{{route('profile.updatePreferences',  ['user' => $user->id])}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row p-3">
                        
                            <div class="col-6 mt-3">
                                <label for="bidang_id" class="form-label">Pilih bidang anda</label>
                                <select name="bidang_id[]"  data-width="100%" multiple="multiple" id="select2-bidang-preference" >
                                    <option value="">Select Bidang</option>
                                    @foreach ($bidangs as $bidang)
                                        <option value="{{ $bidang->id }}"  @if (in_array($bidang->id, $selectedBidangs)) selected @endif>{{ $bidang->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="bidang_id" class="form-label">Pilih kategori yang anda minati</label>
                                <select name="category_id[]" data-width="100%" multiple="multiple" id="select2-category-preference" >
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if (in_array($category->id, $selectedCategories)) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="content_settings" class="form-label">Content Preferences (* Setting ini akan mengatur bagaimana konten ditampilkan di beranda anda! <span><b>tidak berpengaruh pada hasil pencarian</b></span>)</label>
                                    <select class="form-control" name="content_settings" id="select2-setting">
                                        <option value="0" {{ $user->content_settings == '0' ? 'selected' : '' }}>Tampilkan semua</option>
                                        <option value="1" {{ $user->content_settings == '1' ? 'selected' : '' }}>Tampilkan konten yang sesuai dengan bidang saya saja</option>
                                        <option value="2" {{ $user->content_settings == '2' ? 'selected' : '' }}>Tampilkan konten yang sesuai dengan bidang dan kategori yang saya pilih</option>
                                    </select>
                                </div>
                            </div>
                            @error('content_setting')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            {{-- <div class="row"> --}}
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-success w-100 mb-3 p-2 px-4 border border-0">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </section>
          
          </main>
    </div>
@endsection
@push('addon-script')
<script>
$(document).ready(function() {

        $('#select2-bidang-preference').select2({
            placeholder: "Select Bidang"
        });
        $('#select2-category-preference').select2({
            placeholder: "Search Categories"
        });
        $('#select2-setting').select2();
        
});
</script>
@endpush

    