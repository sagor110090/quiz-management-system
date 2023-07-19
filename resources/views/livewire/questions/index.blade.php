@section('title', __('Questions'))
<div>
    <div class="col-lg-12 col-md-12 col-12">
        <div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 fw-bold text-white">{{__('Questions Listing')}}</h3>
                </div>
                <div>
                @can('question-create')
                    <button type="button"  data-bs-toggle="modal" wire:click.prevent="resetInput()"  data-bs-target="#questionCreateModal"
                        class="btn btn-white"><i class="fa fa-plus"></i> {{__('Create New Questions')}}</button>
                @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
        <div class="card rounded-3">
            <div class="card-body">
                <div class="justify-content-between align-items-center mb-3">
                    @include('livewire.questions.create')
                    @include('livewire.questions.update')
                    @include('livewire.questions.view')


                    <div class="col-md-12">
                        <div class="row mb-2 mt-2 justify-content-md-between">
                            <div class="col-md-2 pb-sm-3">
                                <div class="row g-3 align-items-center border-1 ">
                                    {{-- <div class="col-auto">
                                        <label for="" class="col-form-label">{{__('Per Page')}}</label>
                                    </div> --}}
                                    {{-- <div class="col-auto">
                                        <select wire:model='perPage' class="form-select">
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div> --}}
                                    @can('question-delete')
                    <button class="btn btn-danger btn-sm mb-2" {{ count($checked) == 0 ? 'disabled' : '' }}
                        wire:click='bulkDeleteTriggerConfirm()'> <i class="fa fa-trash" aria-hidden="true"></i> {{__('Delete')}}({{ count($checked) }})
                    </button>
                    @endcan
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text border-right-0 border"><i class="fa fa-search"></i></span>
                                    <input wire:model='keyWord' type="text" class="form-control border-left-0 border" name="search" id="search"
                                    placeholder="{{__('Search Questions')}}">
                                </div>
                            </div>
                        </div>
                    </div>
				<div class="table-responsive">
					<table class="table table-bordered table-sm">
						<thead class="thead">
							<tr>
                            @can('question-delete')

                            <td><input type="checkbox" value="1" wire:model="checkedAll"></td>

                            @endcan
								<td>#</td>
								<th>{{__('Question')}}</th>
								<th>{{__('Quiz Name')}}</th>
								<th>{{__('Image')}}</th>
								<td>{{__('ACTIONS')}}</td>
							</tr>
						</thead>
						<tbody>
							@foreach($questions as $row)
							<tr>
                            @can('question-delete')

                            <td><input type="checkbox" value="{{ $row->id }}" wire:model="checked">
                                        </td>
                                @endcan
								<td>{{ $loop->iteration }}</td>
								<td>{{ $row->question }}</td>
								<td>{{ $row->quiz->quiz_name }}</td>
                                <td>
                                    @if ($row->image)
                                    <img src="{{ Storage::url($row->image) }}" alt="" height="200px" width="300px" alt="image">
                                    @endif
                                </td>
								<td width="200">

                                        {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#questionShowModal" class="btn btn-warning btn-sm"wire:click="show({{ $row->id }})"><i
                                            class="fa fa-eye"></i></button> --}}

                                        @can('question-edit')

                                        <button type="button" data-bs-toggle="modal" data-bs-target="#questionUpdateModal" class="btn btn-success btn-sm"wire:click="edit({{ $row->id }})">Edit   <i
                                            class="fa fa-edit"></i></button>

                                        @endcan

                                        @can('question-delete')

                                            <button class="btn btn-danger btn-sm"
                                            wire:click="triggerConfirm({{ $row->id }})">Delete   <i
                                                class="fa fa-trash"></i> </button>
                                        @endcan


								</td>
							@endforeach
						</tbody>
					</table>
					{{ $questions->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
