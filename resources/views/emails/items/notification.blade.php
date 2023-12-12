<x-mail::message>
# Introduction

<p> {{$item->name}} is created </p>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
