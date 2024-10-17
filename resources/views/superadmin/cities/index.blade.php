@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">{{$title}}</h6>
                <a class="btn btn-outline-success" href="{{ route("$guard.$route.create") }}"><i class="fa fa-plus-circle"></i> Add</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">State</th>
                            <th scope="col">Country</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($records))
                            @foreach ($records as $k => $r)
                                <tr>
                                    <th scope="row">{{ $k+1 }}</th>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->state->name }}</td>
                                    <td>{{ $r->state->country->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route("$guard.$route.edit", $r->id) }}"
                                            class="btn btn-sm btn-sm-square btn-outline-info m-1" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        {{-- <a href="{{ route("$guard.$route.show", $r->id) }}"
                                                    class="btn btn-sm btn-sm-square btn-outline-info m-1" title="View"><i
                                                        class="fa fa-eye"></i></a> --}}
                                        <form action="{{ route("$guard.$route.destroy", $r->id) }}" method="POST"
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
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this City?")) {
                $('#delete-form-' + id).submit();
            }
        }
    </script>
@endsection
