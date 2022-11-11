<div class="form-group">
    <x-form.input type="text" name="name" label="Category Name" class="form-control-lg" :value="$category->name"/>
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
    <x-form.textarea name="description" label="Description" :value="$category->description"/>
</div>

<div class="form-group">
    <x-form.label id="image">Category Image</x-form.label>
    <x-form.input type="file" name="image" id="image" accept="image/*" />
    @if ($category->image)
        <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="40"></td>
    @endif
</div>

<div class="form-group">
    <x-form.label id="status">Status</x-form.label>
    <div>
        <x-form.radio name="status" id="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
    </div>
</div>

<button type="submit" class="form-group btn btn-primary">{{ $button_label ?? 'save' }}</button>
<!-- /.form-group btn btn-primary -->
