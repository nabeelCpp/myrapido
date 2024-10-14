@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Admins</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Region Assigned</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($admins))
                            @foreach ($admins as $k => $r)
                                <tr>
                                    <th scope="row">{{ $sn++ }}</th>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>
                                        @if ($r->regions()->count())
                                            <ul>
                                                @foreach ($r->regions as $reg)
                                                    <li> <a href="{{ route($guard . '.admins.edit', $reg->id) }}"
                                                            class="btn btn-link"> {{ $reg->name }} </a></li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $r->phone }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route($guard . '.admins.edit', $r->id) }}"
                                            class="btn btn-sm btn-sm-square btn-outline-info m-1" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{ route($guard . '.admins.destroy', $r->id) }}" method="POST"
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
                                <td colspan="7" align="center">No Record Found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $admins->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this Admin?")) {
                $('#delete-form-' + id).submit();
            }
        }
    </script>
@endsection
