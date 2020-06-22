@extends('layouts.app')

@section('content')
    <div class="col-md-10" id="trainings">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <trainings-list trainings="{{ $trainings }}" store-route="{{ route('training_applications.store') }}"></trainings-list>


{{--                <table border="1">--}}
{{--                    <caption>Зарегистрированные тренировки</caption>--}}
{{--                    <tr>--}}
{{--                        <th>Скалодром</th>--}}
{{--                        <th>Дата</th>--}}
{{--                        <th>Создатель</th>--}}
{{--                        <th>Количество участников (заявок)</th>--}}
{{--                        <th></th>--}}
{{--                    </tr>--}}
{{--                    @foreach($trainings as $training)--}}
{{--                        <tr>--}}
{{--                            <training>{{ $training->training_place->name }}</training>--}}
{{--                            <training>{{ $training->start_datetime }}</training>--}}
{{--                            <training>{{ $training->owner->name }}</training>--}}
{{--                            <training>{{ $training->participants()->count() . '/' . $training->max_participants . " ({$training->active_applications_count})" }}</training>--}}
{{--                            <training>--}}
{{--                                @if ($training->canBeApplied())--}}
{{--                                    <form method="post" action="{{ route('training_applications.store') }}">--}}
{{--                                        @csrf--}}
{{--                                        <input type="hidden" name="training_id" value="{{ $training->id }}">--}}
{{--                                        <button class="btn-sm" type="submit">Подать заявку на участие</button>--}}
{{--                                    </form>--}}
{{--                                @else--}}
{{--                                    Вы уже подавали заявку или являетесь создателем--}}
{{--                                @endif--}}
{{--                            </training>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                </table>--}}
            </div>
        </div>
    </div>
@endsection