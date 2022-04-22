<div class="modal animated fadeIn" id="modal-detail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDetailLabel">@{{single.p_nama}}</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive table-borderless table-hover table-question mb-0">
                    <tbody>
                        <tr v-for="(value, key) in dataDetail">
                            <td align="center" style="border-top: unset !important;">
                                <i v-if="value.ukpd_value" class="fa fa-check-square text-primary"></i>
                                <i v-if="!value.ukpd_value" class="far fa-square text-primary"></i>
                                <!-- <input type="checkbox" v-model="value.ukpd_value" disabled="disabled"> -->
                            </td>
                            <td style="vertical-align: center;border-top: unset !important;">
                                <span :style="(!value.ukpd_value) ? 'text-decoration:line-through;' : ''">
                                    @{{value.g_nama}}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <span>
                    Skor : &nbsp;<b>@{{single.ukp_skor}}%</b>
                </span>
                <span>
                    Hasil : &nbsp;<b>@{{single.ukp_hasil}}</b>
                </span>
            </div>
        </div>
    </div>
</div>