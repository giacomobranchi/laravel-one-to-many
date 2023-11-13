@extends('layouts.admin.app')

@section('content')
    <div class="container">
        {{-- <h1>ADMIN/PROJECTS/INDEX.BLADE</h1> --}}
        <h2 class="fs-4 text-secondary my-4">
            {{ Auth::user()->name }} {{ __('Project List') }}
        </h2>

        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('User Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ Auth::user()->name }} {{ __('Projects Page') }}
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary my-3"><i
                class="fa-solid fa-file-circle-plus"></i> New Project</a>

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Preview</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">GitHub</th>
                        <th scope="col">Website</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr class="">
                            <td class="align-middle" scope="row">{{ $project->id }}</td>
                            <td class="text-center align-middle"><img width="90px" src="{{ $project->cover_image }}"
                                    alt=""></td>
                            <td class="align-middle">{{ $project->title }}</td>
                            <td class="align-middle">{{ $project->content }}</td>
                            <td class="align-middle">{{ $project->github }}</td>
                            <td class="align-middle">{{ $project->website }}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a role="button" class="btn btn-primary"
                                        href="{{ route('admin.projects.show', $project) }}">Show</a>
                                    <a class="btn btn-warning" href="{{ route('admin.projects.edit', $project) }}"
                                        role="button">Edit</a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteproject{{ $project->id }}">
                                        Delete
                                    </button>

                                    <!-- DELETE Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="deleteproject{{ $project->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitle{{ $project->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitle{{ $project->id }}">
                                                        {{ $project->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start ">
                                                    <p>This operation will move the project
                                                        "<strong>{{ $project->title }}</strong>" in the Recycle Bin.</p>
                                                    <p>Are you sure?</p>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i>
                                                        Cancel</button>

                                                    <form action="{{ route('admin.projects.destroy', $project) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger m-2" type="submit"><i
                                                                class="fa-regular fa-trash-can"></i> Delete</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="align-middle">No Projects to show</td>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
@endsection
