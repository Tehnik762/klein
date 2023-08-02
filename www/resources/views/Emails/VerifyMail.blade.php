<x-mail::message>
# Introduction

Welcome!

Feel free to verify your email address by clicking the button

<x-mail::button :url="$verifylink">
Verify your Email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
