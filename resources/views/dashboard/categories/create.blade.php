@extends('layouts.dashboard')

@section('header' , 'osid')

@section('breadcrum')
    @parent
    <li class="breadcrumb-item active">Starter Page</li>
@stop

@section('content')

    <form action="{{route('categories.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Category Name</label>
            <input type="text" class="form-control" name="name">
        </div>

        <div class="form-group">
            <label for="">Parent Category</label>
            <select name="parent_id"  class="form-control">
                <option value="">Select Category Parent</option>
                @foreach($parents as $parent)
                    <option value="{{$parent->id}}">$parent->name</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="">Category Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="active">
                <label class="form-check-label">Active</label>
            </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status"  value="archived">
                <label class="form-check-label">Archived</label>
             </div>
        </div>

        <button type="submit" class="form-group btn btn-primary">Save</button>
        <!-- /.form-group btn btn-primary -->
    </form>
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
