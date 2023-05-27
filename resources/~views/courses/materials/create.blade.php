@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/dropzone.min.css">
@endsection

@section('content')
    <h1>Upload Materials to:</h1>
    <h2>{{ $course->id }}-{{ $course->name }} ({{ $course->code }})</h2>

    <form id="upload-form" action="/courses/{{ $course->id }}/materials" method="POST" class="dropzone">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    </form>

    <a href="/courses/{{ $course->id }}">Done</a>
@endsection

@section('scripts')
    <script type="text/javascript" src="/js/dropzone.min.js"></script>
    <script>
        Dropzone.options.uploadForm = {
            dictDefaultMessage: "Drop materials here to upload",
            acceptedFiles:".pdf,.pptx,.ppt,.odp",
            // addRemoveLinks: true
        }
    </script>
@endsection
