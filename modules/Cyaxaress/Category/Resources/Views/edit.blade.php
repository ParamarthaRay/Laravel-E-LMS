@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('categories.index') }}" title="Categories">Categories</a></li>
    <li><a href="#" title="Edit Category">Edit Category</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-6 bg-white">
        <p class="box__title">Update Category</p>
        <form action="{{ route('categories.update', $category->id) }}" method="post" class="padding-30">
            @csrf
            @method('patch')
            <input type="text" name="title" required placeholder="Category Name" class="text" value="{{ $category->title }}">
            <input type="text" name="slug" required placeholder="Category English Name" class="text" value="{{ $category->slug }}">
            <p class="box__title margin-bottom-15">Select Parent Category</p>
            <select name="parent_id" id="parent_id">
                <option value="">None</option>
                @foreach($categories as $categoryItem)
                <option value="{{ $categoryItem->id }}"  @if($categoryItem->id == $category->parent_id) selected @endif>{{ $categoryItem->title }}</option>
                @endforeach
            </select>
            <button class="btn btn-webamooz_net">Update</button>
        </form>
        </div>
    </div>
@endsection
