
<div class="modal animated fadeIn" id="modalTambahGejala" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="modalDetailLabel">Tambah Data Gejala</h3>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('Admin.tambah-gejala') }}" method="POST" id="formGejala">
        @csrf
          <div class="mb-3">
            <label for="g_kode" class="col-form-label">Kode Gejala:</label>
            <input type="text" class="form-control" name="g_kode" >
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

<!--<div class="modal animated fadeIn" id="modalTambahGejala" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalDetailLabel">Tambah Data Gejala</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
             <div class="modal-body">
                <div class="container-fluid"></div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <form action="{{ route('Admin.tambah-gejala') }}" method="POST" id="formGejala">
                            @csrf
                            <div class="form-group">
                                    <label for= "Kode Gejala">Kode Gejala</label>
                                    <input type="text" name="g_kode" placeholder="Kode Gejala">
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="Gejala">Gejala</label>
                                    <input type="text" name="g_nama" placeholder="Gejala">
                                </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="Nilai Belief">Nilai Belief</label>
                                    <input type="text" name="g_bel" placeholder="Nilai Belief">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="Nilai Plausibility">Nilai Plausibility</label>
                                    <input type="text" name="g_pls" placeholder="Nilai Plausibility">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit Data</button>
                        </form>
                    </div>
                </div>
                
            </div> 
        </div>
    </div>
</div> -->









