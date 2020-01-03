@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="column col-9">
                                Личные тренировки
                            </div>
                            <div class="column col-3">
                                <a href="{{ route('trainings.create') }}" class="btn btn-info">Создать новую</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table border="1">
                            <caption>Ваши зарегистрированные тренировки</caption>
                            <tr>
                                <th>Скалодром</th>
                                <th>Дата</th>
                                <th>Создатель</th>
                                <th>Количество участников</th>
                            </tr>
                            @foreach($user->trainings as $training)
                                <tr>
                                    <td>{{ $training->training_place->name }}</td>
                                    <td>{{ $training->start_datetime }}</td>
                                    <td>{{ $training->owner->name }}</td>
                                    <td>{{ $training->max_participants }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection