@foreach ($menu as $item)
<a class="text-gray-500" href="{{ $item['url'] }}" @if($item['blank']) target="_blank" @endif>
    <span class="flex justify-between">
        @if(isset($item['icon']) && !empty($item['icon']))
        <x-icon class="w-4 h-4 mx-2" name="{{ $item['icon'] }}"></x-icon>
        @endif
        {{ $item['title'] }}
    </span>
</a>
@endforeach
