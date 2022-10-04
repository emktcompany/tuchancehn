<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>#TuChance</title>
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Dosis:300,400,700|Open+Sans:300,600,700');
    @import url('{{ asset('css/pdf.css') }}');
  </style>
</head>
@php
  $user = auth('api')->user()->load('avatar');
@endphp
<body class="font-sans">
  <div class="h-8 bg-purple"></div>
  <div class="max-w-xl mx-auto px-8">
    <div class="flex">
      <div class="flex flex-col items-center flex-1 justify-center py-3">
        <h1 class="text-center text-grey-dark mb-4 font-dosis uppercase">
          {{$user->name}}
          <div class="h-1 bg-teal mt-4"></div>
        </h1>
      </div>
      @if ($user->avatar)
        <div class="flex flex-none w-32 py-8">
          <img src="{{ asset("storage/{$user->avatar->path}") }}" alt="{{$user->name}}" width="{{$user->avatar->meta['width']}}" height="{{$user->avatar->meta['height']}}" class="rounded-full w-32 h-32">
        </div>
      @endif
    </div>
    <div class="h-4 bg-grey-light"></div>
    <div class="py-8 flex -mx-4 page-content">
      <div class="px-8 w-1/3 text-grey-dark">
        <h2 class="font-dosis uppercase">Contacto</h2>
        <div class="h-px bg-grey-light"></div>
        <div class="flex items-center py-6">
          <div class="flex-none w-4 text-teal mr-2">
            {{svg_image('icons/regular/envelope', 'fill-current w-4', [
              'width'  => '16',
              'height' => '16'
            ])}}
          </div>
          <div class="flex-1">
            <div class="truncate w-full">{{$user->email}}</div>
          </div>
        </div>
        <div class="h-px bg-grey-light"></div>
        @if ($user->candidate->phone)
          <div class="flex items-center py-6">
            <div class="flex-none w-4 text-teal mr-2">
              {{svg_image('icons/solid/phone', 'fill-current w-4', [
                'width'  => '16',
                'height' => '16'
              ])}}
            </div>
            <div class="flex-1">
              <div class="truncate w-full">{{$user->candidate->phone}}</div>
            </div>
          </div>
          <div class="h-px bg-grey-light"></div>
        @endif
        @if ($user->candidate->cell_phone)
          <div class="flex items-center py-6">
            <div class="flex-none w-4 text-teal mr-2">
              {{svg_image('icons/solid/mobile-alt', 'fill-current w-4', [
                'width'  => '16',
                'height' => '16'
              ])}}
            </div>
            <div class="flex-1">
              <div class="truncate w-full">{{$user->candidate->cell_phone}}</div>
            </div>
          </div>
          <div class="h-px bg-grey-light"></div>
        @endif
        <h2 class="font-dosis uppercase mt-12">Ubicación</h2>
        <div class="h-px bg-grey-light"></div>
        <div class="py-6">
          <strong>País:</strong> {{$user->country->name}}
        </div>
        <div class="h-px bg-grey-light"></div>
        @if ($user->state)
          <div class="py-6">
            <strong>Departamento:</strong> {{$user->state->name}}
          </div>
          <div class="h-px bg-grey-light"></div>
        @endif
        @if ($user->city)
          <div class="py-6">
            <strong>Municipio:</strong> {{$user->city->name}}
          </div>
          <div class="h-px bg-grey-light"></div>
        @endif
      </div>
      <div class="px-8 w-2/3 text-justify">
        <h2 class="font-dosis uppercase">Perfil</h2>
        <p>{!! nl2br(e($user->candidate->summary)) !!}</p>
        @if (count($user->candidate->work_experience?:[]))
          <h2 class="font-dosis uppercase">Experiencia</h2>

          <div class="h-px bg-grey-light"></div>
          <div class="">
            @foreach ($user->candidate->work_experience as $row)
              <div class="pt-6">
                <p class="font-dosis text-teal text-xl font-bold uppercase">{{$row['position']}}</p>
                <div class="flex justify-between -mx-4 text-grey-dark">
                  <p class="px-4 uppercase">{{$row['company']}}</p>
                  <p class="px-4">
                    {{__('dates.months.long.' . ($row['start_month']-1))}}/{{$row['start_year']}}
                    &nbsp;&mdash;&nbsp;
                    @if (isset($row['is_current']) && is_numeric($row['is_current']) ? (int) $row['is_current'] : $row['is_current'] == 'true')
                        Actualidad
                    @elseif(isset($row['leave_month']) && isset($row['leave_year']))
                      {{__('dates.months.long.' . ($row['leave_month']-1))}}/{{$row['leave_year']}}
                    @endif
                  </p>
                </div>
              </div>
              <div class="h-px bg-grey-light"></div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</body>
</html>
