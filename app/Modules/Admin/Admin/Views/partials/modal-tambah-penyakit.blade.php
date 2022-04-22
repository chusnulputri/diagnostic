
<div class="modal animated fadeIn" id="modalTambahPenyakit" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalDetailLabel">Tambah Data Penyakit</h3>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('Admin.tambah-penyakit') }}" method="POST" id="formPenyakit">
        @csrf
          <div class="mb-3">
            <label for="p_kode" class="col-form-label">Kode Penyakit:</label>
            <input type="text" class="form-control" name="p_kode" >
          </div>
          <div class="mb-3">
            <label for="p_nama" class="col-form-label">Nama Penyakit:</label>
            <input type="text" class="form-control" name="p_nama" ></input>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>