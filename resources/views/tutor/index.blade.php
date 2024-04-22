@extends('layouts.app')

@section('content')
    <div class="container mb-5 mt-5">
        <div class="card card-table p-3 shadow mb-5 bg-body rounded">
            <h1 class="text-center fw-bold">Manage Tutoring Session</h1>
            <div class="row">
                <div class="col-12">
                    
                </div>
                <div class="col-12 mt-3">
                    <div class="table-container">
                        <table id="datatable" class="table table-striped nowrap" style="width: 100%">
                            <thead>
                                
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Invitation Code</th>
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">Start date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tutors) > 0)  
                                @foreach ($tutors as $tutor)  
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $tutor->post->title }}</td>
                                    <td class="text-center"><span class="fw-bolder" style="color: #5D8BFF; letter-spacing: 2px">{{ $tutor->invitation_code}}</span></td>
                                    <td class="text-center">{{ $tutor->created_at->format('d/m/Y')}}</td>
                                    <td class="text-center">{{ $tutor->start_time ? \Carbon\Carbon::parse($tutor->start_time)->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">{{ $tutor->end_time ? \Carbon\Carbon::parse($tutor->end_time)->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">
                                        @if ($tutor->status === 0 || $tutor->status === null)
                                        <span class="badge bg-secondary p-2 font-monospace" style="letter-spacing: 2px">Belum Mulai</span>
                                        @elseif ($tutor->status === 1)
                                        <span class="badge bg-primary p-2 font-monospace" style="letter-spacing: 2px">Sedang berjalan</span>
                                        @elseif ($tutor->status === 2)
                                        <span class="badge bg-success p-2 font-monospace" style="letter-spacing: 2px">Selesai</span>
                                        @elseif ($tutor->status === 3)
                                        <span class="badge bg-danger p-2 font-monospace" style="letter-spacing: 2px">Dibatalkan</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-hover" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="{{route('tutor.detail', $tutor->id)}}">Detail</a></li>
                                                @if (Auth::user()->role === 'Tutor')
                                                    @if ($tutor->status === 2)
                                                        @if ($tutor->buktiTutor->where('user_id', Auth::user()->id)->isEmpty())
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#uploadBuktiModal" onclick="document.getElementById('tutorId').value = '{{ $tutor->id }}'">Upload Bukti Tutor</a></li>
                                                        @endif
                                                    @endif
                                                    @if ($tutor->status != 3 && $tutor->status != 2)
                                                        <li><a class="dropdown-item" href="{{route('tutor.batal', $tutor->id)}}" onclick="return confirm('Are you sure you want to cancel this tutoring session?')">Batalkan</a></li>
                                                    @endif
                                                <li><a class="dropdown-item" href="{{route('tutor.delete', $tutor->id)}}"  onclick="return confirm('Are you sure you want to delete this tutoring session?')">Delete</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data tutoring session!</td>
                                </tr>
                                @endif
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
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
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
                            <!-- Other form elements for uploading bukti tutor if needed -->
                        </form>
                    </div>
                    {{-- <div class="modal-footer"> --}}
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        
    </div>
@endsection
@push('addon-script')
<script>
    @if (count($tutors) > 0)
        $('#datatable').DataTable( {
            responsive: true
        } );
    @endif
</script>
@endpush
    