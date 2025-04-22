<p class="box__title">Create New Category</p>
<form action="{{ route('categories.store') }}" method="post" class="padding-30">
    @csrf
    <input type="text" name="title" required placeholder="Category Name" class="text">
    <input type="text" name="slug" required placeholder="Category English Name" class="text">
    <p class="box__title margin-bottom-15">Select Parent Category</p>
    <select name="parent_id" id="parent_id">
        <option value="">None</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
    </select>
    <button class="btn btn-webamooz_net">Add</button>
</form>
