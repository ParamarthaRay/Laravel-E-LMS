<p class="box__title">Create New Slide</p>
<form action="{{ route('slides.store') }}" method="post" class="padding-30" enctype="multipart/form-data">
    @csrf
    <x-input type="file" name="image" required placeholder="Image" class="text" />
    <x-input type="number" name="priority" placeholder="Priority" class="text" />
    <x-input type="text" name="link" placeholder="Link" class="text" />
    <p class="box__title margin-bottom-15">Display Status</p>
    <select name="status" id="status">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
    </select>
    <button class="btn btn-webamooz_net">Add</button>
</form>
