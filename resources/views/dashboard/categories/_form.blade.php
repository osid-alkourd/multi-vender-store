<div class="form-group">
    <label for="">Category Name</label>
    <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) name="name" value="{{ old('name', $category->name) }}">
    @error('name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="">Parent Category</label>
    <select name="parent_id" class="form-control">
        <option value="">Select Category Parent</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id' , $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="">Description</label>
    <textarea name="description" class="form-control">{{old('description' , $category->description )}}</textarea>
    @error('description')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="">Category Image</label>
    <input type="file" name="image" class="form-control">
    @if ($category->image)
        <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="40"></td>
    @endif
</div>

<div class="form-group">
    <label for="">Status</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="active" @checked(old('status' , $category->status  ) == 'active')>
        <label class="form-check-label">Active</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="archived" @checked(old('status' ,$category->status ) == 'archived')>
        <label class="form-check-label">Archived</label>
    </div>
    @error('status')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
</div>

<button type="submit" class="form-group btn btn-primary">{{ $button_label ?? 'save' }}</button>
<!-- /.form-group btn btn-primary -->
