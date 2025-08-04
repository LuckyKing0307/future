@extends('layouts.main')
@section('content')

    <div class="w-full max-w-xs mx-auto font-sans text-sm leading-none">
        <div class="relative rounded-t-2xl bg-white/90 backdrop-blur-sm ring-1 ring-black/5 p-4 pt-5">
            <div class="flex items-center gap-3">
                <div class="flex-1">
                    <p class="text-xs text-gray-500">****{{ substr($user->phone, -4) }}</p>
                </div>
                <span class="font-extrabold text-xl tracking-wide">{{ $user->tariff()?->name }}</span>
            </div>

            <div class="mt-4 rounded-xl bg-indigo-200/70 p-3 text-indigo-900 space-y-0.5">
                <p><span class="font-semibold">{{ __('profile.balance') }}:</span> $ {{ $user->pointsFunction() }}</p>
                <p><span class="font-semibold">{{ __('profile.deposit') }}:</span>{{ $user->payments() }}</p>
                <p><span class="font-semibold">{{ __('profile.ball') }}</span> $ {{ $user->ball }}</p>
                @if($user->tariff_at)
                    <p class="text-xs text-gray-700 pt-1">{{ __('profile.tasks') }}: {{ $user->tasks()->count() }}</p>
                    <p class="text-xs text-gray-700 pt-1">{{ __('profile.days_left') }}: {{ $user->daysLeft()['days'] }} {{ __('profile.days') }}</p>
                    <div class="h-1.5 w-full bg-indigo-300/60 mt-1 rounded">
                        <div class="h-full bg-indigo-600 rounded-l" style="width:{{ $user->daysLeft()['precentage'] }}%"></div>
                    </div>
                @endif
            </div>
        </div>

        <div class="rounded-b-2xl bg-white ring-1 ring-black/5 divide-y divide-gray-100">
            @foreach($items as $item)
                <a href="{{ $item['href'] }}" type="button" class="flex link items-center w-full justify-between px-4 py-3 bg-white hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-.5304.2107-1.0391.5858-1.4142C12.9609 9.2107 13.4696 9 14 9c.5304 0 1.0391.2107 1.4142.5858C15.7893 9.9609 16 10.4696 16 11s-.2107 1.0391-.5858 1.4142C15.0391 12.7893 14.5304 13 14 13c-.5304 0-1.0391-.2107-1.4142-.5858C12.2107 12.0391 12 11.5304 12 11z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>{{ __($item['label']) }}</span>
                </span>
                    <span class="flex items-center gap-2">
                    @if(!is_null($item['badge']))
                            <span class="inline-block min-w-[1.4rem] text-center rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
                            {{ $item['badge'] }}
                        </span>
                        @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
                </a>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
@endsection
