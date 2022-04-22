<!-- <div class="modal animated fadeIn" id="modalEditGejala" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDetailLabel"></h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <form action="" method="POST" id="formUpdateGejala">
                            @csrf
                            @method('PUT')
                            <input type="text" name="g_kode" placeholder="Kode Gejala" value="">
                            <input type="text" name="g_nama" placeholder="Gejala" value="">
                            <input type="text" name="g_bel" placeholder="Nilai Belief" value="">
                            <input type="text" name="g_pls" placeholder="Nilai Plausibility" value="">
                            <input type="submit" name="submit" value="Simpan">
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div> -->

<div class="modal animated fadeIn" id="modalEditRule" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalDetailLabel">Edit Data Rule</h3>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form form action="" method="POST" id="formUpdateRule">
        @csrf
        @method('PUT')
          <div class="mb-3">
            <label for="r_penyakit_id" class="col-form-label">Kode Penyakit:</label>
            <input type="text" class="form-control" name="r_penyakit_id" >
          </div>
          <div class="mb-3">
            <label for="r_gejala_id" class="col-form-label">Kode Gejala:</label>
            <input type="text" class="form-control" name="r_gejala_id" ></input>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="submit">Submit Data</button>
      </div>
      </form>
    </div>
  </div>
</div>