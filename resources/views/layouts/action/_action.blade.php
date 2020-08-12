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

</form>