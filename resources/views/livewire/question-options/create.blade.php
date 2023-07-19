<!-- Modal -->
<div wire:ignore.self class="modal fade" id="questionOptionCreateModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="questionOptionCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Create New Question Option')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="modal-body">
				<form>
                
            <div class="form-group mt-3">
                <label for="option_name">{{__('Option Name')}}</label>
                <input wire:model="option_name" type="text" class="form-control" id="option_name" placeholder="{{__('Option Name')}}">@error('option_name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mt-3">
                <label for="question_id">{{__('Question Id')}}</label>
                <input wire:model="question_id" type="text" class="form-control" id="question_id" placeholder="{{__('Question Id')}}">@error('question_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary  close-modal">{{__('Save')}}</button>
            </div>
        </div>
    </div>
</div>
