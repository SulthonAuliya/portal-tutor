@extends('layouts.app')

@section('content')
    <div class="container">
        
             <!-- Main content -->
              <section class="content mx-4">
                <!-- /.container-fluid -->
                <div class="dashboard-content">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                @method('POST')
                                <div class="row p-3">

                                <div class="col-6 mt-3">
                                    <select name="bidang_id"  data-width="100%" id="select2-bidang-create" required>
                                        <option value=""></option>
                                    </select>
                                </div>

                                <div class="col-6 mt-3">
                                    <select name="category_id[]" data-width="100%" multiple="multiple" id="select2-category-create" required>
                                        <option value=""></option>
                                    </select>
                                </div>

                                <div class="col-12 mt-3">
                                  <div class="fowm-group">
                                    <label for="formFileLg" class="form-label">Upload Image</label>
                                    <input class="form-control form-control-lg" id="formFileLg" type="file" />
                                  </div>
                                </div>
                                
                                <div class="col-md-12 mt-3">
                                  <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control">
                                  </div>
                                </div>

                              <div class="col-6 mt-3">
                                  <label for="tipe" class="form-label">Tipe Tutoring</label>
                                  <select name="tipe"  data-width="100%" class="form-select" required>
                                      <option value="">Select Tipe Tutoring</option>
                                      <option value="online">Onlie</option>
                                      <option value="offline">Offline</option>
                                      <option value="both">Both</option>
                                  </select>
                              </div>

                              <div class="col-6 mt-3">
                                    <label for="tipe" class="form-label">Lokasi Tutoring</label>
                                    <select name="lokasi"  data-width="100%" id="select2-kota-create" required>
                                        <option value=""></option>
                                        <option value="0">Select Kota</option>
                                    </select>
                              </div>

                                <div class="col-md-12 mt-3">
                                  <div class="form-group">
                                    <label for="">Deskripsi Course</label>
                                    <textarea name="deskripsi" class="form-control" id="editor" required></textarea>
                                  </div>
                                </div>
                                @error('deskripsi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                </div>
                                <div class="row pr-3">
                                  <div class="col text-right">
                                      <button type="submit" class="btn-color mb-3 p-2 px-4 border border-0">
                                        Tambah
                                      </button>
                                  </div>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </section>
        
    </div>
@endsection

@push('addon-script')
  <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('editor');
      $(document).ready(function() {
            // Function to populate Select2 with categories
            function populateCategories2(bidangId = null) {
                $.ajax({
                    url: "{{ route('ajax.get-categories') }}",
                    type: "GET",
                    data: {
                        bidangId: bidangId // Pass selected bidang ID
                    },
                    success: function(data) {
                        // Clear existing options
                        $('#select2-category-create').empty();

                        // Populate Select2 with new options
                        $.each(data, function(index, option) {
                            $('#select2-category-create').append('<option value="' + option.id + '">' + option.name + '</option>');
                        });

                        // Reinitialize Select2
                        $('#select2-category-create').select2({
                            placeholder: "Search Categories"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Function to populate Select2 with bidang
            function populateBidang2() {
                $.ajax({
                    url: "{{ route('ajax.get-bidang') }}",
                    type: "GET",
                    success: function(data) {
                        // Clear existing options
                        $('#select2-bidang-create').empty();

                        // Populate Select2 with new options
                        $.each(data, function(index, option) {
                            $('#select2-bidang-create').append('<option value="' + option.id + '">' + option.name + '</option>');
                        });

                        // Reinitialize Select2
                        $('#select2-bidang-create').select2({
                            placeholder: "Select Bidang"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Function to populate Select2 with bidang
            function populateKota2() {
                $.ajax({
                    url: "{{ route('ajax.get-kota') }}",
                    type: "GET",
                    success: function(data) {
                        // Clear existing options
                        $('#select2-kota-create').empty();

                        // Populate Select2 with new options
                        $.each(data, function(index, option) {
                            $('#select2-kota-create').append('<option value="' + option.id + '">' + option.name + '</option>');
                        });

                        // Reinitialize Select2
                        $('#select2-kota-create').select2({
                            placeholder: "Search Kota"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Initialize Select2 for kota  dropdown
            $('#select2-kota-create').select2({
                placeholder: "Search Kota"
                
            });
            
            // Initialize Select2 for bidang dropdown
            $('#select2-bidang-create').select2({
                placeholder: "Select Bidang"
                
            });

            // Initialize Select2 for categories dropdown
            $('#select2-category-create').select2({
                placeholder: "Search Categories",
            });

            // Event listener for change in bidang dropdown
            $('#select2-bidang-create').on('change', function() {
                var selectedBidangId = $(this).val();
                populateCategories(selectedBidangId);
            });

            // Populate bidang and categories initially
            populateKota2();
            populateBidang2();
            populateCategories2();
      });
  </script>
@endpush