<div class="modal animated fadeIn" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDetailLabel"></h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12" v-for="(val, idx) in dataDetail">
                        <div class="ibox ibox-question">
                            <div class="ibox-title bg-primary">
                                <!-- <input type="hidden" name="ukp_penyakit_id[]" :value="val.p_id"> -->
                                <h3>@{{idx+1}}.&nbsp; @{{val.p_nama}}</h3>
                            </div>
                            <div class="ibox-content">
                                <table class="table table-responsive table-borderless table-hover table-question mb-0">
                                    <tbody>
                                        <tr v-for="(value, key) in val.detail">
                                            <td align="center">
                                                <i v-if="value.ukpd_value" class="fa fa-check-square text-primary"></i>
                                                <i v-if="!value.ukpd_value" class="far fa-square text-primary"></i>
                                                <!-- <input type="checkbox" v-model="value.ukpd_value" disabled="disabled"> -->
                                            </td>
                                            <td style="vertical-align: center;">
                                                <span :style="(!value.ukpd_value) ? 'text-decoration:line-through;' : ''">
                                                    @{{value.g_nama}}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="ibox-footer d-flex justify-content-between">
                                <span>
                                    Skor : &nbsp;<b>@{{val.ukp_skor}}%</b>
                                </span>
                                <span>
                                    Hasil : &nbsp;<b>@{{val.ukp_hasil}}</b>
                                </span>
                                <!-- <button class="btn btn-sm btn-outline-primary">Selanjutnya &nbsp;<i class="fa fa-arrow-right"></i></button> -->
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- <div class="modal-footer"> -->
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Send message</button> -->
            <!-- </div> -->
        </div>
    </div>
</div>