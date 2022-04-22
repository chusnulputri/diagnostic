<div class="modal fade" id="modal-logout" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12 text-center" style="font-size: 14pt; font-weight: 600;">
                    Log Out ?
                </div>
                <div class="col-md-12 text-center" style="font-weight: 500; color: #aaa; margin-top: 3px;">
                    <p>Anda akan kembali ke halaman login</p>
                </div>

                <div class="col-md-12 text-center" style="padding-top: 20px; border-top: 1px solid #eee; margin-top: 5px;">
                    <button type="button" id="btn-close-modal-logout" class="btn btn-white" data-dismiss="modal">Tidak</button>
                    <button type="button" id="btn-konfirm-modal-logout" class="btn btn-primary" onclick="logout(event, 'execute')">Ya, logout akun saya</button>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-logout-company" tabindex="-1" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12 text-center" style="font-size: 14pt; font-weight: 600;">
                    Berhasil!
                </div>
                <div class="col-md-12 text-center" style="font-weight: 500; color: #aaa; margin-top: 3px;">
                    <p id="text-response-change-company">-</p>
                </div>

                <div class="col-md-12 text-center" style="padding-top: 20px; border-top: 1px solid #eee; margin-top: 5px;">
                    <button type="button" id="btn-konfirm-modal-logout-company" class="btn btn-primary" onclick="logout(event, 'execute','company')">Ya, login kembali!</button>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>
