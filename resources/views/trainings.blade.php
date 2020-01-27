@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <table border="1">
                    <caption>Зарегистрированные тренировки</caption>
                    <tr>
                        <th>Скалодром</th>
                        <th>Дата</th>
                        <th>Создатель</th>
                        <th>Количество участников (заявок)</th>
                        <th></th>
                    </tr>
                    @foreach($trainings as $training)
                        <tr>
                            <td>{{ $training->training_place->name }}</td>
                            <td>{{ $training->start_datetime }}</td>
                            <td>{{ $training->owner->name }}</td>
                            <td>{{ $training->participants()->count() . '/' . $training->max_participants . " ({$training->active_applications_count})" }}</td>
                            <td>
                                @if ($training->canBeApplied())
                                    <form method="post" action="{{ route('training_applications.store') }}">
                                        @csrf
                                        <input type="hidden" name="training_id" value="{{ $training->id }}">
                                        <button class="btn-sm" type="submit">Подать заявку на участие</button>
                                    </form>
                                @else
                                    Вы уже подавали заявку или являетесь создателем
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>


            </div>
        </div>
    </div>
    </div>
@endsection
