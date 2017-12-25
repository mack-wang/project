@if(session('success'))
    <div class="ui success message visible">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="ui error message visible">{{ session('error') }}</div>
@endif
@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="ui error message visible">{{ $error }}</div>
    @endforeach
@endif