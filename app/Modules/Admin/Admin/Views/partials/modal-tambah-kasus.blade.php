<div class="modal animated fadeIn" id="modalTambahKasus" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalDetailLabel">Tambah Data Kasus</h3>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('Admin.tambah-kasus') }}" method="POST" id="formKasus">
          @csrf
          <div class="mb-3">
            <label for="k_kode_gejala" class="col-form-label">Kode Gejala:</label>
            <input type="text" class="form-control" name="k_kode_gejala" >
          </div>
          <div class="mb-3">
            <label for="k_nama_penyakit">Nama Penyakit</label>
            <input type="text" class="form-control" name="k_nama_penyakit">
          </div>
          <div class="mb-3">
            <label for="k_kategori" class="col-form-label">Kategori Diagnosa:</label>
            <input type="text" class="form-control" name="k_kategori"></input>
          </div>
          <div class="mb-3">
            <label for="k_skor" class="col-form-label">Persentase:</label>
            <input type="text" class="form-control" name="k_skor"></input>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="submit">Submit Data</button>
      </div>
      </form>
    </div>
  </div>
</div>