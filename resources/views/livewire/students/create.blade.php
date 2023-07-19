<!-- Modal -->
<div wire:ignore.self class="modal  fade" id="studentCreateModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="studentCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Send Mail')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mt-3">
                        <label for="message">{{__('Message')}}</label>
                        <textarea name="message" id="message" wire:model='message' class="form-control" cols="30" rows="10"></textarea>
                        @error('message') <span
                            class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="button" wire:click.prevent="sendMail()"
                    class="btn btn-primary  close-modal">{{__('Send')}}</button>
            </div>
        </div>
    </div>
</div>
