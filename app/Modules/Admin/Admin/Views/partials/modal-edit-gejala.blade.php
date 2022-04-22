<div class="modal animated fadeIn" id="modalEditGejala" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalDetailLabel">Edit Data Gejala</h3>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <form form action="" method="POST" id="formUpdateGejala">
              @csrf
              @method('PUT')
            <div class="mb-3">
              <label for="g_kode" class="col-form-label">Kode Gejala:</label>
              <input type="text" class="form-control" name="g_kode" ></input>
            </div>
            <div class="mb-3">
              <label for="g_nama" class="col-form-label">Gejala:</label>
              <input type="text" class="form-control" name="g_nama" ></input>
            </div>
            <div class="mb-3">
              <label for="g_bel" class="col-form-label">Nilai Belief:</label>
              <input type="text" class="form-control" name="g_bel"></input>
            </div>
            <div class="mb-3">
              <label for="g_pls" class="col-form-label">Nilai Plausibility:</label>
              <input type="text" class="form-control" name="g_pls"></input>
            </div>
              <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </div>
          </form>
        </div>
    </div>
  </div>
</div>