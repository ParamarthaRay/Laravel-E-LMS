@extends('layouts.app') {{-- Adjust this layout if you're using a different one --}}

@section('title', $category->title)

@section('content')
    <style>
        /* General Styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .card-text {
            font-size: 1rem;
            color: #7f8c8d;
            line-height: 1.5;
        }

        .card-text strong {
            color: #34495e;
        }

        .list-group-item {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .list-group-item a {
            color: #2980b9;
            text-decoration: none;
        }

        .list-group-item a:hover {
            text-decoration: underline;
        }

        /* Alerts */
        .alert-info {
            background-color: #f0f8ff;
            color: #2980b9;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* Buttons */
        .btn-outline-secondary {
            padding: 8px 16px;
            font-size: 1rem;
            border-radius: 4px;
            background-color: transparent;
            color: #7f8c8d;
            border: 1px solid #7f8c8d;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #7f8c8d;
            color: #fff;
            border-color: #7f8c8d;
        }

        .btn-primary {
            padding: 8px 16px;
            font-size: 1rem;
            border-radius: 4px;
            background-color: #3498db;
            color: #fff;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                padding: 15px;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-text {
                font-size: 0.9rem;
            }

            .list-group-item {
                padding: 10px;
                font-size: 0.9rem;
            }

            .btn-outline-secondary, .btn-primary {
                font-size: 0.9rem;
                padding: 6px 12px;
            }
        }
    </style>

    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="card-title">{{ $category->title }}</h2>
                <p class="card-text">
                    <strong>Description:</strong><br>
                    {{ $category->description ?? 'No description available.' }}
                </p>

                <p class="card-text">
                    <strong>Parent Category:</strong>
                    {{ $category->parent ?? 'None' }}
                </p>

                <p class="card-text">
                    <strong>Number of Subcategories:</strong>
                    {{ $category->subCategories->count() }}
                </p>

                <p class="card-text">
                    <strong>Courses in this Category:</strong> {{ $category->courses->count() }}
                </p>

                @if($category->courses->count())
                    <ul class="list-group list-group-flush mt-3">
                        @foreach($category->courses as $course)
                            <li class="list-group-item">
                                <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-info mt-3">
                        No courses available in this category.
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">← Back to Categories</a>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit Category</a>
                </div>
            </div>
        </div>
    </div>
@endsection
