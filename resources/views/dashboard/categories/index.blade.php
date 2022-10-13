@extends('layouts.dashboard')

@section('header' , 'osid')

@section('breadcrum')
    @parent
    <li class="breadcrumb-item active">Starter Page</li>
@stop

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Category id</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
            <th>operation</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td></td>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('categories.edit' , [$categories->id])}}" class="btn btn-sm btn-outline-success"></a>
                    <!-- /.btn btn-sm btn-outline-success -->
                </td>
                <form action="{{route('categories.destroy' , [$categories->id])}}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                    <!-- /.btn btn-sm btn-outline-danger -->
                </form>
            </tr>
        @empty
            <tr>
                <td colspan="7">No Categories Defined</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <!-- /.table -->

    <!-- /.row -->
@stop


{{--
   @push('style')
       <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
   @endpush
   --}}

{{-- append to style not override
    @push('style')
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}></script>
    @endpush
--}}

@push('scripts')

@endpush
