@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <main class="card mt-5">
            <section class="container-fluid">
              <div class="row py-lg-5">
                <div class="col-lg-8 col-md-8 mx-auto">
                    <div class="text-center">
                        <h1>Edit Profile</h1><br>
                        <h5>Current Profile Picture (*will be changed once saved)</h5>
                        <img src="{!! $user->profile_pic !!}" class="rounded-circle profile-pic" alt="Avatar" />
                    </div>
                  <form action="{{route('profile.update',  ['user' => $user->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row p-3">

                        <div class="col-12 mt-3">
                            <div class="fowm-group">
                                <label for="formFileLg" class="form-label">Upload Image</label>
                                <input class="form-control form-control-lg" id="formFileLg" name="profile_pic" type="file" />
                                <input type="hidden" name="old_image" value="{{ $user->profile_pic }}">
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="{{$user->username}}" required>
                            </div>
                        </div>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" value="{{$user->email}}" required>
                            </div>
                        </div>
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="full_name" class="form-label">Full name</label>
                                <input type="text" name="full_name" class="form-control" value="{{$user->full_name}}" required>
                            </div>
                        </div>
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" value="{{$user->phone_number}}" >
                            </div>
                        </div>
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" name="city" class="form-control" value="{{$user->city}}" >
                            </div>
                        </div>
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="description">Deskripsi Course</label>
                                <textarea name="description" class="form-control" id="editor">{{ $user->description }}</textarea>
                            </div>
                        </div>
                        @error('deskripsi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        {{-- <hr class="my-5">
                        <h3>Edit Social medias</h3> --}}
                        {{-- <div class="col-md-12 mt-5">
                            @foreach (['instagram', 'line', 'whatsapp', 'website', 'linkedin', 'custom'] as $type)
                                <div class="row">
                                    <div class="col-12">
                                        <label for="{{ ucfirst($type) }}" class="form-label">{{ ucfirst($type) }}</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name_{{ $type }}" class="form-label">Name</label>
                                            <input type="text" name="sosmed[{{ $type }}][name]" id="name_{{ $type }}" class="form-control" value="{{ $user->sosmed->where('type', $type)->first()->name ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="link_{{ $type }}" class="form-label">Link</label>
                                            <input type="text" name="sosmed[{{ $type }}][link]" id="link_{{ $type }}" class="form-control" value="{{ $user->sosmed->where('type', $type)->first()->link ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div> --}}
                        <div class="col-md-12 mt-5">
                            <!-- Loop through existing SOSMED records -->
                            <div class="col-12">
                                <label class="form-label">Social Media</label>
                            </div>
                            @foreach ($user->sosmed as $sosmed)
                            <div class="card p-3 mb-3">
                            <div class="row mt-3">
                                    <div class="col-2">
                                        <div class="form-group mt-2">
                                            <label class="form-label">Type</label>
                                            <select class="form-control" name="sosmed[{{ $loop->index }}][type]">
                                                <option value="instagram" {{ $sosmed->type == 'instagram' ? 'selected' : '' }}>Instagram</option>
                                                <option value="line" {{ $sosmed->type == 'line' ? 'selected' : '' }}>Line</option>
                                                <option value="whatsapp" {{ $sosmed->type == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                                <option value="linkedin" {{ $sosmed->type == 'linkedin' ? 'selected' : '' }}>Linkedin</option>
                                                <option value="website" {{ $sosmed->type == 'website' ? 'selected' : '' }}>Website</option>
                                                <option value="custom" {{ $sosmed->type == 'custom' ? 'selected' : '' }}>Custom</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group mt-2">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="sosmed[{{ $loop->index }}][name]" value="{{ $sosmed->name }}">
                                            <input type="hidden" class="form-control" name="sosmed[{{ $loop->index }}][id]" value="{{ $sosmed->id }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mt-2">
                                            <label class="form-label">Link</label>
                                            <input type="text" class="form-control" name="sosmed[{{ $loop->index }}][link]" value="{{ $sosmed->link }}">
                                        </div>
                                    </div>
                            </div>
                        </div>
                            @endforeach
                            <div class="col-md-12 mt-5" id="sosmed-container">
                                <!-- Existing SOSMED records will be displayed here -->
                            </div>
                        </div>
                    
                        <!-- Add SOSMED Button -->
                        <div class="col-12 text-right d-flex justify-content-end mb-5 mt-2">
                            <button type="button" class="btn btn-primary" id="add-sosmed-btn">Add +</button>
                        </div>
                        
                        <!-- SOSMED Template (Hidden) -->

                        {{-- <div class="row"> --}}
                        <div class="col-12 ">
                            <button type="submit" class="btn btn-success w-100 mb-3 p-2 px-4 border border-0">
                                Save
                            </button>
                        </div>
                        {{-- </div> --}}
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
    // Add SOSMED Button Event Listener
    $('#add-sosmed-btn').on('click', function() {
        // Create SOSMED template
        let sosmedTemplate = $('<div>').addClass('card p-3 mb-3')
            .append($('<div>').addClass('row')
                .append($('<div>').addClass('col-2').append(
                    $('<div>').addClass('form-group').append(
                        $('<label>').addClass('form-label').text('Type'),
                        $('<select>').addClass('form-control type-select').attr('name', 'sosmed[][type]').append(
                            $('<option>').attr('value', 'instagram').text('Instagram'),
                            $('<option>').attr('value', 'line').text('Line'),
                            $('<option>').attr('value', 'whatsapp').text('WhatsApp'),
                            $('<option>').attr('value', 'linkedin').text('Linkedin'),
                            $('<option>').attr('value', 'website').text('Website'),
                            $('<option>').attr('value', 'custom').text('Custom')
                        )
                    )
                ))
                .append($('<div>').addClass('col-4').append(
                    $('<div>').addClass('form-group').append(
                        $('<label>').addClass('form-label').text('Name'),
                        $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'sosmed[][name]')
                    )
                ))
                .append($('<div>').addClass('col-6').append(
                    $('<div>').addClass('form-group').append(
                        $('<label>').addClass('form-label').text('Link'),
                        $('<input>').attr('type', 'text').addClass('form-control').attr('name', 'sosmed[][link]')
                    )
                ))
            );

        // Append SOSMED template to container
        $('#sosmed-container').append(sosmedTemplate);
    });

    // Adjust SOSMED indexes before form submission
    $('form').submit(function() {
        // Loop through all SOSMED inputs
        $('[name^="sosmed"]').each(function(index) {
            // Find all inputs within the current SOSMED group
            let inputs = $(this).closest('.card').find('input, select');
            // Update name attribute with the correct index for each input
            inputs.each(function() {
                let newName = $(this).attr('name').replace(/\[\]/, `[${index}]`);
                $(this).attr('name', newName);
            });
        });
    });
});


</script>
@endpush
    