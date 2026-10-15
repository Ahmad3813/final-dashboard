@extends('layouts.parts.school_layout')

@section('title', 'Classrooms')
@section('topbar', 'Classrooms')

@section('content')
<div class="school-page">
    <header class="school-page-heading">
        <div>
            <h1>Classrooms</h1>
            <p>View classrooms, student numbers, and capacity.</p>
        </div>

        <a href="{{ route('school.create-classroom') }}"
            class="school-primary-action"
            style="text-decoration: none;">
            <span aria-hidden="true">＋</span> Add classroom
        </a>
    </header>

    <section class="school-panel school-assignments" aria-labelledby="classrooms-title">
        <div class="school-panel-header">
            <h2 id="classrooms-title">Classroom list</h2>
        </div>

        <div class="school-table-wrap">
            <table class="school-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>School year</th>
                        <th>Students</th>
                        <th>Capacity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classrooms as $classroom)
                    <tr>
                        <td>{{ $classroom->name }}</td>
                        <td>{{ $classroom->class_year }}</td>
                        <td>{{ $classroom->students_count }}</td>
                        <td>{{ $classroom->capacity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="school-table-empty">
                            No classrooms yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection