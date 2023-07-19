<!-- Modal -->
<div wire:ignore.self class="modal fade" id="staticBackdropShow" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Show User No. {{$selected_id}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="modal-body">
				<form>
            <div class="form-group mt-2 mb-2 border border-secondary rounded-1 p-2">
                <label for="name">Name:-</label>
                <div>{{$name}}</div>
            </div>

            <div class="form-group mt-2 mb-2 border border-secondary rounded-1 p-2">
                <label for="email">Email:-</label>
                <div>{{$email}}</div>
            </div>
            

            <div class="form-group mt-2 mb-2 border border-secondary rounded-1 p-2">
                <label for="image">Image:-</label>
                <div><img src="{{ Storage::url($image) }}" class="img-thumbnail" alt="image" height="200px" width="140px" ></div>
            </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
