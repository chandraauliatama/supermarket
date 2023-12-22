<div class="m-auto flex w-full items-center text-center"
     x-data="{ mode: $event.detail }"
     x-on:dark-mode-toggled.window="mode = $event.detail">
    <img src="{{ asset('images/footer.gif') }}" class="mx-auto flex dark:hidden">
    <img src="{{ asset('images/footerDark.gif') }}" class="mx-auto hidden dark:flex">
</div>
