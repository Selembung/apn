<a href="{{ url($url_edit) }}" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip"
    data-original-title="Edit">
    <i class="fas fa-user-edit"></i>
</a>

<form action="{{ url($url_destroy) }}" method="post" class="d-inline ml--1">
    @method('delete')
    @csrf
    {{-- <button class="btn btn-sm btn-neutral btn-round btn-icon action-delete" data-toggle="tooltip"
        data-original-title="Delete">
        <i class="fas fa-trash"></i>
    </button> --}}

    <button type="button" class="btn btn-sm btn-neutral btn-round btn-icon action-delete" data-toggle="tooltip"
        data-original-title="Delete" onclick='swal({
            title: "Apakah yakin ingin menghapus data ini?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                this.parentElement.submit()
            } else {
              swal("Data ini masih tersimpan!");
            }
          });'>
        <i class="fas fa-trash"></i>
    </button>

    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-sm btn-neutral btn-round btn-icon action-delete" data-toggle="modal"
        data-target="#modal-notification">
        <i class="fas fa-trash"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
        aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content bg-gradient-danger">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    @method('delete')
                    @csrf

                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">You should read this!</h4>
                        <p>Are you sure you want to delete this data?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-white">Yes, of course</button>
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div> --}}



</form>