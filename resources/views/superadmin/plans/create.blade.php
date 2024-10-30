@extends('layouts.app')
@php
    $plan = $plan ?? null
@endphp
@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4"> @if ($plan) Update @else Create @endif Plan</h6>
        <form action="@if($plan){{ route($guard.'.plans.update', $plan->id) }}@else{{ route($guard.'.plans.store') }} @endif" method="post">
            @if ($plan)
                @method('put')
            @endif
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="title" placeholder="Title *" name="title" value="{{ old('title') ?? ($plan->title ?? '') }}">
                <label for="title">Title *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="sub_title" placeholder="Sub Title *" name="sub_title" value="{{ old('sub_title') ?? ($plan->sub_title ?? '') }}">
                <label for="name">Sub Title *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" min="0" class="form-control" id="job_fee" placeholder="Job Fee (%) *" name="job_fee" value="{{ old('job_fee') ?? ($plan->job_fee ?? '') }}">
                <label for="name">Job Fee (%) *</label>
            </div>
            <div class="col-sm-12 col-xl-12 border-top">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Plan Prices</h6>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Duration</th>
                                @foreach ($vehicles as $item)
                                    <th scope="col">{{$item['name'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plan_prices_duration as $item)
                                <tr>
                                    <th scope="row">{{ $item['title'] }}</th>
                                    @foreach ($vehicles as $v)
                                        <td>
                                            @foreach ($currencies as $cur)
                                                <div class="form-floating mb-1">
                                                    <input type="number" class="form-control" placeholder="Price ({{$cur['name']}})" min="0" name="price[{{$item['id']}}][{{$v['id']}}][{{$cur['id']}}]" value="{{ old('price.'.$item['id'].'.'.$v['id'].'.'.$cur['id']) ?? ($plan_prices[$item['id']][$v['id']][$cur['id']] ?? '') }}" id="price_{{$item['id']}}_{{$v['id']}}_{{$cur['id']}}">
                                                    <label for="price_{{$item['id']}}_{{$v['id']}}_{{$cur['id']}}">Price ({{$cur['name']}})</label>
                                                </div>
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea name="description" id="description" style="height: 150px" class="form-control" placeholder="Description *">{{ old('description') ?? ($plan->description ?? '') }}</textarea>
                <label for="description">Description *</label>
            </div>
            <div class="form-check form-switch pull-right">
                <input class="form-check-input" type="checkbox" role="switch" id="status" checked="">
                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" {{ old('status') ? 'checked' : (isset($plan->status) && $plan->status ? 'checked' : '') }}>

                <label class="form-check-label" for="status">Status</label>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end py-2">
                <button class="btn btn-primary"> @if ($plan) Update @else Save @endif </button>
            </div>
        </form>
    </div>
@endsection
