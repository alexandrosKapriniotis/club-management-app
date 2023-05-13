@if(session('message'))
        <?php $status = match (session('message.status')) { 'error' => 'danger', 'success' => 'success', 'warning' => 'warning'}?>
    <div
        class="fs-5 alert alert-{{$status}} py-3 mt-3 px-6 text-{{$status}}"
        role="alert">
        {{session('message.message')}}
    </div>
@endif
