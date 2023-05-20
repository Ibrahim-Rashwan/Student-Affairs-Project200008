<?php
    $route = "/courses/{$course->id}";

    $materials = json_decode($course->materials);

    $canAdd = false;
    if (App\Shared\Shared::isAdmin()) {
        $canAdd = true;
    } else if (App\Shared\Shared::isDoctor()) {
        $doctor = Illuminate\Support\Facades\Auth::user()->doctor;
        foreach ($doctor->courses as $doctorCourse) {
            if ($doctorCourse->id == $course->id) {
                $canAdd = true;
                break;
            }
        }
    }
    // $exams = json_decode($course->exams);
    // $department = App\Models\Department::findOrFail($course->department_id);
    // $doctor = App\Models\Doctor::findOrFail($course->doctor_id);

    // if ($course->pre_requisite_id != null) {
    //     $pre_requisite = App\Models\Course::findOrFail($course->pre_requisite_id);
    // }
    ?>

@extends('layouts.app')

@section('content')


    <div class="card p-3 mb-3 mt-3">
        <h2>{{$course->toString()}}</h2>

        <p>
            Number of Hours:
            {{$course->number_of_hours}}
        </p>


        <p>
            Department:
            {!! $course->department->link() !!}
        </p>

        <p>
            Doctor:
            {!! $course->doctor->link() !!}
        </p>

        <p>
            Pre-Requisite:

            @if ($course->pre_requisite != null)
                {!! $course->pre_requisite->link() !!}
            @else
                None.
            @endif
        </p>

        <hr>

        <section>
            @if ($materials && count($materials) > 0)
                <h3>Materials:</h3>
                <?php $counter = -1; ?>
                <div class="ms-5">
                    @foreach ($materials as $material)
                        <?php
                            $name = App\Shared\Shared::getDisplayName($material);
                            $path = '/' . App\Http\Controllers\MaterialsController::getMaterialPath($course, $material);
                            $counter++;
                        ?>

                        <a href="{{$path}}" target="_blank">{{$name}}</a>
                        <div style="margin-left: 5%">
                            <a href="{{$path}}" download={{$name}} class="btn btn-primary">Download</a>
                            @if ($canAdd)
                                <a href="{{$route}}/materials/{{$counter}}/edit" class="btn btn-secondary">Edit</a>
                                <form action="{{$route}}/materials/{{$counter}}" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value={{csrf_token()}}>
                                    <input type="hidden" name="_method" value='DELETE'>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>

                        <hr>
                    @endforeach
                </div>
            @else
                <h3>No Materials...</h3>
                <hr>
            @endif

            @if ($canAdd)
                <a class="btn btn-success ms-5" href="{{$route}}/materials/create">Upload materials</a>
            @endif
        </section>

        <hr style="height:0.3rem;background-color:black">

        <section>
            @if ($course->exams && count($course->exams) > 0)
                <h3>Exams:</h3>
                <div class="ms-5">
                @foreach ($course->exams as $exam)
                    <?php
                        $name = App\Shared\Shared::getDisplayName($exam->name);
                        $path = '/' . App\Http\Controllers\ExamsController::getExamPath($course, $exam->name);
                    ?>

                    <a href="{{$path}}" target="_blank"><h4>{{$exam->id}}-{{$name}}</h4></a>
                    <div class="ms-5">
                        <p>{{$exam->can_display_score ? "Can" : "Cannot"}} Display score.</p>
                        <small>Starts at: {{$exam->start_time}}</small>
                        <br>
                        <small>Ends at: {{$exam->end_time}}</small>

                        <div class="mt-3">
                            <a href="{{$path}}" download="{{$name}}" class="btn btn-primary">Download</a>
                            @if ($canAdd)
                                <a href="{{$route}}/exams/{{$exam->id}}/edit" class="btn btn-secondary">Edit</a>
                                <form action="{{$route}}/exams/{{$exam->id}}" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value={{csrf_token()}}>
                                    <input type="hidden" name="_method" value='DELETE'>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>

                    </div>
                    <hr>
                @endforeach
                </div>
            @else
                <h3>No Exams...</h3>
            @endif

            @if ($canAdd)
                <a class="btn btn-success ms-5" href="{{$route}}/exams/create">Add Exam</a>
            @endif
        </section>
    </div>

    <div class="d-flex justify-content-between">
        @if (App\Shared\Shared::isAdmin())
        @endif

        @if (App\Shared\Shared::isAdmin())
        <form action="{{$route}}" method="POST" class="d-inline">
            <input type="hidden" name="_token" value={{ csrf_token() }} />
            <input type="hidden" name="_method" value='DELETE' />

            <a href="{{$route}}/edit" class="btn btn-primary d-inline">Edit</a>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        @endif

        @if (App\Shared\Shared::isStudent())
            <?php $subscriptionState = $course->getSubscriptionState(); ?>
            @if (gettype($subscriptionState) != 'boolean')
                Already Subscribed -
                @if ($subscriptionState == null)
                    In progress
                @else
                    Mark: {{$subscriptionState}}
                    @if ($subscriptionState >= App\Shared\Shared::PASS_MARK)
                        (Passed)
                    @else
                        (Failed)
                    @endif
                @endif
            @else
                @if ($course->canSubscribe())
                    <form action="{{$route}}/subscribe" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value={{csrf_token()}}>
                        <button type="submit" class="btn btn-secondary">Subscribe</button>
                    </form>
                @else
                    Can't subscribe
                @endif
            @endif
        @endif

        @if ($canAdd)
            <form action="{{$route}}/generate_student_names" method="POST" class="d-inline">
                <input type="hidden" name="_token" value={{csrf_token()}}>
                <button type="submit" class="btn btn-secondary">Generate Student Names</button>
            </form>
        @endif

        <a href="/courses/" class="btn btn-success">Back</a>

    </div>


@endsection
