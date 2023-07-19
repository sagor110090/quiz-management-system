@section('title', __('Answers'))
<div>
    <div class="col-lg-12 col-md-12 col-12">
        <div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 fw-bold text-white">Students Listing</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
        <div class="card rounded-3">
            <div class="card-body">
                <div class="justify-content-between align-items-center mb-3">
                    <div class="table-responsive">
                        <div class="mb-4">
                            <input wire:model='keyWord' type="text" class="form-control" name="search" id="search"
                                placeholder="Search Students">
                        </div>
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <td>#</td>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <td>ACTIONS</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $row)
                                @if (checkOwnStudent($row->id))
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>
                                            <a href="{{ asset('list-classroom/'.$row->id) }}" class="btn btn-success btn-sm">Check Answers</a>

                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $students->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
