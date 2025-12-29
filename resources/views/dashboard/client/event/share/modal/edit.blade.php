    <div class="modal fade" id="qrCodeEditModal" tabindex="-1" aria-labelledby="qrCodeEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeEditModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Buat kode QR Anda sesuai keinginan Anda.</p>
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <form id="qr-design-form">
                                <div class="mb-4">
                                    <h6>Gaya kode QR</h6>
                                    <div class="btn-group" role="group" aria-label="QR Code Style">
                                        <input type="radio" class="btn-check" name="qr_style" id="styleSquare"
                                            value="square" checked>
                                        <label class="btn btn-outline-primary" for="styleSquare">Square</label>

                                        <input type="radio" class="btn-check" name="qr_style" id="styleDots"
                                            value="dot">
                                        <label class="btn btn-outline-primary" for="styleDots">Dots</label>

                                        <input type="radio" class="btn-check" name="qr_style" id="styleFluid"
                                            value="fluid">
                                        <label class="btn btn-outline-primary" for="styleFluid">Fluid</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6>Gaya mata QR</h6>
                                    <div class="btn-group" role="group" aria-label="QR Eye Style">
                                        <input type="radio" class="btn-check" name="qr_eye_style" id="eyeSquare"
                                            value="square" checked>
                                        <label class="btn btn-outline-primary" for="eyeSquare">Square</label>

                                        <input type="radio" class="btn-check" name="qr_eye_style" id="eyeRound"
                                            value="round">
                                        <label class="btn btn-outline-primary" for="eyeRound">Round</label>

                                        <input type="radio" class="btn-check" name="qr_eye_style" id="eyeSoftEdge"
                                            value="soft_edge">
                                        <label class="btn btn-outline-primary" for="eyeSoftEdge">Soft edge</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="fw-semibold mb-2">Koreksi Kesalahan</div>
                                    <select class="form-select" id="errorCorrection">
                                        <option value="L">Low</option>
                                        <option value="M" selected>Medium</option>
                                        <option value="Q">Quartile</option>
                                        <option value="H">High</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <h6>Warna QR</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 ">
                                            <label for="fgColor" class="form-label">Foreground</label>
                                            <input type="color" class="form-control form-control-color" id="fgColor"
                                                value="#000000" title="Choose foreground color">
                                        </div>
                                        <div class="">
                                            <label for="bgColor" class="form-label">Background</label>
                                            <input type="color" class="form-control form-control-color" id="bgColor"
                                                value="#FFFFFF" title="Choose background color">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 text-center">
                            <div id="qr-code-preview-container" class="p-3 border rounded shadow-sm">
                            </div>
                            <button type="button" id="reset-qr-btn" class="btn btn-sm btn-outline-secondary mt-3">
                                <i class="bi bi-arrow-counterclockwise fs-5"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary py-2 " id="save-qr-design-btn">
                        Simpan desin
                    </button>
                </div>
            </div>
        </div>
    </div>
