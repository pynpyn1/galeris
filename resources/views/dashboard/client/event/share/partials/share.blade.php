 <div class="col-md-7">
     <div class="card shadow-sm mb-4">
         <div class="card-body">
             <div class="row align-items-center">
                 <div class="col-md-12">
                     <h5 class="mb-3 text-primary">Share via link</h5>
                     <p class="text-muted" style="font-size: 0.9rem;">
                         Share the link below with your guests. They'll be able to access the event gallery once you
                         activate it.
                     </p>
                     <div class="input-group mb-3">
                         <input type="text" id="share-link" class="form-control" value="{{ $url }}" readonly
                             aria-label="Event Share Link">
                     </div>

                     <div class="d-flex justify-content-end">
                         <button class="btn btn-outline-primary me-2" type="button" id="copy-button"
                             data-bs-toggle="tooltip" data-bs-placement="top" title="Salin Link">
                             Copy Link
                         </button>
                         <a href="{{ route('provide.photo', $link->slug) }}" class="btn btn-primary" type="button"
                             id="copy-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Salin Link">
                             Open Link
                         </a>

                     </div>
                 </div>

             </div>
         </div>
     </div>
 </div>
