@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Regions</h6>
                <a href="{{ route($guard.'.regions.create') }}" class="btn btn-outline-success"><i
                        class="fa fa-plus-circle"></i> Add</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Region Name</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <th scope="col">Country</th>
                            <th scope="col">Assigned To</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($regions))
                            @foreach ($regions as $k => $r)
                                <tr>
                                    <th scope="row">{{ $sn++ }}</th>
                                    <td>
                                        {{ $r->name }}
                                        <p class="small">
                                            <strong>Address:</strong> {{ $r->address }}<br>
                                            <strong>Phone:</strong> {{ $r->phone }}<br>
                                            <strong>Currency:</strong> {{ $currencies[$r->currency_id]['name'] }}
                                        </p>
                                    </td>
                                    <td>{{ $r->city->name }}</td>
                                    <td>{{ $r->city->state->name }}</td>
                                    <td>{{ $r->city->state->country->name }}</td>
                                    <td>{{ $r->admin ? $r->admin->name : '-' }}</td>
                                    <td>@if($r->status) <span class="badge bg-success">Enabled</span> @else <span class="badge bg-danger">Disabled</span> @endif</td>
                                    <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route($guard.'.regions.edit', $r->id) }}"
                                            class="btn btn-sm btn-sm-square btn-outline-info m-1" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{ route($guard.'.regions.destroy', $r->id) }}" method="POST"
                                            class="d-inline delete-form" id="delete-form-{{ $r->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <a type="button" class="btn btn-sm btn-sm-square btn-outline-danger"
                                                onclick="confirmDelete({{ $r->id }})" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" align="center">No Regions Found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $regions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this region?")) {
                $('#delete-form-' + id).submit();
            }
        }
    </script>
@endsection
