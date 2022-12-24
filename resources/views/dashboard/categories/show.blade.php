@extends('layouts.dashboard')

@section('header', 'Category Product')

@section('breadcrum')
    @parent
    <li class="breadcrumb-item active">Starter Page</li>
@stop

@section('content')

    <table class="table">
        <thead>
            <tr>
                <th>product name</th>
                <th>product store</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($category_products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store_name }}</td>
                </tr>
            @empty
              <tr>
                <td colspan="2">No Products</td>
              </tr>
            @endforelse
        </tbody>
    </table>
@stop

@push('scripts')
@endpush
