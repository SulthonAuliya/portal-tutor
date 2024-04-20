@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card py-2 px-4 shadow bg-body rounded mt-3">
            <div class="row my-5 mx-4">
                <div class="col-12 col-md-9">
                    <h1 class="text-center text-md-start fw-bold primary-color" style="text-shadow: 1px 1px 5px #489dff9f !important">Tutoring Session Detail</h1>
                </div>
                <div class="col-12 col-md-3 text-end">
                    @if ($session->status === 2)
                    <a href="" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#listBuktiTutoring">Bukti Tutoring</a>
                    @endif
                </div>
                <div class="col-md-4 col-12 mb-3 mt-5">
                    <div class="card shadow-sm">
                        <img src="{!! $session->post->img_url !!}" class="bd-placeholder-img card-img-top" width="100%" height="225" role="img" aria-label="Placeholder: Thumbnail" alt="Post Image">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p class="card-text">{!! $session->post->title !!}</p>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{route('post.show', $session->post->id)}}" class="btn btn-sm btn-outline-secondary">View</a>
                                    </div>
                                    
                                </div>
                                <div class="col-12 mt-3 d-flex justify-content-between align-items-center">
                                    <small class="text-body-secondary badge">{{ $session->post->tipe }} | {{ $session->post->lokasi }}</small>
                                    <small class="text-body-secondary">{{ $session->post->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 offset-md-2 mt-5">
                    <div class="card">
                        <div class="row my-5 mx-md-3">
                            <div class="col-12 text-center">
                                <h3>Invitation Code</h3>
                            </div>
                            <div class="col-12 text-center my-3">
                                <h1 class="primary-color fw-bolder" style="text-shadow: 1px 1px 5px #489dff9f !important">{{$session->invitation_code}}</h1>
                            </div>
                            <div class="col-12">
                                <div class="row px-5">
                                    <div class="col-6">
                                        <h5 class="opacity-75">Tutor</h5>
                                        <hr>
                                        <a href="{{route("profile.index", ["user" => $session->post->user->id])}}"><h5 class="primary-color ">{{ $session->tutor->username}}</h5></a>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="opacity-75">Status</h5>
                                        <hr>
                                        <h5 class="primary-color ">
                                            @if ($session->status === 0)
                                            <span class="badge bg-secondary p-md-2 font-monospace">Belum Mulai</span>
                                            @elseif ($session->status === 1)
                                            <span class="badge bg-primary p-md-2 font-monospace">Sedang berjalan</span>
                                            @elseif ($session->status === 2)
                                            <span class="badge bg-success p-md-2 font-monospace">Selesai</span>
                                            @elseif ($session->status === 3)
                                            <span class="badge bg-danger p-md-2 font-monospace">Dibatalkan</span>
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="col-6 mt-4">
                                        <h5 class="opacity-75" >Start Time</h5>
                                        <hr>
                                        <h5 class="primary-color ">{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('d/m/Y') : '-' }} <br> {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i:s A') : '-' }}</h5>
                                    </div>
                                    <div class="col-6 mt-4">
                                        <h5 class="opacity-75">End Time</h5>
                                        <hr>
                                        <h5 class="primary-color ">{{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('d/m/Y') : '-' }} <br> {{ $session->end_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i:s A') : '-' }}</h5>
                                    </div>
                                    @if ($session->tutor_id === Auth::user()->id && Auth::user()->role === 'Tutor')
                                        <div class="col-12 mt-5 mt-md-2">
                                            @if ($session->status === 0)
                                            <a href="{{route('tutor.mulai', $session->id)}}" class="btn btn-primary w-100">Mulai Sesi Tutoring</a>
                                            @elseif ($session->status === 1)
                                            <a href="{{route('tutor.end', $session->id)}}" class="btn btn-success w-100">Selesaikan Sesi Tutoring</a>
                                            @endif
                                        </div>
                                        <div class="col-12 mt-1">
                                            @if ($session->status === 0)
                                            <a href="{{route('tutor.batal', $session->id)}}" class="btn btn-danger w-100"  onclick="return confirm('Are you sure you want to cancel this tutoring session?')">Batalkan Sesi Tutoring</a>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="col-12 mt-1">
                                            @if ($session->status === 2)
                                                @php
                                                    $bukti = $session->buktiTutor->where('user_id', Auth::user()->id)->first();
                                                    $buktiTutor = $bukti !== null;
                                                @endphp
                                                @if (!$buktiTutor)
                                                    <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#uploadBuktiModal" onclick="document.getElementById('tutorId').value = '{{ $session->id }}'">Upload Bukti Tutor</a>
                                                @else

                                                @endif
                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5">
                    <div class="table-container">
                        <table id="datatable" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Full Name</th>
                                    <th class="text-center">Waktu Bergabung</th>
                                    <th class="text-center">Status Kehadiran</th>
                                    <th class="text-center">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($session->pesertaTutor as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->user->full_name }}</td>
                                    <td>{{ $data->created_at->format('d/m/Y | H:i:s A') }}</td>
                                    <td class="text-center">
                                        @if ($data->status_kehadiran === 0 || $data->status_kehadiran === null)
                                        <span class="badge bg-secondary p-2 font-monospace" style="letter-spacing: 2px">-</span>
                                        @elseif ($data->status_kehadiran === 1)
                                            <span class="badge bg-success  p-2 font-monospace" style="letter-spacing: 2px">Hadir</span>
                                            @elseif ($data->status_kehadiran === 2)
                                            <span class="badge bg-warning p-2 font-monospace" style="letter-spacing: 2px">Sakit</span>
                                            @elseif ($data->status_kehadiran === 3)
                                            <span class="badge bg-primary p-2 font-monospace" style="letter-spacing: 2px">Izin</span>
                                            @endif    
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-primary " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-hover" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="{{route('profile.index', $data->user_id)}}">Detail</a></li>
                                                    @if (Auth::user()->role === 'Tutor')
                                                    <li><a class="dropdown-item bg-success text-light" href="{{route('tutor.kehadiran', ['peserta' => $data->id, 'status' => 1])}}">Hadir</a></li>
                                                    <li><a class="dropdown-item bg-warning text-light" href="{{route('tutor.kehadiran', ['peserta' => $data->id, 'status' => 2])}}">Sakit</a></li>
                                                    <li><a class="dropdown-item bg-primary text-light" href="{{route('tutor.kehadiran', ['peserta' => $data->id, 'status' => 3])}}">Izin</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>

        {{-- modal upload bukti tutoring --}}
        <div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-labelledby="uploadBuktiModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-lg"">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h3 class="modal-title text-center" id="uploadBuktiModalLabel">Upload Bukti Tutoring!</h3>
                    </div>
                    <div class="modal-body p-5">
                        <form id="uploadBuktiForm" method="POST" action="{{ route('tutor.uploadBuktiTutor') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tutor_id" id="tutorId">
                            <div class="row">
                                <div class="col-12">
                                    <label for="img_url" class="form-label">Upload Bukti Tutoring Session anda!</label>
                                    <input type="file" class="form-control" name="img_url" required>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" form="uploadBuktiForm" class="btn btn-primary w-100">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal list bukti tutoring --}}
        <div class="modal fade" id="listBuktiTutoring" tabindex="-1" aria-labelledby="listBuktiTutoringLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-lg"">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h3 class="modal-title text-center" id="listBuktiTutoringLabel">List Bukti Tutoring</h3>
                    </div>
                    <div class="modal-body p-5">
                        <div class="row">
                            <div class="col-12">
                                <table id="datatable2" class="table table-striped nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Full Name</th>
                                            <th class="text-center">Bukti Tutoring</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>{{ $session->tutor->full_name}} <b>({{$session->tutor->role}})</b></td>
                                            <td>
                                                {{-- @dd($session->buktiTutor) --}}
                                                @if (!$session->buktiTutor->where('user_id', $session->tutor_id)->isEmpty())
                                                    @php
                                                        $tutor = $session->buktiTutor->where('user_id', $session->tutor_id)->first();
                                                    @endphp
                                                    <a href="{{ $tutor->img_url ?? '#' }}" class="btn btn-primary" target="_blank">Sudah diupload</a>
                                                @else
                                                    Belum diupload
                                                @endif
                                            </td>
                                        </tr>
                                        @foreach ($peserta as $data)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 2 }}</td>
                                            <td>{{ $data->user->full_name }}</td>
                                            @php
                                                $buktiTutor = $buktiTutoring->get($data->user_id);
                                            @endphp
                                            <td>
                                                @if ($buktiTutor)
                                                    <a href="{{$buktiTutor->img_url}}" class="btn btn-primary" target="_blank">Sudah diupload</a>
                                                @else
                                                    <span class="btn btn-secondary disabled ">Belum diupload</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('addon-script')
<script>
        $('#datatable').DataTable( {
            responsive: true
        } );
        $('#datatable2').DataTable( {
            responsive: true
        } );
</script>
@endpush