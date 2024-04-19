@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card py-2 px-4 shadow bg-body rounded">
            <div class="row my-5 mx-4">
                <div class="col-12">
                    <h1 class="text-center text-md-start fw-bold primary-color" style="text-shadow: 1px 1px 5px #489dff9f !important">Tutoring Session Detail</h1>
                </div>
                <div class="col-md-4 col-12 mb-3 mt-5">
                    <div class="card shadow-sm">
                        <img src="{!! $session->post->img_url !!}" class="bd-placeholder-img card-img-top" width="100%" height="225" role="img" aria-label="Placeholder: Thumbnail" alt="Post Image">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <p class="card-text">{!! $session->post->title !!}</p>
                                </div>
                                <div class="col-2">
                                    <a href="{{route("profile.index", ["user" => $session->post->user->id])}}">
                                        <img src="{!! $session->post->user->profile_pic !!}" class="rounded-circle profile-pic img-fluid" alt="Avatar" />
                                    </a>
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
                                        <h5 class="primary-color ">{{ $session->tutor->username}}</h5>
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
                                        <h5 class="primary-color ">{{ $session->start_time ? $session->start_time->format('d/m/Y') : '-' }}</h5>
                                    </div>
                                    <div class="col-6 mt-4">
                                        <h5 class="opacity-75">End Time</h5>
                                        <hr>
                                        <h5 class="primary-color ">{{ $session->end_time ? $session->end_time->format('d/m/Y') : '-' }}</h5>
                                    </div>
                                    <div class="col-12 mt-5 mt-md-2">
                                        @if ($session->status === 0)
                                            <a href="#" class="btn btn-primary w-100">Mulai Sesi Tutoring</a>
                                        @elseif ($session->status === 1)
                                            <a href="#" class="btn btn-success w-100">Selesaikan Sesi Tutoring</a>
                                        @endif
                                    </div>
                                    <div class="col-12 mt-1">
                                        @if ($session->status === 0)
                                            <a href="#" class="btn btn-danger w-100">Batalkan Sesi Tutoring</a>
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
                                                    <li><a class="dropdown-item" href="{{route('profile.index', $data->id)}}">Detail</a></li>
                                                    @if (Auth::user()->role === 'Tutor')
                                                    <li><a class="dropdown-item bg-success text-light" href="#">Hadir</a></li>
                                                    <li><a class="dropdown-item bg-warning text-light" href="#">Sakit</a></li>
                                                    <li><a class="dropdown-item bg-primary text-light" href="#">Izin</a></li>
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
    </div>
@endsection
@push('addon-script')
<script>
        $('#datatable').DataTable( {
            responsive: true
        } );
</script>
@endpush