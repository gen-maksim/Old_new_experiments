@extends('layouts.app')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Создать тренировку') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('trainings.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="training_place" class="col-md-4 col-form-label text-md-right">{{ __('Скалодром') }}</label>

                        <div class="col-md-6">
                            <select id="training_place_id" class="form-control @error('training_place_id') is-invalid @enderror" name="training_place_id" required autocomplete="training_place_id" autofocus>
                                @foreach($training_places as $training_place)
                                    <option value='{{ $training_place->id }}'>{{ $training_place->name }}</option>
                                @endforeach
                            </select>

                            @error('training_place_id')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="start_datetime" class="col-md-4 col-form-label text-md-right">{{ __('Дата тренировки') }}</label>

                        <div class="col-md-6">
                            <input id="start_datetime" type="datetime-local" format="HH:mm" class="form-control @error('start_datetime') is-invalid @enderror" name="start_datetime" value="{{ old('start_datetime') }}" required autocomplete="start_datetime">

                            @error('start_datetime')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="duration_in_mins" class="col-md-4 col-form-label text-md-right">{{ __('Длительность в минутах') }}</label>

                        <div class="col-md-6">
                            <input id="duration_in_mins" type="number" class="form-control @error('duration_in_mins') is-invalid @enderror" name="duration_in_mins" required autocomplete="new-duration_in_mins">

                            @error('duration_in_mins')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="max_participants" class="col-md-4 col-form-label text-md-right">{{ __('Максимальное колическтво участников') }}</label>

                        <div class="col-md-6">
                            <input id="max_participants" type="number" class="form-control @error('max_participants') is-invalid @enderror" name="max_participants" required autocomplete="new-max_participants">

                            @error('max_participants')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Сохранить') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection