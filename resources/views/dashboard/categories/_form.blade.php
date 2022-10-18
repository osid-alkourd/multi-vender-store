<div class="form-group">
    <label for="">Category Name</label>
    <input type="text" class="form-control" name="name" value="{{$category->name}}">
</div>

<div class="form-group">
    <label for="">Parent Category</label>
    <select name="parent_id"  class="form-control">
        <option value="">Select Category Parent</option>
        @foreach($parents as $parent)
            <option value="{{$parent->id}}" @selected($category->parent_id == $parent->id)>{{$parent->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="">Description</label>
    <textarea name="description" class="form-control">{{$category->description}}</textarea>
</div>

<div class="form-group">
    <label for="">Category Image</label>
    <input type="file" name="image" class="form-control">
</div>

<div class="form-group">
    <label for="">Status</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="active" @checked($category->status == 'active')>
        <label class="form-check-label">Active</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status"  value="archived"  @checked($category->status == 'archived')>
        <label class="form-check-label">Archived</label>
    </div>
</div>

<button type="submit" class="form-group btn btn-primary">Save</button>
<!-- /.form-group btn btn-primary -->
