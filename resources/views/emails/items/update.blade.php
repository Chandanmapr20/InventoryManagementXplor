<x-mail::message>
# Introduction

<p> {{$item->name}} is Updated </p>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
