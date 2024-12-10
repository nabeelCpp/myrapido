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
                        <th scope="col">Phone</th>
                        <th scope="col">NIC/Akama</th>
                        <th scope="col">License Number</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($drivers))
                        @foreach ($drivers as $k => $r)
                            <tr>
                                <th scope="row">{{ $k+1 }}</th>
                                <td>{{ $r->name }}<br><small class="text-muted">{{ $r->gender }}</small></td>
                                <td>{{ $r->phone }}</td>
                                <td>{{ $r->nic }}</td>
                                <td>{{ $r->license_number }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" data-id="{{$r->id}}" data-status="{{$r->status}}" onchange="changeStatus(this)" id="flexSwitchCheckChecked{{$r->id}}" @if($r->status) checked="" @endif></td>
                                    </div>

                                <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route("$guard.$route.edit", $r->id) }}"
                                        class="btn btn-sm btn-sm-square btn-outline-info m-1" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ route("$guard.$route.show", $r->id) }}"
                                                class="btn btn-sm btn-sm-square btn-outline-info m-1" title="View"><i
                                                    class="fa fa-eye"></i></a>
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
                            <td colspan="8" align="center">No Record Found!</td>
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
            if (confirm("Are you sure you want to delete this Driver?")) {
                $('#delete-form-' + id).submit();
            }
        }

        const changeStatus = (_this) => {
            let id = $(_this).data('id');
            let status = $(_this).data('status');
            $.ajax({
                url: `drivers/${id}/changeStatus`,
                type: "POST",
                data: {
                    status: status
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    </script>
@endsection
