@extends('layouts.dashboard')

@section('header', 'categories')

@section('breadcrum')
    @parent
    <li class="breadcrumb-item active">Starter Page</li>
@stop

@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
    </div>


    <x-alert type="success" />

    <form action="{{ URL::current() }}" method="GET" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" id="" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">Filter</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Category id</th>
                <th>Name</th>
                <th>Status</th>
                <th>Products count</th>
                <th>Parent</th>
                <th>Created At</th>
                <th>operation</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="40"></td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>{{ $category->parent_name }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.categories.edit', [$category->id]) }}"
                            class="btn btn-sm btn-outline-success">edit</a>
                        <!-- /.btn btn-sm btn-outline-success -->
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.destroy', [$category->id]) }}" method="post">
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
    {{ $categories->withQueryString()->links() }}
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
