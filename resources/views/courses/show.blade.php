<?php
    $route = "/courses/{$course->id}";

    $materials = json_decode($course->materials);
    // $exams = json_decode($course->exams);
    // $department = App\Models\Department::findOrFail($course->department_id);
    // $doctor = App\Models\Doctor::findOrFail($course->doctor_id);

    // if ($course->pre_requisite_id != null) {
    //     $pre_requisite = App\Models\Course::findOrFail($course->pre_requisite_id);
    // }
    ?>

@extends('layouts.app')

@section('content')

    <a href="/courses" class="btn btn-success">Back</a>

    <div class="card p-3 mb-3 mt-3">
        <h2>{{$course->toString()}}</h2>

        <p>
            Number of Hours:
            {{$course->number_of_hours}}
        </p>

        <p>
            Department:
            <br>
            {{$course->department->name}} ({{$course->department->code}})
        </p>

        <p>
            Doctor:
            <br>
            {{$course->doctor->user->name}}
        </p>

        <p>
            Pre-Requisite:
            <br>
            @if ($course->pre_requisite != null)
                {{$course->pre_requisite_id}}-{{$course->pre_requisite->name}} ({{$course->pre_requisite->code}})
            @else
                None.
            @endif
        </p>

        <hr>

        <section>
            @if ($materials && count($materials) > 0)
                <h3>Materials:</h3>
                <?php $counter = -1; ?>
                <div class="ms-3">
                    @foreach ($materials as $material)
                        <?php
                            $name = App\Shared\Shared::getDisplayName($material);
                            $path = '/' . App\Http\Controllers\MaterialsController::getMaterialPath($course, $material);
                            $counter++;
                        ?>

                        <a href="{{$path}}" target="_blank">{{$name}}</a>
                        <div style="margin-left: 5%">
                            <a href="{{$path}}" download={{$name}}>Download</a>
                            <a href="{{$route}}/materials/{{$counter}}/edit">Edit</a>
                            <form action="{{$route}}/materials/{{$counter}}" method="POST">
                                <input type="hidden" name="_token" value={{csrf_token()}}>
                                <input type="hidden" name="_method" value='DELETE'>
                                <button type="submit">Delete</button>
                            </form>
                        </div>

                        <hr>
                    @endforeach
                </div>
            @else
                <h3>No Materials...</h3>
            @endif
            <br>
            <a href="{{$route}}/materials/create" class="ms-3">Upload materials</a>
        </section>

        <hr>
        <hr>

        <section>
            @if ($course->exams && count($course->exams) > 0)
                <h3>Exams:</h3>
                <div class="ms-3">
                @foreach ($course->exams as $exam)
                    <?php
                        $name = App\Shared\Shared::getDisplayName($exam->name);
                        $path = '/' . App\Http\Controllers\ExamsController::getExamPath($course, $exam->name);
                    ?>

                    <a href="{{$path}}" target="_blank"><h4>{{$exam->id}}-{{$name}}</h4></a>
                    <div style="margin-left: 5%">
                        <a href="{{$path}}" download="{{$name}}">Download</a>
                        <a href="{{$route}}/exams/{{$exam->id}}/edit" >Edit</a>
                        <form action="{{$route}}/exams/{{$exam->id}}" method="POST">
                            <input type="hidden" name="_token" value={{csrf_token()}}>
                            <input type="hidden" name="_method" value='DELETE'>
                            <button type="submit">Delete</button>
                        </form>

                        <p>{{$exam->can_display_score ? "Can" : "Cannot"}} Display score.</p>
                        <small>Starts at: {{$exam->start_time}}</small>
                        <br>
                        <small>Ends at: {{$exam->end_time}}</small>
                    </div>
                    <hr>
                @endforeach
                </div>
            @else
                <h3>No Exams...</h3>
            @endif

            <a href="{{$route}}/exams/create" class="ms-3">Add Exam</a>
        </section>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{$route}}/edit" class="btn btn-primary d-inline">Edit</a>

        <form action="{{$route}}" method="POST" class="d-inline">
            <input type="hidden" name="_token" value={{ csrf_token() }} />
            <input type="hidden" name="_method" value='DELETE' />

            <button type="submit" class="btn btn-danger">Delete</button>
        </form>

        <form action="{{$route}}/subscribe" method="POST" class="d-inline">
            <input type="hidden" name="_token" value={{csrf_token()}}>
            <button type="submit" class="btn btn-secondary">Subscribe</button>
        </form>
    </div>


@endsection
