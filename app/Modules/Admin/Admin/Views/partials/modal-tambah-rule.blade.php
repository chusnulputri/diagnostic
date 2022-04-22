<div class="modal animated fadeIn" id="modalTambahGejala" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalDetailLabel">Tambah Data Rule</h3>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('Admin.tambah-rule') }}" method="POST" id="formRule">
        @csrf
          <div class="mb-3">
            <label for="r_penyakit_id" class="col-form-label">Kode Penyakit :</label>
            <input type="text" class="form-control" name="r_penyakit_id" >
          </div>
          <div class="mb-3">
            <label for="r_gejala_id" class="col-form-label">Kode Gejala:</label>
            <input type="text" class="form-control" name="r_gejala_id" ></input>
          </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </div>
       </form>
    </div>
  </div>
</div>











