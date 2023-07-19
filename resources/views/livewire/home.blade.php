<div>
    <div class="card bg-light text-dark shadow">
        <div class="card-body">
            <h1 class="card-title">Join Classroom :-</h1>
            <p class="card-text">
                <form wire:submit.prevent="store">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" wire:model='classroom_id' placeholder="Enter The Classroom Id">
                        <button class="btn btn-outline-secondary" type="submit">Join</button>
                    </div>
                    @error('classroom_id') <span class="error">{{ $message }}</span> @enderror
                </form>

        </div>
    </div>
</div>
