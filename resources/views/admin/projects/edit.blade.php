@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <h1>ADMIN/PROJECTS/EDIT.BLADE</h1>
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Project Edit Page for') }} {{ Auth::user()->name }}.
        </h2>
        <h3 class="fs-5 text-secondary">
            {{ __('Editing Project') }} ID: {{ $project->id }}
        </h3>

        <div class="row justify-content-center my-3">
            <div class="col">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT')

                    <div class="mb-3">

                        <label for="title" class="form-label"><strong>Title</strong></label>

                        <input type="text" class="form-control" name="title" id="title"
                            aria-describedby="helpTitle" value="{{ old('title') ? old('title') : $project->title }}">

                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="type_id" class="form-label">Categories</label>
                        <select class="form-select @error('type_id') is-invalid  @enderror" name="type_id" id="type_id">
                            <option selected disabled>Select a category</option>
                            <option value="">Uncategorized</option>

                            @forelse ($types as $type)
                                <option value="{{ $type->id }}"
                                    {{ $type->id == old('type_id', $post->type_id) ? 'selected' : '' }}>
                                    {{ $type->name }}</option>
                            @empty
                            @endforelse


                        </select>
                    </div>
                    @error('type_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">

                        <label for="content" class="form-label"><strong>Content</strong></label>

                        <textarea class="form-control" name="content" id="content" aria-describedby="helpTitle" cols="30" rows="5">{{ old('content') ? old('content') : $project->content }}</textarea>


                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="github" class="form-label">Title</label>
                        <input type="text" name="github" id="github"
                            class="form-control  @error('github') is-invalid  @enderror"
                            placeholder="Type the link to your code here" aria-describedby="helperTitle"
                            value="{{ old('github', $project->github) }}">
                        <small id="helpergithub" class="text-muted">Type the link to your code here: 50 characters</small>
                    </div>
                    @error('github')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label for="website" class="form-label">website</label>
                        <input type="text" name="website" id="website"
                            class="form-control  @error('website') is-invalid  @enderror"
                            placeholder="Type the website link here" aria-describedby="helperwebsite"
                            value="{{ old('website', $project->website) }}">
                        <small id="helperwebsite" class="text-muted">Type the website link here max: 50 characters</small>
                    </div>
                    @error('website')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror


                    <div class="mb-3">

                        <div class="mb-3">

                            @if (str_contains($project->cover_image, 'http'))
                                <td><img class=" img-fluid" style="height: 100px" src="{{ $project->cover_image }}"
                                        alt="{{ $project->title }}"></td>
                            @else
                                <td><img class=" img-fluid" style="height: 100px"
                                        src="{{ asset('storage/' . $project->cover_image) }}"></td>
                            @endif

                        </div>

                        <label for="cover_image" class="form-label"><strong>Choose a Thumbnail image file</strong></label>

                        <input type="file" class="form-control" name="cover_image" id="cover_image"
                            placeholder="Cerca..." aria-describedby="fileHelpThumb">

                        @error('cover_image ')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <button type="submit" class="btn btn-success my-3"><i class="fa-solid fa-floppy-disk"></i>
                        Save</button>
                    <a class="btn btn-primary" href="{{ route('admin.projects.index') }}"><i class="fa-solid fa-ban"></i>
                        Cancel</a>

                </form>
            </div>
        </div>

    </div>
@endsection
