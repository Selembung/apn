@if (Session::has('message'))
<div class="alert alert-success {{ Session::has('important') ? 'alert-important alert-danger' : 'alert-success' }} alert-dismissible fade show"
    role="alert">
    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
    <span class="alert-inner--text"><strong>Success!</strong> {{ Session::get('message') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif