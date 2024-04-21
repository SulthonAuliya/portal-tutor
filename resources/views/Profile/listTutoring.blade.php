@extends('layouts.app')

@section('content')
    <div class="container mb-5 mt-5">
        <div class="card card-table p-3 shadow mb-5 bg-body rounded">
            <h1 class="text-center fw-bold text-primary" style="text-shadow: 1px 1px 3px #489dff9f !important">History Tutoring Session {{$user->full_name}}</h1>
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
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">Start date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$user->tutoring->isEmpty())  
                                @foreach ($user->tutoring as $tutor)  
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $tutor->post->title }}</td>
                                    <td class="text-center">{{ $tutor->created_at->format('d/m/Y')}}</td>
                                    <td class="text-center">{{ $tutor->start_time ? \Carbon\Carbon::parse($tutor->start_time)->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">{{ $tutor->end_time ? \Carbon\Carbon::parse($tutor->end_time)->format('d/m/Y') : '-' }}</td>
                                    
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-hover" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="{{route('tutor.detail', $tutor->id)}}">Detail</a></li>
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
        
    </div>
@endsection
@push('addon-script')
<script>
        $('#datatable').DataTable( {
            responsive: true
        } );
</script>
@endpush
    