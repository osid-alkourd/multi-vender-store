@extends('layouts.dashboard')

@section('header' , 'categories')

@section('breadcrum')
    @parent
    <li class="breadcrumb-item active">Starter Page</li>
@stop

@section('content')
    <div class="mb-5">
        <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
        <!-- /.btn btn-sm btn-outline-primary -->
    </div>
    <!-- /.mb-5 -->

    <x-alert type="success"/>
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
                <td><img src="{{asset('storage/'.$category->image)}}" alt="" height="40" ></td>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_id}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('dashboard.categories.edit' , [$category->id])}}" class="btn btn-sm btn-outline-success">edit</a>
                    <!-- /.btn btn-sm btn-outline-success -->
                </td>
                <td>
                    <form action="{{route('dashboard.categories.destroy' , [$category->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                        <!-- /.btn btn-sm btn-outline-danger -->
                    </form>
                </td>
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
