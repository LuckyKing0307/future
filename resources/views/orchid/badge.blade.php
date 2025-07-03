@php($colors = ['success'=>'bg-success','danger'=>'bg-danger','warning'=>'bg-warning'])
<span class="badge {{ $colors[$color] ?? 'bg-secondary' }}">{{ $value }}</span>
